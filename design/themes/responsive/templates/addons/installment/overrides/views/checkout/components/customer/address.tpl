{script src="js/addons/installment/adress.js"}

{$element_identifier = "address-group"}
{$group_meta = "hidden"}

{if $show_profiles_on_checkout}
    {$element_identifier = "user-profiles"}
    {$group_meta = ""}
{/if}
{*{fn_print_die($cities)}*}

<div class="{$group_meta} litecheckout__group" data-ca-lite-checkout-element="{$element_identifier}"
     data-ca-address-position="{$settings.Checkout.address_position}">
    {if $show_profiles_on_checkout}
        {include file="views/checkout/components/user_profiles.tpl"}
    {else}
        <div class="alert alert-info delivery-date-container" style="padding: 10px 16px;" role="alert">
            <span>{__('approximate_delivery_days')}</span>
            <span class="delivery-date__days"></span>
        </div>

        <div class="row-fluid" style="padding: 0 4px">
            <div class="span6">
                <input type="text" disabled value="Узбекистан" style="width: 100%;">
            </div>
            <div class="span5">
                <select
                        class="cm-country cm-location-shipping"
                        style="width: 100%"
                        name="user_data[region]"
                        id="formAddress__select"
                >
                    {foreach $cities as $value}
                        <option value="{$value['id']}" data-delivery-days="{$value['days']}">{$value['city_name']|capitalize}</option>
                    {/foreach}
                </select>
            </div>
            <div class="span5">
                <select name="user_data[distract]" id="formAddress5" class="city-regions" style="width: 100%;"></select>
            </div>
        </div>
        <div class="row-fluid" style="padding: 8px 4px 0 4px">
            <div class="span6">
                <input name="user_data[street]" type="text" style="width: 100%" placeholder="Улица">
            </div>
            <div class="span5">
                <input name="user_data[home]" type="text" style="width: 100%" placeholder="Дом">
            </div>
            <div class="span5">
                <input name="user_data[apartment]" type="text" style="width: 100%" placeholder="Квартира">
            </div>
        </div>
    {/if}
</div>
