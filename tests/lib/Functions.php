<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: Functions
 * @author: sasokrajnc
 * @datetime: 10/10/2018 - 20:33
 * @version: Functions v1.1
 */

namespace My\Lib;

use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverBy;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use SlackAlerter;
use My\MyAbstractTestCase;
use My\ProductOrder\Steps;

/**
 * Adds some functions
 */
trait Functions {

    /**
     * @param $function
     * @param $item
     * @param $message
     */
    public function logAction($function, $item, $message) {

        if ($item) {

            // Send steps to slack if debug enabled
            if(MyAbstractTestCase::$stepdebug){
                SlackAlerter::testStep(Steps::$testName, Steps::$subtestName, $function, $message);
            }

            // Send steps to log if debug enabled
            if(MyAbstractTestCase::$steplog){
                $this->logResults(Steps::$testName, Steps::$subtestName, $function, $message);
            }

            $this->debug($message . " :: Successfull");
        }
        else {

            $this->warn($message . " :: Not Successfull");
        }

    }

    /**
     * Check if field is filled correctly
     *
     * @param strinf $fieldtype :: input
     * @param string $webdriverWait :: waitForId
     * @param string $webdriverFind :: findById
     * @param string $attributeValue :: email
     * @param string $keys :: saso@carthook.com
     * @param string $message :: Message
     * @return string $fieldValue
     */
    public function completeAndCheckField($function, $fieldtype, $webdriverWait, $webdriverFind, $attributeValue, $keys, $message, $skipvalidation = false, $mustBeVisible = false, $selectType = "selectByVisibleText") {

        // Define total tryings
        $counter = 0;
        $max     = 20;

        // If element needs to be visible
        if ($mustBeVisible) {

            // Wait for field and make sure it is visible
            $fieldWait = $this->{$webdriverWait}($attributeValue, true);

        }
        else {

            // Wait for field
            $fieldWait = $this->{$webdriverWait}($attributeValue);
        }

        $this->logAction($function, $fieldWait, "Locating " . $fieldtype . "field: '" . $fieldtype . "'");

        // Find field
        $fieldFind = $this->{$webdriverFind}($attributeValue);
        $this->logAction($function, $fieldFind, "Setting field " . $fieldtype);

        if ($fieldtype === "input") {

            // Enter keys
            $sendKeys = $fieldWait->sendKeys($keys);
            $this->logAction($function, $sendKeys, "Entering data to input field " . $keys);

            if ($skipvalidation) {

                $fieldValue = $keys;

                $this->debug("Skipped Input Validation :: Confirming that input value is: '" . $keys . "'");

            }
            else {

                // Get field value
                $fieldValue = $fieldFind->getAttribute("value");
                $this->logAction($function, $fieldValue, "Getting field entered data " . $fieldValue);

                $this->debug("Checking if entered field data is correct");
                // Check if entered value is correct | If not, repeat until correct
                while (($counter < $max) && $fieldValue != $keys) {
                    $fieldFind->clear()->sendKeys($keys);

                    // Get new entered value
                    $fieldValue = $fieldFind->getAttribute("value");

                    $this->warn("vnos je: " . $fieldValue);


                    // Increase counter
                    $counter++;
                }
            }

            $this->debug("Entered field data is correct");

        }
        else {

            // Init select field
            $select = new WebDriverSelect($fieldWait);
            $this->logAction($function, $select, "Setting new select element");

            // Select option
            $select->{$selectType}($keys);

            // If validation is skipped
            if ($skipvalidation) {

                $fieldValue = $keys;

                $this->debug("Skipped Select Validation :: Confirming that selecting option is" . $keys);

            }
            else {

                $this->debug("Selecting option " . $keys);
                $this->debug("Checking if option is selected");

                // Get value of selected field
                $fieldValue = $fieldFind->getAttribute("value");

                // Check if field is selected
                if ($fieldValue) {

                    $this->logAction($function, $fieldValue, "Getting selected option");

                    // Check if entered value is correct | If not, repeat until correct
                    while (($counter < $max) && $fieldValue !== $keys) {

                        // Deselect all
                        $select->deselectAll();

                        // Select again
                        $select->{$selectType}($keys);

                        // Get new selected value
                        $fieldValue = $fieldFind->getAttribute("value");

                        // Increase counter
                        $counter++;
                    }

                    $this->debug("Confirming that selecting option is '" . $keys . "'");
                }
                else {

                    $this->debug("Option '" . $keys . "' is not selected");

                    // If field is not selected, select it
                    $selectAgain = $select->{$selectType}($keys);
                    $this->logAction($function, $selectAgain, "Option '" . $keys . "' is being selected again");

                    // Define new selected value
                    $fieldValue = $fieldFind->getAttribute("value");
                }
            }
        }

        // If field completing is successfully, log it
        $this->logAction($function, $fieldValue, $message);

        // Return field value
        return $fieldValue;
    }

    /**
     *  Get string between text
     *
     * @param $string
     * @param $start
     * @param $end
     * @return bool|string
     */
    public function get_string_between($string, $start, $end) {

        $string = ' ' . $string;
        $ini    = strpos($string, $start);
        if ($ini == 0)
            return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }

    /**
     * Get clean value without currency symbol and without thousand and decimal separators
     *
     * @param $value
     * @return mixed
     */
    public function get_clean_price($value) {

        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Get clean value without currency symbol
     *
     * @param $value
     * @return mixed
     */
    public function doCleanPrice($value) {

        return (string)(number_format(str_replace(array('$','-',','), array('','',''), $value),2));
    }

    /**
     * Log php results while testing
     *
     * @param $testName
     * @param $subtestName
     * @param $function
     * @param string $actionDescription
     */
    public function logResults($testName, $subtestName, $function, $actionDescription = "") {

        // Define results
        $logHeader = PHP_EOL .

            strtoupper($subtestName) . PHP_EOL . "Time: " . date("H:i:s") . PHP_EOL . "Function: " . $function . PHP_EOL . "Action description: " . $actionDescription . PHP_EOL .

            "-------------------------" . PHP_EOL;

        // Save results to log
        file_put_contents('./logs/' . $testName . '.log', $logHeader, FILE_APPEND);

    }

    /**
     * Display array difference, we will need this for chData comparing
     *
     * @param array $array1
     * @param array $array2
     * @param array|null $keysToCompare
     * @return array
     */
    function arrayDifference(array $array1, array $array2, array $keysToCompare = null) {

        $serialize   = function (&$item, $idx, $keysToCompare) {
            if (is_array($item) && $keysToCompare) {
                $a = array();
                foreach ($keysToCompare as $k) {
                    if (array_key_exists($k, $item)) {
                        $a[$k] = $item[$k];
                    }
                }
                $item = $a;
            }
            $item = serialize($item);
        };
        $deserialize = function (&$item) {
            $item = unserialize($item);
        };

        array_walk($array1, $serialize, $keysToCompare);
        array_walk($array2, $serialize, $keysToCompare);

        // Items that are in the original array but not the new one
        $deletions  = array_diff($array1, $array2);
        $insertions = array_diff($array2, $array1);

        array_walk($insertions, $deserialize);
        array_walk($deletions, $deserialize);

        return array('insertions' => $insertions,
                     'deletions'  => $deletions);
    }

    /**
     * Wait until condition is meet
     *
     * @return bool
     */
    function waitForSpinner() {

        // Wait until condition is meet (Wait for ch preloader)
        $webdriver     = $this->wd;
        $spinnerClosed = $this->wd->wait()->until(function () use ($webdriver) {
            $elements = $webdriver->findElements(WebDriverBy::className(self::DIV_BY_CLASS_LOADING_WINDOW_SPINNER));

            return count($elements) < 2;
        }, 'Error locating less than two elements');

        return ($spinnerClosed) ? true : false;
    }

    /**
     * New test notification
     *
     * @param $testName
     */
    public static function startTest($testName){

        $notifier = NotifierFactory::create();

        // Notification
        $notification =
            (new Notification())
                ->setTitle('New Test Started')
                ->setBody($testName)
                ->setIcon(__DIR__ . '/../img/logo.png')
                ->addOption('subtitle', '') // Only works on macOS (AppleScriptNotifier)
                ->addOption('sound', 'Frog') // Only works on macOS (AppleScriptNotifier)
        ;
        // Send it
        $notifier->send($notification);
    }

    /**
     * Test notification
     *
     * @param $message
     */
    public function debugMessage($message){

        $notifier = NotifierFactory::create();

        // Notification
        $notification =
            (new Notification())
                ->setTitle('Debug notification')
                ->setBody($message)
                ->setIcon(__DIR__ . '/../img/logo.png')
                ->addOption('subtitle', '') // Only works on macOS (AppleScriptNotifier)
                ->addOption('sound', 'Frog') // Only works on macOS (AppleScriptNotifier)
        ;
        // Send it
        $notifier->send($notification);
    }
}