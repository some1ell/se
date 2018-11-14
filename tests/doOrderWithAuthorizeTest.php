<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: doOrderWithAuthorizeTest
 * @author: sasokrajnc
 * @datetime: 13/10/2018 - 22:47
 * @version: doOrderWithAuthorizeTest
 */

namespace My;

use My\ProductOrder\Constants;
use My\ProductOrder\Steps;
use My\ProductOrder\Orders;
use SlackAlerter;
use CL\Slack;

/**
 * Happy path to enable payment processor AUTHORIZE and perform tests
 *
 * @delayAfter My\doOrderWithNmiTest
 * @delayMinutes 0
 * @group 2
 * @group authorize
 * @group web2
 */
class doOrderWithAuthorizeTest extends MyAbstractTestCase implements Constants {

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
    public function test_enablePaymentProcessorAuthorize() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Enable payment processor
        try {
            // Start the process
            $processorStatus = $this->orderstep->enablePaymentProcessor(Steps::PAYMENT_PROCESSOR_AUTHORIZE, "selenium", false);
        }
        catch (\Exception $e) {
            SlackAlerter::webdriverException(basename(__FILE__, ".php"), __FUNCTION__, $e, self::SLACK_CHANNEL_WEBDRIVER_ERRORS);
        }

        // Assert (Check if payment processor is enabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'AUTHORIZE' is enabled");
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
        $orderData = $this->noTaxNoDiscountNoFunnel("Authorize", false, "selenium");

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
        $orderData = $this->withDiscount("Authorize", false, "selenium");

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
        $orderData = $this->withTax("Authorize", false, "selenium");

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
        $orderData = $this->withShipping("Authorize", false, "selenium");

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
        $orderData = $this->withOneStepFunnel("Authorize", false, "selenium");

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
        $orderData = $this->withTaxDiscountShippingOneStepFunnel("Authorize", false, "selenium");

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
        $orderData = $this->withTaxDiscountShippingTwoStepFunnel("Authorize", false, "selenium");

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
    public function test_disablePaymentProcessorAuthorize() {

        // Define function
        $this->orderstep->defineTestProperties(__FUNCTION__);

        // Go to Admin env url
        $this->wd->get(self::$adminUrl);

        // Disable payment processor
        $processorStatus = $this->orderstep->disablePaymentProcessor(Steps::PAYMENT_PROCESSOR_AUTHORIZE, "selenium", false);

        // Assert (Check if payment processor is disabled)
        try {
            // Assertions
            $this->assertTrue($processorStatus, "Payment processor 'AUTHORIZE' is disabled");
        }
        catch (\Exception $e) {
            SlackAlerter::assertException(basename(__FILE__, ".php"),$this->getName(), $e);
        }
    }
}