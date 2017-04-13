<?php namespace Dual\Seohelper\Controllers;

use BackendMenu;
use System\Classes\CombineAssets;
use Backend\Classes\Controller;

class Helper extends Controller
{

	public function __construct(){

		parent::__construct();

		$styles = array();
		$styles[0] = '/plugins/dual/seohelper/assets/css/styles.less';
		$this->addCss(CombineAssets::combine($styles, base_path('/')));
	}

	public $pageTitle = 'SEOHelper';

	public $bodyClass = 'plugin-seohelper';

	public function factors(){

		$this->vars['title'] = 'Page Factors';
		BackendMenu::setContext('Dual.Seohelper', 'minifier', 'factors');
	}

	public function hints(){

		$this->vars['title'] = 'Tips & Tricks';
		BackendMenu::setContext('Dual.Seohelper', 'minifier', 'hints');
	}
}