<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: Define
 * @author: sasokrajnc
 * @datetime: 30/10/2018 - 23:16
 * @version: Define.php, v1.1
 */

namespace My\ProductOrder;

class Define implements Constants {

    /*
     * Get all the shipping data
     * @param string $country
     * @param mixed string $emilCounter
     * @param string $orderValue
     */
    public static function defineShipping($country, $emailCounter, $orderValue = "0.00") {

        switch ($country):
            // Free shipping
            case "Slovenia":

                // Default price
                $price = "0.00";

                return array("email"     => "sasokrajnc+" . $emailCounter . "@gmail.com",
                             "firstname" => "Test",
                             "lastname"  => "User",
                             "address"   => "My Address",
                             "city"      => "City",
                             "country"   => "Slovenia",
                             "state"     => "",
                             "zip"       => "1000",
                             "details"   => "",
                             "price"     => $price);
                break;
            // Free shipping < $29.99, Paid Shipping > $30.00
            case "Croatia":

                // Default price
                $price = "0.00";

                // Price based on total cart value
                if ($orderValue > "29.99") {

                    $price = "10.00";
                }

                return array("email"     => "sasokrajnc+" . $emailCounter . "@gmail.com",
                             "firstname" => "Test",
                             "lastname"  => "User",
                             "address"   => "My Address",
                             "city"      => "City",
                             "country"   => "Croatia",
                             "state"     => "",
                             "zip"       => "1000",
                             "details"   => "",
                             "price"     => $price);
                break;
            // Free shipping < $29.99, Paid Shipping > $30.00
            case "United States":

                // Default price
                $price = "0.00";

                // Price based on total cart value
                if ($orderValue > "29.99") {

                    $price = "10.00";
                }

                return array("email"     => "sasokrajnc+" . $emailCounter . "@gmail.com",
                             "firstname" => "test",
                             "lastname"  => "buyer",
                             "address"   => "55 East 52nd Street 21st Floor",
                             "city"      => "New York",
                             "country"   => "United States",
                             "state"     => "New York",
                             "zip"       => "10022",
                             "details"   => "",
                             "price"     => $price);
                break;
        endswitch;
    }

    /*
     * Get credit card data
     *
     * @param string $paymentProcessor
     * @return array
     */
    public static function defineCreditCard($paymentProcessor) {

        switch ($paymentProcessor):

            // Credit Card credentials for Stripe payment processor
            case self::PAYMENT_PROCESSOR_STRIPE:
                return array("card_number"  => "4111 1111 1111 1111",
                             "name_on_card" => "Test User",
                             "expiry_date"  => "12 / 30",
                             "cvv"          => "123",
                             "details"      => "");
                break;

            // Credit Card credentials for Authorize payment processor
            case self::PAYMENT_PROCESSOR_AUTHORIZE:
                return array("card_number"  => "4242 4242 4242 4242",
                             "name_on_card" => "Test User",
                             "expiry_date"  => "12 / 30",
                             "cvv"          => "123",
                             "details"      => "");
                break;

            // Credit Card credentials for Nmi payment processor
            case self::PAYMENT_PROCESSOR_NMI:
                return array("card_number"  => "4111 1111 1111 1111",
                             "name_on_card" => "Test User",
                             "expiry_date"  => "12 / 30",
                             "cvv"          => "123",
                             "details"      => "");
                break;

            // Credit Card credentials for Braintree payment processor
            case self::PAYMENT_PROCESSOR_BRAINTREE:
                return array("card_number"  => "4111 1111 1111 1111",
                             "name_on_card" => "Test User",
                             "expiry_date"  => "12 / 30",
                             "cvv"          => "123",
                             "details"      => "");
                break;
        endswitch;
    }

    /*
    * Get PayPal data
     *
    * @param mixed string $type
    * @param mixed string $userType
    * @return array
    */
    public static function definePayPal($type, $userType) {

        // Developers site
        if ($type == "developers") {

        }
        else {
            // Sandbox site

            switch ($userType):

                // Credit Card credentials for Nmi payment processor
                case "merchant":
                    return array("email_address" => self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_MERCHAND_LOGIN_EMAIL,
                                 "password"      => self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_MERCHAND_LOGIN_PASSWORD,
                                 "way_to_pay"    => "CREDIT UNION");
                    break;
                case "buyer":
                    return array("email_address" => self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_BUYER_LOGIN_EMAIL,
                                 "password"      => self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_BUYER_LOGIN_PASSWORD,
                                 "way_to_pay"    => "CREDIT UNION");
                    break;
            endswitch;
        }
    }

    /*
     * Get admin data
     *
     * @param string $admin
     * @return array
     */
    public static function defineAdminLogin($admin) {

        switch ($admin):
            case "saso":
                return array("email"     => "saso@carthook.com",
                             "password"  => "fabea9f3e4!",
                             "firstname" => "Sašo",
                             "lastname"  => "Krajnc",
                             "address"   => "My Address",
                             "city"      => "City",
                             "country"   => "Slovenia",
                             "zip"       => "10.00",
                             "details"   => "");
                break;
            case "selenium":
                return array("email"     => "tech@carthook.com",
                             "password"  => "noMoreBugz",
                             "firstname" => "Automate",
                             "lastname"  => "Testing",
                             "address"   => "My Address",
                             "city"      => "City",
                             "country"   => "Slovenia",
                             "zip"       => "10.00",
                             "details"   => "");
                break;
        endswitch;
    }

    /*
     * Get the total value after the applied coupon
     *
     * @param string $orderDiscount
     * @param string $subtotalValue
     * @return string
     */
    public static function defineCoupon($orderDiscount, $subtotalValue = false) {

        switch ($orderDiscount):

            // 10% on all products
            case"10off":
                $total         = ($subtotalValue) ? ($subtotalValue * 0.1) : "0.00";
                $coupon_code   = "10off";
                $coupon_type   = "percent_off";
                $coupon_amount = "10";
                break;
            // 100% on all products
            case"100off":
                $total         = ($subtotalValue) ? $subtotalValue : "0.00";
                $coupon_code   = "100off";
                $coupon_type   = "percent_off";
                $coupon_amount = "100";
                break;
            // 100% on all products
            case"minus10":
                $total         = ($subtotalValue) ? "10.00" : "0.00";
                $coupon_code   = "100off";
                $coupon_type   = "amount_off";
                $coupon_amount = "10";
                break;
            // 100% on all products
            case"minus100_avocado_m":
                $total         = ($subtotalValue) ? "100.00" : "0.00";
                $coupon_code   = "100off";
                $coupon_type   = "amount_off";
                $coupon_amount = "100";
                break;
            // Free shipping on all products
            case"free_shipping":
                $total         = "10.00";
                $coupon_code   = "free_shipping";
                $coupon_type   = "percent_off";
                $coupon_amount = "100";
                break;
            // Free shipping for Croatia
            case"free_croatia":
                $total         = "10.00";
                $coupon_code   = "free_shipping";
                $coupon_type   = "percent_off";
                $coupon_amount = "100";
                break;

            // If not defined, return 0
            default:
                $total         = "0.00";
                $coupon_code   = "undefined";
                $coupon_type   = "undefined";
                $coupon_amount = "undefined";
                break;
        endswitch;

        return array("total"       => (string)(number_format($total,2)),
                     "coupon_code" => $coupon_code,
                     "coupon_type" => $coupon_type,
                     "amount"      => $coupon_amount);
    }

    /*
     * Get the total tax value
     *
     * @param string $orderDiscount
     * @param string $subtotalValue
     * @return string
     */
    public static function defineTax($subtotalValue, $taxType) {

        switch ($taxType):

            // 10% TAX (VAT)
            case"10%":
                $tax_rate        = 0.1;
                $total           = ($tax_rate * $subtotalValue) / (1 + $tax_rate);
                $tax_rate_string = "10%";
                break;

            // If not defined, return 0
            default:
                $tax_rate        = 0;
                $total           = "0.00";
                $tax_rate_string = "undefined";
                break;
        endswitch;

        return array("tax_rate"        => $tax_rate,
                     "total"           => (string)(number_format($total,2)),
                     "tax_rate_string" => $tax_rate_string);
    }
}