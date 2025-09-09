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
<div class="card mt-2 packetery panel" id="packetaPickupPointChange">
    <div class="card-header">
        <h3 class="card-header-title">
            <i class="icon-dropbox"></i> {l s='Packeta' d='Modules.Packetery.Display_order_main'}
        </h3>
    </div>
    <div class="card-body">
        {if isset($packetStatusTranslatedCode)}
            <p>
                <span class="packetery-order-status {$statusCssClass}">{$packetStatusTranslatedCode}</span>
            </p>
        {/if}

        {if isset($logLink)}
            <a href="{$logLink}">{l s='Show log' d='Modules.Packetery.Display_order_main'}</a>
        {/if}

        <form action="{$returnUrl}" method="post">
            {if $isAddressDelivery}
                <p>
                    {l s='Carrier' d='Modules.Packetery.Display_order_main'}:
                    <strong class="picked-delivery-place" data-validated="{$isAddressValidated}">
                        {if $pickupPointOrAddressDeliveryName}
                            {$pickupPointOrAddressDeliveryName}
                        {else}
                            {l s='Please select shipment method again' d='Modules.Packetery.Display_order_main'}
                        {/if}
                    </strong>
                </p>
                {if $isAddressValidated && isset($validatedAddress)}
                    <p class="validatedAddress">
                        {l s='Delivery address verified for order' d='Modules.Packetery.Display_order_main'}:<br>
                        {l s='Street' d='Modules.Packetery.Display_order_main'}: <strong class="packetery-street">{$validatedAddress['street']} {$validatedAddress['houseNumber']}</strong><br>
                        {l s='City' d='Modules.Packetery.Display_order_main'}: <strong class="packetery-city">{$validatedAddress['city']}</strong><br>
                        {l s='Zip' d='Modules.Packetery.Display_order_main'}: <strong class="packetery-zip">{$validatedAddress['zip']}</strong><br>
                        {l s='County' d='Modules.Packetery.Display_order_main'}: <strong class="packetery-county">{$validatedAddress['county']}</strong><br>
                        {l s='GPS' d='Modules.Packetery.Display_order_main'}: <strong class="packetery-gps">{$validatedAddress['latitude']}, {$validatedAddress['longitude']}</strong><br>
                    </p>
                {/if}
                {if isset($widgetOptions) && !$isExported}
                    <p>
                        <a href="" class="btn btn-outline-secondary btn-default open-packeta-hd-widget"
                           data-widget-options="{$widgetOptions|json_encode}">
                            {if isset($validatedAddress) && $validatedAddress['zip']}
                                {l s='Change validated delivery address' d='Modules.Packetery.Display_order_main'}
                            {else}
                                {l s='Set validated delivery address' d='Modules.Packetery.Display_order_main'}
                            {/if}
                        </a>

                        <input type="hidden" name="order_id" value="{$orderId|intval}">
                        <input type="hidden" name="address">
                    </p>
                {/if}
            {else}
                <p>{l s='Pickup point' d='Modules.Packetery.Display_order_main'}:
                    <strong class="picked-delivery-place">
                        {if $pickupPointOrAddressDeliveryName}
                            {$pickupPointOrAddressDeliveryName}
                        {else}
                            {l s='Please select pickup point' d='Modules.Packetery.Display_order_main'}
                        {/if}
                    </strong>
                </p>
                {if $pickupPointChangeAllowed && !$isExported}
                    <p>
                        <a href="" class="btn btn-outline-secondary btn-default open-packeta-widget"
                           data-widget-options="{$widgetOptions|json_encode}">{l s='Change pickup point' d='Modules.Packetery.Display_order_main'}</a>
                        <input type="hidden" name="order_id" value="{$orderId|intval}">
                        <input type="hidden" name="pickup_point">
                    </p>
                {/if}
            {/if}

            {if !$isExported}
                <div class="mt-4">
                    <div class="form-row align-items-center">
                        <div class="col-sm-2 col-12 my-1">
                            <label for="weight">{l s='Weight' d='Modules.Packetery.Display_order_main'}:</label>
                        </div>
                        <div class="col-sm-2 my-1">
                            <div class="input-group">
                                <input
                                        type="text"
                                        name="weight"
                                        id="weight"
                                        class="form-control"
                                        value="{$orderWeight}"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {if $carrierRequiresSize === true}
                    <div class="mt-1">
                        <div class="form-row align-items-center">
                            <div class="col-sm-2 col-12 my-1">
                                <label>{l s='Size (L x W x H):' d='Modules.Packetery.Display_order_main'}</label>
                            </div>
                            <div class="col-sm-2 my-1">
                                <input class="form-control" name="length" value="{$orderDetails['length']}" placeholder="{l s='Length' d='Modules.Packetery.Display_order_main'}">
                            </div>
                            <div class="col-auto my-1">
                                x
                            </div>
                            <div class="col-sm-2 my-1">
                                <input class="form-control" name="width" value="{$orderDetails['width']}" placeholder="{l s='Width' d='Modules.Packetery.Display_order_main'}">
                            </div>
                            <div class="col-auto my-1">
                                x
                            </div>
                            <div class="col-sm-2 my-1">
                                <input class="form-control" name="height" value="{$orderDetails['height']}" placeholder="{l s='Height' d='Modules.Packetery.Display_order_main'}">
                            </div>
                            <div class="col-auto my-1">
                                (mm)
                            </div>
                        </div>
                    </div>
                {/if}

                {if $showPriceInputs === true}
                    <div class="mt-1">
                        <div class="form-row align-items-center">
                            <div class="col-sm-2 col-12 my-1">
                                <label for="price_total">{l s='Packet value' d='Modules.Packetery.Display_order_main'}:</label>
                            </div>
                            <div class="col-sm-2 my-1">
                                <div class="input-group">
                                    <input
                                            type="text"
                                            name="price_total"
                                            id="price_total"
                                            class="form-control"
                                            value="{$total}"
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{$exportCurrency}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {if $isCod}
                        <div class="mt-1">
                            <div class="form-row align-items-center">
                                <div class="col-sm-2 col-12 my-1">
                                    <label for="price_cod">{l s='COD value' d='Modules.Packetery.Display_order_main'}:</label>
                                </div>
                                <div class="col-sm-2 my-1">
                                    <div class="input-group">
                                        <input
                                                type="text"
                                                name="price_cod"
                                                id="price_cod"
                                                class="form-control"
                                                value="{$cod}"
                                        >
                                        <div class="input-group-append">
                                            <span class="input-group-text">{$exportCurrency}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                {/if}

                {* It is not possible to turn it off for other carriers in case that product for adults is present in the order. *}
                {if $carrierSupportsAgeVerification}
                    <div class="mt-1">
                        <div class="form-row align-items-center">
                            <div class="col-sm-2 col-12 my-1">
                            </div>
                            <div class="col-auto my-1">
                                <div class="checkbox">
                                    <div class="md-checkbox md-checkbox-inline">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    id="age_verification_required"
                                                    name="age_verification_required"
                                                    value="1"
                                                    {if ($ageVerificationRequired === null && $isOrderForAdults) || $ageVerificationRequired === true}checked="checked"{/if}
                                            >
                                            <i class="md-checkbox-control"></i>{l s='Require age verification' d='Modules.Packetery.Display_order_main'}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                <div class="text-right">
                    <button class="btn btn-primary" name="{$submitButton}">{l s='Save' d='Modules.Packetery.Display_order_main'}</button>
                </div>
            {/if}
        </form>

        {* There will be more buttons aka more actions in future. If there is no button hide the divider *}
        {if $showActionButtonsDivider}
            <hr />
        {/if}
        {if $postParcelButtonAllowed}
            <form action="{$returnUrl}" method="post">
                <p>
                    <button class="btn btn-outline-secondary btn-default"
                            type="submit"
                            name="process_post_parcel"
                            id="process_post_parcel"
                    >
                        <i class="material-icons" aria-hidden="true">send</i>
                        {l s='Post parcel' d='Modules.Packetery.Display_order_main'}
                    </button>
                    <input type="hidden" name="order_id" value="{$orderId|intval}">
                </p>
            </form>
        {/if}
        {if isset($messages)}
            {foreach from=$messages item=message}
                {$message_text = nl2br($message.text)}
                <div class="alert alert-{$message.class}">{$message_text}</div>
            {/foreach}
        {/if}
    </div>
</div>
<script type="application/javascript">
    var process_post_parcel_confirmation = "{l s='Do you really wish to post the parcel?' d='Modules.Packetery.Display_order_main'}";
</script>
