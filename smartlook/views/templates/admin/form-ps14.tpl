{*
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
 *}
 
<form enctype="multipart/form-data" method="post" class="defaultForm smartlook" id="configuration_form">
	<fieldset id="fieldset_0">
		<legend>
			{l s='Settings' mod='smartlook'}
		</legend>
		<label>{l s='Smartlook Code' mod='smartlook'}</label>
		<div class="margin-form">
			<input type="text" value="{$smartlook_key|escape:'htmlall':'UTF-8'}" id="SMARTLOOK_KEY" name="SMARTLOOK_KEY">&nbsp;<sup>*</sup>
			<span name="help_box" class="hint" style="display: none;">{l s='This information is available in your Smartlook account' mod='smartlook'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Record visitors' mod='smartlook'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartlook_variables_enabled|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTLOOK_VARIABLES_ENABLED" name="SMARTLOOK_VARIABLES_ENABLED">
			<span name="help_box" class="hint" style="display: none;">{l s='By enabling this option you will be able to see selected variables in your Smartlook dashboard.' mod='smartlook'}<span class="hint-pointer"></span></span>  
		</div>
                <div class="margin-form">
                        <input class="button" type="submit" name="submitsmartlook" value="{l s='Save' mod='smartlook'}" id="configuration_form_submit_btn">
		</div>                
		<div class="small"><sup>*</sup> {l s='Required field' mod='smartlook'}</div>
        </fieldset>
        <br/>
	<fieldset id="fieldset_1">
		<legend>
			{l s='Visitor info' mod='smartlook'}
		</legend>
                <label>{l s='Name' mod='smartlook'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartlook_customer_name|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTLOOK_CUSTOMER_NAME" name="SMARTLOOK_CUSTOMER_NAME">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s display name.' mod='smartlook'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Email' mod='smartlook'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartlook_customer_email|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTLOOK_CUSTOMER_EMAIL" name="SMARTLOOK_CUSTOMER_EMAIL">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s email.' mod='smartlook'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
                <div class="margin-form">
                        <input class="button" type="submit" name="submitsmartlook" value="{l s='Save' mod='smartlook'}" id="configuration_form_submit_btn">
		</div>
	</fieldset>
</form>
