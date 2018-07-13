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

 
{if $smartlook_code|escape:'htmlall':'UTF-8' eq true}
<script type="text/javascript">
    {$smartlook_code}{if $smartlook_variables_enabled|escape:'htmlall':'UTF-8' eq true && $smartlook_variables_js|escape:'quotes':'UTF-8'}{$smartlook_variables_js}{/if}
</script>
{/if}