<?php 
/*
* minicskeleton - a module template for Prestashop v1.5+
* Copyright (C) 2013 S.C. Minic Studio S.R.L.
* 
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('_PS_VERSION_'))
  exit;
 
class MinicCookie extends Module
{
	// DB file
	const INSTALL_SQL_FILE = 'install.sql';

	// Paths
	private $module_path;
	private $admin_tpl_path;
	private $front_tpl_path;
	private $hooks_tpl_path;

	// Response
	private $response = array(
		'message' => false,
		'type' => 'conf',
		'open' => false
	);	

	public function __construct()
	{
		$this->name = 'miniccookie';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'minic studio';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
		// $this->dependencies = array('blockcart');

		parent::__construct();

		$this->displayName = $this->l('Minic Cookie');
		$this->description = $this->l('A simple module to show the European Union cookie law.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		// Paths
		$this->module_path 		= _PS_MODULE_DIR_.$this->name.'/';
		$this->admin_tpl_path 	= _PS_MODULE_DIR_.$this->name.'/views/templates/admin/';
		$this->front_tpl_path	= _PS_MODULE_DIR_.$this->name.'/views/templates/front/';
		$this->hooks_tpl_path	= _PS_MODULE_DIR_.$this->name.'/views/templates/hooks/';
		
	}

	/**
 	 * install
	 */
	public function install()
	{
		// Create DB tables - uncomment below to use the install.sql for database manipulation
		/*
		if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
			return false;
		else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
			return false;
		$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
		// Insert default template data
		$sql = str_replace('THE_FIRST_DEFAULT', serialize(array('width' => 1, 'height' => 1)), $sql);
		$sql = str_replace('FLY_IN_DEFAULT', serialize(array('width' => 1, 'height' => 1)), $sql);
		$sql = preg_split("/;\s*[\r\n]+/", trim($sql));

		foreach ($sql as $query)
			if (!Db::getInstance()->execute(trim($query)))
				return false;
		*/

		$text = array();
		foreach (Language::getLanguages(false) as $key => $lang) {
			$text[$lang['id_lang']] = '<p>'.$this->l('<h3>We are using cookies to give you the best experience on our site. Cookies are files stored in your browser and are used by most websites to help personalise your web experience.</h3>
<h4>By continuing to use our website, you are agreeing to our use of cookies.</h4>').'</p>';
		}

		$settings = array(
			'autohide' => 1,
			'always' => 0,
			'time' => 15,
			'link' => 0,
			'bg_color' => 'rgb(255,255,255)',
		);

		if (!parent::install() || 
			!$this->registerHook('displayFooter') || 
			!$this->registerHook('displayHeader') || 
			!$this->registerHook('displayBackOfficeHeader') || 
			!$this->registerHook('displayAdminHomeQuickLinks') || 
			!Configuration::updateValue(strtoupper($this->name).'_START', 1) || 
			!Configuration::updateValue(strtoupper($this->name).'_TEXT', $text, true) ||
			!Configuration::updateValue(strtoupper($this->name).'_SETTINGS', serialize($settings)))
			return false;
		return true;
	}

	/**
 	 * uninstall
	 */
	public function uninstall()
	{
		if (!parent::uninstall() || 
			!Configuration::deleteByName(strtoupper($this->name).'_START') || 
			!Configuration::deleteByName(strtoupper($this->name).'_TEXT') || 
			!Configuration::deleteByName(strtoupper($this->name).'_SETTINGS'))
			return false;
		return true;
	}

	/**
 	 * admin page
	 */	
	public function getContent()
	{
		if(Tools::isSubmit('submitSettings'))
			$this->updateSettings();

		// Smarty for admin
		$conf = Configuration::getMultiple(array(strtoupper($this->name).'_START', 'PS_SHOP_NAME', 'PS_SHOP_DOMAIN', 'PS_SHOP_EMAIL'));
		$languages = Language::getLanguages(false);

		$text = array();
		foreach (Language::getLanguages(false) as $key => $lang) {
			$text[$lang['id_lang']] = Configuration::get(strtoupper($this->name).'_TEXT', $lang['id_lang']);
		}

		$this->smarty->assign('minic', array(
			'first_start' 	 => $conf[strtoupper($this->name).'_START'],

			'admin_tpl_path' => $this->admin_tpl_path,
			'front_tpl_path' => $this->front_tpl_path,
			'hooks_tpl_path' => $this->hooks_tpl_path,

			'post_action' => 'index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&tab_module='. $this->tab .'&module_name='.$this->name,

			'info' => array(
				'module'	=> $this->name,
            	'name'      => $conf['PS_SHOP_NAME'],
        		'domain'    => $conf['PS_SHOP_DOMAIN'],
        		'email'     => $conf['PS_SHOP_EMAIL'],
        		'version'   => $this->version,
            	'psVersion' => _PS_VERSION_,
        		'server'    => $_SERVER['SERVER_SOFTWARE'],
        		'php'       => phpversion(),
        		'mysql' 	=> Db::getInstance()->getVersion(),
        		'theme' 	=> _THEME_NAME_,
        		'userInfo'  => $_SERVER['HTTP_USER_AGENT'],
        		'today' 	=> date('Y-m-d'),
        		'module'	=> $this->name,
        		'context'	=> (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') == 0) ? 1 : ($this->context->shop->getTotalShops() != 1) ? $this->context->shop->getContext() : 1,
			),

			'flags' => array(
				'text' => $this->displayFlags($languages, $this->context->language->id, 'text', 'text', true),
			),
			'lang_active' => $this->context->language->id,

			'langs' => $languages,
			'lang_iso' => $this->context->language->iso_code, 
			'css_dir' => _THEME_CSS_DIR_,
            'ad' => dirname($_SERVER["PHP_SELF"]),
            'base_uri' => __PS_BASE_URI__,

            'text' => $text,
            'settings' => unserialize(Configuration::get(strtoupper($this->name).'_SETTINGS'))
		));
	
		// Change first start
		if($conf[strtoupper($this->name).'_START'] == 1)
			Configuration::updateValue(strtoupper($this->name).'_START', 0);

		$this->smarty->assign('response', $this->response);

		return $this->display(__FILE__, 'views/templates/admin/miniccookie.tpl');
	}

	public function updateSettings()
	{
		$settings = array(
			'autohide' => (int)Tools::getValue('autohide'),
			'always' => (int)Tools::getValue('always'),
			'time' => (int)Tools::getValue('time'),
			'link' => (Validate::isUrl(Tools::getValue('link'))) ? Tools::getValue('link') : 0,
			'bg_color' => Tools::getValue('bg_color')
		);

		$text = Tools::getValue('text');
		$texts = array();
		foreach (Language::getLanguages(false) as $key => $lang) {
			$texts[$lang['id_lang']] = $text[$lang['id_lang']];
		}

		Configuration::updateValue(strtoupper($this->name).'_SETTINGS', serialize($settings));
		Configuration::updateValue(strtoupper($this->name).'_TEXT', $texts, true);

		$this->setResponse($this->l('Updated successfull.'));
	}

	/**
	 * Configure response message
	 *
	 * @param $message string - optional - the message to show
	 * @param $type string - optional - the type of the message (conf, error, warn)
	 * @param $open string - optional - which minic container to show, (#sample)
	 */
	public function setResponse($message = false, $type = 'conf', $open = false)
	{
		$this->response = array(
			'message' => $message,
			'type' => $type,
			'open' => $open
		);
	}

	// BACK OFFICE HOOKS

	/**
 	 * admin <head> Hook
	 */
	public function hookDisplayBackOfficeHeader()
	{
		// Check if module is loaded
		if (Tools::getValue('configure') != $this->name)
			return false;

		// CSS
		$this->context->controller->addCSS($this->_path.'views/css/elusive-icons/elusive-webfont.css');
		$this->context->controller->addCSS($this->_path.'views/css/custom.css');
		$this->context->controller->addCSS($this->_path.'views/css/admin.css');
		// JS
		$this->context->controller->addJquery();
		$this->context->controller->addJqueryPlugin('colorpicker');
		$this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js');
		$this->context->controller->addJS(__PS_BASE_URI__.'js/tinymce.inc.js');
		$this->context->controller->addJS($this->_path.'views/js/admin.js');
	}

	/**
	 * Hook for back office dashboard
	 */
	public function hookDisplayAdminHomeQuickLinks()
	{	
		$this->context->smarty->assign('miniccookie', $this->name);
	    return $this->display(__FILE__, 'views/templates/hooks/quick_links.tpl');    
	}

	// FRONT OFFICE HOOKS

	/**
 	 * <head> Hook
	 */
	public function hookDisplayHeader()
	{
		// CSS
		$this->context->controller->addCSS($this->_path.'views/css/'.$this->name.'.css');
		// JS
		$this->context->controller->addJS($this->_path.'views/js/'.$this->name.'.js');
	}

	/**
 	 * Footer hook
	 */
	public function hookDisplayFooter($params)
	{		
		$settings = unserialize(Configuration::get(strtoupper($this->name).'_SETTINGS'));

		if(!isset($_COOKIE['miniccookie']) || $settings['always'] == 1){
			$this->context->smarty->assign('miniccookie', array(
				'settings' => unserialize(Configuration::get(strtoupper($this->name).'_SETTINGS')),
				'text' => Configuration::get(strtoupper($this->name).'_TEXT', $this->context->language->id)
			));
		}

		setcookie('miniccookie', 1, time()+60*60*24*356);

		return $this->display(__FILE__, 'views/templates/hooks/home.tpl');
	}
}

?>