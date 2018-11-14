#Tests location
alias carthook='cd SERVER/carthook/selenium-tests'

#Start selenium parallel
alias start_sel_multi='java -jar ./vendor/bin/selenium-server-standalone-3.14.0.jar'

#Start selenium single
alias start_sel_single='java -jar ./vendor/bin/selenium-server-standalone-3.14.0.jar -role hub -timeout 30 -browserTimeout 60;java -jar ./vendor/bin/selenium-server-standalone-3.14.0.jar -role node -maxSession 1'

#PayPal
alias dev_enable_paypal='vendor/bin/steward run dev chrome --pattern doOrderWithPayPalTest.php --filter test_enablePaymentProcessorPayPal --ignore-delays -vvv'
alias dev_disable_paypal='vendor/bin/steward run dev chrome --pattern doOrderWithPayPalExpressTest.php --filter test_disablePaymentProcessorPayPal --ignore-delays -vvv'

alias stage_enable_paypal='vendor/bin/steward run stage chrome --pattern doOrderWithPayPalTest.php --filter test_enablePaymentProcessorPayPal --ignore-delays -vvv'
alias stage_disable_paypal='vendor/bin/steward run stage chrome --pattern doOrderWithPayPalExpressTest.php --filter test_disablePaymentProcessorPayPal --ignore-delays -vvv'

alias dev_run_paypal='vendor/bin/steward run dev chrome --group paypal --ignore-delays -vvv'
alias dev_run_paypal_incognito='vendor/bin/steward run dev chrome_i --group paypal --ignore-delays -vvv'
alias dev_run_paypal_headless='vendor/bin/steward run dev chrome_h --group paypal --ignore-delays -vvv'
alias dev_run_paypalexpress='vendor/bin/steward run dev chrome --group paypalexpress --ignore-delays -vvv'
alias dev_run_paypalexpress_incognito='vendor/bin/steward run dev chrome_i --group paypalexpress --ignore-delays -vvv'
alias dev_run_paypalexpress_headless='vendor/bin/steward run dev chrome_h --group paypalexpress --ignore-delays -vvv'
alias dev_run_paypal_both='vendor/bin/steward run dev chrome --group paypal --ignore-delays --group paypalexpress -vvv'
alias dev_run_paypal_both_incognito='vendor/bin/steward run dev chrome_i --group paypal --ignore-delays --group paypalexpress -vvv'
alias dev_run_paypal_both_headless='vendor/bin/steward run dev chrome_h --group paypal --ignore-delays --group paypalexpress -vvv'

alias stage_run_paypal='vendor/bin/steward run stage chrome --group paypal --ignore-delays -vvv'
alias stage_run_paypal_incognito='vendor/bin/steward run stage chrome_i --group paypal --ignore-delays -vvv'
alias stage_run_paypal_headless='vendor/bin/steward run stage chrome_h --group paypal --ignore-delays -vvv'
alias stage_run_paypalexpress='vendor/bin/steward run stage chrome --group paypalexpress --ignore-delays -vvv'
alias stage_run_paypalexpress_incognito='vendor/bin/steward run stage chrome_i --group paypalexpress --ignore-delays -vvv'
alias stage_run_paypalexpress_headless='vendor/bin/steward run stage chrome_h --group paypalexpress --ignore-delays -vvv'
alias stage_run_paypal_both='vendor/bin/steward run stage chrome --group paypal --group paypalexpress --ignore-delays -vvv'
alias stage_run_paypal_both_incognito='vendor/bin/steward run stage chrome_i --group paypal --group paypalexpress --ignore-delays -vvv'
alias stage_run_paypal_both_headless='vendor/bin/steward run stage chrome_h --group paypal --group paypalexpress --ignore-delays -vvv'

#Authorize
alias dev_enable_authorize='vendor/bin/steward run dev chrome --pattern doOrderWithAuthorizeTest.php --filter test_enablePaymentProcessorAuthorize --ignore-delays -vvv'
alias dev_disable_authorize='vendor/bin/steward run dev chrome --pattern doOrderWithAuthorizeTest.php --filter test_disablePaymentProcessorAuthorize --ignore-delays -vvv'

alias stage_enable_authorize='vendor/bin/steward run stage chrome --pattern doOrderWithAuthorizeTest.php --filter test_enablePaymentProcessorAuthorize --ignore-delays -vvv'
alias stage_disable_authorize='vendor/bin/steward run stage chrome --pattern doOrderWithAuthorizeTest.php --filter test_disablePaymentProcessorAuthorize --ignore-delays -vvv'

alias dev_run_authorize='vendor/bin/steward run dev chrome --group authorize --ignore-delays -vvv'
alias dev_run_authorize_incognito='vendor/bin/steward run dev chrome_i --group authorize --ignore-delays -vvv'
alias dev_run_authorize_headless='vendor/bin/steward run dev chrome_h --group authorize --ignore-delays -vvv'

alias stage_run_authorize='vendor/bin/steward run stage chrome --group authorize --ignore-delays -vvv'
alias stage_run_authorize_incognito='vendor/bin/steward run stage chrome_i --group authorize --ignore-delays -vvv'
alias stage_run_authorize_headless='vendor/bin/steward run stage chrome_h --group authorize --ignore-delays -vvv'

#Braintree
alias dev_enable_braintree='vendor/bin/steward run dev chrome --pattern doOrderWithBraintreeTest.php --filter test_enablePaymentProcessorBraintree --ignore-delays -vvv'
alias dev_disable_braintree='vendor/bin/steward run dev chrome --pattern doOrderWithBraintreeTest.php --filter test_disablePaymentProcessorBraintree --ignore-delays -vvv'

alias stage_enable_braintree='vendor/bin/steward run stage chrome --pattern doOrderWithBraintreeTest.php --filter test_enablePaymentProcessorBraintree --ignore-delays -vvv'
alias stage_disable_braintree='vendor/bin/steward run stage chrome --pattern doOrderWithBraintreeTest.php --filter test_disablePaymentProcessorBraintree --ignore-delays -vvv'

alias dev_run_braintree='vendor/bin/steward run dev chrome --group braintree --ignore-delays -vvv'
alias dev_run_braintree_incognito='vendor/bin/steward run dev chrome_i --group braintree --ignore-delays -vvv'
alias dev_run_braintree_headless='vendor/bin/steward run dev chrome_h --group braintree --ignore-delays -vvv'

alias stage_run_braintree='vendor/bin/steward run stage chrome --group braintree --ignore-delays -vvv'
alias stage_run_braintree_incognito='vendor/bin/steward run stage chrome_i --group braintree --ignore-delays -vvv'
alias stage_run_braintree_headless='vendor/bin/steward run stage chrome_h --group braintree --ignore-delays -vvv'

#Stripe
alias dev_enable_stripe='vendor/bin/steward run dev chrome --pattern doOrderWithStripeTest.php --filter test_enablePaymentProcessorStripe --ignore-delays -vvv'
alias dev_disable_stripe='vendor/bin/steward run dev chrome --pattern doOrderWithStripeTest.php --filter test_disablePaymentProcessorStripe --ignore-delays -vvv'

alias stage_enable_stripe='vendor/bin/steward run stage chrome --pattern doOrderWithStripeTest.php --filter test_enablePaymentProcessorStripe --ignore-delays -vvv'
alias stage_disable_stripe='vendor/bin/steward run stage chrome --pattern doOrderWithStripeTest.php --filter test_disablePaymentProcessorStripe --ignore-delays -vvv'

alias dev_run_stripe='vendor/bin/steward run dev chrome --group stripe --ignore-delays -vvv'
alias dev_run_stripe_incognito='vendor/bin/steward run dev chrome_i --group stripe --ignore-delays -vvv'
alias dev_run_stripe_headless='vendor/bin/steward run dev chrome_h --group stripe --ignore-delays -vvv'

alias stage_run_stripe='vendor/bin/steward run stage chrome --group stripe --ignore-delays -vvv'
alias stage_run_stripe_incognito='vendor/bin/steward run stage chrome_i --group stripe --ignore-delays -vvv'
alias stage_run_stripe_headless='vendor/bin/steward run stage chrome_h --group stripe --ignore-delays -vvv'

#Nmi
alias dev_enable_nmi='vendor/bin/steward run dev chrome --pattern doOrderWithNmiTest.php --filter test_enablePaymentProcessorNmi --ignore-delays -vvv'
alias dev_disable_nmi='vendor/bin/steward run dev chrome --pattern doOrderWithNmiTest.php --filter test_disablePaymentProcessorNmi --ignore-delays -vvv'

alias stage_enable_nmi='vendor/bin/steward run stage chrome --pattern doOrderWithNmiTest.php --filter test_enablePaymentProcessorNmi --ignore-delays -vvv'
alias stage_disable_nmi='vendor/bin/steward run stage chrome --pattern doOrderWithNmiTest.php --filter test_disablePaymentProcessorNmi --ignore-delays -vvv'

alias dev_run_nmi='vendor/bin/steward run dev chrome --group nmi --ignore-delays -vvv'
alias dev_run_nmi_incognito='vendor/bin/steward run dev chrome_i --group nmi --ignore-delays -vvv'
alias dev_run_nmi_headless='vendor/bin/steward run dev chrome_h --group nmi --ignore-delays -vvv'

alias stage_run_nmi='vendor/bin/steward run stage chrome --group nmi --ignore-delays -vvv'
alias stage_run_nmi_incognito='vendor/bin/steward run stage chrome_i --group nmi --ignore-delays -vvv'
alias stage_run_nmi_headless='vendor/bin/steward run stage chrome_h --group nmi --ignore-delays -vvv'

#Cash On Delivery
alias dev_enable_cod='vendor/bin/steward run dev chrome --pattern doOrderWithCashOnDeliveryTest.php --filter test_enablePaymentProcessorCashOnDelivery --ignore-delays -vvv'
alias dev_disable_cod='vendor/bin/steward run dev chrome --pattern doOrderWithCashOnDeliveryTest.php --filter test_disablePaymentProcessorCashOnDelivery --ignore-delays -vvv'

alias stage_enable_cod='vendor/bin/steward run stage chrome --pattern doOrderWithCashOnDeliveryTest.php --filter test_enablePaymentProcessorCashOnDelivery --ignore-delays -vvv'
alias stage_disable_cod='vendor/bin/steward run stage chrome --pattern doOrderWithCashOnDeliveryTest.php --filter test_disablePaymentProcessorCashOnDelivery --ignore-delays -vvv'

alias dev_run_cod='vendor/bin/steward run dev chrome --group cod --ignore-delays -vvv'
alias dev_run_cod_incognito='vendor/bin/steward run dev chrome_i --group cod --ignore-delays -vvv'
alias dev_run_cod_headless='vendor/bin/steward run dev chrome_h --group cod --ignore-delays -vvv'

alias stage_run_cod='vendor/bin/steward run stage chrome --group cod --ignore-delays -vvv'
alias stage_run_cod_incognito='vendor/bin/steward run stage chrome_i --group cod --ignore-delays -vvv'
alias stage_run_cod_headless='vendor/bin/steward run stage chrome_h --group cod --ignore-delays -vvv'

#All
alias dev_run_all='vendor/bin/steward run dev chrome -vvv'
alias dev_run_all_incognito='vendor/bin/steward run dev chrome_i -vvv'
alias dev_run_all_headless='vendor/bin/steward run dev chrome_h -vvv'

alias stage_run_all='vendor/bin/steward run stage chrome -vvv'
alias stage_run_all_incognito='vendor/bin/steward run stage chrome_i -vvv'
alias stage_run_all_headless='vendor/bin/steward run stage chrome_h -vvv'