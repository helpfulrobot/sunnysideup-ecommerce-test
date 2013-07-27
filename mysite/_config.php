<?php

global $project; $project = 'mysite';
global $database; $database = 'ecommerce';
require_once('conf/ConfigureFromEnv.php');

//===================---------------- START PHP ----------------===================
date_default_timezone_set("NZ");
//===================---------------- END PHP ----------------===================

//===================---------------- START mysite MODULE ----------------===================
Director::addRules(50, array(
	'build-ecommerce//$Action/$ID/$OtherID' => 'CleanEcommerceTables'
));

Object::add_extension('SiteConfig', 'SiteConfigExtras');
//===================---------------- END mysite MODULE ----------------===================


//===================---------------- START sapphire MODULE ----------------===================
MySQLDatabase::set_connection_charset('utf8');
SSViewer::set_theme('main');
Geoip::$default_country_code = "NZ";
GD::set_default_quality(85);
Email::setAdminEmail('swd@sunnysideup.co.nz');
//Member::set_password_validator( new NZGovtPasswordValidator());
SiteTree::$breadcrumbs_delimiter = ' <span class="delimiter">&raquo;</span> ';
Session::set_timeout(1209600);//60 * 60 * 24 * 14
Email::bcc_all_emails_to('copyonly@sunnysideup.co.nz');
Requirements::set_combined_files_folder("_cache");
//Director::forceWWW();
FulltextSearchable::enable();
if(Director::isDev()) {
	SSViewer::set_source_file_comments(true);
}
if(Director::isLive()) {
	SS_Log::add_writer(new SS_LogEmailWriter('errors@sunnysideup.co.nz'), SS_Log::ERR);
}
SiteTree::enable_nested_urls();
i18n::set_locale('en_NZ');
Geoip::$default_country_code = 'NZ';
Email::setAdminEmail("sales@silverstripe-ecommerce.com");
//===================---------------- END sapphire MODULE ----------------===================


//===================---------------- START cms MODULE ----------------===================
LeftAndMain::setApplicationName("Sunny Side Up Test Website");
LeftAndMain::set_loading_image("themes/main/images/logo.gif");
ModelAdmin::set_page_length(100);
CMSMenu::remove_menu_item("CommentAdmin");
CMSMenu::remove_menu_item("ReportAdmin");
CMSMenu::remove_menu_item("HelpAdmin");
LeftAndMain::setLogo($location = "", $style = "");
PageComment::enableModeration();
//===================---------------- ENBD cms MODULE  ----------------===================



// __________________________________START ECOMMERCE MODULE CONFIG __________________________________


// __________________________________START ECOMMERCE MODULE CONFIG __________________________________
EcommerceConfig::set_folder_and_file_locations(array("mysite/_config/ecommerce.yaml"));
// __________________________________ END ECOMMERCE MODULE CONFIG __________________________________




//===================---------------- START metatags MODULE ----------------===================
// dont forget to add $this->addBasicMetatagRequirements() to Page_Controller->init();
// and add this to your Page.ss template file: $ExtendedMetatags
//MUST SET ...
Object::add_extension('SiteConfig', 'MetaTagSiteConfigExtension');
Object::add_extension('SiteTree', 'MetaTagAutomation');
Object::add_extension('ContentController', 'MetaTagAutomation_controller');
//MAY SET ...
/* pop-ups and form interaction */
//MetaTagAutomation::set_disable_update_popup(false);
//MetaTagAutomation::set_meta_data_coding("your name goes here");
//MetaTagAutomation::set_meta_data_design("your designer's name goes here");
/* meta descriptions */
//MetaTagAutomation::set_meta_desc_length(24);
/* meta keywords */
//MetaTagAutomation::set_hide_keywords_altogether(true);
//FONTS - see google fonts for options, include within CSS file as: body {font-family: Inconsolata;}
//MetaTagAutomation::add_google_font("Voces");
//MetaTagAutomation::add_google_font("Quattrocento+Sans" );
/* combined files */
MetaTagAutomation_controller::set_folder_for_combined_files("cache");
MetaTagAutomation_controller::set_combine_css_files_into_one(true);
MetaTagAutomation_controller::set_combine_js_files_into_one(true);
/* favicons */
//MetaTagAutomation::set_use_themed_favicon(true);
//===================---------------- END metatags MODULE ----------------===================



//===================---------------- START payment MODULE ----------------===================
Payment::set_site_currency("EUR");
Currency::setCurrencySymbol("€");
Payment::set_supported_methods(array(
	'DirectCreditPayment_TESTSUCCESS' => 'Test Successful Payment',
	'DirectCreditPayment_TESTFAILURE' => 'Test Failed Payment',
	'InStorePayment' => 'Pay in Store on Pick-Up',
));
//===================---------------- END payment MODULE ----------------===================







// __________________________________ START ECOMMERCE PRODUCT VARIATIONS MODULE CONFIG __________________________________
//MAY SET
//ProductWithVariationDecorator_Controller::set_use_js_validation(false);
//ProductWithVariationDecorator_Controller::set_alternative_validator_class_name("MyValidatorClass");
// __________________________________ END ECOMMERCE PRODUCT VARIATIONS MODULE CONFIG __________________________________



// __________________________________ START ECOMMERCE PRODUCT VARIATIONS COLOUR MODULE CONFIG __________________________________
//MUST SET
Object::add_extension("ProductAttributeValue", "ProductAttributeDecoratorColour_Value");
Object::add_extension("ProductAttributeType", "ProductAttributeDecoratorColour_Type");
//MAY SET
ProductAttributeDecoratorColour_Value::set_default_contrast_colour("FFFFFF");
ProductAttributeDecoratorColour_Value::set_default_colour("000000");
ProductAttributeDecoratorColour_Value::set_put_styling_in_dropdown_options(true);
//ColourDropdownField::set_js_location_for_select_styling("ecommerce_product_variation_colours/javascript/ColourDropdownField.js")
//____________EASY SORTING - REQUIRES: http://sunny.svnrepository.com/svn/sunny-side-up-general/dataobjectsorter
Object::add_extension('ProductAttributeValue', 'DataObjectSorterDOD');
Object::add_extension('ProductAttributeType', 'DataObjectSorterDOD');
// __________________________________ END ECOMMERCE PRODUCT VARIATIONS COLOUR MODULE CONFIG __________________________________








//===================---------------- START ecommerce_Repeatorders MODULE ----------------===================
//Object::add_extension('Order', 'AutomaticallyCreatedOrderDecorator');
//RepeatOrder::set_delivery_days(array('Tuesday','Wednesday','Thursday','Friday'));
//RepeatOrder::set_payment_methods(array(
	//'DirectCreditPayment'  => 'Direct Credit (payment into bank account)',
	//'DpsPxPayStoredPayment'  => 'Saved Credit Card using DPS'
//));
//RepeatOrder::set_minimum_days_in_the_future(3);
//===================---------------- END ecommerce_Repeatorders MODULE ----------------===================





//===================---------------- START ecommerce_delivery MODULE ----------------===================
//NOTE: add http://svn.gpmd.net/svn/open/multiselectfield/tags/0.2/ for nicer interface
//===================---------------- END ecommerce_delivery  MODULE ----------------===================



//===================---------------- START ecommerce_tax MODULE ----------------===================
// *** GST TAX MODIFIER
//MUST SET
//MAY SET
Object::add_extension('Product', 'GSTTaxDecorator');
//Object::add_extension('ProductVariation', 'GSTTaxDecorator');
//GSTTaxModifier::set_exclusive_explanation(" (to be added to prices above)");
//GSTTaxModifier::set_inclusive_explanation(" (included in prices above)");
//GSTTaxModifier::set_based_on_country_note(" - based on a sale to: ");
//GSTTaxModifier::set_no_tax_description("tax-exempt");
//GSTTaxModifier::set_refund_title("Tax Exemption");
//GSTTaxModifier::set_order_item_function_for_tax_exclusive_portion("PortionWithoutTax");
//EcommerceRole::set_fixed_country_code("NZ");
//GSTTaxModifier::set_default_country_code("NZ"); AND / OR //Geoip::$default_country_code = "NZ";
//===================---------------- END ecommerce_tax MODULE ----------------===================


//===================---------------- START ecommerce_product_tag MODULE ----------------===================
Object::add_extension("Product","EcommerceProductTagProductDecorator");
//ProductsAndGroupsModelAdmin::add_managed_model("EcommerceProductTag");
//===================---------------- END ecommerce_product_tag MODULE ----------------===================


//===================---------------- START ecommerce_alsorecommended MODULE ----------------===================
Object::add_extension('Product', 'EcommerceAlsoRecommendedDOD');
//===================---------------- END ecommerce_alsorecommended MODULE ----------------===================

//===================---------------- START ecommerce_dimensions MODULE ----------------===================
Object::add_extension("Product","EcommerceDimensionsDecorator");
//===================---------------- END ecommerce_dimensions MODULE ----------------===================


//===================---------------- START ecommerc_stockcontrol MODULE ----------------===================
//SET BUYABLES
Object::add_extension('Product', 'BuyableStockDecorator');
BuyableStockDecorator::add_buyable("Product");
Object::add_extension('ProductVariation', 'BuyableStockDecorator');
BuyableStockDecorator::add_buyable("ProductVariation");

//HIGHLY RECOMMENDED
MinMaxModifier::set_use_stock_quantities(true); //make use of the stock quantity tables to keep track of them
//ProductsAndGroupsModelAdmin::add_managed_model("BuyableStockManualUpdate");
//ProductsAndGroupsModelAdmin::add_managed_model("BuyableStockOrderEntry");


//MAY SET
//MinMaxModifier::set_default_min_quantity(1);
//MinMaxModifier::set_default_max_quantity(99);
//MinMaxModifier::set_min_field("MinQuantity");
//MinMaxModifier::set_max_field("MaxQuantity");
//MinMaxModifier::set_adjustment_message("Based on stock availability, quantities have been adjusted as follows: ");
//MinMaxModifier::set_sorry_message("Sorry, your selected value not is available");
//===================---------------- END ecommerc_stockcontrol MODULE ----------------===================


//===================---------------- START ecommerce_quick_add MODULE ----------------===================
//===================---------------- END ecommerce_quick_add MODULE ----------------===================


//===================---------------- START ecommerce_group_pricing MODULE ----------------===================
//MUST SET - WHERE APPLICABLE
DataObject::add_extension("Product", "ComplexPriceBuyableDecorator");
DataObject::add_extension("ProductVariation", "ComplexPriceBuyableDecorator");
DataObject::add_extension("ComplexPriceObject", "ComplexPriceBuyableDecorator_ComplexPriceObject");
//===================---------------- END ecommerce_group_pricing MODULE ----------------===================


//===================---------------- START googleAnalyticsbasics MODULE ----------------===================
DataObject::add_extension('SiteTree', 'GoogleAnalytics');
GoogleAnalytics::$googleAnalyticsCode = "UA-26108878-1"; //e.g. UA-xxxx-y
//===================---------------- END googleAnalyticsbasics MODULE ----------------===================



//===================---------------- START ecommerce_discount_coupon MODULE ----------------===================
//StoreAdmin::add_managed_model("DiscountCouponOption");
//DiscountCouponOptions::set_coupons_can_only_be_used_once(true);
//===================---------------- END ecommerce_discount_coupon MODULE ----------------===================


$theme = Session::get("theme");
if(!$theme) {
	$theme = "main";
}
SSViewer::set_theme($theme);
