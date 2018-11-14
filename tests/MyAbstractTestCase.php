<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: MyAbstractTestCase
 * @author: sasokrajnc
 * @datetime: 21/10/2018 - 00:02
 * @version: MyAbstractTestCase.php, v1.1
 */

namespace My;

use Lmc\Steward\ConfigProvider;
use Lmc\Steward\Test\AbstractTestCase;
use My\Lib\Functions;
use OndraM\CiDetector\CiDetector;

/**
 * Abstract class for custom tests, could eg. define some properties or instantiate some common components in setUp().
 */
abstract class MyAbstractTestCase extends AbstractTestCase
{
    // Include functions
    use Functions;

    /** @var int Default width of browser window (Steward's default is 1280) */
    public static $browserWidth = 1310;
    /** @var int Default height of browser window (Steward's default is 1024) */
    public static $browserHeight = 1050;
    /** @var string */
    public static $baseUrl;
    /** @var string */
    public static $adminUrl;
    /** @var string */
    public static $currentEnv;

    // Steps log
    public static $stepdebug= false;
    public static $steplog= false;
    public static $stepdb= false;

    public function setUp()
    {
        parent::setUp();

        // Only show notification on local
        if (!(new CiDetector())->isCiDetected()) {
            self::startTest($this->getName());
        }

        // Set base and admin url according to environment
        switch (ConfigProvider::getInstance()->env) {
            case 'production':
                self::$baseUrl = '';
                self::$adminUrl = 'https://admin.carthook.com';
                self::$currentEnv = 'production';
                break;
            case 'stage':
                self::$baseUrl = 'https://carthook-stage-testing.myshopify.com';
                self::$adminUrl = 'https://admin.stage.carthook.com';
                self::$currentEnv = 'stage';
                break;
            case 'dev':
                self::$baseUrl = 'https://carthook-dev-testing.myshopify.com';
                self::$adminUrl = 'https://admin.dev.carthook.com';
                self::$currentEnv = 'dev';
                break;
            case 'local':
                self::$baseUrl = '';
                self::$adminUrl = '';
                self::$currentEnv = 'local';
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown environment "%s"', ConfigProvider::getInstance()->env));
        }

        $this->debug('Base URL set to "%s"', self::$baseUrl);

        if (ConfigProvider::getInstance()->env === 'production') {
            $this->warn('The tests are run against production, so be careful!');
        }
        if (ConfigProvider::getInstance()->env === 'stage') {
            $this->warn('The tests are run against staging environment');
        }
        if (ConfigProvider::getInstance()->env === 'dev') {
            $this->warn('The tests are run against development environment');
        }

        // Delete all cookies
        $this->wd->manage()->deleteAllCookies();
    }
}
