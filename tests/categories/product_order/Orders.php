<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: Functions
 * @author: sasokrajnc
 * @datetime: 10/10/2018 - 20:33
 * @version: Functions.php1
 */

namespace My\ProductOrder;

/**
 * Tests
 */
trait Orders {

    /**
     * Product Orange
     *
     * Single product
     * No tax
     * No discount
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function noTaxNoDiscountNoFunnel($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Orange",
                                           "product_variant"  => false,
                                           "product_quantity" => "3",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Apple
     *
     * Single product
     * No tax
     * With discount
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscount($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "10off";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Apple",
                                           "product_variant"  => "L",
                                           "product_quantity" => "1",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Apple
     *
     * Single product
     * With tax
     * No discount
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withTax($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "1",
                                           "funnel"           => false),);

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Peach
     *
     * Single product
     * No tax
     * No discount
     * With shipping
     * No Funnel
     *
     * @return array
     */
    public function withShipping($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Croatia";
        $orderDiscount   = "";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Peach",
                                           "product_variant"  => "M",
                                           "product_quantity" => "6",
                                           "funnel"           => false),);

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Avocado
     *
     * Single product
     * No tax
     * No discount
     * No shipping
     * With Funnel
     *
     * @return array
     */
    public function withOneStepFunnel($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Cat",
                                           "product_variant"  => false,
                                           "product_quantity" => "1",
                                           "funnel"           => array(0 => array("upsell"   => array("skip"     => true,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => ""),
                                                                                  "downsell" => array("skip"     => false,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => "10")))));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Motor
     *
     * Single product
     * With tax
     * With discount
     * With shipping
     * With Funnel
     *
     * @return array
     */
    public function withTaxDiscountShippingOneStepFunnel($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Croatia";
        $orderDiscount   = "10off";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Motorcycle",
                                           "product_variant"  => "",
                                           "product_quantity" => "10",
                                           "funnel"           => array(0 => array("upsell"   => array("skip"     => true,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => ""),
                                                                                  "downsell" => array("skip"     => false,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => "1")))));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Car
     *
     * Single product
     * With tax
     * With discount
     * With shipping
     * With Funnel
     *
     * @return array
     */
    public function withTaxDiscountShippingTwoStepFunnel($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Croatia";
        $orderDiscount   = "10off";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Car",
                                           "product_variant"  => "M",
                                           "product_quantity" => "10",
                                           "funnel"           => array(0 => array("upsell"   => array("skip"     => true,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => ""),
                                                                                  "downsell" => array("skip"     => false,
                                                                                                      "variant"  => "M",
                                                                                                      "quantity" => "1")),
                                                                       1 => array("upsell"   => array("skip"     => false,
                                                                                                      "variant"  => "M",
                                                                                                      "quantity" => "1"),
                                                                                  "downsell" => array("skip"     => true,
                                                                                                      "variant"  => "",
                                                                                                      "quantity" => "")))));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Avocado
     *
     * Single product
     * No tax
     * With discount 10%0ff
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscount10percent($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "10off";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "3",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Avocado
     *
     * Single product
     * No tax
     * With discount 100%off
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscount100percent($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "100off";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "3",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Avocado
     *
     * Single product
     * No tax
     * With discount $10 amount
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscountMinus10($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "minus10";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "4",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Avocado
     *
     * Single product
     * No tax
     * With discount $100 amount
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscountMinus100($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Slovenia";
        $orderDiscount   = "minus10";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "4",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Grape + Avocado
     *
     * Single product
     * No tax
     * With discount free shipping
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscountFreeShipping($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Croatia";
        $orderDiscount   = "free_shipping";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Grape",
                                           "product_variant"  => "M",
                                           "product_quantity" => "10",
                                           "funnel"           => false),
                                1 => array("product_name"     => "Avocado",
                                           "product_variant"  => "M",
                                           "product_quantity" => "2",
                                           "funnel"           => false)
            );

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }

    /**
     * Product Banana
     *
     * Single product
     * No tax
     * With discount free shipping Croatia
     * No shipping
     * No Funnel
     *
     * @return array
     */
    public function withDiscountFreeShippingCroatia($paymentProcessor, $connectProcessor, $adminLogin) {

        // Define country and coupon
        $shippingCountry = "Croatia";
        $orderDiscount   = "free_croatia";

        // Define what kind of order do you want
        $productDetails = array(0 => array("product_name"     => "Banana",
                                           "product_variant"  => "",
                                           "product_quantity" => "10",
                                           "funnel"           => false));

        // Get correct order values based on defined product details, shipping country and coupon
        $correctOrderValues = Calculations::getOrderCorrectValues($productDetails, $paymentProcessor, $connectProcessor, $adminLogin, $shippingCountry, $orderDiscount);

        return array("productDetails"                 => $productDetails,
                     "orderDetails"                   => $correctOrderValues['orderDetails'],
                     "correctTotalValues"             => $correctOrderValues['correctTotalValues'],
                     "correctFunnelValues"            => $correctOrderValues['correctFunnelValues'],
                     "correctThankYouPageTotalValues" => $correctOrderValues['correctThankYouPageTotalValues']);
    }
}