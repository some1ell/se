<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: Calculations
 * @author: sasokrajnc
 * @datetime: 31/10/2018 - 00:48
 * @version: Calculations.php, v1.1
 */

namespace My\ProductOrder;

use My\Lib\Functions;

class Calculations {

    use Functions;

    /*
     * Get product details to define the final order
     *
     * @param array $productDetails
     * @return array
     */
    public static function getProductOrderData($productDetails) {

        // Define product values
        $orderWithTax           = false;
        $orderWithFunnel        = false;
        $orderFunnelTagPriority = 0;

        // Get product data for all products
        foreach ($productDetails as $product) {

            // Get all product specification from the defined product
            $productSpecifications = Products::defineProduct($product['product_name']);

            // Check if any of Global product has tax enabled
            if ($productSpecifications['tax']) {
                $orderWithTax = true;
            }

            // Check for tag priority in Global product
            if ($productSpecifications['funnel_tag_priority']) {

                // If tag funnel is not yet defined
                if ($orderFunnelTagPriority == 0) {

                    // Check for funnel position in Global product and define new order tag position
                    if ($productSpecifications['funnel_tag_priority'] > $orderFunnelTagPriority):

                        // Define new position
                        $orderFunnelTagPriority = $productSpecifications['funnel_tag_priority'];

                        // Define funnel tag
                        $orderWithFunnel = $productSpecifications['funnel_tag'];

                    endif;
                }
                else {
                    // Order has position already defined, so we will look for the priority

                    // Check for funnel position and set order tag a new position (smaller the position, the higher priority)
                    if ($productSpecifications['funnel_tag_priority'] < $orderFunnelTagPriority):

                        // Set a new order funnel tag position
                        $orderFunnelTagPriority = $productSpecifications['funnel_tag_priority'];

                        // Define new funnel tag
                        $orderWithFunnel = $productSpecifications['funnel_tag'];;

                    endif;
                }
            }
        }

        return array("orderWithTax"           => $orderWithTax,
                     "orderWithFunnel"        => $orderWithFunnel,
                     "orderFunnelTagPriority" => $orderFunnelTagPriority);
    }

    /*
     * Get product correct order data based on order step
     *
     * @param array $productDetails
     * @param string $productFunnelTag
     * @param string $orderDiscount
     * @param string $shippingCountry
     * @return array
     */
    public static function getProductOrderCorrectData($productDetails, $orderWithFunnel, $orderWithTax, $orderDiscount, $shippingCountry) {

        $self = new static; //OBJECT INSTANTIATION

        // Define correct values
        $correctCheckoutValues       = array();
        $correct_global_FunnelValues = "0.00";
        $correctThankYouPageValues   = array();
        $productPrice                = "0.00";
        $productTax                  = "0.00";
        $productCoupon               = "0.00";
        $shippingPrice               = "0.00";
        $subtotalValue               = "0.00";
        $funnelProductTotalValues    = "0.00";
        $funnelTotalShippingValues   = "0.00";
        $partial_quantity            = array();

        // Get product data for all products
        foreach ($productDetails as $product) {

            // Get all product specification from the defined product
            $global_productSpecifications = Products::defineProduct($product['product_name']);

            // Check if product has funnels
            if (is_array($product['funnel'])) {

                // Check if product has correct tag by priority
                if ($global_productSpecifications['funnel_tag'] == $orderWithFunnel) {

                    // Define correct funnel values
                    $correct_global_FunnelValues = $global_productSpecifications['funnel'];
                }

                // Get funnel selected values so we can use them in the calculations
                foreach ($product['funnel'] as $funnelStep_key => $funnelStep) {

                    // Get values only if the funnel steps are defined in the order
                    if (isset($funnelStep['upsell'])) {

                        // Loop through the funnel step
                        foreach ($funnelStep as $partial_type => $partial) {

                            // Get defined quantity which we will use in funnel calculations for not partials that don't have specific price defined
                            $partial_quantity[$funnelStep_key][] = $partial['quantity'];
                        }
                    }
                }
            }

            // If product has variant defined, get the correct variant price based on variant name
            if ($product['product_variant']) {

                // Check if global variables are properly defined
                if (is_array($global_productSpecifications['variant'])) {

                    // Get all options
                    foreach ($global_productSpecifications['variant'] as $global_variant) {

                        // Check if variant that we are looking for actually exist
                        if ($global_variant['name'] === $product['product_variant']):

                            // Variant is found, define a price for it
                            $productPrice = $global_variant['price_clean'];

                        endif;
                    }
                }
            }
            else {

                // Variants are not defined from the global product, so the product price is set to default price
                $productPrice = $global_productSpecifications['price_clean'];
            }

            // Define correct Checkout subtotal value based on all products in the cart
            $subtotalValue += ($productPrice * $product['product_quantity']);
        }

        // ----- CHECKOUT PAGE

        // Get shipping price based on subtotal value
        $shippingPrice = (Define::defineShipping($shippingCountry, 1, $subtotalValue)) ? : $shippingPrice;

        // Get coupon value
        $productCoupon = (Define::defineCoupon($orderDiscount, $subtotalValue)) ? : $productCoupon;

        // Check if coupon applies on product or shipping
        if(isset($productCoupon['coupon_code']) && $productCoupon['coupon_code'] == "free_shipping"){

            // Get tax (tax default definition is 10%)
            $productTax = ($orderWithTax) ? ($subtotalValue * 0.1) : $productTax;

        } else {

            // Order with coupon that applies on product
            $productTax = ($orderWithTax) ? (($subtotalValue - $productCoupon['total']) * 0.1) : $productTax;
        }

        // ----- END CHECKOUT PAGE

        // ----- FUNNEL PAGE

        // Check if order has funnels defined
        if (is_array($product['funnel'])) {

            foreach ($correct_global_FunnelValues as $global_funnelStep_key => $global_funnelStep) {

                // Loop through the funnel step
                foreach ($global_funnelStep as $global_partial_type => $global_partial) {

                    // If we defined funnel inside the order not to be skipped
                    if($product['funnel'][$global_funnelStep_key][$global_partial_type]['skip'] == false){

                        // Check if partial has specific price defined
                        if ($global_partial['funnel_selected_quantity']) {

                            // Partial has a specific price determined
                            $funnelProductTotalValues += ($global_partial['funnel_price_clean'] * $global_partial['funnel_selected_quantity']);

                        }
                        else {

                            // Partial don't has a specific price determined -> we wil need quantity from the product defined qty
                            $funnelProductTotalValues += ($global_partial['funnel_price_clean'] * $partial_quantity[$global_funnelStep_key][$global_partial_type]);

                        }

                        // We don't need rounding for sum
                        $funnelTotalShippingValues += ($global_partial['funnel_shipping_clean']);
                    }
                }
            }
        }

        // Get tax (tax default definition is 10%)
        $funnelTotalTaxValues = ($orderWithTax) ? ($funnelProductTotalValues * 0.1) : "0.00";
        // ----- END FUNNEL PAGE

        // Define correct Checkout page values
        $correctCheckoutValues['subtotal'] = $self->doCleanPrice(($subtotalValue == 0 ? "0.00" : $subtotalValue));
        $correctCheckoutValues['shipping'] = $self->doCleanPrice(($shippingPrice['price'] == 0 ? "0.00" : $shippingPrice['price']));
        $correctCheckoutValues['tax']      = $self->doCleanPrice(($productTax == 0 ? "0.00" : $productTax));
        $correctCheckoutValues['coupon']   = $self->doCleanPrice(($productCoupon['total'] == 0 ? "0.00" : $productCoupon['total']));
        $correctCheckoutValues['total']    = $self->doCleanPrice((($subtotalValue + $shippingPrice['price'] + $productTax - $productCoupon['total']) == 0 ? "0.00" : ($subtotalValue + $shippingPrice['price'] + $productTax - $productCoupon['total'])));

        // Define correct Thank you page values
        $correctThankYouPageValues['subtotal'] = $self->doCleanPrice((($subtotalValue + $funnelProductTotalValues) == 0 ? "0.00" : ($subtotalValue + $funnelProductTotalValues)));
        $correctThankYouPageValues['shipping'] = $self->doCleanPrice((($shippingPrice['price'] + $funnelTotalShippingValues) == 0 ? "0.00" : ($shippingPrice['price'] + $funnelTotalShippingValues)));
        $correctThankYouPageValues['tax']      = $self->doCleanPrice(($productTax + $funnelTotalTaxValues == 0 ? "0.00" : $productTax + $funnelTotalTaxValues));
        $correctThankYouPageValues['coupon']   = $self->doCleanPrice(($productCoupon['total'] == 0 ? "0.00" : $productCoupon['total']));
        $correctThankYouPageValues['total']    = $self->doCleanPrice((($subtotalValue + $funnelProductTotalValues + $shippingPrice['price'] + $funnelTotalShippingValues + $productTax + $funnelTotalTaxValues - $productCoupon['total']) == 0 ? "0.00" : ($subtotalValue + $funnelProductTotalValues + $shippingPrice['price'] + $funnelTotalShippingValues + $productTax + $funnelTotalTaxValues - $productCoupon['total'])));

        return array("correctCheckoutValues"          => $correctCheckoutValues,
                     "correctFunnelValues"            => $correct_global_FunnelValues,
                     "correctThankYouPageTotalValues" => $correctThankYouPageValues);
    }

    /*
     * Based on order, calculate correct values for the all order steps
     *
     * @param array $productDetails
     * @param string $paymentProcessor
     * @param boolean $connectProcessor
     * @param string $adminLogin
     * @param string $shippingCountry
     * @param $orderDiscount
     * @return array
     */
    public static function getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount) {

        // returned values: array -> boolean orderWithTax, boolean orderWithFunnel, int orderFunnelTagPriority
        $productOrderData = self::getProductOrderData($productDetails);

        $orderDetails = array("payment_processor" => $paymentProcessor,
                              "connect_processor" => $connectProcessor,
                              "admin_login"       => $adminLogin,
                              "shipping_country"  => $shippingCountry,
                              "with_tax"          => $productOrderData['orderWithTax'],
                              "with_funnel"       => $productOrderData['orderWithFunnel'],
                              "with_discount"     => ($orderDiscount) ? $orderDiscount : false);

        // Get Funnel correct values
        $productOrderCorrectData = self::getProductOrderCorrectData($productDetails, $productOrderData['orderWithFunnel'], $productOrderData['orderWithTax'], $orderDiscount, $shippingCountry);

        // Final order should have these correct values
        $correctTotalValues = $productOrderCorrectData['correctCheckoutValues'];

        // Funnel should have these correct values
        $correctFunnelValues = $productOrderCorrectData['correctFunnelValues'];

        // Thank you page should have these correct values
        $correctThankYouPageValues = $productOrderCorrectData['correctThankYouPageTotalValues'];

        return array("orderDetails"                   => $orderDetails,
                     "correctTotalValues"             => $correctTotalValues,
                     "correctFunnelValues"            => $correctFunnelValues,
                     "correctThankYouPageTotalValues" => $correctThankYouPageValues);
    }
}