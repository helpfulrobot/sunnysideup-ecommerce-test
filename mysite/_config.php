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



