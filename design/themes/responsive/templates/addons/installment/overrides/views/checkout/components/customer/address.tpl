{script src="js/addons/installment/adress.js"}

{$element_identifier = "address-group"}
{$group_meta = "hidden"}

{if $show_profiles_on_checkout}
    {$element_identifier = "user-profiles"}
    {$group_meta = ""}
{/if}

<div class="{$group_meta} litecheckout__group" data-ca-lite-checkout-element="{$element_identifier}"
     data-ca-address-position="{$settings.Checkout.address_position}">
    {if $show_profiles_on_checkout}
        {include file="views/checkout/components/user_profiles.tpl"}
    {else}
        <div class="row-fluid" style="padding: 0 4px">
            <div class="span8">
                <select
                        class="cm-country cm-location-shipping"
                        style="width: 100%"
                        name="user_data[region]"
                        id="formAddress__select"
                >
                    {foreach $cities as $value}
                        <option selected value="{$value['city_id']}">{$value['city_name']}</option>
                    {/foreach}
                </select>
            </div>
            <div class="span8">
                {*                <input name="user_data[region]" id="smth" type="text" style="width: 100%" placeholder="Район">*}

                <select name="user_data[distract]" id="formAddress5" class="tashkent-regions d-none">
                </select>
                <input type="text" placeholder="район" class="not-tashkent-region">
            </div>
        </div>
        <div class="row-fluid" style="padding: 8px 4px 0 4px">
            <div class="span8">
                <input name="user_data[street]" type="text" style="width: 100%" placeholder="Улица">
            </div>
            <div class="span4">
                <input name="user_data[home]" type="text" style="width: 100%" placeholder="Дом">
            </div>
            <div class="span4">
                <input name="user_data[apartment]" type="text" style="width: 100%" placeholder="Квартира">
            </div>
        </div>
    {/if}
</div>
