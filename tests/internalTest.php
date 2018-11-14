<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: doOrderWithPayPalTest
 * @author: sasokrajnc
 * @datetime: 13/10/2018 - 22:47
 * @version: doOrderWithPayPalTest */

namespace My;

use My\ProductOrder\Constants;
use My\ProductOrder\Steps;
use My\ProductOrder\Orders;
use SlackAlerter;
use CL\Slack;

/**
 * Happy path to enable payment processor PAYPAL and perform tests
 *
 * @group 1
 * @group paypal
 */
class internalTest extends MyAbstractTestCase implements Constants{

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
     * Test
     */
    public function testTest()
    {

        $this->wd->get(self::$adminUrl);

    }
}