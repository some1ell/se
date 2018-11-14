<?php

/**
 * Class SlackAlerter
 */
class SlackAlerter implements \My\ProductOrder\Constants
{
    /**
     * @var string
     */
    protected static $slackNick = "Carthook";

    /**
     * @var string
     */
    protected static $slackChannel = "#webdriver-errors";

    /**
     * @var string
     */
    protected static $slackKey = "";

    /**
     * @var string
     */
    protected static $slackIcon = "";

    /**
     * @param $testName
     * @param $subTest
     * @param Exception $e
     * @param $channel
     * @throws Exception
     */
    public static function webdriverException($testName, $subTest, \Exception $e, $channel)
    {
        if (!empty(self::getSlackKey())) {
            $slackPayload = new CL\Slack\Payload\ChatPostMessagePayload();

            $slackClient = new CL\Slack\Transport\ApiClient(self::getSlackKey());
            $slackPayload->setChannel($channel);
            $slackPayload->setUsername(self::getSlackNick());
            $slackPayload->setIconUrl(self::getSlackIcon());

            $slackPayload->setText("*" . $testName . "*" . PHP_EOL . ":: " . $subTest . "()" . PHP_EOL . PHP_EOL . "*Error:* " . PHP_EOL . $e->getMessage() . PHP_EOL . PHP_EOL . "*Trace:* " . PHP_EOL .  $e->getTraceAsString());

            $slackClient->send($slackPayload);
        }

        throw $e;
    }

    /**
     * @param string $fileName
     * @param string $testName
     * @param Exception $e
     * @throws Exception
     */
    public static function assertException($fileName, $testName, \Exception $e)
    {
        if (!empty(self::getSlackKey())) {
            $slackPayload = new CL\Slack\Payload\ChatPostMessagePayload();

            $slackClient = new CL\Slack\Transport\ApiClient(self::getSlackKey());
            $slackPayload->setChannel(self::getSlackChannel());
            $slackPayload->setUsername(self::getSlackNick());
            $slackPayload->setIconUrl(self::getSlackIcon());

            $slackPayload->setText("*" . $fileName . "*" . PHP_EOL . ":: " . $testName . PHP_EOL . PHP_EOL . "*Error:* " . PHP_EOL . $e->getMessage());

            $slackClient->send($slackPayload);
        }

        throw $e;
    }

    /**
     * @param string $testName
     * @param string $functionName
     * @param string $action
     */
    public static function testStep($testName, $subtestName, $functionName, $action)
    {
        if (!empty(self::getSlackKey())) {
            $slackPayload = new CL\Slack\Payload\ChatPostMessagePayload();

            $slackClient = new CL\Slack\Transport\ApiClient(self::getSlackKey());
            $slackPayload->setChannel(self::SLACK_CHANNEL_TEST_STEPS);
            $slackPayload->setUsername(self::getSlackNick());
            $slackPayload->setIconUrl(self::getSlackIcon());
            $slackPayload->setText("*" . $testName . "*" . PHP_EOL . ":: " . $subtestName . PHP_EOL . ":: " . $functionName . "()" . PHP_EOL . "--> " . $action);
            $slackClient->send($slackPayload);
        }
    }

    /**
     * @param string $functionName
     * @param string $message
     */
    public static function testError($functionName, $message)
    {
        if (!empty(self::getSlackKey())) {
            $slackPayload = new CL\Slack\Payload\ChatPostMessagePayload();

            $slackClient = new CL\Slack\Transport\ApiClient(self::getSlackKey());
            $slackPayload->setChannel(self::SLACK_CHANNEL_TEST_ERRORS);
            $slackPayload->setUsername(self::getSlackNick());
            $slackPayload->setIconUrl(self::getSlackIcon());

            $slackPayload->setText("*Error for function: " . $functionName . "() *" . PHP_EOL . "--> " . $message);

            $slackClient->send($slackPayload);
        }
    }

    /**
     * @param string $slackNick
     */
    public static function setSlackNick($slackNick)
    {
        self::$slackNick = $slackNick;
    }

    /**
     * @param string $slackChannel
     */
    public static function setSlackChannel($slackChannel)
    {
        self::$slackChannel = $slackChannel;
    }

    /**
     * @param string $slackKey
     */
    public static function setSlackKey($slackKey)
    {
        self::$slackKey = $slackKey;
    }

    /**
     * @param string $slackIcon
     */
    public static function setSlackIcon($slackIcon)
    {
        self::$slackIcon = $slackIcon;
    }

    /**
     * @return string
     */
    public static function getSlackNick()
    {
        return self::$slackNick;
    }

    /**
     * @return string
     */
    public static function getSlackChannel()
    {
        return self::$slackChannel;
    }

    /**
     * @return string
     */
    public static function getSlackKey()
    {
        return self::$slackKey;
    }

    /**
     * @return string
     */
    public static function getSlackIcon()
    {
        return self::$slackIcon;
    }
}
