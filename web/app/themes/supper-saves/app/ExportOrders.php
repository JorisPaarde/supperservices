<?php

namespace App;

use DateTime;
use DateTimeInterface;
use Generator;
use Illuminate\Support\Str;
use Roots\WPConfig\Config;
use WC_Order;
use WC_Order_Item_Product;
use WC_Order_Query;

class ExportOrders
{
    private int $clientId;
    private DateTimeInterface $date;
    private int $nth;
    private string $password;
    private string $server;
    private static array $slots;
    private string $username;

    public function __construct(
        DateTimeInterface $date,
        int $nth,
        int $clientId,
        string $server,
        string $username,
        string $password
    ) {
        $this->date = $date;
        $this->nth = $nth;
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->clientId = $clientId;
    }

    public function __invoke(): void
    {
        $stream = fopen('php://memory', 'rw');

        $wroteLines = false;

        foreach ($this->getLines() as $line) {
            if ($wroteLines) {
                fwrite($stream, "\r\n");
            }

            fwrite($stream, $this->lineToString($line));
            $wroteLines = true;
        }

        rewind($stream);
        $this->uploadToFtp($stream);
        fclose($stream);
        static::schedule();
    }

    private function baseLine(): array
    {
        $base = array_fill_keys(range(0, 119), '');
        $base[0] = $this->clientId;

        return $base;
    }

    private function fileName(): string
    {
        $now = new DateTime();

        return sprintf(
            "%d%s%03d.TXT",
            $this->clientId,
            $now->format('Ymdhi'),
            $this->nth,
        );
    }

    private function fillLine(array $base, WC_Order $order, WC_Order_Item_Product $item, int $index): array
    {
        $hasShipping = $order->has_shipping_address();

        $base[1] = $order->get_meta('_order_number', true);
        $base[3] = (new DateTime($order->get_meta('delivery_date', true)))->format('Ymd');
        $base[4] = $order->get_customer_id();
        $base[5] = $order->get_billing_company();
        $base[6] = $order->get_formatted_billing_full_name();
        $base[30] = $hasShipping ? $order->get_shipping_first_name() : $order->get_billing_first_name();
        $base[31] = $hasShipping ? $order->get_shipping_last_name() : $order->get_billing_last_name();
        $base[32] = $order->get_user()->user_email ?? $order->get_billing_email();
        $base[33] = $hasShipping ? $order->get_shipping_phone() : $order->get_billing_phone();
        $base[50] = $hasShipping ? $order->get_shipping_address_1() : $order->get_billing_address_1();
        $base[51] = $hasShipping ? $order->get_shipping_address_2() : $order->get_billing_address_2();
        $base[53] = $hasShipping ? $order->get_shipping_postcode() : $order->get_billing_postcode();
        $base[54] = $hasShipping ? $order->get_shipping_city() : $order->get_billing_city();
        $base[55] = $hasShipping ? $order->get_shipping_country() : $order->get_billing_country();
        $base[70] = $order->meta_exists('delivery_time')
            ? self::getSlots()[$order->get_meta('delivery_time')] ?? null
            : null;
        $base[90] = $index + 1;
        $base[91] = $item->get_product()->get_sku();
        $base[92] = Str::limit($item->get_name(), 30, '');
        $base[93] = $item->get_quantity();

        return $base;
    }

    public static function forDate(DateTimeInterface $date, int $nth = 1): ?self
    {
        if (Config::get('FTP_EXPORT_SERVER') === null || Config::get('FTP_EXPORT_CLIENT_ID') === null) {
            return null;
        }

        return new ExportOrders(
            $date,
            $nth,
            (int) Config::get('FTP_EXPORT_CLIENT_ID'),
            Config::get('FTP_EXPORT_SERVER'),
            Config::get('FTP_EXPORT_USERNAME'),
            Config::get('FTP_EXPORT_PASSWORD'),
        );
    }

    private static function getSlots(): array
    {
        if (isset(self::$slots)) {
            return self::$slots;
        }

        $rawSlots = get_option('coderockz_woo_delivery_time_slot_settings')['time_slot'] ?? [];
        self::$slots = [];

        foreach ($rawSlots as $slot) {
            $key = sprintf(
                '%s - %s',
                date("H:i", mktime(0, (int)$slot['start'])),
                date("H:i", mktime(0, (int)$slot['end'])),
            );

            self::$slots[$key] = $slot['name'];
        }

        return self::$slots;
    }

    /**
     * @param resource $stream
     * @return void
     */
    private function uploadToFtp($stream): void
    {
        $ch = curl_init();

        $url = implode('/', array_filter([
            'ftps://' . $this->server,
            trim(Config::get('FTP_EXPORT_FOLDER'), '/'),
            $this->fileName(),
        ]));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USE_SSL, CURLFTPSSL_TRY);
        curl_setopt($ch, CURLOPT_FTPSSLAUTH, CURLFTPAUTH_TLS);
        curl_setopt($ch, CURLOPT_UPLOAD, 1);
        curl_setopt($ch, CURLOPT_INFILE, $stream);

        curl_exec($ch);
        curl_close($ch);
    }

    private function getLines(): Generator
    {
        $query = new WC_Order_Query([
            'delivery_date' => $this->date->format('Y-m-d'),
            'status' => ['completed', 'processing'],
        ]);

        /** @var \WC_Order[] $orders */
        $orders = $query->get_orders();

        $base = $this->baseLine();

        foreach ($orders as $order) {
            foreach (array_values($order->get_items()) as $index => $item) {
                if (!$item instanceof WC_Order_Item_Product) {
                    continue;
                }

                yield $this->fillLine($base, $order, $item, $index);
            }
        }
    }

    private function lineToString(array $line): string
    {
        $line = array_map(function (?string $value) {
            $value = str_replace(['|', '\''], '', $value);

            return iconv(mb_detect_encoding($value), "ASCII//IGNORE", $value);
        }, $line);

        return implode('|', $line);
    }

    public static function schedule(): void
    {
        if (!wp_next_scheduled('export_orders')) {
            // Use single events and reschedule every event manually to make sure the new time is timezone aware
            // since recurring events only add a predefined interval which wouldn't work with daytime saving.
            wp_schedule_single_event(strtotime('tomorrow 14:00 ' . wp_timezone_string()), 'export_orders');
        }
    }
}
