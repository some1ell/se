<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: products
 * @author: sasokrajnc
 * @datetime: 09/10/2018 - 11:03
 * @version: products.php, v1.1
 */

namespace My\ProductOrder;

use Lmc\Steward\Component\AbstractComponent;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use My\Lib\RandomString;
use My\Lib\Functions;
use My\MyAbstractTestCase;
use CL\Slack;
use SlackAlerter;
use Lmc\Steward\Test\AbstractTestCaseBase;


/**
 * Product order tests
 * Page objects
 */
class Steps extends AbstractComponent implements Constants {

    // Test and subtest name
    public static $testName = "";
    public static $subtestName = "";

    /**
     * Create UniqueValue instance
     * @param AbstractTestCaseBase $tc TestCase instance
     * @param string $testName
     */
    public function __construct(AbstractTestCaseBase $tc, $testName)
    {
        parent::__construct($tc);
        self::$testName = $testName;
    }

    // Use functions
    use Functions;

    // ChData
    private $status_chdata = array();
    private $status_cartdata = array();

    /**
     * Properties for debug and log actions
     *
     * @param $subtestName
     */
    public function defineTestProperties($subtestName){

        self::$subtestName = $subtestName;
    }

    /**
     * Add product to a cart
     *
     * @param $product
     * @param bool $variant
     * @param int $qty
     * @param $product_id
     * @param $product_qty_id
     * @return array
     */
    public function addProductToCart($product, $variant = false, $qty = 1, $product_id, $product_qty_id) {

        // Find Catalog
        $actionDescription = "Clicking on menu Catalog";
        $action            = $this->findByLinkText(self::CATALOG)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page is loaded and check if title is correct
        $actionDescription = "Waiting for page products to load";
        $action            = $pageTitle = $this->waitForPartialTitle(self::PARTIAL_TITLE_PRODUCTS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Scroll to payment processors
        $actionDescription = "Scrolling through the page";
        $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Find product by name
        $actionDescription = "Finding product " . $product['name'];
        $action            = $productLocated = $this->findByLinkText($product['name']);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get product name
        $actionDescription = "Getting product name";
        $action            = $productName = $productLocated->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Click on product by Text
        $actionDescription = "Clicking on product " . $product['name'];
        $action            = $productLocated->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // If Product has variants
        if ($variant) {
            // Select variant
            $this->completeAndCheckField(__FUNCTION__,"select", "waitForId", "findById", self::SELECT_VARIANT, $variant, "Variant " . $variant . " is selected", false, true, "selectByVisibleText");
        }

        // Get product data
        $actionDescription = "Getting a product price";
        $action            = $productPrice = $this->findByClass(self::PRODUCT_PRICE)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // It is faster to click back and add another product to a cart if qty < 3
        if ($qty < 3) {
            // Check for quantity and add product to a cart
            $i = 0;
            do {
                if ($i != 0) {

                    // Click back button to add new item again to a cart
                    $actionDescription = "Clicking on browser back button";
                    $action            = $this->wd->navigate()->back();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait until page is loaded and check if title is correct
                    $actionDescription = "Waiting for page single product to be laoded";
                    $action            = $this->waitForPartialTitle($product['name']);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                }
                // Click button to add it to a cart
                $actionDescription = "Clicking on add to a cart button";
                $action            = $addToACart = $this->findById(self::ADD_TO_CART)->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                $i++;
            } while ($i < $qty);
        }
        else {
            // Click button to add it to a cart
            $actionDescription = "Clicking on add to a cart button";
            $action            = $addToACart = $this->findById(self::ADD_TO_CART)->click();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Wait for Cart page title
            $actionDescription = "Waiting for page cart to load";
            $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_CART);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Find quantity field and, click, clear it
            $actionDescription = "Finding quantity field, clicking on it and clearing value";
            $action            = $qtyField = $this->waitForId($product_qty_id)->click()->clear();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Enter new quantity
            $actionDescription = "Entering new product quantity " . $qty;
            $action            = $qtyField->sendKeys($qty);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Update new quantity
            $actionDescription = "Updating a new product quantity";
            $action            = $this->findByCss(self::INPUT_FIELD_BY_CSS_CART_UPDATE_QTY_BUTTON)->click();
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Return array :: Item name :: Item variant :: Item price :: Item quantity :: Total
        $productData = array("name"     => $productName,
                             "quantity" => $qty,
                             "variant"  => ($variant) ? $variant : "",
                             "price"    => $productPrice,
                             "id"       => $product_id,
                             "qty_id"   => $product_qty_id);
        $this->logAction(__FUNCTION__,$addToACart, "Product '" . $product['name'] . "' is added to a cart");

        // Return
        return $productData;
    }

    /**
     * Go to checkout page
     *
     * @return string
     */
    public function gotoCheckoutPage() {

        // Wait until cart page is opened and search for checkout button and then click on it
        $actionDescription = "Clicking on checkout button";
        $action            = $this->waitForClass(self::BUTTON_CHECKOUT)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until checkout page is opened and check if title is correct
        $actionDescription = "Waiting for checkout page to be loaded";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_CHECKOUT);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until line items are loaded
        $actionDescription = "Waiting for products to be loaded";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className(self::LOADED_PRODUCTS)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Return checkout page title
        return $this->wd->getTitle();
    }

    /**
     * Go to products page
     *
     * @return string
     */
    public function gotoProductsPage() {
        // Find Catalog from the menu and click on it
        $actionDescription = "Clicking on menu Catalog";
        $action            = $this->findByLinkText(self::CATALOG)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page is loaded and check if title is correct
        $actionDescription = "Waiting for page products to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_PRODUCTS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Return products page title
        $actionDescription = "Getting page title";
        $pageTitle         = $this->wd->getTitle();
        $this->logAction(__FUNCTION__,$pageTitle, $actionDescription);

        return $pageTitle;
    }

    /**
     * Fill shipping data
     *
     * @param $country
     * @param $emailCounter
     * @return array
     */
    public function fillShippingData($country, $emailCounter) {

        // Get defined shipping with unique email 'increase' string
        $getShipping = Define::defineShipping($country, $emailCounter);

        // Complete "Email" field
        $ShippingEmail = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_CHECKOUT_EMAIL, $getShipping['email'], "Email " . $getShipping['email'] . " is entered");

        // Complete "First name" field
        $ShippingFirstName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_FIRSTNAME, $getShipping['firstname'], "First name " . $getShipping['firstname'] . " is entered");

        // Complete "Last name" field
        $ShippingLastName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_LASTNAME, $getShipping['lastname'], "Last name " . $getShipping['lastname'] . " is entered");

        // Complete "Address" field
        $ShippingAddress = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_ADDRESS, $getShipping['address'], "Address " . $getShipping['address'] . " is entered");

        // Complete "City" field
        $ShippingCity = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_CITY, $getShipping['city'], "City " . $getShipping['city'] . " is entered");

        // Complete "Country" field
        $ShippingCountry = $this->completeAndCheckField(__FUNCTION__,"select", "waitForId", "findById", self::SELECT_FIELD_BY_ID_COUNTRY, $getShipping['country'], "Country " . $getShipping['country'] . " is selected");

        if ($getShipping["state"] != "") {
            $ShippingCountry = $this->completeAndCheckField(__FUNCTION__,"select", "waitForId", "findById", self::SELECT_FIELD_BY_ID_COUNTRY_STATE, $getShipping['state'], "State " . $getShipping['state'] . " is selected");
        }

        // Complete "Zip" field
        $ShippingZip = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_ZIP, $getShipping['zip'], "Zip " . $getShipping['zip'] . " is entered");

        $shippingData = array("email"     => $ShippingEmail,
                              "firstname" => $ShippingFirstName,
                              "lastname"  => $ShippingLastName,
                              "address"   => $ShippingAddress,
                              "city"      => $ShippingCity,
                              "country"   => $ShippingCountry,
                              "zip"       => $ShippingZip,);

        // Return
        return $shippingData;
    }

    /**
     * Fill admin login data
     *
     * @param $admin
     * @return array
     */
    public function fillAdminLoginData($admin) {

        $getLoginData = Define::defineAdminLogin($admin);
        $this->logAction(__FUNCTION__,$getLoginData, "Admin login data is prepared");

        // Complete "Email" field
        $LoginEmail = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_ADMIN_LOGIN_EMAIL, $getLoginData['email'], "Email '" . $getLoginData['email'] . "' is entered");

        // Complete "Password" field
        $LoginPass = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_ADMIN_LOGIN_PASSWORD, $getLoginData['password'], "Password '" . $getLoginData['password'] . "' is entered");

        $loginData = array("email"    => $LoginEmail,
                           "password" => $LoginPass);

        // Click on Sign in button
        $actionDescription = "Clicking on Sign in button";
        $action            = $this->findByTag("button")->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Return
        return $loginData;
    }

    /*
     * Wait until shipping is fetched
     */
    public function waitForShippingFetch() {

        // Wait until Spinner is not visible any more
        $actionDescription = "Waiting for spinner to finish loading";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className("fa-spinner")));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until shipping value contains currency symbol
        $actionDescription = "Waiting for shipping values to be fetched";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementTextContains(WebDriverBy::cssSelector(self::SHIPPING_FETCH), self::SHIPPING_FETCH_SYMBOL));
        $this->logAction(__FUNCTION__,$action, $actionDescription);
    }

    public function storeConnectionModalFix(){
        /* ##################### Only for Test until bug fixed*/
        $modalIsVisible = false;
        $webdriver     = $this->wd;

        try{
            $findModal = $webdriver->findElements(WebDriverBy::className(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS));
            $modalIsVisible = (count($findModal) >= 1) ? true : false;

        } catch (\Exception $e){
            'Error locating window. Number located: ' . $modalIsVisible;

        } finally{

            if($modalIsVisible){

                $this->debugMessage("Store connection modal");

                $this->logAction(__FUNCTION__, $modalIsVisible, "Connect Store Modal window is visible");
                $closeModal = $this->findByClass(self::MODAL_CLOSE_BUTTON)->click();
                $this->logAction(__FUNCTION__, $closeModal, "Modal window is closed");
                $modalIsClosed = $this->wd->wait(10, 1000)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS)));
                $this->logAction(__FUNCTION__, $modalIsClosed, "Connect Store Modal window is not visible anymore");
            }
        }
        /* ############################################################# */
    }

    /**
     * Disable payment processor
     *
     * @param $paymentProcessor
     * @param $adminLogin
     * @param bool $openNewTab
     * @return bool
     */
    public function disablePaymentProcessor($paymentProcessor, $adminLogin, $openNewTab = true) {

        $process = false;

        // If new tab is true, we will open new browser tab
        if ($openNewTab) {

            // Open new tab and store main tab in new variable
            $actionDescription = "Opening a new browser tab";
            $action            = $mainTab = $this->openNewTab();
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Login to Admin panel
        $this->loginToCarthookAdmin($adminLogin, $openNewTab);

        // Wait for dropdown menu to be visible and click on it
        $actionDescription = "Clicking on user dropdown menu";
        $action            = $this->waitForId(self::A_HREF_BY_ID_ADMIN_DASHBOARD_USERMENU_DROPDOWN)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Find menu Settings and click on it
        $actionDescription = "Clicking on menu Settings";
        $action            = $this->findByLinkText(self::SPAN_BY_TEXT_ADMIN_DASHBOARD_USERMENU_SETTINGS)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page title Store Settings is visible
        $actionDescription = "Waiting for page Settings to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_ADMIN_SETTINGS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Check if modal window for Store connection is shown
        $this->storeConnectionModalFix();

        // Find menu Payment Providers and click on it
        $actionDescription = "Clicking on menu Payment providers";
        $action            = $this->waitForLinkText(self::A_HREF_BY_TEXT_ADMIN_DASHBOARD_SETTINGS_PAYMENTPROVIDERS)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page title Payment Processors is visible
        $actionDescription = "Waiting for page Payment providers to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_ADMIN_SETTINGS_PAYMENTPROCESSORS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Only for Payment processor that requires modal window to apply additional settings
        if ($paymentProcessor != self::PAYMENT_PROCESSOR_CASHONDELIVERY) {

            switch ($paymentProcessor):
                case self::PAYMENT_PROCESSOR_PAYPAL:

                    // Wait for PayPal processor to load on page
                    $actionDescription = "Waiting for PayPal to load";
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Check if payment processor is already connected
                    $actionDescription = "Checking if payment provider PayPal is connected";
                    $action            = $checkSelected = $this->findByXpath(self::SPAN_BY_XPATH_PAYPAL_BLOCK_CHECK_IF_CONNECTED)->getText();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    if ($checkSelected == self::PAYMENT_PROCESSOR_CONNECTED) {

                        $this->debug("PayPal payment processor in connected. We will disable it.");

                        // Click on Remove button
                        $actionDescription = "We are disabling payment processor, remove button is clicked";
                        $action            = $this->findByXpath(self::A_HREF_BY_XPATH_PAYPAL_REMOVE_BUTTON)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Wait for success message
                        $actionDescription = "Waiting for PayPal disconnect success message";
                        $action            = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Process was successful
                        $process = true;
                    }
                    else {
                        $this->debug("PayPal payment processor is already disconected.");

                        // Process was successful
                        $process = true;
                    }

                    break;
                case self::PAYMENT_PROCESSOR_CASHONDELIVERY:
                    break;
                default:

                    // Wait for Credit Card processor to load on page
                    $actionDescription = "Waiting for payment processor " . $paymentProcessor . " to load";
                    $action            = $this->waitForXpath(self::SPAN_BY_XPATH_CREDITCARDS_BLOCK_CHECK_IF_CONNECTED);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Check if payment processor is already connected
                    $actionDescription = "Checking if payment provider " . $paymentProcessor . " is connected";
                    $action            = $checkSelected = $this->findByXpath(self::SPAN_BY_XPATH_CREDITCARDS_BLOCK_CHECK_IF_CONNECTED)->getText();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    if ($checkSelected == self::PAYMENT_PROCESSOR_CONNECTED) {

                        $this->debug("Payment processor '" . $paymentProcessor . "' in connected. We will disable it.");

                        // Click on Remove button
                        switch ($paymentProcessor):
                            case self::PAYMENT_PROCESSOR_NMI:

                                $actionDescription = "Clicking on remove button to remove Nmi";
                                $action            = $disconnectButton = $this->findByXpath(self::A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_NMI)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                break;
                            case self::PAYMENT_PROCESSOR_AUTHORIZE:

                                $actionDescription = "Clicking on remove button to remove Authorize";
                                $action            = $disconnectButton = $this->findByXpath(self::A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_AUTHORIZE)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                break;
                            case self::PAYMENT_PROCESSOR_BRAINTREE:

                                $actionDescription = "Clicking on remove button to remove Braintree";
                                $action            = $disconnectButton = $this->findByXpath(self::A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_BRAINTREE)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                break;
                            case self::PAYMENT_PROCESSOR_STRIPE:

                                $actionDescription = "Clicking on remove button to remove Stripe";
                                $action            = $disconnectButton = $this->findByXpath(self::A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_STRIPE)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                break;
                        endswitch;

                        isset($disconnectButton) ? $this->logAction(__FUNCTION__,$disconnectButton, "Remove button is clicked") : $this->warn("Cannot locate disconnect button");

                        // Wait for success message
                        $actionDescription = "Waiting for " . $paymentProcessor . " disconnected success message";
                        $action            = $connectionSuccessMessage = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Process was successful
                        $process = true;
                    }
                    else {
                        $this->debug("PayPal payment processor is already disconnected.");

                        // Process was successful
                        $process = true;
                    }

                    break;
            endswitch;
        }
        else {
            // Only for Payment processor that do not requires modal window to apply additional settings

            $process = true;
        }

        // If we opened new tab, we need to close it after the process and move back to main browser window
        if ($openNewTab) {

            // Close tab
            $actionDescription = "We are closing tab";
            $action            = $this->wd->close();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Switch back to main tab window
            $actionDescription = "We are switched back to a main tab";
            $action            = $this->wd->switchTo()->window($mainTab);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

        }

        return ($process) ? true : false;

    }

    /**
     * Check if Payment processor is enabled, if not, enable it
     *
     * @param $paymentProcessor
     * @param $adminLogin
     * @param bool $openNewTab
     * @return bool
     */
    public function enablePaymentProcessor($paymentProcessor, $adminLogin, $openNewTab = true) {

        $process = false;

        // If new tab is true, we will open new browser tab
        if ($openNewTab) {

            // Open new tab and store main tab in new variable
            $actionDescription = "Opening new tab";
            $action            = $mainTab = $this->openNewTab();
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Login to Admin panel
        $this->loginToCarthookAdmin($adminLogin, $openNewTab);

        // Wait for dropdown menu to be visible and click on itgit
        $actionDescription = "Clicking on user dropdown menu";
        $action            = $this->waitForId(self::A_HREF_BY_ID_ADMIN_DASHBOARD_USERMENU_DROPDOWN)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Find menu Settings and click on it
        $actionDescription = "Menu Settings in clicked";
        $action            = $this->findByLinkText(self::SPAN_BY_TEXT_ADMIN_DASHBOARD_USERMENU_SETTINGS)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page title Store Settings is visible
        $actionDescription = "Waiting for page Settings to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_ADMIN_SETTINGS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Check if modal window for Store connection is shown
        $this->storeConnectionModalFix();

        // Find menu Payment Providers and click on it
        $actionDescription = "Clicking on menu Payment Providers";
        $action            = $this->waitForLinkText(self::A_HREF_BY_TEXT_ADMIN_DASHBOARD_SETTINGS_PAYMENTPROVIDERS)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until page title Payment Processors is visible
        $actionDescription = "Waiting for page Payment Providers to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_ADMIN_SETTINGS_PAYMENTPROCESSORS);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Only for Payment processor that requires modal window to apply additional settings
        if ($paymentProcessor != self::PAYMENT_PROCESSOR_CASHONDELIVERY) {

            $this->debug("Payment Processor will be selected");

            switch ($paymentProcessor):
                case self::PAYMENT_PROCESSOR_PAYPAL:
                case self::PAYMENT_PROCESSOR_PAYPAL_EXPRESS:

                    // Wait for PayPal processor to load on page
                    $actionDescription = "Waiting for PayPal to load";
                    $action            = $this->waitForXpath(self::SPAN_BY_XPATH_PAYPAL_BLOCK_CHECK_IF_CONNECTED);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Check if payment processor is already connected
                    $actionDescription = "Checking if PayPal is already connected";
                    $action            = $checkSelected = $this->findByXpath(self::SPAN_BY_XPATH_PAYPAL_BLOCK_CHECK_IF_CONNECTED)->getText();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    if ($checkSelected != self::PAYMENT_PROCESSOR_CONNECTED) {

                        $this->debug("Payment processor in not connected. We will connect it.");

                        // Click on Connect Now button
                        $actionDescription = "Clicking on connect now buttob";
                        $action            = $this->findByXpath(self::A_HREF_BY_XPATH_PAYPAL_BUTTON_CONNECTNOW)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Wait until modal window is loaded
                        $actionDescription = "Waiting for modal window to open";
                        $action            = $this->waitForClass(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        $this->debug("PayPal Payment Processor data will be filled");

                        // Wait for API Username field to be visible and fill in data
                        $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::PAYPAL_INPUT_FIELD_BY_ID_APIUSERNAME, self::PAYPAL_API_USERNAME, "PayPal API Username " . self::PAYPAL_API_USERNAME . " is entered");

                        // Wait for API Password field to be visible and fill in data
                        $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::PAYPAL_INPUT_FIELD_BY_ID_APIPASSWORD, self::PAYPAL_API_PASSWORD, "PayPal API Password " . self::PAYPAL_API_PASSWORD . " is entered");

                        // Wait for API Signature field to be visible and fill in data
                        $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::PAYPAL_INPUT_FIELD_BY_ID_APISIGNATURE, self::PAYPAL_API_SIGNATURE, "PayPal API Signature " . self::PAYPAL_API_SIGNATURE . " is entered");

                        // Check if reference transactions are enabled
                        $actionDescription = "Checking if reference transactions are enabled";
                        $action            = $selectaReferenceTransactions = $this->wd->findElement(WebDriverBy::id(self::PAYPAL_CHECKBOX_FIELD_BY_ID_REFERENCE_TRANSACTIONS));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // If option is not checked, check it
                        if (!$selectaReferenceTransactions->isSelected()) {

                            // Reference transactions are not enabled
                            $this->debug("Reference transactions are not enabled");

                            // Make reference transaction visible
                            $actionDescription = "Making checkbox visible to be clickable";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::PAYPAL_CHECKBOX_FIELD_BY_ID_REFERENCE_TRANSACTIONS . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Check reference transactions
                            $actionDescription = "Enabling reference transactions";
                            $action            = $this->findByXpath(self::PAYPAL_CHECKBOX_FIELD_BY_XPATH_SLIDER_ROUND_REFERENCE_TRANSACTIONS_CHECK)->click();
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }
                        else {

                            // Reference transactions are enabled
                            $this->debug("Reference transactions are enabled");
                        }

                        // Scroll to bottom of the page
                        $actionDescription = "Scrolling to the bottom of the page";
                        $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Click on Save PayPal API Data
                        $actionDescription = "Clicking on connect button for PayPal";
                        $action            = $this->findByXpath(self::PAYPAL_CONNECT_BUTTON_BY_XPATH)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Waiting modal window to close
                        $actionDescription = "Waiting for modal window to close";
                        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS)));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Wait for success message
                        $actionDescription    = "Waiting for connection success message";
                        $payPalSuccessMessage = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                        $this->logAction(__FUNCTION__,$payPalSuccessMessage, $actionDescription);

                        // Process was successful
                        $process = ($payPalSuccessMessage) ? true : false;
                    }
                    else {
                        $this->debug("PayPal Payment processor is already connected.");

                        // Process was successful
                        $process = true;
                    }

                    break;
                case self::PAYMENT_PROCESSOR_CASHONDELIVERY:

                    // Wait for
                    break;
                default:

                    // Wait for select to be visible
                    $actionDescription = "Waiting for the Credit Card select dropdown field to be visible";
                    $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::tagName(self::SELECT_BY_TAG_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Waiting for the Credit Card providers to be loaded
                    $actionDescription = "Waiting for the Credit Card providers to be loaded into select field";
                    $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className(self::SELECT_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Select payment processor
                    $this->completeAndCheckField(__FUNCTION__,"select", "waitForClass", "findByClass", self::SELECT_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD, $paymentProcessor, "Payment Processor " . $paymentProcessor . " is selected", "true");

                    // Check if payment processor is already connected
                    $actionDescription = "Checking if payment processor is already connected";
                    $checkSelected     = $this->findByXpath(self::SPAN_BY_XPATH_CREDITCARDS_BLOCK_CHECK_IF_CONNECTED)->getText();
                    $this->logAction(__FUNCTION__,$checkSelected, $actionDescription);

                    if ($checkSelected != self::PAYMENT_PROCESSOR_CONNECTED) {

                        $this->debug("Payment processor in not connected. We will connect it.");

                        // Click on Connect Now button
                        $actionDescription = "Clicking on the Connect now button";
                        $action            = $this->findByLinkText(self::SPAN_BY_TEXT_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD_BUTTON)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Wait until modal window is loaded
                        $actionDescription = "Waiting for the modal window to load";
                        $action            = $this->waitForClass(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        $this->debug("Payment Processor data will be filled");

                        // Based on payment processor, enable it
                        switch ($paymentProcessor):
                            case self::PAYMENT_PROCESSOR_NMI:

                                // Find confirmation checkbox and click on it (use space to check it)
                                $actionDescription = "Clicking on Nmi confirmation checkbox";
                                $action            = $this->findByName(self::NMI_INPUT_CHECKBOX_BY_NAME_CONFIRMATION)->sendKeys(array(WebDriverKeys::SPACE));
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for API field to be visible and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::NMI_INPUT_FIELD_BY_ID_APIKEY, self::NMI_API_KEY, "Nmi API Key " . self::NMI_API_KEY . " is entered");

                                // Click on Connect button
                                $actionDescription = "Clicking on Nmi connect buttob";
                                $action            = $this->findByXpath(self::NMI_CONNECT_BUTTON_BY_XPATH)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Waiting for the modal window to close
                                $actionDescription = "Waiting for the modal window to close";
                                $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS)));
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for success message
                                $actionDescription = "Waiting for the connection success message";
                                $action            = $nmiSuccessMessage = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Process was successful
                                $process = ($nmiSuccessMessage) ? true : false;

                                break;

                            case self::PAYMENT_PROCESSOR_AUTHORIZE:

                                // Wait for API login ID field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::AUTHORIZE_INPUT_FIELD_BY_ID_API_LOGINID, self::AUTHORIZE_API_LOGINID, "Authorize Login ID " . self::AUTHORIZE_API_LOGINID . " is entered");

                                // Wait for Transaction Key field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::AUTHORIZE_INPUT_FIELD_BY_ID_TRANSACTIONKEY, self::AUTHORIZE_API_TRANSACTIONKEY, "Authorize Transaction Key " . self::AUTHORIZE_API_TRANSACTIONKEY . " is entered");

                                // Wait for Public Client Key field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::AUTHORIZE_INPUT_FIELD_BY_ID_PUBLICCLIENTKEY, self::AUTHORIZE_API_PUBLICCLIENTKEY, "Authorize Public Key " . self::AUTHORIZE_API_PUBLICCLIENTKEY . " is entered");

                                // Click on Connect button
                                $actionDescription = "Clicking on Authorize connect button";
                                $action            = $this->findByXpath(self::AUTHORIZE_CONNECT_BUTTON_BY_XPATH)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for success message
                                $actionDescription = "Waiting for the connection succes message";
                                $action            = $authorizeSuccessMessage = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Process was successful
                                $process = ($authorizeSuccessMessage) ? true : false;

                                break;

                            case self:: PAYMENT_PROCESSOR_BRAINTREE:

                                // Wait for Braintree merchant ID field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::BRAINTREE_INPUT_FIELD_BY_ID_MERCHANTID, self::BRAINTREE_API_MERCHANTID, "Braintree Merchant ID " . self::BRAINTREE_API_MERCHANTID . " is entered");

                                // Wait for Public API key field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::BRAINTREE_INPUT_FIELD_BY_ID_PUBLIC_API_KEY, self::BRAINTREE_API_PUBLICAPIKEY, "Braintree API Public Key " . self::BRAINTREE_API_PUBLICAPIKEY . " is entered");

                                // Wait for Private API key field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::BRAINTREE_INPUT_FIELD_BY_ID_PRIVATE_API_KEY, self::BRAINTREE_API_PRIVATEAPIKEY, "Braintree API Private Key " . self::BRAINTREE_API_PRIVATEAPIKEY . " is entered");

                                // Check if reference transactions are enabled
                                $actionDescription = "Checking if reference transactions are enabled";
                                $action            = $enablePayPalPayments = $this->wd->findElement(WebDriverBy::id(self::BRAINTREE_INPUT_CHECKBOX_BY_ID_PAYPAL_CONFIRMATION));
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // If option is not checked, check it
                                if (!$enablePayPalPayments->isSelected()) {

                                    // Reference transactions are not enabled
                                    $this->debug("PayPal payments with Braintree are not enabled. We will enable them.");

                                    // Make reference transaction visible
                                    $actionDescription = "Making checkbox button visible for the PayPal transactions";
                                    $action            = $this->wd->executeScript("document.getElementById('" . self::BRAINTREE_INPUT_CHECKBOX_BY_ID_PAYPAL_CONFIRMATION . "').style.display = 'block';");
                                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                                    // Check PayPal payments
                                    $actionDescription = "Enabling PayPal payment with the Braintree";
                                    $action            = $this->findByXpath(self::BRAINTREE_INPUT_CHECKBOX_BY_XPATH_SLIDER_ROUND_PAYPAL_CONFIRMATION_CHECK)->click();
                                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                                }
                                else {

                                    // Reference transactions are enabled
                                    $this->debug("PayPal payments with Braintree are enabled");
                                }

                                // Scroll to the bottom
                                $actionDescription = "Scrolling to the bottom of the page";
                                $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Click on Connect button
                                $actionDescription = "Clicking on the connect button for the Braintree";
                                $action            = $this->findByXpath(self::BRAINTREE_CONNECT_BUTTON_BY_XPATH)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for success message
                                $actionDescription = "Waiting for the Braintree connection success message";
                                $action            = $braintreeSuccessMessage = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Process was successful
                                $process = ($braintreeSuccessMessage) ? true : false;
                                break;

                            case self::PAYMENT_PROCESSOR_STRIPE:

                                // Wait for connect button and click on it
                                $actionDescription = "Waiting for connect Stripe button to appear";
                                $action            = $connectStripeButton = $this->waitForXpath(self::STRIPE_CONNECT_BUTTON_BY_XPATH);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Clicking on connect Strip button
                                $actionDescription = "Clicking on connect Stripe button";
                                $action            = $connectStripeButton->sendKeys(WebDriverKeys::ENTER);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait until page is redirected to Strip connect page
                                $actionDescription = "Waiting for page to redirect to the Stripe";
                                $action            = $this->wd->wait()->until(WebDriverExpectedCondition::urlContains(self::STRIPE_CONNECT_PAGE_BY_PARTIAL_URL));
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Find Sign in button and click on it
                                $actionDescription = "Clicking on the Sign in button to fill the login credentials";
                                $action            = $this->findByCss(self::STRIPE_A_HREF_BY_CSS_SIGNIN)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Find field email and fill data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", "email", self::STRIPE_LOGIN_EMAIL, "Email: " . self::STRIPE_LOGIN_EMAIL . " is entered");

                                // Find password field and fill in data
                                $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", "password", self::STRIPE_LOGIN_PASSWORD, "Password: " . self::STRIPE_LOGIN_PASSWORD . " is entered");

                                // Click on Sign in button
                                $actionDescription = "Clicking on the Sign in button to log in";
                                $action            = $this->findByClass(self::STRIPE_BUTTON_BY_CLASS_SIGNIN)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for unsuccessful page loaded (localhost)
                                $actionDescription = "Waiting for the unsuccessfull page loaded (local host)";
                                $action            = $this->wd->wait()->until(WebDriverExpectedCondition::urlContains(self::STRIPE_REDIRECT_BY_PARTIAL_URL_LOCAL_HOST));
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Getting current url
                                $actionDescription = "Getting current page url, and changing it to match the admin redirect url";
                                $currentUrl        = $this->wd->getCurrentURL();
                                $this->logAction(__FUNCTION__,$currentUrl, $actionDescription);

                                // Change url to "http://admin.dev.carthook.com" with stripe parameters included
                                $newUrl = str_replace(self::STRIPE_REDIRECT_BY_PARTIAL_URL_LOCAL_HOST, MyAbstractTestCase::$adminUrl, $currentUrl);

                                // Go to new url
                                $actionDescription = "Redirecting to the Admin page";
                                $action            = $this->wd->get($newUrl);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Wait for successfully connection
                                $actionDescription       = "Waiting for the Stripe successfull connection message";
                                $stripeConnectionMessage = $this->waitForXpath(self::SPAN_BY_XPATH_CREDITCARDS_BLOCK_CHECK_IF_CONNECTED)->getText();
                                $this->logAction(__FUNCTION__,$stripeConnectionMessage, $actionDescription);

                                // Process was successful
                                $process = ($stripeConnectionMessage == self::PAYMENT_PROCESSOR_CONNECTED) ? true : false;

                                break;
                            default:
                                $this->warn("Payment processor '" . $paymentProcessor . "' cannot be found!");

                                // Process was not successfull
                                $process = false;

                                break;
                        endswitch;
                    }
                    else {
                        $this->debug("Payment processor '" . $paymentProcessor . "' is connected.");

                        // Process was successful
                        $process = true;
                    }

                    break;
            endswitch;
        }
        else {
            // Only for Payment processor that do not requires modal window to apply additional settings

            // Check if payment processor is already connected
            $actionDescription = "Checking if the payment processor Cash on Delivery is already connected";
            $action            = $checkSelected = $this->findByXpath(self::SPAN_BY_XPATH_CREDITCARDS_CONNECTION_STATUS)->getText();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            if ($checkSelected != self::PAYMENT_PROCESSOR_CONNECTED) {

                $this->debug("Payment processor Cash on Delivery in not connected. We will connect it.");

                // Click on Connect Now button
                $actionDescription = "Clicking on the connect now button";
                $action            = $this->findByCss(self::SPAN_BY_CSS_CREDITCARDS_CONNECTNOW_BUTTON)->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Wait for success message
                $actionDescription = "Waiting for the connection successful message";
                $action            = $this->waitForClass(self::MESSAGE_BY_CLASS_TOAST_SUCCESS);
                $this->logAction(__FUNCTION__,$action, $actionDescription);
            }

            $process = true;
        }

        // If we opened new tab, we need to close it after the process and move back to main browser window
        if ($openNewTab) {

            // Close tab
            $actionDescription = "Closing the tab";
            $action            = $this->wd->close();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Switch back to main tab window
            $actionDescription = "Switching back to the main window";
            $action            = $this->wd->switchTo()->window($mainTab);
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        return ($process) ? true : false;
    }

    /**
     * PayPal login processor used for login with PayPal, PayPal Express and PayPal through Braintree
     *
     * @param $type
     * @param $userType
     * @param bool $modal
     * @return array|bool
     */
    public function PayPalLoginProcess($type, $userType, $modal = true) {

        // Get PayPal Payment login credentials
        $getPaymentProcessorData = Define::definePayPal($type, $userType);
        $this->logAction(__FUNCTION__,$getPaymentProcessorData, "Preparing login credentials for a Payment Processor 'PayPal'");

        // If PayPal modal is opened
        if ($modal) {
            // Wait until PayPal login window is opened
            $actionDescription = "Waiting for the PayPal modal login window to open";
            $action            = $this->wd->wait()->until(WebDriverExpectedCondition::numberOfWindowsToBe(2));
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Get all window tabs
            $actionDescription = "Getting all opened windows tab IDS";
            $action            = $handles = $this->wd->getWindowHandles();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Switch to a PayPal newly opened window
            $actionDescription = "Switching to a newly PayPal modal window";
            $action            = $this->wd->switchTo()->window(end($handles));
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Getting current window title
            $actionDescription = "Getting current window title";
            $action            = $this->wd->getTitle();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Wait until iframe with input field for email login is loaded
            $actionDescription = "Waiting for the input fields to load inside iframe";
            $action            = $this->waitForName("login_email");
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Find and fill email address
        $payPalEmail = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGIN_EMAIL, $getPaymentProcessorData['email_address'], "PayPal login 'Email' " . $getPaymentProcessorData['email_address'] . " is entered");

        // Find and click a button to continue processing the payment
        $actionDescription = "Clicking on the Continue button";
        $action            = $this->waitForId(self::BUTTON_BY_ID_PAYPAL_SANDBOX_CONTINUE)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Find password, wait till it is visible and fill in credentials
        $payPalPassword = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGIN_PASSWORD, $getPaymentProcessorData['password'], "PayPal login 'Password' " . $getPaymentProcessorData['password'] . " is entered", false, true);

        // Click on Log in button
        $actionDescription = "Clicking on the Log in button";
        $action            = $this->findById(self::BUTTON_BY_ID_PAYPAL_SANDBOX_LOGIN)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait until we are logged in
        $actionDescription = "Waiting until we are logged in";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_WELCOME_TITLE)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        sleep(3);

        // Wait for spinner to finish loading
        $actionDescription = "Waiting for the page to load";
        $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Click on Continue button
        $actionDescription = "Clicking on the Continue button";
        $action            = $this->waitForClass(self::INPUT_FIELD_BY_CLASS_PAYPAL_SANDBOX_LOGGED_IN_CONTINUE_BUTTON)->click();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Wait for spinner to finish loading
        $actionDescription = "Waiting for the spinner to finish loading";
        $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Locate confirm button
        $actionDescription = "Locating Confirm button";
        $action            = $locateConfirmButton = $this->waitForId(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Return values to check asserting
        return ($locateConfirmButton) ? array("email_address" => $payPalEmail,
                                              "password"      => $payPalPassword) : false;
    }

    /**
     * Enable and fill credentials for selected payment processor
     *
     * @param $paymentProcessor
     * @param $processorStatus
     * @return array|bool
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function selectPaymentProcessorAndFillData($paymentProcessor, $processorStatus) {

        // If Payment Processor is enabled
        if ($processorStatus) {

            // Scroll to Payment Providers
            $actionDescription = "Scrolling to the Payment providers";
            $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Waiting for a payment component to load completely
            $actionDescription = "Waiting for the payment component to load";
            $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::tagName(self::ELEMENT_BY_TAG_CHECKOUT_PAYMENTCOMPONENT)));
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            switch ($paymentProcessor):

                // If payment processor is "Cash on Delivery"
                case self::PAYMENT_PROCESSOR_CASHONDELIVERY:

                    // Find a payment processor Cash On Delivery
                    $actionDescription = "Locating payment provider Cash on Delivery";
                    $action            = $selectPaymentProcessor = $this->findById(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // If option is not checked, check it
                    if (!$selectPaymentProcessor->isSelected()) {

                        // Check if Cash On Delivery enabled
                        $actionDescription = "Checking if payment processor PayPal is enabled";
                        $action            = $processorPayPal = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Make other options visible
                        if (count($processorPayPal) !== 0) {

                            // We will make PayPal checkbox visible so we can disable it
                            $actionDescription = "Making PayPal checkbox visible";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Deselect option
                            $actionDescription = "Deselecting PayPal option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }

                        // Find a payment processor Credit Cards
                        $actionDescription = "Checking if payment processor Credit Cards is enabled";
                        $action            = $processorCreditCards = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        if (count($processorCreditCards) !== 0) {

                            // We will make CreditCards checkbox visible so we can disable it
                            $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').style.display = 'block';");

                            // Deselect option
                            $actionDescription = "Deselecting Credit Cards option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }

                        // Make actual input visible
                        $actionDescription = "Making Cash on Delivery option visible";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').style.display = 'block';");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Select Cash On Delivery option
                        $actionDescription = "Selecting Cash on Delivery option as a payment processor";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').click();");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                    }

                    // Return "true" if Cash On Delivery is selected
                    return array("is_selected" => ($selectPaymentProcessor) ? true : false);

                    break;

                // If payment processor is "PayPal"
                case self::PAYMENT_PROCESSOR_PAYPAL:

                    // Find a payment processor PayPal
                    $actionDescription      = "Locating payment processor PayPal";
                    $selectPaymentProcessor = $this->findById(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL);
                    $this->logAction(__FUNCTION__,$selectPaymentProcessor, $actionDescription);

                    // If option is not checked, check it
                    if (!$selectPaymentProcessor->isSelected()) {

                        // Find a payment processor Credit Cards
                        $actionDescription    = "Locating payment processor Credit Cards";
                        $processorCreditCards = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD));
                        $this->logAction(__FUNCTION__,$processorCreditCards, $actionDescription);

                        // Make other options visible
                        if (count($processorCreditCards) !== 0) {

                            // We will make Credit Cards checkbox visible so we can disable it
                            $actionDescription = "Making Credit Cards checkbox visible";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Deselect option
                            $actionDescription = "Deselecting Credit Cards option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }

                        $actionDescription = "Locating processor Cash on Delivery";
                        $action            = $processorCashOnDelivery = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        if (count($processorCashOnDelivery) !== 0) {

                            // We will make Cash on Delivery checkbox visible so we can disable it
                            $actionDescription = "Making Credit Cards checkbox visible";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Deselect option
                            $actionDescription = "Deselecting Credit Cards option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }

                        // Make actual input visible
                        $actionDescription = "Making payment processor PayPal visible";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').style.display = 'block';");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Select PayPal option
                        $actionDescription = "Selecting PayPal as a payment processor";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').click();");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                    }

                    // Click on button Complete Purchase to open PayPal login window
                    $actionDescription = "Clicking on button Complete purchase";
                    $action            = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Process with a PayPal login function and log into PayPal and select a way to pay
                    $payPalReturnedData = $this->PayPalLoginProcess("sandbox", "buyer", false);

                    // Return "PayPal" values in array
                    return array("email_address" => $payPalReturnedData['email_address'],
                                 "password"      => $payPalReturnedData['password'],
                                 "way_to_pay"    => "CREDIT UNION");

                    break;

                // If payment processor is "PayPal Express"
                case self::PAYMENT_PROCESSOR_PAYPAL_EXPRESS:

                    // Get PayPal login credentials
                    $getPaymentProcessorData = Define::definePayPal("sandbox", "buyer");

                    // Select PayPal Express as a payment processor
                    $actionDescription = "Selecting PayPal as a payment processor";
                    $action            = $selectPaymentProcessor = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_PAYMENTPROCESSOR_PAYPAL_EXPRESS)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait for spinner to finish loading
                    $actionDescription = "Waiting for the spinner to finish loading";
                    $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    sleep(5);

                    $this->warn($this->wd->getTitle());
                    // Click on Log in button
                    $actionDescription = "Clicking on Log in button";
                    $action            = $this->waitForCss(self::A_HREF_BY_CSS_PAYPAL_EXPRESS_LOGIN_BUTTON)->sendKeys(WebDriverKeys::ENTER);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Find and fill email address
                    $action = $payPalEmail = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_PAYPAL_SANDBOX_LOGIN_EMAIL, $getPaymentProcessorData['email_address'], "PayPal login email '" . $getPaymentProcessorData['email_address'] . "' is entered");
                    $this->logAction(__FUNCTION__,$action, "PayPal login email is filled: '" . $getPaymentProcessorData['email_address'] . "'");

                    // Find and click a button to continue processing payment
                    $actionDescription = "Clicking on Continue button";
                    $action            = $this->waitForId(self::BUTTON_BY_ID_PAYPAL_SANDBOX_CONTINUE)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait for spinner to finish loading
                    $actionDescription = "Waiting for spinner to finish loading";
                    $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::INPUT_FIELD_BY_CLASS_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Find password, wait till it is visible and fill in credentials
                    $action = $payPalPassword = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_PAYPAL_SANDBOX_LOGIN_PASSWORD, $getPaymentProcessorData['password'], "PayPal login 'Password' " . $getPaymentProcessorData['password'] . " is entered", true);
                    $this->logAction(__FUNCTION__,$action, "PayPal login password is filled");

                    // Click on Log in button
                    $actionDescription = "Clicking on Log in button";
                    $action            = $this->findById(self::BUTTON_BY_ID_PAYPAL_SANDBOX_LOGIN)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    //PayPal Express sandbox has some issue loading, so we will process the login session again
                    $actionDescription = "PayPal Express Sandbox issue, we are clicking double back button to repeat login process";
                    $action            = $this->wd->navigate()->back();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    $actionDescription = "PayPal Express Sandbox issue, we are clicking double back button to repeat login process";
                    $action            = $this->wd->navigate()->back();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait for spinner to finish loading
                    $actionDescription = "Waiting for the spinner to finish loading";
                    $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    sleep(3);

                    // Click on Continue button
                    $actionDescription = "Clicking on Continue button";
                    $action            = $this->waitForClass(self::INPUT_FIELD_BY_CLASS_PAYPAL_SANDBOX_LOGGED_IN_CONTINUE_BUTTON)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait for spinner to finish loading
                    $actionDescription = "Waiting for the spinner to finish loading";
                    $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Locate confirm button
                    $actionDescription = "Locating confirm button";
                    $action            = $locateConfirmButton = $this->waitForId(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait until button is ready to be clickable
                    $actionDescription = "Waiting until button is ready to be clickable";
                    $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // We will use send keys + enter because click() is not 100% working in the paypal
                    $actionDescription = "Clicking on Agree and Pay button";
                    $action            = $locateConfirmButton->sendKeys(array(WebDriverKeys::ENTER));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    sleep(1);

                    // Return "PayPal" values in array
                    return array("email_address" => $payPalEmail,
                                 "password"      => $payPalPassword,
                                 "way_to_pay"    => "CREDIT UNION");

                    break;

                // If payment processor is "Braintree PayPal"
                case self::PAYMENT_PROCESSOR_BRAINTREE_PAYPAL:

                    // Select Braintree PayPal as a payment processor
                    $actionDescription = "Selecting Braintree as a payment processor";
                    $action            = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_PAYMENTPROCESSOR_PAYPAL_BRAINTREE)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Process with a PayPal login function and log into PayPal and select a way to pay
                    $payPalReturnedData = $this->PayPalLoginProcess("sandbox", "buyer");

                    // Return "PayPal" values in array
                    return array("email_address" => $payPalReturnedData['email_address'],
                                 "password"      => $payPalReturnedData['password'],
                                 "way_to_pay"    => "CREDIT UNION");

                    break;

                // Default payment processor are "Credit Cards"
                default:

                    // Select Credit Card as a payment processor
                    $actionDescription = "Selecting Credit Cards as a payment processor";
                    $action            = $selectPaymentProcessor = $this->findById(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // If option is not cheched, check it
                    if (!$selectPaymentProcessor->isSelected()) {

                        $actionDescription = "Locating payment processor PayPal";
                        $action            = $processorPayPal = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Make other options visible
                        if (count($processorPayPal) !== 0) {

                            $actionDescription = "Making PayPal checkbox visible";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            $actionDescription = "Deselecting PayPal option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }

                        $actionDescription = "Locating payment processor Cash on Delivery";
                        $action            = $processorCashOnDelivery = $this->wd->findElements(WebDriverBy::id(self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY));
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        if (count($processorCashOnDelivery) !== 0) {

                            $actionDescription = "Making Cash on Delivery checkbox visible";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').style.display = 'block';");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Deselect option
                            $actionDescription = "Deselecting Cash on Delivery option";
                            $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY . "').checked = false;");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);
                        }

                        // Make actual input visible
                        $actionDescription = "Making Credit Cards checkbox visible";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').style.display = 'block';");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Select Credit Card option
                        $actionDescription = "Selecting Credit Cards as a pament processor";
                        $action            = $this->wd->executeScript("document.getElementById('" . self::INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD . "').click();");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);
                    }

                    // Get Payment Processor Credit Card credentials
                    $action = $getPaymentProcessorData = Define::defineCreditCard($paymentProcessor);
                    $this->logAction(__FUNCTION__,$action, "Preparing credentials for a Payment Processor '" . $paymentProcessor . "'");

                    switch ($paymentProcessor):

                        case self::PAYMENT_PROCESSOR_STRIPE:

                            // Wait until fields are visible to be filled
                            $actionDescription = "Waiting for the Stripe input fields to be visible";
                            $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_CHECKOUT_CREDIT_CARD_NUMBER)));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Get current Main window ID
                            $actionDescription = "Getting current Main window ID";
                            $action            = $currentHandle = $this->wd->getWindowHandle();
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Stripe Card Number

                            // Find Stripe iframe for Card number
                            $actionDescription = "Locating Stripe iframe for the Card number";
                            $action            = $stripe_iframe_cardnumber = $this->wd->findElement(WebDriverBy::tagName(self::INPUT_FIELD_BY_TAGNAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_NUMBER));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to stripe iframe
                            $actionDescription = "Switching to the Stripe Credit number iframe window";
                            $action            = $this->wd->switchTo()->frame($stripe_iframe_cardnumber);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card number
                            $ccNumber = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_NUMBER, $getPaymentProcessorData['card_number'], "Credit card 'Number' " . $getPaymentProcessorData['card_number'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Stripe Expiry Date

                            // Find Stripe iframe for Expiry date
                            $actionDescription = "Locating Stripe iframe window for Expiry date";
                            $action            = $stripe_iframe_expirydate = $this->wd->findElement(WebDriverBy::name(self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_EXPIRYDATE));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to stripe iframe Expiry date
                            $actionDescription = "Switching to the Stripe Expiry date iframe";
                            $action            = $this->wd->switchTo()->frame($stripe_iframe_expirydate);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card expiry date
                            $ccExp = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_EXPIRYDATE, $getPaymentProcessorData['expiry_date'], "Credit card 'Expiry date' " . $getPaymentProcessorData['expiry_date'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Stripe CVV

                            // Find Stripe iframe for CVV
                            $actionDescription = "Locating Stripe iframe window for CVV";
                            $action            = $stripe_iframe_expirydate = $this->wd->findElement(WebDriverBy::name(self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_CVV));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to stripe CVV iframe
                            $actionDescription = "Switching to the Stripe CVV iframe window";
                            $action            = $this->wd->switchTo()->frame($stripe_iframe_expirydate);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card cvv
                            $ccCvv = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_CVV, $getPaymentProcessorData['cvv'], "Credit card 'CVV' " . $getPaymentProcessorData['cvv'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card name
                            $ccName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", "card-name", $getPaymentProcessorData['name_on_card'], "Credit card 'Name' " . $getPaymentProcessorData['name_on_card'] . " is entered");

                            break;

                        case self::PAYMENT_PROCESSOR_AUTHORIZE:

                            // Wait until fields are visible to be filled
                            $actionDescription = "Waiting for the Authorize fields to be visible";
                            $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NUMBER)));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card number
                            $ccNumber = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NUMBER, $getPaymentProcessorData['card_number'], "Credit card 'Number' " . $getPaymentProcessorData['card_number'] . " is entered");

                            // Find and fill credit card name
                            $ccName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NAME, $getPaymentProcessorData['name_on_card'], "Credit card 'Name' " . $getPaymentProcessorData['name_on_card'] . " is entered");

                            // Find and fill credit card expiry date
                            $ccExp = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_EXPIRYDATE, $getPaymentProcessorData['expiry_date'], "Credit card 'Expiry date' " . $getPaymentProcessorData['expiry_date'] . " is entered");

                            // Find and fill credit card cvv
                            $ccCvv = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_CVV, $getPaymentProcessorData['cvv'], "Credit card 'CVV' " . $getPaymentProcessorData['cvv'] . " is entered");

                            break;

                        case self::PAYMENT_PROCESSOR_NMI:

                            // Wait until fields are visible to be filled
                            $actionDescription = "Waiting for the Nmi fields to be visible";
                            $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NUMBER)));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card number
                            $ccNumber = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NUMBER, $getPaymentProcessorData['card_number'], "Credit card 'Number' " . $getPaymentProcessorData['card_number'] . " is entered");

                            // Find and fill credit card name
                            $ccName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NAME, $getPaymentProcessorData['name_on_card'], "Credit card 'Name' " . $getPaymentProcessorData['name_on_card'] . " is entered");

                            // Find and fill credit card expiry date
                            $ccExp = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_EXPIRYDATE, $getPaymentProcessorData['expiry_date'], "Credit card 'Expiry date' " . $getPaymentProcessorData['expiry_date'] . " is entered");

                            // Find and fill credit card cvv
                            $ccCvv = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_CVV, $getPaymentProcessorData['cvv'], "Credit card 'CVV' " . $getPaymentProcessorData['cvv'] . " is entered");

                            break;

                        case self::PAYMENT_PROCESSOR_BRAINTREE:

                            // Wait until fields are visible to be filled
                            $actionDescription = "Waiting for the Braintree fields to be visible";
                            $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_CHECKOUT_CREDIT_CARD_NUMBER)));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Get current Main window ID
                            $actionDescription = "Getting current Main window ID";
                            $action            = $currentHandle = $this->wd->getWindowHandle();
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Braintree Card Number

                            // Find Braintree iframe for Card number
                            $actionDescription = "Locating Braintree iframe for the Card number";
                            $action            = $braintree_iframe_cardnumber = $this->wd->findElement(WebDriverBy::name(self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_NUMBER));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to braintree iframe
                            $actionDescription = "Switching to the Braintree Card number iframe";
                            $action            = $this->wd->switchTo()->frame($braintree_iframe_cardnumber);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card number
                            $ccNumber = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_NUMBER, $getPaymentProcessorData['card_number'], "Credit card 'Number' " . $getPaymentProcessorData['card_number'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Braintree Expiry Date

                            // Find Braintree iframe for Expiry date
                            $actionDescription = "Locating Braintree iframe for the Expiry date";
                            $action            = $braintree_iframe_expirydate = $this->wd->findElement(WebDriverBy::name(self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_EXPIRYDATE));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to the Braintree iframe Expiry date
                            $actionDescription = "Switching to the Braintree Expiry iframe";
                            $action            = $this->wd->switchTo()->frame($braintree_iframe_expirydate);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card expiry date
                            $ccExp = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_EXPIRYDATE, $getPaymentProcessorData['expiry_date'], "Credit card 'Expiry date' " . $getPaymentProcessorData['expiry_date'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // ----> Braintree CVV

                            // Find Braintree iframe for CVV
                            $actionDescription = "Locating Braintree iframe for the CVV";
                            $action            = $braintree_iframe_expirydate = $this->wd->findElement(WebDriverBy::name(self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_CVV));
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Switch to the Braintree CVV iframe
                            $actionDescription = "Switching to the Braintree CVV iframe";
                            $action            = $this->wd->switchTo()->frame($braintree_iframe_expirydate);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card cvv
                            $ccCvv = $this->completeAndCheckField(__FUNCTION__,"input", "waitForName", "findByName", self::INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_CVV, $getPaymentProcessorData['cvv'], "Credit card 'CVV' " . $getPaymentProcessorData['cvv'] . " is entered");

                            // ----> Switch back to Main

                            // Switch back to Main order window
                            $actionDescription = "Switching back to the Main window";
                            $action            = $this->wd->switchTo()->window($currentHandle);
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Find and fill credit card name
                            $ccName = $this->completeAndCheckField(__FUNCTION__,"input", "waitForId", "findById", self::INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_NAME, $getPaymentProcessorData['name_on_card'], "Credit card 'Name' " . $getPaymentProcessorData['name_on_card'] . " is entered");

                            break;
                    endswitch;

                    // Return "Credit Cards" values in array
                    return array("card_number"  => $ccNumber,
                                 "name_on_card" => $ccName,
                                 "expiry_date"  => $ccExp,
                                 "cvv"          => $ccCvv);

                    break;

            endswitch;

        }
        else {

            // Log error
            $this->warn("Payment processor " . $paymentProcessor . " is not enabled!");

            return false;
        }
    }

    /**
     * Open new tab
     *
     * @return bool|string
     */
    public function openNewTab() {

        // Current window tab
        $actionDescription = "Getting current Main window ID";
        $action            = $currentHandle = $this->wd->getWindowHandle();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Open new window tab
        $actionDescription = "Opening new window tab";
        $action            = $newTab = $this->wd->executeScript("window.open('about:blank','_blank');");
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get all window tabs
        $actionDescription = "Getting all window tabs";
        $action            = $handles = $this->wd->getWindowHandles();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // New tab
        $newHandle = end($handles);
        $this->logAction(__FUNCTION__,$newHandle, "Getting window ID for newly opened tab");

        // Switch to new window tab
        $actionDescription = "Switching to a new window tab";
        $action            = $this->wd->switchTo()->window($newHandle);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        return ($currentHandle != $newHandle) ? $currentHandle : false;
    }

    /**
     * Go to Admin Carthook page
     *
     * @param $admin
     * @param bool $openNewTab
     */
    public function loginToCarthookAdmin($admin, $openNewTab = true) {

        // If login will be performed in new tab
        if ($openNewTab) {

            // Go to Carthook Admin
            $actionDescription = "Opening Carthook Admin page";
            $action            = $this->wd->get(MyAbstractTestCase::$adminUrl);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Get current url
            $actionDescription = "Getting current URL";
            $action            = $this->wd->wait()->until(WebDriverExpectedCondition::urlContains("login"));
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }
        else {

            // Locating login component
            $actionDescription = "Locating login component";
            $action            = $this->wd->wait()->until(WebDriverExpectedCondition::urlContains("login"));
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Check for redirect
        $redirect = false;

        // Try until redirected
        do {
            // Fill in Admin login data
            $this->fillAdminLoginData($admin);

            // Wait until page title Dashboard is visible
            $actionDescription = "Waiting to be logged in Carthook Admin";
            $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_ADMIN_DASHBOARD);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Getting page title
            $actionDescription = "Checking if we are logged in";
            $action            = $DashboardTitle = $this->wd->getTitle();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Check if title contains
            if (mb_strpos($DashboardTitle, self::PARTIAL_TITLE_ADMIN_DASHBOARD) !== false) {
                $redirect = true;
            }

        } while (

            $redirect === false);

        $this->logAction(__FUNCTION__,$redirect, "Successfully loged into Carthook Admin");
    }

    /**
     * Continue process to the checkout page
     *
     * @param $paymentProcessor
     * @param $connectProcessor
     * @param $adminLogin
     * @return array
     */
    public function continueToCheckoutPage($paymentProcessor, $connectProcessor, $adminLogin) {
        // Default Processor status is set to True
        $processorStatus = true;

        // Before we go to Checkout page, we will make sure that Payment processor is enabled
        if ($connectProcessor && $adminLogin) {

            // Enable payment processor
            $processorStatus = $this->enablePaymentProcessor($paymentProcessor, $adminLogin);
        }

        // ACTION -> Go to checkout page
        $Action_gotocheckoutpage = $this->gotoCheckoutPage();

        // Return values to check asserting
        return array("currentpage"     => $Action_gotocheckoutpage,
                     "processorStatus" => $processorStatus

        );
    }

    /**
     * Define correct shipping data and fill the fields
     *
     * @param $shippingCountry
     * @param $emailCounter
     * @return array
     */
    function continueToFillShippingData($shippingCountry, $emailCounter) {

        // Get Shipping data based on Country
        $ShippingData = Define::defineShipping($shippingCountry, $emailCounter);

        // Define correct Shipping values
        $correctShippingValues = array("email"     => $ShippingData['email'],
                                       "firstname" => $ShippingData['firstname'],
                                       "lastname"  => $ShippingData['lastname'],
                                       "address"   => $ShippingData['address'],
                                       "city"      => $ShippingData['city'],
                                       "country"   => $ShippingData['country'],
                                       "zip"       => $ShippingData['zip']);

        // ACTION -> Fill in the shipping data
        $Action_fillintheshippingdata = $this->fillShippingData($shippingCountry, $emailCounter);

        // Store Shipping data to returned
        $returnedShippingValues = $Action_fillintheshippingdata;

        // Wait for Shipping fetch
        $this->waitForShippingFetch();

        return array("correctshippingvalues"  => $correctShippingValues,
                     "returnedshippingvalues" => $returnedShippingValues,

        );
    }

    /**
     * Define correct payment processor values, select it and proceed to complete the order
     *
     * @param $paymentProcessor
     * @param $processorStatus
     * @return array
     */
    public function continueToSelectPaymentProcessor($paymentProcessor, $processorStatus) {
        // Define correct values for selected Payment processor
        switch ($paymentProcessor):
            // If payment processor is "Cash on Delivery"
            case self::PAYMENT_PROCESSOR_CASHONDELIVERY:

                // Define correct Cash on Delivery payment values
                $correctPaymentProcessorValues = array("is_selected" => true);

                break;
            // If payment processor is "PayPal"
            case self::PAYMENT_PROCESSOR_PAYPAL:

                // Define correct PayPal payment values
                $paymentProcessorData = Define::definePayPal("sandbox", "buyer");

                // Define correct Credit card values
                $correctPaymentProcessorValues = array("email_address" => $paymentProcessorData['email_address'],
                                                       "password"      => $paymentProcessorData['password'],
                                                       "way_to_pay"    => $paymentProcessorData['way_to_pay']);

                break;

            // If payment processor is "PayPal Express"
            case self::PAYMENT_PROCESSOR_PAYPAL_EXPRESS:

                // Define correct PayPal payment values
                $paymentProcessorData = Define::definePayPal("sandbox", "buyer");

                // Define correct Credit card values
                $correctPaymentProcessorValues = array("email_address" => $paymentProcessorData['email_address'],
                                                       "password"      => $paymentProcessorData['password'],
                                                       "way_to_pay"    => $paymentProcessorData['way_to_pay']);

                break;

            // If payment processor is "Braintree PayPal"
            case self::PAYMENT_PROCESSOR_BRAINTREE_PAYPAL:

                // Define correct PayPal payment values
                $paymentProcessorData = Define::definePayPal("sandbox", "buyer");

                // Define correct Credit card values
                $correctPaymentProcessorValues = array("email_address" => $paymentProcessorData['email_address'],
                                                       "password"      => $paymentProcessorData['password'],
                                                       "way_to_pay"    => $paymentProcessorData['way_to_pay']);

                break;

            // Default payment processor are "Credit Cards"
            default:

                // Get Credit card data based on Payment processor
                $paymentProcessorData = Define::defineCreditCard($paymentProcessor);

                // Define correct Credit card values
                $correctPaymentProcessorValues = array("card_number"  => $paymentProcessorData['card_number'],
                                                       "name_on_card" => $paymentProcessorData['name_on_card'],
                                                       "expiry_date"  => $paymentProcessorData['expiry_date'],
                                                       "cvv"          => $paymentProcessorData['cvv']);
                break;
        endswitch;

        // ACTION -> Select Payment Processor and fill the data
        $Action_selectpaymentprocessorandfilldata = $this->selectPaymentProcessorAndFillData($paymentProcessor, $processorStatus);

        // Store Payment Processor data to returned
        $returnedPaymentProcessorValues = $Action_selectpaymentprocessorandfilldata;

        return array("correctpaymentprocessorvalues"  => $correctPaymentProcessorValues,
                     "returnedpaymentprocessorvalues" => $returnedPaymentProcessorValues,);
    }

    /**
     * Check total values in checkout page
     *
     * @param bool $taxEnabled
     * @param bool $couponEnabled
     * @return array
     */
    public function continueToCheckTotalValues($taxEnabled = false, $couponEnabled = false) {

        // Default tax and coupon values
        $taxesValueClean  = "0.00";
        $couponValueClean = "0.00";

        // Wait for the fetching to be done
        $actionDescription = "Waiting until values are fetched";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::SPINNER_ICON_BY_FONT_AWESOME)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Locating total values
        $actionDescription = "Locating total order values";
        $action            = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get Subtotal value
        $actionDescription = "Getting subtotal value";
        $action            = $subtotalValue = $this->waitForCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SUBTOTAL)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean subtotal value
        $subtotalValueClean = $this->doCleanPrice($subtotalValue);

        // Get Shipping value
        $actionDescription = "Getting shipping value";
        $action            = $shippingValue = $this->waitForCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SHIPPING)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean shipping value
        $shippingValueClean = $this->doCleanPrice($shippingValue);

        // Only if coupon enabled
        if ($couponEnabled) {

            // Get coupon value
            $actionDescription = "Getting coupon value";
            $action            = $couponValue = $this->waitForCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_COUPON)->getText();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Get clean coupon value
            $couponValueClean = $this->doCleanPrice($couponValue);
        }

        // Only if tax is enabled
        if ($taxEnabled) {

            // If coupon is 100% off, we cannot find the tax value, because it is 0
            if($couponEnabled != "100off" || ($couponValueClean >= $subtotalValueClean)){
                // Get Taxes value
                $actionDescription = "Getting tax value";
                $action            = $taxesValue = $this->waitForCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_TAXES)->getText();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Get clean taxes value
                $taxesValueClean = $this->doCleanPrice($taxesValue);
            } else {

                // Tax is zero
                $taxesValueClean = "0.00";
            }
        }

        // Locate total value and scroll to it
        $actionDescription = "Scrolling to the Total value position on the screen";
        $action            = $this->wd->executeScript("$(window).scrollTop(0);");
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get total value
        $actionDescription = "Getting total value";
        $action            = $totalValueText = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean total value
        $totalValueClean = $this->doCleanPrice($totalValueText);

        // Define actual total values
        $returnedTotalValues = array("subtotal" => $subtotalValueClean,
                                     "shipping" => $shippingValueClean,
                                     "tax"      => $taxesValueClean,
                                     "coupon"   => $couponValueClean,
                                     "total"    => $totalValueClean);

        return array("returnedtotalvalues" => $returnedTotalValues);
    }

    /**
     * Check total values in thank you page
     *
     * @param bool $taxEnabled
     * @param bool $couponEnabled
     * @return array
     */
    public function continueToCheckThankYouPageTotalValues($taxEnabled = false, $couponEnabled = false) {

        // Default tax and coupon values
        $taxesValueClean  = "0.00";
        $couponValueClean = "0.00";

        // Wait for the fetching to be done
        $actionDescription = "Waiting until values are fetched";
        $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className(self::SPINNER_ICON_BY_FONT_AWESOME)));
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Locating total values
        $actionDescription = "Locating total order values";
        $action            = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get Subtotal value
        $actionDescription = "Getting subtotal value";
        $action            = $subtotalValue = $this->findByCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SUBTOTAL)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean subtotal value
        $subtotalValueClean = $this->doCleanPrice($subtotalValue);

        // Get Shipping value
        $actionDescription = "Getting shipping value";
        $action            = $shippingValue = $this->findByCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SHIPPING)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean shipping value
        $shippingValueClean = $this->doCleanPrice($shippingValue);

        // Only if tax is enabled
        if ($taxEnabled) {

            // If coupon is 100% off, we cannot find the tax value, because it is 0
            if($couponEnabled != "100off"){
                // Get Taxes value
                $actionDescription = "Getting tax value";
                $action            = $taxesValue = $this->findByCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_TAXES)->getText();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Get clean taxes value
                $taxesValueClean = $this->doCleanPrice($taxesValue);
            } else {

                // Tax is zero
                $taxesValueClean = "0.00";
            }
        }

        // Only if coupon enabled
        if ($couponEnabled) {

            // Get coupon value
            $actionDescription = "Getting coupon value";
            $action            = $couponValue = $this->findByCss(self::SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_COUPON)->getText();
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Get clean coupon value
            $couponValueClean = $this->doCleanPrice($couponValue);
        }

        // Locate total value and scroll to it
        $actionDescription = "Scrolling to the Total value position on the screen";
        $action            = $this->wd->executeScript("$(window).scrollTop(0);");
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get total value
        $actionDescription = "Getting total value";
        $action            = $totalValueText = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL)->getText();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get clean total value
        $totalValueClean = $this->doCleanPrice($totalValueText);

        // Define actual total values
        $returnedTotalValues = array("subtotal" => $subtotalValueClean,
                                     "shipping" => $shippingValueClean,
                                     "tax"      => $taxesValueClean,
                                     "coupon"   => $couponValueClean,
                                     "total"    => $totalValueClean);

        return array("returnedtotalvalues" => $returnedTotalValues);
    }

    /**
     * Continue to payment method and proceed with payment
     *
     * @param $paymentProcessor
     * @param $withFunnel
     * @param $currentHandle
     * @param $country
     * @param $token
     * @return array
     */
    public function continueToPay($paymentProcessor, $withFunnel, $currentHandle, $country, $token) {

        $completePurchase = false;
        $statusMessage    = "";
        $redirect         = ($withFunnel) ? "Upsell / Downsell page" : "Thank you page";

        switch ($paymentProcessor):
            case self::PAYMENT_PROCESSOR_PAYPAL:

                // Getting window handless
                $actionDescription = "Checking if PayPal pop-up window is opened";
                $action            = $handles = $this->wd->getWindowHandles();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Check if paypal pop-up window is opened
                if (count($handles) > 1) {

                    // We are still on PayPal Login popup window and we need to click on Button Agree & Pay to complete the order
                    // Locate confirm button
                    $actionDescription = "Locating PayPal Agree & Pay button";
                    $action            = $this->findById(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Get current PayPal window ID
                    $actionDescription = "Getting current PayPal window ID";
                    $action            = $PayPalLoginWindow = $this->wd->getWindowHandle();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    $this->warn("Order main window: " . $currentHandle . " | PayPal popup window: " . $PayPalLoginWindow);

                    // Because now we have focus on newly opened window, we need to switch back to a Main window to continue the process
                    $actionDescription = "Switching back to the Main window";
                    $action            = $this->wd->switchTo()->window($currentHandle);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Locating PayPal Iframe window
                    $actionDescription = "Locating PayPal iframe window";
                    $action            = $pp_frame = $this->wd->findElement(WebDriverBy::className(self::IFRAME_BY_CLASS_PAYPAL_IFRAME_WINDOW));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Switching to PayPal window frame
                    $actionDescription = "Switching to PayPal iframe";
                    $action            = $this->wd->switchTo()->frame($pp_frame);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Locating PayPal iframe continue button
                    $actionDescription = "Locating PayPal iframe continue button";
                    $action            = $this->findByPartialLinkText(self::BUTTON_BY_TEXT_PAYPAL_IFRAME_CONTINUE_BUTTON)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Switch to Pay Pal login window
                    $actionDescription = "Switching to PayPal login window";
                    $action            = $this->wd->switchTo()->window($PayPalLoginWindow);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Click on Agree & Pay button
                    $actionDescription = "Locating on Agree & Pay button";
                    $action            = $this->findById(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait until button is ready to be clickable
                    $actionDescription = "Waiting until button is ready to be clickable";
                    $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    sleep(1);

                    // Switch back to main order window
                    $actionDescription = "Switching back to the Main window";
                    $action            = $this->wd->switchTo()->window($currentHandle);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                }
                else {

                    // Wait for spinner to finish loading
                    $actionDescription = "Waiting for the spinner to finish loading";
                    $action            = $this->wd->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Locating Agree & Pay button
                    $actionDescription = "Locating Agree and Pay button";
                    $action            = $completePurchase = $this->waitForId(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Wait until button is ready to be clickable
                    $actionDescription = "Waiting until button is ready to be clickable";
                    $action            = $this->wd->wait(120, 250)->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id(self::INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON)));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // We will use send keys + enter because click() is not 100% working in the paypal
                    $actionDescription = "Clicking on the Agree and Pay button";
                    $action            = $completePurchase->sendKeys(array(WebDriverKeys::ENTER));
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    sleep(1);
                }

                break;

            case self::PAYMENT_PROCESSOR_PAYPAL_EXPRESS:

                // Wait for redirect from PayPal to Checkout Page
                $actionDescription = "Waiting for the redirect from the PayPal to Checkout page";
                $action            = $waitForButtonLoad = $this->waitForClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE);
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Wait for values to be loaded
                $actionDescription = "Waiting for the all total values to be loaded";
                $action            = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL);
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Locate the email field and clear the value, we will apply new (default) test values
                $actionDescription = "Clearing the email field, we will apply default test values";
                $action            = $this->findByName(self::INPUT_FIELD_BY_NAME_CHECKOUT_CHECKOUT_EMAIL)->clear();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Fill in the default shipping data
                $this->fillShippingData($country, $token);

                // Click on button Complete Purchase
                $actionDescription = "Clicking on the Complete purchase button";
                $action            = $completePurchase = $waitForButtonLoad->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                break;

            case self::PAYMENT_PROCESSOR_STRIPE:

                // STRIPE processor requires minimum order > $0.50 (with no dots 50)
                // Get Total price
                $actionDescription = "Getting Total price";
                $action            = $orderTotal = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL)->getText();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Transforming total price to the price without currency symbol
                $orderTotalCleanPrice = $this->doCleanPrice($orderTotal);

                // If order is lower than 1usd, display a notice
                if ($orderTotalCleanPrice < 0.50) {

                    // Display error inside Log
                    $this->warn("STRIPE payment processor requires order bigger than 0.5USD");
                    $completePurchase = false;

                    // Display error on php log
                    $statusMessage = "STRIPE payment processor requires order bigger than 0.5USD";

                    // Display error on Slack
                    SlackAlerter::testError(__FUNCTION__, $statusMessage);
                }
                else {

                    // Click on button Complete Purchase
                    $actionDescription = "Clicking on the Complete purchase button";
                    $action            = $completePurchase = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);
                }

                break;

            case self::PAYMENT_PROCESSOR_AUTHORIZE:

                // Click on button Complete Purchase
                $actionDescription = "Clicking on the Complete purchase button";
                $action            = $completePurchase = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                break;

            case self::PAYMENT_PROCESSOR_NMI:

                // NMI processor requires minimum order > $1.00 (with no dots 100)
                // Get Total price
                $actionDescription = "Getting Total price value";
                $action            = $orderTotal = $this->waitForCss(self::SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL)->getText();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                // Transforming Total price to the price without currency symbol
                $orderTotalCleanPrice = $this->doCleanPrice($orderTotal);

                // If order is lower than 1usd, display a notice
                if ($orderTotalCleanPrice < "1.00") {

                    // Display error inside Log
                    $this->warn("NMI payment processor requires order bigger than 1USD");
                    $completePurchase = false;

                    // Display error on php log
                    $statusMessage = "NMI payment processor requires order bigger than 1USD";

                    // Display error on Slack
                    SlackAlerter::testError(__FUNCTION__, $statusMessage);
                }
                else {

                    // Click on button Complete Purchase
                    $actionDescription = "Clicking on the Complete purchase button";
                    $action            = $completePurchase = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);
                }

                break;

            case self::PAYMENT_PROCESSOR_BRAINTREE:

                // Click on button Complete Purchase
                $actionDescription = "Clicking on the Complete purchase button";
                $action            = $completePurchase = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                break;

            case self::PAYMENT_PROCESSOR_CASHONDELIVERY:

                // Click on button Complete Purchase
                $actionDescription = "Clicking on the Complete purchase button";
                $action            = $completePurchase = $this->findByClass(self::BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE)->click();
                $this->logAction(__FUNCTION__,$action, $actionDescription);

                break;

        endswitch;

        // Redirect after payment: Thank you page or Upsell / Downsell page
        ($completePurchase) ? $this->logAction(__FUNCTION__,$completePurchase, "Button 'Complete Purchase is clicked. We will be redirected to " . $redirect) : false;

        return ($completePurchase) ? array("status"  => true,
                                           "message" => $statusMessage) : array("status"  => false,
                                                                                "message" => $statusMessage);
    }

    /**
     * Complete order on selected product, selected country, payment processor
     *
     * @param $productName
     * @param bool $productVariant
     * @param int $quantity
     * @return array
     */
    public function addNewProductToCart($productName, $productVariant = false, $quantity = 1) {

        // ACTION -> Go to product page
        $Action_gotoproductpage = $this->gotoProductsPage();

        // Get product values
        $ProductData = Products::defineProduct($productName);

        // Define correct values
        $correctProductValues = array("name"     => $ProductData['name'],
                                      "quantity" => $quantity,);

        if ($productVariant) {
            switch ($productVariant):
                case "S":
                    // If variant is Small, define first values
                    $correctProductValues['variant'] = $ProductData['variant']['var1']['name'];
                    $correctProductValues['price']   = $ProductData['variant']['var1']['price'];
                    $correctProductValues['id']      = $ProductData['variant']['var1']['id'];
                    $correctProductValues['qty_id']  = $ProductData['variant']['var1']['qty_id'];
                    break;
                case "M":
                    // If variant is Medium, define second values
                    $correctProductValues['variant'] = $ProductData['variant']['var2']['name'];
                    $correctProductValues['price']   = $ProductData['variant']['var2']['price'];
                    $correctProductValues['id']      = $ProductData['variant']['var2']['id'];
                    $correctProductValues['qty_id']  = $ProductData['variant']['var2']['qty_id'];
                    break;
                case "L":
                    // If variant is Large, define third values
                    $correctProductValues['variant'] = $ProductData['variant']['var3']['name'];
                    $correctProductValues['price']   = $ProductData['variant']['var3']['price'];
                    $correctProductValues['id']      = $ProductData['variant']['var3']['id'];
                    $correctProductValues['qty_id']  = $ProductData['variant']['var3']['qty_id'];
                    break;
            endswitch;
        }
        else {
            // If no variant is defined, select default name and price
            $correctProductValues['variant'] = "";
            $correctProductValues['price']   = $ProductData['price'];
            $correctProductValues['id']      = $ProductData['id'];
            $correctProductValues['qty_id']  = $ProductData['qty_id'];
        }

        // ACTION -> Add product to cart
        $Action_addproducttocart = $this->addProductToCart(Products::defineProduct($productName), $correctProductValues['variant'], $quantity, $correctProductValues['id'], $correctProductValues['qty_id']);

        // Store data to returned
        $returnedProductValues = $Action_addproducttocart;

        return array("currentpage"           => $Action_gotoproductpage,
                     "correctproductvalues"  => $correctProductValues,
                     "returnedproductvalues" => $returnedProductValues,);
    }

    /**
     * Continue to thank you page and return title
     *
     * @return array
     */
    public function continueToThankYouPage() {

        // Wait until page is loaded
        $actionDescription = "Waiting until Thank you page is loaded";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_THANKYOUPAGE);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Getting chData
        $actionDescription = "Getting window chData";
        $action            = $chData = $this->wd->executeScript("return window.chData");
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Show chData in console
        $this->warn(@print_r($chData['order'], true));

        // Getting page title
        $actionDescription = "Getting page title";
        $action            = $pageTitle = $this->wd->getTitle();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        return array("currentpage" => $pageTitle);
    }

    /**
     * If product has funnels enabled, proceed to funnel and complete it
     *
     * @param $funnel
     * @param $productName
     * @return array
     */
    public function completeFunnel($funnel, $productName) {

        // Wait until page is loaded
        $actionDescription = "Waiting for the funnel page to load";
        $action            = $this->waitForPartialTitle(self::PARTIAL_TITLE_FUNNEL);
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Check if funnel has correct array values
        if (is_array($funnel)) {

            // Define return values
            $funnelTitle            = array();
            $funnelProduct          = array();
            $funnelPrice            = array();
            $funnelPriceClean       = array();
            $funnelSelectedVariant  = array();
            $funnelSelectedQuantity = array();
            $funnelChData           = array();

            // For each funnel do
            foreach ($funnel as $funnel_n => $f) {

                // Funnel step
                $funnelStep = $funnel_n + 1;

                // If we did not define the steps, skip all undefined funnels
                if (!isset($f['upsell'])) {

                    // Wait until spinner is finished with loading
                    $actionDescription = "Waiting for the spinner to finish loading";
                    $action            = $spinnerClosed = $this->waitForSpinner();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Scroll to bottom
                    $actionDescription = "Scrolling to the bottom of the page";
                    $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Skip it
                    $actionDescription = "Upsell " . $funnelStep . " | skipping the product " . $productName;
                    $action            = $this->findByXpath(self::BUTTON_BY_XPATH_FUNNEL_NOTOORDER)->click();
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Check if downsell is added
                    $search = false;

                    $actionDescription = "Checking if downsell is added";
                    $action            = $search = $this->findByXpath(self::H1_BY_XPATH_FUNNEL_PRODUCT_PRICE);
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    // Downsell is added -> skip it
                    if ($search) {

                        // Wait until spinner is finished with loading
                        $actionDescription = "Waiting for the spinner to finish loading";
                        $action            = $this->waitForSpinner();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Scroll to bottom
                        $actionDescription = "Scrolling to the bottom of the page";
                        $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Skip it
                        $actionDescription = "Downsell " . $funnelStep . " | Skipping the product " . $productName;
                        $action            = $this->findByXpath(self::BUTTON_BY_XPATH_FUNNEL_NOTOORDER)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);
                    }

                }
                else {

                    // Funnel step is not the first one, so we need to wait for the spinner to complete  with the loading
                    if ($funnelStep > 1) {

                        // Wait until spinner is finished with loading
                        $actionDescription = "Waiting for the spinner to finish loading";
                        $action            = $spinnerClosed = $this->waitForSpinner();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Wait for product to load
                        $actionDescription = "Waiting for the product to load";
                        $action            = $this->waitForTag("variant-selector-component", true);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                    }
                    else {

                        // Get chData from the checkout page
                        $actionDescription = "Getting chData from the Checkout page";
                        $action            = $checkoutChDAta = $this->wd->executeScript("return window.chData");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Store Checkout chData
                        $this->status_chdata[0] = $checkoutChDAta;

                    }

                    // Get the upsell chData
                    $actionDescription = "Getting chData from the previous upsell page";
                    $action            = $chData = $this->wd->executeScript("return window.chData");
                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                    //$this->warn("FUNNEL STEP '" . $funnelStep . "' - UPSELL");
                    //$this->warn(@print_r($chData["order"], true));
                    $funnelChData[$funnel_n]['upsell'] = $chData["order"];

                    // Check if funnel is set to skip
                    if ($f['upsell']['skip'] == false) {

                        // Wait until spinner is finished with loading
                        $actionDescription = "Waiting for the spinner to finish loading";
                        $action            = $spinnerClosed = $this->waitForSpinner();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Get the current Funnel header
                        $actionDescription = "Getting the current Upsell header";
                        $action            = $funnelHeader = $this->findByTag("h3")->getText();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Store funnel header
                        $funnelTitle[$funnel_n]['upsell'] = $funnelHeader;

                        // Get the current Funnel product
                        $action = $funnelProduct[$funnel_n]['upsell'] = $this->get_string_between($funnelTitle[$funnel_n]['upsell'], "Add", "to your");
                        $this->logAction(__FUNCTION__,$action, "Current funnel 'UPSELL " . $funnelStep . "' - product is: " . $funnelProduct[$funnel_n]['upsell']);

                        // Get the current Funnel product price
                        $actionDescription = "Getting the current Upsell product price";
                        $action            = $funnelProductPrice = $this->findByXpath(self::H1_BY_XPATH_FUNNEL_PRODUCT_PRICE)->getText();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Storing funnel product price
                        $action = $funnelPrice[$funnel_n]['upsell'] = $funnelProductPrice;
                        $this->logAction(__FUNCTION__,$action, "Current funnel 'UPSELL " . $funnelStep . "' - product price title is: " . $funnelPrice[$funnel_n]['upsell']);

                        $action = $funnelPriceClean[$funnel_n]['upsell'] = str_replace("Only ", "", $funnelPrice[$funnel_n]['upsell']);
                        $this->logAction(__FUNCTION__,$action, "Current funnel 'UPSELL " . $funnelStep . "' - product price is: " . $funnelPriceClean[$funnel_n]['upsell']);

                        // If product has variants
                        if ($f['upsell']['variant'] != "") {

                            $variant = " | variant: " . $f['upsell']['variant'];

                            // Select variant
                            $funnelSelectedVariant[$funnel_n]['upsell'] = $this->completeAndCheckField(__FUNCTION__,"select", "waitForClass", "findByClass", self::SELECT_BY_CLASS_FUNNEL_VARIANTSELECT, $f['upsell']['variant'], "Product variant " . $f['upsell']['variant'] . " is selected", false, false, "selectByValue");

                        }
                        else {
                            $variant = "";
                        }

                        // --- Check for Upsell - predefined quantity for specific partial price
                        // First we will save current selected quantity to check if predefined quantity works
                        $actionDescription = "Waiting for the quantity select field to load";
                        $action            = $this->waitForClass(self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT);
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Init select field
                        $actionDescription = "Locating quantity select field";
                        $action            = $QtySelect = $this->wd->executeScript("
                               var e = document.getElementsByClassName('" . self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT . "');
                               return e[0].selectedIndex;
                               ");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Check if the field is auto-selected
                        if ($QtySelect) {

                            // Predefined option is selected
                            $this->debug("Predefined option is selected");

                            // Get value of selected field
                            $actionDescription = "Getting value of the selected quantity";
                            $action            = $qtyFieldValue = $this->wd->executeScript("
                                        var e = document.getElementsByClassName('select-quantity-selector-component');
                                        return e[0].options[e[0].selectedIndex].value;
                                    ");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                        }
                        else {

                            // Default first option is selected
                            $qtyFieldValue = "1";
                            $this->debug("Upsell - Default first option 1 is selected");
                        }

                        // Preselected qty
                        $funnelSelectedQuantity[$funnel_n]['upsell'] = $qtyFieldValue;
                        // --- END Check for predefined quantity for specific partial price

                        // Now lets select the defined Select quantity
                        $this->completeAndCheckField(__FUNCTION__,"select", "waitForClass", "findByClass", self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT, $f['upsell']['quantity'], "Product quantity " . $f['upsell']['quantity'] . " is selected", false, false, "selectByValue");

                        // Scroll to bottom
                        $actionDescription = "Scrolling to the bottom of the page";
                        $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Add to order
                        $actionDescription = "Upsell " . $funnelStep . " | Adding the  product " . $productName . " " . $variant . " | quantity: " . $f['upsell']['quantity'];
                        $action            = $this->findByXpath(self::BUTTON_BY_XPATH_FUNNEL_ADDTOORDER)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);
                    }
                    else {

                        // Scroll to bottom
                        $actionDescription = "Scrolling to the bottom of the page";
                        $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Skip funnel
                        $actionDescription = "Upsell " . $funnelStep . " | skipping the product " . $productName;
                        $action            = $this->findByXpath(self::BUTTON_BY_XPATH_FUNNEL_NOTOORDER)->click();
                        $this->logAction(__FUNCTION__,$action, $actionDescription);

                        // Funnel is skipped, check if it has downsell
                        if (isset($f['downsell'])) {

                            // Wait until spinner is finished with loading
                            $actionDescription = "Waiting for the spinner to finish loading";
                            $action            = $spinnerClosed = $this->waitForSpinner();
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            // Getting the chData
                            $actionDescription = "Getting the previous step chDAta";
                            $action            = $chData = $this->wd->executeScript("return window.chData");
                            $this->logAction(__FUNCTION__,$action, $actionDescription);

                            //$this->warn("FUNNEL STEP '" . $funnelStep . "' - DOWNSELL");
                            //$this->warn(@print_r($chData["order"], true));
                            $funnelChData[$funnel_n]['downsell'] = $chData["order"];

                            // Check if funnel is set to skip
                            if ($f['downsell']['skip'] == false) {

                                // Get the current Funnel header
                                $actionDescription = "Getting the current Downsell header";
                                $action            = $funnelHeader = $this->findByTag("h3")->getText();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Store funnel header
                                $action = $funnelTitle[$funnel_n]['downsell'] = $funnelHeader;
                                $this->logAction(__FUNCTION__,$action, "Current funnel type is 'DOWNSELL' - title is: " . $funnelTitle[$funnel_n]['downsell']);

                                // Get the current Funnel product
                                $action = $funnelProduct[$funnel_n]['downsell'] = $this->get_string_between($funnelTitle[$funnel_n]['downsell'], "Add", "to your");
                                $this->logAction(__FUNCTION__,$action, "Current funnel 'DOWNSELL " . $funnelStep . "' - product is: " . $funnelProduct[$funnel_n]['downsell']);

                                // Get the current Funnel product price
                                $actionDescription = "Getting the current Downsell product price";
                                $action            = $funnelProductPrice = $this->findByXpath(self::H1_BY_XPATH_FUNNEL_PRODUCT_PRICE)->getText();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Store product price
                                $action = $funnelPrice[$funnel_n]['downsell'] = $funnelProductPrice;
                                $this->logAction(__FUNCTION__,$action, "Current funnel 'DOWNSELL " . $funnelStep . "' - product price title is: " . $funnelPrice[$funnel_n]['downsell']);

                                // Store clean price
                                $action = $funnelPriceClean[$funnel_n]['downsell'] = str_replace("Only ", "", $funnelPrice[$funnel_n]['downsell']);
                                $this->logAction(__FUNCTION__,$action, "Current funnel 'DOWNSELL " . $funnelStep . "' - product price is: " . $funnelPriceClean[$funnel_n]['downsell']);

                                // If product has variants
                                if ($f['downsell']['variant'] != "") {

                                    $variant = " | variant: " . $f['downsell']['variant'];

                                    // Select variant
                                    $funnelSelectedVariant[$funnel_n]['downsell'] = $this->completeAndCheckField(__FUNCTION__,"select", "waitForClass", "findByClass", self::SELECT_BY_CLASS_FUNNEL_VARIANTSELECT, $f['downsell']['variant'], "Product variant " . $f['downsell']['variant'] . " is selected", false, false, "selectByValue");

                                }
                                else {
                                    $variant = "";
                                }

                                // --- Check for Downsell - predefined quantity for specific partial price
                                // First we will save current selected quantity to check if predefined quantity works
                                $actionDescription = "Waiting for the quantity select field to load";
                                $action            = $this->waitForClass(self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT);
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Init select field
                                $actionDescription = "Locating quantity select field";
                                $action            = $QtySelect = $this->wd->executeScript("
                               var e = document.getElementsByClassName('" . self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT . "');
                               return e[0].selectedIndex;
                               ");
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Check if the field is auto-selected
                                if ($QtySelect) {

                                    // Predefined option is selected
                                    $this->debug("Predefined option is selected");

                                    // Get value of selected field
                                    $actionDescription = "Getting value of the selected quantity";
                                    $action            = $qtyFieldValue = $this->wd->executeScript("
                                        var e = document.getElementsByClassName('select-quantity-selector-component');
                                        return e[0].options[e[0].selectedIndex].value;
                                    ");
                                    $this->logAction(__FUNCTION__,$action, $actionDescription);

                                }
                                else {

                                    // Default first option is selected
                                    $qtyFieldValue = "1";
                                    $this->debug("Downsell - Default first option 1 is selected");
                                }

                                // Preselected qty
                                $funnelSelectedQuantity[$funnel_n]['downsell'] = $qtyFieldValue;
                                // --- END Check for predefined quantity for specific partial price

                                // Select quantity
                                $this->completeAndCheckField(__FUNCTION__,"select", "waitForClass", "findByClass", self::SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT, $f['downsell']['quantity'], "Product quantity " . $f['downsell']['quantity'] . " is selected", false, false, "selectByValue");

                                // Scroll to bottom
                                $actionDescription = "Scrolling to the bottom of the page";
                                $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Add to order
                                $actionDescription = "Downsell " . $funnelStep . " | Adding the  product " . $productName . " " . $variant . " | quantity: " . $f['downsell']['quantity'];
                                $action            = $this->findByXpath(self::BUTTON_BY_XPATH_FUNNEL_ADDTOORDER)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);
                            }
                            else {

                                // Scroll to bottom
                                $actionDescription = "Scrolling to the bottom of the page";
                                $action            = $this->wd->executeScript("window.scrollTo(0,document.body.scrollHeight)");
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                                // Skip funnel
                                $actionDescription = "Downsell " . $funnelStep . " | skipping the product " . $productName;
                                $action            = $this->waitForXpath(self::BUTTON_BY_XPATH_FUNNEL_NOTOORDER)->click();
                                $this->logAction(__FUNCTION__,$action, $actionDescription);

                            }
                        }
                    }
                }
            }
        }
        else {
            // Funnel details are not correctly stored as array
            $this->warn("Funnel does not have proper details. Please fix array with funnel info.");

            // Close browser
            $this->wd->close();
            $this->warn("Browser window was closed");

            // Quit test
            $this->wd->quit();
            $this->warn("Webdriver has quit");

            // Terminate
            die("Funnel does not exist");
        }

        // Return funnel values to check asserting
        return array("funnel_title"             => $funnelTitle,
                     "funnel_product"           => $funnelProduct,
                     "funnel_price"             => $funnelPriceClean,
                     "funnel_selected_variant"  => $funnelSelectedVariant,
                     "funnel_selected_quantity" => $funnelSelectedQuantity,
                     "funnel_chdata"            => $funnelChData);
    }

    /**
     * Complete all the steps to complete Happy path of product order
     *
     * @param $productDetails
     * @param $orderDetails
     * @param $correctTotalValues
     * @param $correctThankYouPageTotalValues
     * @param $correctFunnelValues
     * @return array
     */
    public function completeOrder($productDetails, $orderDetails, $correctTotalValues, $correctThankYouPageTotalValues, $correctFunnelValues) {

        // Create new instance of random string class.
        $generator = new RandomString;

        // Set token length (for the email purpose)
        $tokenLength = 3;

        // Define token for email
        $token = $generator->generate($tokenLength);

        // Get current window handle
        $actionDescription = "Getting windows ID for current 'Main' tab";
        $action            = $currentHandle = $this->wd->getWindowHandle();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Return asserting array with values to check if everything is ok
        $assertArray = array();

        // Add product to a cart
        foreach ($productDetails as $key => $product) {

            $productData = $this->addNewProductToCart($product['product_name'], $product['product_variant'], $product['product_quantity']);

            // Product assertions
            $assertArray[$key . "_" . "products"]['assert']          = "assertContains";
            $assertArray[$key . "_" . "products"]['correct_values']  = self::PARTIAL_TITLE_PRODUCTS;
            $assertArray[$key . "_" . "products"]['returned_values'] = $productData['currentpage'];
            $assertArray[$key . "_" . "products"]['message']         = "Current page is: " . $productData['currentpage'];

            $assertArray[$key . "_" . $product['product_name']]['assert']          = "assertSame";
            $assertArray[$key . "_" . $product['product_name']]['correct_values']  = $productData['correctproductvalues'];
            $assertArray[$key . "_" . $product['product_name']]['returned_values'] = $productData['returnedproductvalues'];
            $assertArray[$key . "_" . $product['product_name']]['message']         = "Added to a cart -> Product: " . $productData['returnedproductvalues']['name'] . " | Product price: " . $productData['returnedproductvalues']['price'] . " | Product qty: " . $productData['returnedproductvalues']['quantity'];
            unset($product);
        }
        // Continue to checkout page
        $checkoutPageData = $this->continueToCheckoutPage($orderDetails['payment_processor'], $orderDetails['connect_processor'], $orderDetails['admin_login']);

        // Fill in the shipping data
        $shippingData = $this->continueToFillShippingData($orderDetails['shipping_country'], $token);

        // If we have a coupon, enter it
        if ($orderDetails['with_discount']) {

            // Locate coupon field, and enter values
            $actionDescription = "Entering new coupon";
            $action            = $this->findById("coupon_code")->sendKeys($orderDetails['with_discount']);
            $this->logAction(__FUNCTION__,$action, $actionDescription);

            // Apply coupon
            $actionDescription = "Clicking on apply coupon button";
            $action            = $this->findByClass("btn-coupon")->click();
            $this->logAction(__FUNCTION__,$action, $actionDescription);
        }

        // Check if values are calculated properly
        $totalValuesData = $this->continueToCheckTotalValues($orderDetails['with_tax'], $orderDetails['with_discount']);

        // --- Define funnel partial id for cartdata
        if ($orderDetails['with_funnel']) {

            // Get funnel position (funnel position by tag is not included :: we should define this in order)
            $funnelPosition    = 0;
            $funnelProductName = "";
            $partialCount = 0;

            foreach ($productDetails as $productKey => $product) {

                // Loop thought the funnel and get positions for the first selected product
                foreach ($product['funnel'] as $funnelStep => $partial) {

                    foreach ($partial as $partialDetails) {

                        $partialCount = $partialCount++;

                        $this->warn($partialCount);

                        // When first funnel product is added to a cart, mark position
                        if ($partialDetails['skip'] == false) {

                            $funnelPosition    = $partialCount;
                            $funnelProductName = $productDetails[$productKey]['product_name'];

                            break;
                        }
                    }
                }

                // Get next funnel partial id
                $funnelPartialId = Products::getFunnelPartialId($funnelProductName, $funnelPosition);
            }

        }
        else {

            // Funnel partial id will be set for the checkout page
            $funnelPartialId = self::FUNNEL_THANKYOU_PAGE_PARTIAL_ID;
        }

        // Define Carthook order ID
        $actionDescription = "Getting current URL";
        $action            = $orderUrl = $this->wd->getCurrentURL();
        $this->logAction(__FUNCTION__,$action, $actionDescription);

        // Get order id from the last slash within the url
        $orderUrlId = substr($orderUrl, strrpos($orderUrl, '/') + 1);

        // Check if coupon are included in the order
        if ($orderDetails['with_discount']) {

            // Get Coupon details
            $couponDetails = Define::defineCoupon($orderDetails['with_discount']);

            // Create array with values
            $couponData = array('amount'      => $couponDetails['amount'],
                                'coupon_code' => $couponDetails['coupon_code'],
                                'coupon_type' => $couponDetails['coupon_type']);

        }
        else {
            $couponData = null;
        }

        // Send data to chData status
        $this->status_cartdata[0] = array('cart_data'                      => array('line_items' => array()),
                                          'funnel_id'                      => self::FUNNEL_ID,
                                          'funnel_partial_id'              => $funnelPartialId,
                                          'last_charged_funnel_partial_id' => self::FUNNEL_CHECKOUT_PARTIAL_ID,
                                          'last_charged_page_type'         => 'checkout_page',
                                          'order'                          => array('billing_address'             => array('address1'   => $shippingData['returnedshippingvalues']['address'],
                                                                                                                           'address2'   => '',
                                                                                                                           'city'       => $shippingData['returnedshippingvalues']['city'],
                                                                                                                           'company'    => '',
                                                                                                                           'country'    => $shippingData['returnedshippingvalues']['country'],
                                                                                                                           'first_name' => $shippingData['returnedshippingvalues']['firstname'],
                                                                                                                           'last_name'  => $shippingData['returnedshippingvalues']['lastname'],
                                                                                                                           'phone'      => '',
                                                                                                                           'province'   => '',
                                                                                                                           'updated'    => false,
                                                                                                                           'zip'        => $shippingData['returnedshippingvalues']['zip']),
                                                                                    'carthook_order_id'           => $orderUrlId,
                                                                                    'coupon'                      => $couponData,
                                                                                    'currency'                    => 'USD',
                                                                                    'customer'                    => array('buyer_accepts_marketing' => 'true',
                                                                                                                           'email'                   => $shippingData['returnedshippingvalues']['email'],
                                                                                                                           'first_name'              => $shippingData['returnedshippingvalues']['firstname'],
                                                                                                                           'last_name'               => $shippingData['returnedshippingvalues']['lastname']),
                                                                                    'encoded_order_id'            => $orderUrlId,
                                                                                    'last_charged_line_items'     => array(),
                                                                                    'last_charged_shipping_rates' => array(),
                                                                                    'line_items'                  => array(),
                                                                                    'order_id'                    => '',
                                                                                    'order_number'                => '',
                                                                                    'payment_gateway'             => '',
                                                                                    'selected_shipping_rates'     => array(),
                                                                                    'shipping_address'            => array(),
                                                                                    'subtotal_price'              => '',
                                                                                    'token'                       => '',
                                                                                    'total_coupons_amount'        => '',
                                                                                    'total_price'                 => '',),
                                          'position'                       => '1',
                                          'previous_page_url'              => $orderUrl);

        // --- END Define values for cartdata

        // Select Payment processor and if necessary, fill in credentials
        $paymentProcessorData = $this->continueToSelectPaymentProcessor($orderDetails['payment_processor'], $checkoutPageData['processorStatus']);

        // Pay the order (country and token are passed for the paypal express to add additonal token to en email)
        $orderStatus = $this->continueToPay($orderDetails['payment_processor'], $orderDetails['with_funnel'], $currentHandle, $orderDetails['shipping_country'], $token);

        // Thank you page or Funnel
        if ($orderDetails['with_funnel']) {

            // Funnels are enabled
            foreach ($productDetails as $key_f => $productFunnel) {

                // If product has funnels and funnel is enabled
                if ($productFunnel['funnel']) {

                    // Complete funnel
                    $productFunnelData = $this->completeFunnel($productFunnel['funnel'], $productFunnel['product_name']);

                    if ($productFunnelData['funnel_title']) {

                        foreach ($productFunnelData['funnel_title'] as $ft_key => $ft):

                            if (isset($ft['upsell'])) {

                                // Funnel upsell page title assertions
                                $assertArray[$key_f . "_" . "funnel_title"]['assert']          = "assertContains";
                                $assertArray[$key_f . "_" . "funnel_title"]['correct_values']  = $correctFunnelValues[$ft_key]['upsell']['funnel_title'];
                                $assertArray[$key_f . "_" . "funnel_title"]['returned_values'] = $ft['upsell'];
                                $assertArray[$key_f . "_" . "funnel_title"]['message']         = "Current page is: " . $ft['upsell'];

                            }

                            if (isset($ft['downsell'])) {

                                // Funnel downsell page title assertions
                                $assertArray[$key_f . "_" . "funnel_title"]['assert']          = "assertContains";
                                $assertArray[$key_f . "_" . "funnel_title"]['correct_values']  = $correctFunnelValues[$ft_key]['downsell']['funnel_title'];
                                $assertArray[$key_f . "_" . "funnel_title"]['returned_values'] = $ft['downsell'];
                                $assertArray[$key_f . "_" . "funnel_title"]['message']         = "Current page is: " . $ft['downsell'];

                            }

                        endforeach;
                    }
                    if ($productFunnelData['funnel_product']) {

                        foreach ($productFunnelData['funnel_product'] as $fp_key => $fp):

                            if (isset($fp['upsell'])) {

                                $this->warn(@print_r($fp, true));
                                // Funnel upsell product name assertions
                                $assertArray[$key_f . "_" . "funnel_product"]['assert']          = "assertContains";
                                $assertArray[$key_f . "_" . "funnel_product"]['correct_values']  = $correctFunnelValues[$fp_key]['upsell']['funnel_product'];
                                $assertArray[$key_f . "_" . "funnel_product"]['returned_values'] = $fp['upsell'];
                                $assertArray[$key_f . "_" . "funnel_product"]['message']         = "Upsell - Funnel product is: " . $fp['upsell'];
                            }

                            if (isset($fp['downsell'])) {

                                // Funnel downsell product name assertions
                                $assertArray[$key_f . "_" . "funnel_product"]['assert']          = "assertContains";
                                $assertArray[$key_f . "_" . "funnel_product"]['correct_values']  = $correctFunnelValues[$fp_key]['downsell']['funnel_product'];
                                $assertArray[$key_f . "_" . "funnel_product"]['returned_values'] = $fp['downsell'];
                                $assertArray[$key_f . "_" . "funnel_product"]['message']         = "Downsell - Funnel product is: " . $fp['downsell'];
                            }

                        endforeach;

                    };
                    if ($productFunnelData['funnel_price']) {
                        foreach ($productFunnelData['funnel_price'] as $fpr_key => $fpr):

                            if (isset($fpr['upsell'])) {
                                // Funnel upsell product price assertions
                                $assertArray[$key_f . "_" . "funnel_price"]['assert']         = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_price"]['correct_values'] = $correctFunnelValues[$fpr_key]['upsell']['funnel_price'];;
                                $assertArray[$key_f . "_" . "funnel_price"]['returned_values'] = $fpr['upsell'];
                                $assertArray[$key_f . "_" . "funnel_price"]['message']         = "Upsell - Funnel product price is: " . $fpr['upsell'];
                            }

                            if (isset($fpr['downsell'])) {
                                // Funnel downsell product price assertions
                                $assertArray[$key_f . "_" . "funnel_price"]['assert']         = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_price"]['correct_values'] = $correctFunnelValues[$fpr_key]['downsell']['funnel_price'];;
                                $assertArray[$key_f . "_" . "funnel_price"]['returned_values'] = $fpr['downsell'];
                                $assertArray[$key_f . "_" . "funnel_price"]['message']         = "Downsell - Funnel product price is: " . $fpr['downsell'];
                            }

                        endforeach;
                    }
                    /* Funnel partials currently don't use variant yet
                    if ($productFunnelData['funnel_selected_variant']) {
                        foreach ($productFunnelData['funnel_selected_variant'] as $fv_key => $fv):

                            if (isset($fv['upsell'])) {
                                // Funnel upsell product variant assertions
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['assert']          = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['correct_values']  = $correctFunnelValues[$fv_key]['upsell']['funnel_selected_variant'];
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['returned_values'] = $fv['upsell'];
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['message']         = "Upsell - Funnel product variant is: " . $fv['upsell'];
                            }

                            if (isset($fv['downsell'])) {
                                // Funnel downsell product variant assertions
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['assert']          = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['correct_values']  = $correctFunnelValues[$fv_key]['downsell']['funnel_selected_variant'];
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['returned_values'] = $fv['downsell'];
                                $assertArray[$key_f . "_" . "funnel_selected_variant"]['message']         = "Downsell - Funnel product variant is: " . $fv['downsell'];
                            }

                        endforeach;
                    }*/
                    if ($productFunnelData['funnel_selected_quantity']) {
                        foreach ($productFunnelData['funnel_selected_quantity'] as $fq_key => $fq):

                            if (isset($fq['upsell'])) {
                                // Funnel upsell product quantity assertions
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['assert']          = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['correct_values']  = $correctFunnelValues[$fq_key]['upsell']['funnel_selected_quantity'];
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['returned_values'] = $fq['upsell'];
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['message']         = "Upsell - Funnel product quantity is: " . $fq['upsell'];
                            }

                            if (isset($fq['downsell'])) {
                                // Funnel downsell product quantity assertions
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['assert']          = "assertSame";
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['correct_values']  = $correctFunnelValues[$fq_key]['downsell']['funnel_selected_quantity'];
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['returned_values'] = $fq['downsell'];
                                $assertArray[$key_f . "_" . "funnel_selected_quantity"]['message']         = "Downsell - Funnel product quantity is: " . $fq['downsell'];
                            }

                        endforeach;
                    }

                    if ($productFunnelData['funnel_chdata']) {
                        foreach ($productFunnelData['funnel_chdata'] as $fch_key => $fch):

                            if (isset($fch['upsell'])) {
                                // Funnel upsell chData order values assertions
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['assert']          = "assertSame";
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['correct_values']  = $correctFunnelValues[$fch_key]['upsell']['funnel_chdata'];
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['returned_values'] = $fch['upsell'];
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['message']         = "Funnel product quantity is: " . $fch['upsell'];
                                $this->warn(@print_r($fch['upsell'], true));
                            }

                            if (isset($fch['downsell'])) {
                                // Funnel downsell chData order values assertions
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['assert']          = "assertSame";
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['correct_values']  = $correctFunnelChDataValues[$fch_key]['downsell']['funnel_chdata'];
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['returned_values'] = $fch['downsell'];
                                //$assertArray[$key_f . "_" . "funnel_chdata"]['message']         = "Funnel product quantity is: " . $fch['downsell'];
                                $this->warn(@print_r($fch['downsell'], true));
                            }

                        endforeach;
                    }
                }
            }
        }

        /* $_cartData = $this->status_cartdata;
         $_chData = $this->status_chdata;

         $this->log_results($_cartData);
         $this->log_results($_chData);

         // Checkout page assertions
         $assertArray["chData"]['assert']          = "assertSame";
         $assertArray["chData"]['correct_values']  = $_cartData;
         $assertArray["chData"]['returned_values'] = $_chData;
         $assertArray["chData"]['message']         = @print_r($this->arrayDifference($_cartData, $_chData), true);
        */

        // Before we continue to the next step, we needs to be sure that order is processed successfully
        // Order can fail if the minimum price is not reached
        if ($orderStatus['status']) {

            // Display Thank you page
            $thankYouPageData = $this->continueToThankYouPage();
        }
        else {

            // Close browser
            $this->wd->close();
            $this->warn("Browser window was closed");

            // Quit test
            $this->wd->quit();
            $this->warn("Web driver has quit");

            // Terminate
            die($orderStatus['status']);
        }

        // Check if Thank you page values are displayed properly
        $returnedThankYouPageTotalValues = $this->continueToCheckThankYouPageTotalValues($orderDetails['with_tax'], $orderDetails['with_discount']);

        // Checkout page assertions
        $assertArray["checkoutPageData"]['assert']          = "assertContains";
        $assertArray["checkoutPageData"]['correct_values']  = self::PARTIAL_TITLE_CHECKOUT;
        $assertArray["checkoutPageData"]['returned_values'] = $checkoutPageData['currentpage'];
        $assertArray["checkoutPageData"]['message']         = "Current page is: " . $checkoutPageData['currentpage'];

        // Shipping assertions
        $assertArray["shippingData"]['assert']          = "assertSame";
        $assertArray["shippingData"]['correct_values']  = $shippingData['correctshippingvalues'];
        $assertArray["shippingData"]['returned_values'] = $shippingData['returnedshippingvalues'];
        $assertArray["shippingData"]['message']         = "Shipping data entered -> Email: " . $shippingData['returnedshippingvalues']['email'] . PHP_EOL . " | First name: " . $shippingData['returnedshippingvalues']['firstname'] . PHP_EOL . " | Last name: " . $shippingData['returnedshippingvalues']['lastname'] . PHP_EOL . " | Address: " . $shippingData['returnedshippingvalues']['address'] . PHP_EOL . " | City: " . $shippingData['returnedshippingvalues']['city'] . PHP_EOL . " | Country: " . $shippingData['returnedshippingvalues']['country'] . PHP_EOL . " | Zip: " . $shippingData['returnedshippingvalues']['zip'] . PHP_EOL;

        // Total values assertions
        $assertArray["totalValuesData"]['assert']          = "assertSame";
        $assertArray["totalValuesData"]['correct_values']  = $correctTotalValues;
        $assertArray["totalValuesData"]['returned_values'] = $totalValuesData['returnedtotalvalues'];
        $assertArray["totalValuesData"]['message']         = "Total order values: " . PHP_EOL . " | Subtotal: " . $totalValuesData['returnedtotalvalues']['subtotal'] . PHP_EOL . " | Shipping: " . $totalValuesData['returnedtotalvalues']['shipping'] . PHP_EOL . " | Tax: " . $totalValuesData['returnedtotalvalues']['tax'] . PHP_EOL . " | Coupon: " . $totalValuesData['returnedtotalvalues']['coupon'] . PHP_EOL . " | Total: " . $totalValuesData['returnedtotalvalues']['total'] . PHP_EOL;

        // Payment processor assertions
        $assertArray["paymentProcessorData"]['assert']          = "assertSame";
        $assertArray["paymentProcessorData"]['correct_values']  = $paymentProcessorData['correctpaymentprocessorvalues'];
        $assertArray["paymentProcessorData"]['returned_values'] = $paymentProcessorData['returnedpaymentprocessorvalues'];

        // Define correct values for selected Payment processor
        switch ($orderDetails['payment_processor']):
            // If payment processor is "Cash on Delivery"
            case self::PAYMENT_PROCESSOR_CASHONDELIVERY:
                $assertArray["paymentProcessorData"]['message'] = "Payment processor: Cash On Delivery";
                break;
            // If payment processor is "PayPal"
            case self::PAYMENT_PROCESSOR_PAYPAL:
                $assertArray["paymentProcessorData"]['message'] = "Payment values entered -> PayPal login email: " . $paymentProcessorData['returnedpaymentprocessorvalues']['email_address'] . PHP_EOL . " | PayPal login password: " . $paymentProcessorData['returnedpaymentprocessorvalues']['password'] . PHP_EOL;
                break;

            // If payment processor is "PayPal Express"
            case self::PAYMENT_PROCESSOR_PAYPAL_EXPRESS:
                $assertArray["paymentProcessorData"]['message'] = "Payment values entered -> PayPal login email: " . $paymentProcessorData['returnedpaymentprocessorvalues']['email_address'] . PHP_EOL . " | PayPal login password: " . $paymentProcessorData['returnedpaymentprocessorvalues']['password'] . PHP_EOL;
                break;

            // If payment processor is "Braintree PayPal"
            case self::PAYMENT_PROCESSOR_BRAINTREE_PAYPAL:
                $assertArray["paymentProcessorData"]['message'] = "Payment values entered -> PayPal login email: " . $paymentProcessorData['returnedpaymentprocessorvalues']['email_address'] . PHP_EOL . " | PayPal login password: " . $paymentProcessorData['returnedpaymentprocessorvalues']['password'] . PHP_EOL;
                break;

            // Default payment processor are "Credit Cards"
            default:
                $assertArray["paymentProcessorData"]['message'] = "Payment values entered -> CC number: " . $paymentProcessorData['returnedpaymentprocessorvalues']['card_number'] . PHP_EOL . " | CC name: " . $paymentProcessorData['returnedpaymentprocessorvalues']['name_on_card'] . PHP_EOL . " | CC expiry date: " . $paymentProcessorData['returnedpaymentprocessorvalues']['expiry_date'] . PHP_EOL . " | CC cvv: " . $paymentProcessorData['returnedpaymentprocessorvalues']['cvv'] . PHP_EOL;
                break;
        endswitch;

        // Thank you page assertions
        $assertArray["thankYouPageData"]['assert']          = "assertContains";
        $assertArray["thankYouPageData"]['correct_values']  = self::PARTIAL_TITLE_THANKYOUPAGE;
        $assertArray["thankYouPageData"]['returned_values'] = $thankYouPageData['currentpage'];
        $assertArray["thankYouPageData"]['message']         = "Current page is: " . $thankYouPageData['currentpage'];

        // Thank you page value assertions
        $assertArray["thankYouPageValuesData"]['assert']          = "assertSame";
        $assertArray["thankYouPageValuesData"]['correct_values']  = $correctThankYouPageTotalValues;
        $assertArray["thankYouPageValuesData"]['returned_values'] = $returnedThankYouPageTotalValues['returnedtotalvalues'];
        $assertArray["thankYouPageValuesData"]['message']         = "Thank you Page, total order values: " . PHP_EOL . " | Subtotal: " . $returnedThankYouPageTotalValues['returnedtotalvalues']['subtotal'] . PHP_EOL . " | Shipping: " . $returnedThankYouPageTotalValues['returnedtotalvalues']['shipping'] . PHP_EOL . " | Tax: " . $returnedThankYouPageTotalValues['returnedtotalvalues']['tax'] . PHP_EOL . " | Coupon: " . $returnedThankYouPageTotalValues['returnedtotalvalues']['coupon'] . PHP_EOL . " | Total: " . $returnedThankYouPageTotalValues['returnedtotalvalues']['total'] . PHP_EOL;

        return $assertArray;
    }
}