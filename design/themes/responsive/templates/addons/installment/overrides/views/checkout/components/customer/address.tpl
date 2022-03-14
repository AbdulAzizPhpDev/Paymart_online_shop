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
                >
{*                    <option disabled="" selected data-ca-rebuild-states="skip">Город</option>*}
{*                    <option value="uzb">Ташкент</option>*}
{*                    <option value="uzb">Ургенч</option>*}
{*                    <option value="uzb">Фергана</option>*}
{*                    <option value="ru">Нурафшон</option>*}
{*                    <option value="ru">Гулистан</option>*}
{*                    <option value="ru">Термез</option>*}
{*                    <option value="ru">Самарканд</option>*}
{*                    <option value="ru">Наманган</option>*}
{*                    <option value="ru">Навои</option>*}
{*                    <option value="ru">Карши</option>*}
{*                    <option value="ru">Джизак</option>*}
{*                    <option value="ru">Бухара</option>*}
{*                    <option value="ru">Андижан</option>*}
{*                    <option value="kz">Нукус</option>*}
                    {foreach $city as $value}
                        <option selected value="{$value['city_id']}">{$value['city_name']}</option>
                    {/foreach}

                </select>
            </div>
            <div class="span8">
                <input name="user_data[region]" type="text" style="width: 100%" placeholder="Район">
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
