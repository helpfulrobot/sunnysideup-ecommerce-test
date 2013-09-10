<?php

class Page extends SiteTree {

	private static $has_one = array(
		"BackgroundImage" => "Image"
	);

	function MyBackgroundImage() {
		if($this->BackgroundImageID) {
			if($image = $this->BackgroundImage()) {
				return $image;
			}
		}
		if($this->ParentID) {
			if($parent = DataObject::get_by_id("SiteTree", $this->ParentID)) {
				return $parent->MyBackgroundImage();
			}
		}
		if($siteConfig = SiteConfig::current_site_config()) {
			return $siteConfig->BackgroundImage();
		}
	}

}


class Page_Controller extends ContentController {

	private static $allowed_actions = array(
		"settheme"
	);

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */


	public function init() {
		//theme needs to be set TWO times...
		$theme = Session::get("theme"); if(!$theme) {$theme = "main";}SSViewer::set_theme($theme);
		parent::init();
		if($theme == "main") {
			Requirements::themedCSS('reset');
			Requirements::themedCSS('layout');
			Requirements::themedCSS('typography');
			Requirements::themedCSS('form');
			Requirements::themedCSS('menu');

			Requirements::themedCSS('ecommerce');

			Requirements::themedCSS('individualPages');
			Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		}
		if($theme == "simple") {
			Requirements::themedCSS('reset');
			Requirements::themedCSS('layout');
			Requirements::themedCSS('typography');
			Requirements::themedCSS('form');
			Requirements::themedCSS('menu');
			Requirements::themedCSS('ecommerce');
			Requirements::themedCSS('individualPages');
		}
		$theme = Session::get("theme"); if(!$theme) {$theme = "main";}SSViewer::set_theme($theme);
	}

	public function settheme(HTTPRequest $request){
		$newTheme = $request->param("ID");
		Session::set("theme", $newTheme);
		$this->redirect($this->Link());
	}

	function IsNotHome() {
		return $this->URLSegment != "home";
	}

	function Siblings() {
		if($this->ParentID) {
			$extension = "";
			if(Versioned::current_stage() == "Live") {
				$extension = "_Live";
			}
			return DataObject::get("SiteTree", "ShowInMenus = 1 AND ParentID = ".$this->ParentID." AND SiteTree{$extension}.ID <>".$this->ID);
		}
	}

}

