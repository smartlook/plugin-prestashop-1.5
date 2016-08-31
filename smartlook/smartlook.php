<?php
/**
 * Smartlook integration module.
 * 
 * @package   Smartlook
 * @author    Smartlook <vladimir@smartsupp.com>
 * @link      http://www.smartsupp.com
 * @copyright 2015 Smartsupp.com
 * @license   GPL-2.0+
 *
 * Plugin Name:       Smartlook
 * Plugin URI:        http://www.getsmartlook.com
 * Description:       Adds Smartlook code to PrestaShop.
 * Version:           1.0.0
 * Author:            Smartsupp
 * Author URI:        http://www.smartsupp.com
 * Text Domain:       smartlook
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('_PS_VERSION_'))
	exit;

class Smartlook extends Module
{
	public function __construct()
	{
                $this->name = 'smartlook';
		$this->tab = 'advertising_marketing';
		$this->version = '1.0.0';
		$this->author = 'Smartsupp';
		$this->need_instance = 0;
		//$this->ps_versions_compliancy = array('min' => '1.4', 'max' => _PS_VERSION_); 
		$this->bootstrap = true;
		$this->module_key = '';

		parent::__construct();

		$this->displayName = $this->l('Smartlook');
		$this->description = $this->l('Look at your website through your customer\'s eyes! We will record everything visitors do on your site.');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall Smartlook? You will lose all the data related to this module.');

                if (version_compare(_PS_VERSION_, '1.5', '<'))
			require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');

		if (!Configuration::get('SMARTLOOK_CODE'))      
                        $this->warning = $this->l('No Smartlook code provided.');
        }

	public function install()
	{
		if (version_compare(_PS_VERSION_, '1.5', '>=') && Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (!parent::install() 
                    || !$this->registerHook('header') 
                    //|| !$this->registerHook('footer') 
                    || !$this->registerHook('backOfficeHeader') 
                    || !Configuration::updateValue('SMARTLOOK_CODE', '')
                    || !Configuration::updateValue('SMARTLOOK_VARIABLES_ENABLED', '')
                    || !Configuration::updateValue('SMARTLOOK_CUSTOMER_NAME', '')
                    || !Configuration::updateValue('SMARTLOOK_CUSTOMER_EMAIL', '')
		)
                        return false;
                
		return true;
	}
        
	public function uninstall()
	{
		if (!parent::uninstall() 
                    || !$this->unregisterHook('header') 
                    //|| !$this->unregisterHook('footer') 
                    || !$this->unregisterHook('backOfficeHeader') 
                    || !Configuration::deleteByName('SMARTLOOK_CODE')
                    || !Configuration::deleteByName('SMARTLOOK_VARIABLES_ENABLED', '')
                    || !Configuration::deleteByName('SMARTLOOK_CUSTOMER_NAME', '')
                    || !Configuration::deleteByName('SMARTLOOK_CUSTOMER_EMAIL', '')
		)
			return false;
                
		return true;
	}        

	public function displayForm()
	{
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$helper = new HelperForm();

		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;

		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;
		$helper->toolbar_scroll = true;
		$helper->submit_action = 'submit'.$this->name;
		$helper->toolbar_btn = array(
			'save' =>
				array(
					'desc' => $this->l('Save'),
					'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
					'&token='.Tools::getAdminTokenLite('AdminModules'),
				),
			'back' => array(
				'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
				'desc' => $this->l('Back to list')
			)
		);

		$fields_form = array();
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings'),
			),
			'input' => array(
				array(
					'type' => 'textarea',
					'label' => $this->l('Smartlook code'),
					'name' => 'SMARTLOOK_CODE',
                                        'desc' => $this->l('Smartlook code assigned to your account.'),
					'size' => 20,
					'required' => true,
				),
                                array(
                                        'type' => 'checkbox',
                                        'label' => $this->l('Record visitors'),
                                        'name' => 'SMARTLOOK_VARIABLES',
                                        'desc' => $this->l('By enabling this option you will be able to see selected variables in your Smartlook dashboard.'),
                                        'required' => false,
                                        'values' => array(
                                                'query' => array(
                                                    array('id' => 'ENABLED', 'name' => '', 'val' => '1'),
                                                    ),
                                                'id' => 'id',
                                                'name' => 'name'
                                        )
                                ),
			),
			'submit' => array(
				'title' => $this->l('Save'),
			)
		);                    
		$fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Visitor info'),
			),
			'input' => array(
                                array(
                                        'type' => 'checkbox',
                                        'label' => $this->l('Name'),
                                        'name' => 'SMARTLOOK_CUSTOMER',
                                        'desc' => $this->l('Shows customer\'s display name.'),
                                        'required' => false,
                                        'values' => array(
                                                'query' => array(
                                                    array('id' => 'NAME', 'name' => '', 'val' => '1'),
                                                    ),
                                                'id' => 'id',
                                                'name' => 'name'
                                        )
                                ),
                                array(
                                        'type' => 'checkbox',
                                        'label' => $this->l('Email'),
                                        'name' => 'SMARTLOOK_CUSTOMER',
                                        'desc' => $this->l('Shows customer\'s email.'),
                                        'required' => false,
                                        'values' => array(
                                                'query' => array(
                                                    array('id' => 'EMAIL', 'name' => '', 'val' => '1'),
                                                    ),
                                                'id' => 'id',
                                                'name' => 'name'
                                        )
                                ),
			),
			'submit' => array(
				'title' => $this->l('Save'),
			)
		);

		$helper->fields_value['SMARTLOOK_CODE'] = Configuration::get('SMARTLOOK_CODE');
		$helper->fields_value['SMARTLOOK_VARIABLES_ENABLED'] = Configuration::get('SMARTLOOK_VARIABLES_ENABLED');
		$helper->fields_value['SMARTLOOK_CUSTOMER_NAME'] = Configuration::get('SMARTLOOK_CUSTOMER_NAME');
		$helper->fields_value['SMARTLOOK_CUSTOMER_EMAIL'] = Configuration::get('SMARTLOOK_CUSTOMER_EMAIL');

		return $helper->generateForm($fields_form);
	}

	public function getContent()
	{
		$output = '';
		if (Tools::isSubmit('submit'.$this->name))
		{
			$smartlook_code = Tools::getValue('SMARTLOOK_CODE');
			if (!$smartlook_code || empty($smartlook_code))
			{
				$output .= $this->displayError($this->l('Invalid Smartlook Code'));                            
			}
                        else {
				Configuration::updateValue('SMARTLOOK_CODE', $smartlook_code);
				$output .= $this->displayConfirmation($this->l('Settings updated successfully'));
                        }
                        Configuration::updateValue('SMARTLOOK_VARIABLES_ENABLED', Tools::getValue('SMARTLOOK_VARIABLES_ENABLED'));
                        Configuration::updateValue('SMARTLOOK_CUSTOMER_NAME', Tools::getValue('SMARTLOOK_CUSTOMER_NAME'));
                        Configuration::updateValue('SMARTLOOK_CUSTOMER_EMAIL', Tools::getValue('SMARTLOOK_CUSTOMER_EMAIL'));
		}

		if (version_compare(_PS_VERSION_, '1.5', '>='))
			$output .= $this->displayForm();
		else
		{
			$this->context->smarty->assign(array(
				'smartlook_code' => Configuration::get('SMARTLOOK_CODE'),
				'smartlook_variables_enabled' => Configuration::get('SMARTLOOK_VARIABLES_ENABLED'),
				'smartlook_customer_name' => Configuration::get('SMARTLOOK_CUSTOMER_NAME'),
				'smartlook_customer_email' => Configuration::get('SMARTLOOK_CUSTOMER_EMAIL'),
			));
			$output .= $this->display(__FILE__, 'views/templates/admin/form-ps14.tpl');
		}

		return $this->display(__FILE__, 'views/templates/admin/configuration.tpl').$output;
	}

	public function hookHeader()
	{
                $smartlook_code = Configuration::get('SMARTLOOK_CODE');
                
		if ($smartlook_code)
		{
                    $this->context->smarty->assign('smartlook_code', $smartlook_code);
                    $this->context->smarty->assign('smartlook_cookie_domain', Tools::getHttpHost(true).__PS_BASE_URI__);
                    
                    $customer = $this->context->customer;                    
                    if ($customer->id) {
                            $this->context->smarty->assign('smartlook_dashboard_name', sprintf('"%s %s"', $customer->firstname, $customer->lastname));
                            
                            $variables_enabled = Configuration::get('SMARTLOOK_VARIABLES_ENABLED');
                            $this->context->smarty->assign('smartlook_variables_enabled', $variables_enabled);
                            
                            if ($variables_enabled) {
                                    $smartlook_variables_js = '';
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_NAME')) {
                                            $smartlook_variables_js .= 'smartlook ("tag", "name", "' . $customer->firstname . ' ' . $customer->lastname . '");';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_EMAIL')) {
                                            $smartlook_variables_js .= 'smartlook ("tag", "email", "' . $customer->email . '");';
                                    }
                                    $this->context->smarty->assign('smartlook_variables_js', trim($smartlook_variables_js, ', '));
                            }
                    } else {
                            $this->context->smarty->assign('smartlook_dashboard_name', '""');
                            $this->context->smarty->assign('smartlook_variables_enabled', 0);
                            $this->context->smarty->assign('smartlook_variables_js', '');
                    }                    
                    
                    return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
                }                    
	}

        /*
        public function hookFooter()
	{
                $smartlook_key = Configuration::get('SMARTLOOK_KEY');
                
		if ($smartlook_key)
		{
                    $this->context->smarty->assign('smartlook_key', $smartlook_key);
                    $this->context->smarty->assign('smartlook_cookie_domain', Tools::getHttpHost(true).__PS_BASE_URI__);

                    $optional_api = trim(Configuration::get('SMARTLOOK_OPTIONAL_API'));
                    if ($optional_api && !empty($optional_api)) {
                            $this->context->smarty->assign('optional_api', trim($optional_api));
                    }
                    
                    $customer = $this->context->customer;                    
                    if ($customer->id) {
                            $this->context->smarty->assign('smartlook_dashboard_name', sprintf('"%s %s"', $customer->firstname, $customer->lastname));
                            
                            $variables_enabled = 1; //Configuration::get('SMARTLOOK_VARIABLES_ENABLED');
                            $this->context->smarty->assign('smartlook_variables_enabled', $variables_enabled);
                            
                            if ($variables_enabled) {
                                    $smartlook_variables_js = '';
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_ID')) {
                                            $smartlook_variables_js .= 'id : {label: "' . $this->l('ID') . '", value: "' . $customer->id . '"},';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_NAME')) {
                                            $smartlook_variables_js .= 'name : {label: "' . $this->l('Name') . '", value: "' . $customer->firstname . ' ' . $customer->lastname . '"},';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_EMAIL')) {
                                            $smartlook_variables_js .= 'email : {label: "' . $this->l('Email') . '", value: "' . $customer->email . '"}, ';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_PHONE')) {
                                            $addresses = $this->context->customer->getAddresses($this->context->language->id);
                                            $phone = $addresses[0]['phone_mobile'] ? $addresses[0]['phone_mobile'] : $addresses[0]['phone'];
                                            $smartlook_variables_js .= 'phone : {label: "' . $this->l('Phone') . '", value: "' . $phone . '"}, ';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_ROLE')) {
                                            $group = new Group($customer->id_default_group, $this->context->language->id, $this->context->shop->id);
                                            $smartlook_variables_js .= 'role : {label: "' . $this->l('Role') . '", value: "' . $group->name . '"}, ';
                                    }
                                    if (Configuration::get('SMARTLOOK_CUSTOMER_SPENDINGS') || Configuration::get('SMARTLOOK_CUSTOMER_ORDERS')) {
                                            $orders = Order::getCustomerOrders($customer->id, true);
                                            $count = 0;
                                            $spendings = 0;
                                            foreach ($orders as $order) {
                                                    if ($order['valid']) {
                                                            $count++;
                                                            $spendings += $order['total_paid_real'];
                                                    }
                                            }
                                            if (Configuration::get('SMARTLOOK_CUSTOMER_SPENDINGS')) {
                                                    $smartlook_variables_js .= 'spendings : {label: "' . $this->l('Spendings') . '", value: "' . Tools::displayPrice($spendings, $this->context->currency->id) . '"}, ';
                                            }        
                                            if (Configuration::get('SMARTLOOK_CUSTOMER_ORDERS')) {
                                                    $smartlook_variables_js .= 'orders : {label: "' . $this->l('Orders') . '", value: "' . $count . '"}, ';
                                            }
                                    }
                                    $this->context->smarty->assign('smartlook_variables_js', trim($smartlook_variables_js, ', '));
                            }
                    } else {
                            $this->context->smarty->assign('smartlook_dashboard_name', '""');
                            $this->context->smarty->assign('smartlook_variables_enabled', 0);
                            $this->context->smarty->assign('smartlook_variables_js', '');
                    }                    
                    
                    return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
                }                    
	}
        */

	public function hookBackOfficeHeader()
	{
		$js = '';
		if (strcmp(Tools::getValue('configure'), $this->name) === 0)
		{
			if (version_compare(_PS_VERSION_, '1.5', '>') == true)
			{
				$this->context->controller->addCSS($this->_path.'views/css/smartlook.css');
				if (version_compare(_PS_VERSION_, '1.6', '<') == true)
					$this->context->controller->addCSS($this->_path.'views/css/smartlook-nobootstrap.css');
			}
			else
			{
				$js .= '<link rel="stylesheet" href="'.$this->_path.'views/css/smartlook.css" type="text/css" />'.
                                       '<link rel="stylesheet" href="'.$this->_path.'views/css/smartlook-nobootstrap.css" type="text/css" />';
			}
		}
                return $js;
        }
        
}