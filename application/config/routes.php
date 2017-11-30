<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = 'my_404';
$route['translate_uri_dashes'] = FALSE;

$route['about'] = 'main/about';
$route['contact-us'] = 'main/contact_us';
$route['lookbook'] = 'main/gallery';

$route['social'] = 'main/social';
$route['login'] = 'main/login';
$route['login/validation'] = 'main/login_validation';

$route['signup'] = 'main/signup';
$route['signup/validation'] = 'main/signup_validation';
$route['signup/success'] = 'main/signup_success';

$route['activation'] = 'account/account_activation';
$route['forgot-password'] = 'main/forgot_password';
$route['forgot-password/validation'] = 'main/forgot_password_validation';

$route['collections/([a-z]+)/([a-z]+)'] = 'collections/products/$1/$2';
$route['collections/product/(:num)/(:any)'] = 'collections/view_product/$1/$2';
//$route['collections/(:any)'] = 'collections/all/$1';
$route['collections/fit-guide'] = 'collections/fit_guide';

$route['account/confirm-payment'] = 'account/confirm_payment';
$route['account/set-security'] = 'account/set_security';
$route['account/set-security/validation'] = 'account/set_security_validation';
$route['account/add-address'] = 'account/add_address';
$route['account/update-address'] = 'account/update_address';
$route['account/verify-password'] = 'account/verify_password';
$route['account/change-password'] = 'account/change_password';
$route['logged-out'] = 'main/logged_out';


//$route['checkout'] = 'checkout/checkout';
//$route['checkout/customer-information'] = 'store/customer_information';
$route['checkout/contact-information'] = 'checkout/contact_information';
$route['checkout/shipping-method/'] = 'checkout/shipping_method';
$route['checkout/payment-method/'] = 'checkout/payment_method';
$route['paypal/payment'] = 'checkout/paypal_payment';
$route['paypal/payment-processing'] = 'checkout/paypal_processing';

$route['seo/sitemap\.xml'] = "seo/sitemap";