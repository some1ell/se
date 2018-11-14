<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: doOrderWithBraintreeTest
 * @author: sasokrajnc
 * @datetime: 13/10/2018 - 22:47
 * @version: doOrderWithBraintreeTest
 */

namespace My;

use My\ProductOrder\Constants;
use My\ProductOrder\Steps;
use My\ProductOrder\Orders;
use SlackAlerter;
use CL\Slack;

/**
 * Happy path to enable payment processor BRAINTREE and perform tests
 *
 * @delayAfter My\doOrderWithAuthorizeTest
 * @delayMinutes 0
 * @group 3
 * @group braintree
 * @group web3
 */
class doOrderWithBraintreeTest extends MyAbstractTestCase implements Constants {

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
    public function test_enablePaymentProcessorBraintree() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Enable payment processor
        try {
            // Start the process
            $processorStatus = $this->orderstep->enablePaymentProcessor(Steps::PAYMENT_PROCESSOR_BRAINTREE, "selenium", false);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Assert (Check if payment processor is enabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'BRAINTREE' is enabled");
        }
        catch (\Exception $e) {
            SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
        }
    }

    /*
     * Test | Single product, No Tax, No Discount, No Funnel
     */
    public function test_AddSingleProductNoTaxNoDiscountNoFunnel() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->noTaxNoDiscountNoFunnel("Braintree", false, "selenium");

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
     * Test | Single product, No Tax, With Discount, No Funnel
     */
    public function test_AddSingleProductWithDiscount() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withDiscount("Braintree", false, "selenium");

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
     * Test | Single product, With Tax, No Discount, No Funnel
     */
    public function test_AddSingleProductWithTax() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withTax("Braintree", false, "selenium");

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
     * Test | Single product, With Tax, No Discount, No Funnel
     */
    public function test_AddSingleProductWithShipping() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withShipping("Braintree", false, "selenium");

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
     * Test | Single product, No Tax, No Discount, Funnel
     */
    public function test_AddSingleProductWithOneStepFunnel() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withOneStepFunnel("Braintree", false, "selenium");

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
     * Test | Single product, With Tax, With Discount, With Funnel
     */
    public function test_AddSingleProductWithTaxDiscountShippingOneStepFunnel() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withTaxDiscountShippingOneStepFunnel("Braintree", false, "selenium");

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
     * Test | Single product, With Tax, With Discount, With 2 Step Funnel
     */
    public function test_AddSingleProductWithTaxDiscountShippingTwoStepFunnel() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // What kind of order
        $orderData = $this->withTaxDiscountShippingTwoStepFunnel("Braintree", false, "selenium");

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
    public function test_disablePaymentProcessorBraintree() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Disable payment processor
        $processorStatus = $this->orderstep->disablePaymentProcessor(Steps::PAYMENT_PROCESSOR_BRAINTREE, "selenium", false);

        // Assert (Check if payment processor is disabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'BRAINTREE' is disabled");
        }
        catch (\Exception $e) {
            SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
        }
    }
}