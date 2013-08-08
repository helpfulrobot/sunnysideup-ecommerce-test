<?php

global $project;
$project = 'mysite';

global $database;
$database = 'kleinekeuken_nl';

require_once('conf/ConfigureFromEnv.php');

MySQLDatabase::set_connection_charset('utf8');

// Set the current theme. More themes can be downloaded from
// http://www.silverstripe.org/themes/
SSViewer::set_theme('simple');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();


Email::setAdminEmail("sales@silverstripe-ecommerce.com");

/*** ECOMMERCE ***/
LeftAndMain::require_css("ecommerce/css/ecommercecmsfixes.css");


EcommerceConfig::set_folder_and_file_locations(array("mysite/ecommerce_config/ecommerce.yaml"));

PayPalExpressCheckoutPayment::set_live_config("pay_api1.sunnysideup.co.nz","A5X7F3B7UCHDDS2Y","AFcWxV21C7fd0v3bYYYRCpSSRl31AOiulket7ufyMMAWVAVr6aZ8Gf5l");
