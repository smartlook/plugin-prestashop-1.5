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

<div class="panel">
	<div class="row" id="smartlook_top">
		<div class="col-lg-6">
			<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/smartlook_logo.png" alt="Smartlook" />
		</div>
		<div class="col-lg-6 text-right">
			<span>{l s='Not a Smartlook user yet?' mod='smartlook'}</span>
                        <a class="btn btn-default btn-lg" href="https://www.getsmartlook.com/cs/sign/up/" rel="external">{l s='Create your account to get started.' mod='smartlook'}</a>
		</div>
	</div>
</div>