<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: doOrderWithDiscounts
 * @author: sasokrajnc
 * @datetime: 12/11/2018 - 23:06
 * @version: doOrderWithDiscounts.php, v1.1
 */

namespace My;

use My\ProductOrder\Constants;
use My\ProductOrder\Steps;
use My\ProductOrder\Orders;
use SlackAlerter;
use CL\Slack;

/**
 * Happy path to enable payment processor CASHONDELIVERY and perform tests with discounts
 *
 * @delayAfter My\doOrderWithCashOnDeliveryTest
 * @delayMinutes 0
 * @group 5
 * @group discounts
 * @group web5
 */
class doOrderWithDiscountsTest extends MyAbstractTestCase implements Constants {

    /** @var Steps - Page Objects */
    protected $orderstep;

    // Include order test cases
    use Orders;

    /**
     * @before
     */
    public function init() {

        // Init Steps (define test name)
        $this->orderstep = new Steps($this, basename(__FILE__, ".php"));

        // Slack
        SlackAlerter::setSlackChannel(self::SLACK_CHANNEL_ASSERT_ERRORS);
        SlackAlerter::setSlackKey(self::SLACK_TOKEN);
        SlackAlerter::setSlackNick(self::SLACK_NICKNAME);
    }

    /*
     * Test | Enable payment processor
     */
    public function test_enablePaymentProcessorCashOnDelivery() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Enable payment processor
        try {
            // Start the process
            $processorStatus = $this->orderstep->enablePaymentProcessor(Steps::PAYMENT_PROCESSOR_CASHONDELIVERY, "selenium", false);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Assert (Check if payment processor is enabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'CASHONDELIVERY' is enabled");
        }
        catch (\Exception $e) {
            SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
        }
    }

    /*
     * Test | Single product, No Tax, With Discount 10%, No Funnel
     */
    public function test_10percent() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscount10percent("Cash On Delivery", false, "selenium");

        // Go to Shop env url
        $this->wd->get(self::$baseUrl);

        // Start the process
        try {
            // Order step results, to check assertions
            $results = $this->orderstep->completeOrder($orderData['productDetails'], $orderData['orderDetails'], $orderData['correctTotalValues'], $orderData['correctThankYouPageTotalValues'], $orderData['correctFunnelValues']);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Check for the correct value assertions
        if ($results) {
            foreach ($results as $res):
                try {
                    // Assertions
                    $this->{$res['assert']}($res['correct_values'], $res['returned_values'], $res['message']);
                }
                catch (\Exception $e) {
                    SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
                }
            endforeach;
        }
    }

    /*
     * Test | Single product, No Tax, With Discount 100%, No Funnel
     */
    public function test_100percent() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscount100percent("Cash On Delivery", false, "selenium");

        // Go to Shop env url
        $this->wd->get(self::$baseUrl);

        // Start the process
        try {
            // Order step results, to check assertions
            $results = $this->orderstep->completeOrder($orderData['productDetails'], $orderData['orderDetails'], $orderData['correctTotalValues'], $orderData['correctThankYouPageTotalValues'], $orderData['correctFunnelValues']);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Check for the correct value assertions
        if ($results) {
            foreach ($results as $res):
                try {
                    // Assertions
                    $this->{$res['assert']}($res['correct_values'], $res['returned_values'], $res['message']);
                }
                catch (\Exception $e) {
                    SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
                }
            endforeach;
        }
    }

    /*
     * Test | Single product, No Tax, With Discount - $10, No Funnel
     */
    public function test_Minus10_amount() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscountMinus10("Cash On Delivery", false, "selenium");

        // Go to Shop env url
        $this->wd->get(self::$baseUrl);

        // Start the process
        try {
            // Order step results, to check assertions
            $results = $this->orderstep->completeOrder($orderData['productDetails'], $orderData['orderDetails'], $orderData['correctTotalValues'], $orderData['correctThankYouPageTotalValues'], $orderData['correctFunnelValues']);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Check for the correct value assertions
        if ($results) {
            foreach ($results as $res):
                try {
                    // Assertions
                    $this->{$res['assert']}($res['correct_values'], $res['returned_values'], $res['message']);
                }
                catch (\Exception $e) {
                    SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
                }
            endforeach;
        }
    }

    /*
     * Test | Single product, No Tax, With Discount - $100, No Funnel
     */
    public function test_Minus100_amount() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscountMinus100("Cash On Delivery", false, "selenium");

        // Go to Shop env url
        $this->wd->get(self::$baseUrl);

        // Start the process
        try {
            // Order step results, to check assertions
            $results = $this->orderstep->completeOrder($orderData['productDetails'], $orderData['orderDetails'], $orderData['correctTotalValues'], $orderData['correctThankYouPageTotalValues'], $orderData['correctFunnelValues']);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Check for the correct value assertions
        if ($results) {
            foreach ($results as $res):
                try {
                    // Assertions
                    $this->{$res['assert']}($res['correct_values'], $res['returned_values'], $res['message']);
                }
                catch (\Exception $e) {
                    SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
                }
            endforeach;
        }
    }

    /*
     * Test | Single product, No Tax, With Discount - free shipping, No Funnel
     */
    public function test_FreeShipping_AllCountries() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscountFreeShipping("Cash On Delivery", false, "selenium");

        // Go to Shop env url
        $this->wd->get(self::$baseUrl);

        // Start the process
        try {
            // Order step results, to check assertions
            $results = $this->orderstep->completeOrder($orderData['productDetails'], $orderData['orderDetails'], $orderData['correctTotalValues'], $orderData['correctThankYouPageTotalValues'], $orderData['correctFunnelValues']);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Check for the correct value assertions
        if ($results) {
            foreach ($results as $res):
                try {
                    // Assertions
                    $this->{$res['assert']}($res['correct_values'], $res['returned_values'], $res['message']);
                }
                catch (\Exception $e) {
                    SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
                }
            endforeach;
        }
    }

    /*
     * Test | Disable payment processor
     */
    public function test_disablePaymentProcessorCashOnDelivery() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Enable payment processor
        $processorStatus = $this->orderstep->disablePaymentProcessor(Steps::PAYMENT_PROCESSOR_CASHONDELIVERY, "selenium", false);

        // Assert (Check if payment processor is disabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'CASHONDELIVERY' is disabled");
        }
        catch (\Exception $e) {
            SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
        }
    }
}