<?php
/** File info
 *
 * @app: Carthook Tests
 * @filename: Constants
 * @author: sasokrajnc
 * @datetime: 21/10/2018 - 21:47
 * @version: Constants.php, v1.1
 */

namespace My\ProductOrder;

/**
 * Constants
 */
interface Constants {

    // Global
    const MESSAGE_BY_CLASS_TOAST_SUCCESS = "toast-success";
    const MODAL_CLOSE_BUTTON             = "dialog__close-btn";
    const FUNNEL_ID = "181";
    const FUNNEL_CHECKOUT_PARTIAL_ID = "rZVeCphKjrfNB3mnCFXF";
    const FUNNEL_THANKYOU_PAGE_PARTIAL_ID = "klvJhhTgmZeDcqyoLAJP";
    const DIV_BY_CLASS_LOADING_WINDOW_SPINNER = "white-overlay";
    const BUTTON_BY_CLASS_NAME_COUPON_APPLY = "btn-coupon";
    const SPINNER_ICON_BY_FONT_AWESOME = "fa-spinner";

    // Slack
    const SLACK_CHANNEL_WEBDRIVER_ERRORS = "#webdriver-errors";
    const SLACK_CHANNEL_ASSERT_ERRORS = "#assert-errors";
    const SLACK_CHANNEL_TEST_STEPS = "#test-steps";
    const SLACK_CHANNEL_TEST_ERRORS = "#test-errors";
    const SLACK_TOKEN = "xoxp-229812613238-228846659315-267825155074-4c965a0946589ce222117659e2cb504d";
    const SLACK_NICKNAME = "Carthook";

    // Menu
    const CATALOG = "Catalog";

    // Product page
    const PRODUCT_PRICE  = "price-item";
    const SELECT_VARIANT = "SingleOptionSelector-0";
    const ADD_TO_CART    = "AddToCartText-product-template";

    // Products page
    const URL_PRODUCTS           = "collections/all";
    const PARTIAL_TITLE_PRODUCTS = "Products";

    // Cart page
    const PARTIAL_TITLE_CART                          = "Your Shopping Cart";
    const INPUT_FIELD_BY_CSS_CART_UPDATE_QTY_BUTTON = "input.btn.btn--secondary.small--hide.cart__submit-control";

    // Checkout page
    const PARTIAL_TITLE_CHECKOUT                                     = "Checkout";
    const LOADED_PRODUCTS                                            = "item-image-holder";
    const INPUT_FIELD_BY_NAME_CHECKOUT_CHECKOUT_EMAIL                = "email";
    const INPUT_FIELD_BY_NAME_CHECKOUT_FIRSTNAME                     = "first_name";
    const INPUT_FIELD_BY_NAME_CHECKOUT_LASTNAME                      = "last_name";
    const INPUT_FIELD_BY_NAME_CHECKOUT_ADDRESS                       = "address1";
    const INPUT_FIELD_BY_NAME_CHECKOUT_CITY                          = "city";
    const SELECT_FIELD_BY_ID_COUNTRY                                 = "shipping_country";
    const SELECT_FIELD_BY_ID_COUNTRY_STATE                           = "shipping_province";
    const INPUT_FIELD_BY_NAME_CHECKOUT_ZIP                           = "zip";
    const SHIPPING_FETCH                                             = ".ch-shipping-value span";
    const SHIPPING_FETCH_SYMBOL                                      = "$";
    const INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CREDITCARD           = "credit_card-t";
    const INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_PAYPAL               = "paypal-t";
    const INPUT_BY_ID_CHECKOUT_PAYMENTPROCESSOR_CASHONDELIVERY       = "cash_on_delivery-t";
    const BUTTON_BY_CLASS_CHECKOUT_PAYMENTPROCESSOR_PAYPAL_EXPRESS   = "ch-paypal-express-button";
    const BUTTON_BY_CLASS_CHECKOUT_PAYMENTPROCESSOR_PAYPAL_BRAINTREE = "paypal-button";
    const ELEMENT_BY_TAG_CHECKOUT_PAYMENTCOMPONENT                   = "payment-component";
    const BUTTON_BY_CLASS_CHECKOUT_COMPLETEPURCHASE                  = "btn-block";
    const INPUT_FIELD_BY_ID_CHECKOUT_CREDIT_CARD_NUMBER = "card-number";

    // Checkout page / Thank you page total values
    const SPAN_BY_CLASS_CHECKCOUT_TOTALVALUES_TOTAL  = "div.ch-value.ch-total-price-value > span.ch-placeholder";
    const SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SUBTOTAL = "li.ch-subtotal > div.ch-value.ch-subtotal-value > span";
    const SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_SHIPPING = "li.ch-shipping > div.ch-value.ch-shipping-value > span";
    const SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_TAXES    = "li.ch-taxes > div.ch-value.ch-taxes-value > span";
    const SPAN_BY_CSS_CHECKCOUT_TOTALVALUES_COUPON   = "li.ch-coupon > div.ch-value.ch-taxes-value > span";

    // Thank you page values
    const A_HREF_BY_XPATH_THANKYOU_PAGE_EMAIL = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[4]/div/p/a";
    const STRONG_BY_XPATH_THANKYOU_PAGE_ORDER_ID = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[5]/div/p/strong";
    const SPAN_BY_XPATH_THANKYOU_PAGE_SHIPPING_FIRSTNAME = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-shipping-address-component/div/div[2]/div[1]/span[1]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_SHIPPING_LASTNAME = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-shipping-address-component/div/div[2]/div[1]/span[2]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_SHIPPING_ADDRESS = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-shipping-address-component/div/div[2]/div[2]/span";
    const SPAN_BY_XPATH_THANKYOU_PAGE_SHIPPING_CITY = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-shipping-address-component/div/div[2]/div[3]/span[1]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_SHIPPING_ZIP = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-shipping-address-component/div/div[2]/div[3]/span[2]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_BILLING_FIRSTNAME = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-billing-address-component/div/div[2]/div[1]/span[1]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_BILLING_LASTNAME = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-billing-address-component/div/div[2]/div[1]/span[2]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_BILLING_ADDRESS = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-billing-address-component/div/div[2]/div[2]/span";
    const SPAN_BY_XPATH_THANKYOU_PAGE_BILLING_CITY = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-billing-address-component/div/div[2]/div[3]/span[1]";
    const SPAN_BY_XPATH_THANKYOU_PAGE_BILLING_ZIP = "//*[@id=\"ch-checkout-app\"]/div/section[3]/div[9]/order-billing-address-component/div/div[2]/div[3]/span[2]";

    // Thank you page
    const PARTIAL_TITLE_THANKYOUPAGE = "Thank You";

    // Funnel page
    const PARTIAL_TITLE_FUNNEL                  = "One Time Offer";
    const SELECT_BY_CLASS_FUNNEL_VARIANTSELECT  = "select-variant-selector-component";
    const SELECT_BY_CLASS_FUNNEL_QUANTITYSELECT = "select-quantity-selector-component";
    const BUTTON_BY_XPATH_FUNNEL_ADDTOORDER     = "//*[@id=\"ch-checkout-app\"]/div/div/div[9]/div/ch-button/div[1]/button/span";
    const BUTTON_BY_XPATH_FUNNEL_NOTOORDER      = "//*[@id=\"ch-checkout-app\"]/div/div/div[11]/div/ch-button/div[1]/button/span";
    const H1_BY_XPATH_FUNNEL_PRODUCT_PRICE      = "//*[@id=\"ch-checkout-app\"]/div/div/div[4]/div/h1/strong";

    // Admin login page
    const URL_ADMIN_LOGIN_PAGE                   = "https://admin.dev.carthook.com/login";
    const INPUT_FIELD_BY_ID_ADMIN_LOGIN_EMAIL    = "email";
    const INPUT_FIELD_BY_ID_ADMIN_LOGIN_PASSWORD = "password";

    // Admin Dashboard
    const A_HREF_BY_ID_ADMIN_DASHBOARD_USERMENU_DROPDOWN                  = "navbarDropdownMenuLink";
    const A_HREF_BY_CLASS_ADMIN_DASHBOARD_USERMENU_DROPDOWN2              = "navbar-toggler";
    const SPAN_BY_TEXT_ADMIN_DASHBOARD_USERMENU_SETTINGS                  = "Settings";
    const A_HREF_BY_TEXT_ADMIN_DASHBOARD_SETTINGS_PAYMENTPROVIDERS        = "Payment Providers";
    const SELECT_BY_ATTRIBUTE_ADMIN_DASHBOARD_SETTINGS                    = "selectedCreditCardPaymentProcessor";
    const PARTIAL_TITLE_ADMIN_DASHBOARD                                   = "Dashboard";
    const PARTIAL_TITLE_ADMIN_SETTINGS                                    = "Store Settings";
    const PARTIAL_TITLE_ADMIN_SETTINGS_PAYMENTPROCESSORS                  = "Payment Processors";
    const SELECT_BY_TAG_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD       = "select";
    const SELECT_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD     = "custom-select";
    const SPAN_BY_TEXT_ADMIN_SETTINGS_PAYMENTPROCESSORS_CREDITCARD_BUTTON = "Connect Now";
    const MODAL_BY_CLASS_ADMIN_SETTINGS_PAYMENTPROCESSORS                 = "dialog";

    // Shop header
    const HEADER_CART = "site-header__cart";

    // Cart preview
    const BUTTON_CHECKOUT = "elm_pos_0";

    // Payment Processors
    const PAYMENT_PROCESSOR_STRIPE           = "Stripe";
    const PAYMENT_PROCESSOR_AUTHORIZE        = "Authorize";
    const PAYMENT_PROCESSOR_NMI              = "Nmi";
    const PAYMENT_PROCESSOR_BRAINTREE        = "Braintree";
    const PAYMENT_PROCESSOR_BRAINTREE_PAYPAL = "Braintree PayPal";
    const PAYMENT_PROCESSOR_PAYPAL           = "PayPal";
    const PAYMENT_PROCESSOR_PAYPAL_EXPRESS   = "PayPal Express";
    const PAYMENT_PROCESSOR_CASHONDELIVERY   = "Cash On Delivery";
    const PAYMENT_PROCESSOR_CONNECTED        = "Connected";
    const PAYMENT_PROCESSOR_NOTCONNECTED     = "Not Connected ";
    const A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_NMI = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[1]/div/div[2]/p/a";
    const A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_AUTHORIZE = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[1]/div/div[2]/p/a[2]";
    const SPAN_BY_XPATH_CREDITCARDS_BLOCK_CHECK_IF_CONNECTED = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[1]/div/div[2]/p/span";
    const A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_BRAINTREE = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[1]/div/div[2]/p/a[2]";
    const A_HREF_BY_XPATH_CREDITCARDS_REMOVE_BUTTON_STRIPE = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[1]/div/div[2]/p/a[2]";
    const SPAN_BY_XPATH_CREDITCARDS_CONNECTION_STATUS = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[3]/div/div[2]/p/span";
    const SPAN_BY_CSS_CREDITCARDS_CONNECTNOW_BUTTON = "div.panel.payment-processors.cod > div > div.col-sm-3.ng-star-inserted > p > a > span";

    // PayPal credentials
    const URL_PAYPAL_SANDBOX_LOGIN_PAGE                            = "https://www.sandbox.paypal.com/signin";
    const URL_PAYPAL_DEVELOPERS_LOGIN_PAGE                         = "https://www.paypal.com/signin?returnUri=https%3A%2F%2Fdeveloper.paypal.com%2Fdeveloper%2Faccounts%2F";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_BUYER_LOGIN_EMAIL       = "tech-buyer@carthook.com";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_BUYER_LOGIN_PASSWORD    = "12345678";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_MERCHAND_LOGIN_EMAIL    = "tech-facilitator@carthook.com";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_MERCHAND_LOGIN_PASSWORD = "12345678";

    // PayPal component
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGIN_EMAIL                      = "email";
    const INPUT_FIELD_BY_NAME_PAYPAL_SANDBOX_LOGIN_EMAIL = "login_email";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGIN_PASSWORD                   = "password";
    const INPUT_FIELD_BY_NAME_PAYPAL_SANDBOX_LOGIN_PASSWORD = "login_password";
    const BUTTON_BY_ID_PAYPAL_SANDBOX_LOGIN                                 = "btnLogin";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_WELCOME_TITLE          = "reviewUserInfo";
    const SELECT_BY_XPATH_PAYPAL_SANDBOX_LOGGED_IN_WAYTOPAY_CREDITUNION           = "//*[@id=\"xoSelectFi\"]/div[1]/div[1]/div[2]/div/div[1]/div/ul/li[1]";
    const SELECT_BY_XPATH_PAYPAL_SANDBOX_LOGGED_IN_WAYTOPAY_CREDITUNION_PAYPAL_EXPRESS           = "//*[@id=\"xoSelectFi\"]/div[1]/div[1]/div[2]/div/div[1]/div/ul/li[1]/experience[1]/div/div/ng-transclude/div";
    const INPUT_FIELD_BY_CLASS_PAYPAL_SANDBOX_LOGGED_IN_CONTINUE_BUTTON     = "continueButton";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_CONFIRM_PAYMENT_BUTTON = "confirmButtonTop";
    const BUTTON_BY_ID_PAYPAL_SANDBOX_CONTINUE                              = "btnNext";
    const INPUT_FIELD_BY_ID_PAYPAL_SANDBOX_LOGGED_IN_LOADING                = "preloaderSpinner";
    const INPUT_FIELD_BY_CLASS_PAYPAL_SANDBOX_LOGGED_IN_LOADING = "lockIcon";
    const BUTTON_BY_TEXT_PAYPAL_IFRAME_CONTINUE_BUTTON = "Continue";
    const IFRAME_BY_CLASS_PAYPAL_IFRAME_WINDOW = "paypal-checkout-sandbox-iframe";
    const SPAN_BY_XPATH_PAYPAL_BLOCK_CHECK_IF_CONNECTED = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[2]/div/div[2]/p/span";
    const A_HREF_BY_XPATH_PAYPAL_BUTTON_CONNECTNOW = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[2]/div/div[3]/p/a/span";
    const A_HREF_BY_XPATH_PAYPAL_REMOVE_BUTTON = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/div/div/div[2]/div/div[2]/div/div[2]/p/a[2]";
    const A_HREF_BY_CSS_PAYPAL_EXPRESS_LOGIN_BUTTON = "#loginSection > div > div.span11.alignRight.baslLoginButtonContainer > a";


    // PayPal elements
    const PAYPAL_CONNECT_BUTTON_BY_CLASS_SELECTOR = "paypal";
    const PAYPAL_INPUT_FIELD_BY_ID_APIUSERNAME = "payPalApiUsername";
    const PAYPAL_INPUT_FIELD_BY_ID_APIPASSWORD = "payPalApiPassword";
    const PAYPAL_INPUT_FIELD_BY_ID_APISIGNATURE = "payPalApiSignature";
    const PAYPAL_CHECKBOX_FIELD_BY_ID_REFERENCE_TRANSACTIONS = "payPalReferenceTransactions";
    const PAYPAL_CHECKBOX_FIELD_BY_XPATH_SLIDER_ROUND_REFERENCE_TRANSACTIONS_CHECK = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[3]/div/div/div/form/div[6]/label/span";
    const PAYPAL_CONNECT_BUTTON_BY_XPATH = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[3]/div/div/div/form/custom-button/button";

    // PayPal API credentials
    const PAYPAL_API_USERNAME = "tech-facilitator_api1.carthook.com";
    const PAYPAL_API_PASSWORD = "ZVFNJUYFGY5N8RNS";
    const PAYPAL_API_SIGNATURE = "AFcWxV21C7fd0v3bYYYRCpSSRl31An7q4cAVM7HLO0vbPgu5kp1zgTPy";

    // Cash on Delivery
    const CASHONDELIVERY_CONNECT_BUTTON_BY_CSS_SELECTOR = "cod";

    // NMI elements
    const NMI_INPUT_CHECKBOX_BY_NAME_CONFIRMATION = "nmiProcessorShared";
    const NMI_INPUT_FIELD_BY_ID_APIKEY          = "nmiApiKey";
    const NMI_CONNECT_BUTTON_BY_XPATH           = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[5]/div/div/div/form/custom-button/button";

    // NMI credentials
    const NMI_API_KEY                           = "xp7P2FMEqFTPup4hDhHfrWW4c9yy3m48";

    // Payment component Nmi / Authorize
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NUMBER     = "cc-number";
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_NAME       = "cc-name";
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_EXPIRYDATE = "cc-exp";
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_CC_CVV        = "cc-cvc";

    // Authorize elements
    const AUTHORIZE_INPUT_FIELD_BY_ID_API_LOGINID = "authorizeLoginID";
    const AUTHORIZE_INPUT_FIELD_BY_ID_TRANSACTIONKEY = "authorizePublicKey";
    const AUTHORIZE_INPUT_FIELD_BY_ID_PUBLICCLIENTKEY = "authorizePrivateKey";
    const AUTHORIZE_CONNECT_BUTTON_BY_XPATH = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[4]/div/div/div/form/custom-button/button";

    // Authorize credentials
    const AUTHORIZE_API_LOGINID = "8c8uFvC9x";
    const AUTHORIZE_API_TRANSACTIONKEY = "58d9Cs99NprL5k46";
    const AUTHORIZE_API_PUBLICCLIENTKEY = "7XmkfC8t325WsEWUdQz5c2ZRZe58j97cyhc2qG2hxMrtAwJz8VPEU87rgAe2VgeC";

    // Braintree elements
    const BRAINTREE_INPUT_FIELD_BY_ID_MERCHANTID = "braintreeMerchantId";
    const BRAINTREE_INPUT_FIELD_BY_ID_PUBLIC_API_KEY = "braintreePublicApiKey";
    const BRAINTREE_INPUT_FIELD_BY_ID_PRIVATE_API_KEY = "braintreePrivateApiKey";
    const BRAINTREE_CONNECT_BUTTON_BY_XPATH = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[6]/div/div/div/form/custom-button/button";
    const BRAINTREE_INPUT_CHECKBOX_BY_ID_PAYPAL_CONFIRMATION = "braintreePayPalEnabled";
    const BRAINTREE_INPUT_CHECKBOX_BY_XPATH_SLIDER_ROUND_PAYPAL_CONFIRMATION_CHECK = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[6]/div/div/div/form/div[6]/label/span";

    // Braintree credentials
    const BRAINTREE_API_MERCHANTID = "27fjvffcmfkqbhzm";
    const BRAINTREE_API_PUBLICAPIKEY = "zn4wfy26tbt5g8sb";
    const BRAINTREE_API_PRIVATEAPIKEY = "a292b48d25bf8c20ff65716f870a24c4";

    // Payment component Braintree
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_NUMBER = "braintree-hosted-field-number";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_NUMBER     = "credit-card-number";
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_NAME       = "card-name";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_EXPIRYDATE = "braintree-hosted-field-expirationDate";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_EXPIRYDATE = "expiration";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_IFRAME_CC_CVV = "braintree-hosted-field-cvv";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_BRAINTREE_CC_CVV        = "cvv";

    // Stripe elements
    const STRIPE_CONNECT_BUTTON_BY_XPATH = "/html/body/app-root/app-admin/div/settings/merchant-payment-processors/ngx-smart-modal[2]/div/div/div/div/div/button[2]";
    const STRIPE_CONNECT_PAGE_BY_PARTIAL_URL = "connect.stripe.com";
    const STRIPE_A_HREF_BY_CSS_SIGNIN = "#header > p > span > a";
    const STRIPE_BUTTON_BY_CLASS_SIGNIN = "blue";
    const STRIPE_REDIRECT_BY_PARTIAL_URL_LOCAL_HOST = "http://localhost:4200";

    // Stripe credentials
    const STRIPE_LOGIN_EMAIL = "artisan@roksrocks.com";
    const STRIPE_LOGIN_PASSWORD = "wHnCbuY7VdhiR@6m";

    // Payment component Stripe
    const INPUT_FIELD_BY_TAGNAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_NUMBER = "iframe";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_NUMBER     = "cardnumber";
    const INPUT_FIELD_BY_ID_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_NAME       = "card-name";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_EXPIRYDATE = "__privateStripeFrame5";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_EXPIRYDATE = "exp-date";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_IFRAME_CC_CVV = "__privateStripeFrame6";
    const INPUT_FIELD_BY_NAME_CHECKOUT_PAYMENTCOMPONENT_STRIPE_CC_CVV        = "cvc";
}