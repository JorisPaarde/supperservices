<?php

use App\ExportOrders;
use Carbon\Carbon;
use Roots\WPConfig\Config;

add_action('init', [ExportOrders::class, 'schedule']);

if (Config::get('FTP_EXPORT_SERVER') !== null && Config::get('FTP_EXPORT_CLIENT_ID') !== null) {
    $today = Carbon::today();

    if (in_array($today->dayOfWeekIso, [6, 7])) {
        // Don't export on saturday and sunday
        ExportOrders::schedule();
        return;
    } elseif ($today->dayOfWeekIso === 5) {
        // Add an extra export on friday for orders to be delivered on monday
        add_action('export_orders', ExportOrders::forDate((clone $today)->addDays(3), 2));
    }

    add_action('export_orders', ExportOrders::forDate($today->addDay()));
}
