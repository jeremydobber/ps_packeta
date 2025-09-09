{**
 * 2017 Zlab Solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Eugene Zubkov <magrabota@gmail.com>, RTsoft s.r.o
 *  @copyright Since 2017 Zlab Solutions
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *}
{*
 This file is inserted before the list of shipping methods:
 * PS 1.6: 5-steps checkout
 * PS 1.6: OPC - twice! order-opc.js inserts this html first along with all carrier html and then again, separately only this html
 * PS 1.7
*}
<script type="text/javascript">
    PacketaModule = window.PacketaModule || { };

    {* json_encode writes PHP array to JS object, nofilter prevents " to be turned to &quot; in PS 1.7  (removed - jdobber) *}
    PacketaModule.config = {$packetaModuleConfig|json_encode};

    if (typeof PacketaModule.runner !== 'undefined') {
        PacketaModule.runner.onBeforeCarrierLoad();
    }
</script>
