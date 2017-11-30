<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/

$autoload['packages'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/

$autoload['libraries'] = array('database', 'session', 'table', 'javascript', 'pagination', 'user_agent', 'form_validation', 'facebook', 'merchant', 'ipnlistener', 'paypal_lib', 'misc_lib', 'encrypt');


/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in the system/libraries folder or in your
| application/libraries folder within their own subdirectory. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
*/

$autoload['drivers'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array('form', 'url', 'html', 'security', 'date', 'file');


/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/

$autoload['config'] = array('facebook', 'google', 'paypal', 'paypallib_config', 'pagination', 'email');


/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/

					$autoload['model'] = array(

						'Admin_model' => 'Admin',
						'Address_book_model' => 'Address_book',
						'Addresses_model' => 'Addresses',
						'Answers_model' => 'Answers',
						'Bank_account_payment_methods_model' => 'Bank_account_payment_methods',
						'Brands_model' => 'Brands',
						'Card_payment_methods_model' => 'Card_payment_methods',
						'Cart_model' => 'Cart',
						'Colours_model' => 'Colours',
						'Contact_us_model' => 'Contact_us',
						'Countries_model' => 'Countries',
						'Default_address_model' => 'Default_address',
						'Domestic_shipping_rates_model' => 'Domestic_shipping_rates',
						'Failed_logins_model' => 'Failed_logins',
						'Failed_resets_model' => 'Failed_resets',
						'Female_categories_model' => 'Female_categories',
						'Female_sizes_model' => 'Female_sizes',
						'Female_shoe_sizes_model' => 'Female_shoe_sizes',
						'Intl_shipping_rates_model' => 'Intl_shipping_rates',
						'Logins_model' => 'Logins',
						'Male_categories_model' => 'Male_categories',
						'Male_sizes_model' => 'Male_sizes',
						'Male_shoe_sizes_model' => 'Male_shoe_sizes',
						'Messages_model' => 'Messages',
						'Oauth_logins_model' => 'Oauth_logins',
						'Order_details_model' => 'Order_details',
						'Orders_model' => 'Orders',
						'Page_metadata_model' => 'Page_metadata',
						'Paypal_payment_methods_model' => 'Paypal_payment_methods',
						'Payments_model' => 'Payments',
						'Product_categories_model' => 'Product_categories',
						'Product_options_model' => 'Product_options',
						'Products_model' => 'Products',
						'Security_questions_model' => 'Security_questions',
						'Shipping_model' => 'Shipping',
						'Shipping_status_model' => 'Shipping_status',
						'Site_activities_model' => 'Site_activities',
						'Song_model' => 'Song',
						'Store_model' => 'Store',
						'Temp_users_model' => 'Temp_users',
						'Transactions_model' => 'Transactions',
						'Reviews_model' => 'Reviews',
						'Users_model' => 'Users',
						'Wishlist_model' => 'Wishlist',
						'Question_categories_model' => 'Question_categories',
						'Questions_model' => 'Questions',
						
					);

