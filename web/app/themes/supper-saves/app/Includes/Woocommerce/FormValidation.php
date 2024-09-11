<?php 
namespace App\Includes\Woocommerce;

use Ddeboer\Vatin\Validator;
use CMPayments\IBAN;

class FormValidation 
{    
    public function __construct()
    {
        // Uncomment when they want to validate VAT nr. again
        // add_filter('acf/validate_value/name=billing_tax', [$this, 'checkVatNumber'], 10, 4);

        add_filter('acf/validate_value/name=billing_iban', [$this, 'checkIbanNumber'], 10, 4);
        add_filter('acf/validate_value/name=billing_coc', [$this, 'checkCoc'], 10, 4);
    }

    /**
     * Validate European VAT Number
     * 
     * @return string|bool
     */
    public function checkVatNumber(bool $valid, string $value, array $field, string $input_name)
    {
        if (!$valid || !$field['required'] && empty($value)) {
            return (bool) $valid;
        }

        $validator = new Validator;

        if (!$validator->isValid($value, true)) {
            return __('VAT number is invalid', 'wordpress');
        }

        return $valid;
    }

    /**
     * Validate IBAN
     * 
     * @return string|bool
     */
    public function checkIbanNumber(bool $valid, string $value, array $field, string $input_name)
    {
        if (!$valid || !$field['required'] && empty($value)) {
            return (bool) $valid;
        }

        $iban = new IBAN($value);

        if (!$iban->validate()) {
            return __('IBAN is invalid', 'wordpress');
        }

        return $valid;
    }

    /**
     * Validate COC (KVK) number
     * 
     * @return string|bool
     */
    public function checkCoc(bool $valid, string $value, array $field, string $input_name)
    {
        // Remove spaces for validation
        $value = preg_replace('/\s+/', '', $value);

        if (!$valid || !$field['required'] && empty($value)) {
            return (bool) $valid;
        }

        if ($this->checkGermanCoc($value) || $this->checkDutchCoc($value)) {
            return $valid;
        }

        return __('Invalid CoC', 'supper');
    }

    /**
     * Check against the German CoC format.
     * 
     * Must start with 'HRA' of 'HRB' and end with 5 or 6 numbers.
     *
     * @param string $value
     * @return bool
     */
    public function checkGermanCoc(string $value): bool
    {
        return preg_match('/^HR[AB]\d{5,6}$/', $value) === 1;
    }

     /**
     * Check against the Dutch CoC format.
     *
     * Must have 8 numbers.
     *
     * @param string $value
     * @return bool
     */
    public function checkDutchCoc(string $value): bool
    {
        return strlen($value) === 8 && is_numeric($value);
    }
}
