{script src="js/addons/installment/contract-create.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">
{*{fn_print_die()}*}
{assign var=language_symbol value=$currencies[$smarty.const.CART_PRIMARY_CURRENCY].symbol}

<input type="hidden" value="{$total_price}" id="price">
<input type="hidden" value="1" id="quantity">
<input type="hidden" value="Fantomas" id="name_product">
<input type="hidden" value="{$company['p_c_token']}" id="seller_token">
<input type="hidden" value="{$company['p_c_id']}" id="seller_id">
<input type="hidden" value="{$user['p_user_id']}" id="user_id">
<input type="hidden" value="{$api_base_url}" class="api_base_url">

<div class="contract-create-page container">
    <section class="back-button">
        {if isset($redirect_url)}
            <a href="{$redirect_url|fn_url}">
                <img width="32" src="/design/themes/abt__unitheme2/media/images/addons/installment/Vector.svg"
                     alt="Arrow image">
            </a>
        {else}
            <a href="/">
                <img width="32" src="/design/themes/abt__unitheme2/media/images/addons/installment/Vector.svg"
                     alt="Arrow image">
            </a>
        {/if}
    </section>

    <section class="buyer-header row ty-m-none">
        <div class="span5 info">
            <img class="main-profile__img"
                 width="80"
                 src="/design/themes/responsive/media/images/user.png"
                 alt="Profile image">
            <div class="main-profile__text">
                <span class="main-profile__text-item">{$user['firstname']}  {$user['lastname']}</span>
                <span class="main-profile__text-second">{__('customer_phone')}: {$user['phone']}</span>
                <input id="phone_input" type="hidden" value="{$user['phone']}">
            </div>
        </div>
        <div class="span5 installment-limit">
            <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                 alt="Billing icon"
                 width="40"
            >
            <div class="text">
                <div class="title">{__('avialable_installment')}:</div>
                <div class="price">{$user['i_limit']|number_format:false:false:' '} {$language_symbol}</div>
            </div>
        </div>
        <div class="span6 ty-right status">
            <span>Верифицирован</span>
        </div>
    </section>

    <hr class="ty-mtb-s">

    <section class="products">
        <h3>{__('abt__ut2.export.actions.products')}</h3>

        <div class="table-responsive-wrapper">
            <table class="products-table table table-middle table-responsive">
                <thead>
                <tr>
                    <th>{__('name')}</th>
                    <th>{__('promotion_op_amount')|capitalize}</th>
                    <th>{__('ab__stickers.conditions.names.price')}</th>
                    <th>{__('total_nds')}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $products as $product }
                    <tr>
                        <td>{$product['name']}</td>
                        <td>{$product['amount']}</td>
                        <td>{($product['price'])|number_format:false:false:' '}</td>
                        <td>{($product['total_price'])|number_format:false:false:' '}</td>
                    </tr>
                {/foreach}
                </tbody>
                <tfoot>
                <tr>
                    <td class="orange" colspan="1">{__('total')}</td>
                    <td class="orange">{$total_products|number_format:false:false:' ' }</td>
                    <td class="orange"></td>
                    <td class="orange">{$total_price|number_format:false:false:' ' }</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="calculate-price">
        <h3>{__('cost_calculation')}</h3>

        <div class="row ty-m-none">
            <p for="ccars">{__('choose_period')}:</p>
            <div class="span5 ty-m-none">
                <div class="input-paying">
                    <select name="selectName" id="selectedId">
                        {foreach $periods as $period => $item}
                            <option value="{$period}" {$item['selected']}>{$item['name']}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="span5 monthly-payment">
                <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                     alt="Billing ico">
                <div class="text">
                    <div class="title">{__('monthly_payment')}:</div>
                    <div class="price-month">
                        <span>{$calculator->month|number_format:false:false:' '}</span>
                        {$currencies[$smarty.const.CART_PRIMARY_CURRENCY].symbol}
                    </div>
                </div>
            </div>
            <div class="span5 total-price">
                <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                     alt="Billing ico">
                <div class="text">
                    <div class="title">{__('total_with_markup')}:</div>
                    <div class="price">
                        <span>{$calculator->total|number_format:false:false:' '}</span>
                        {$currencies[$smarty.const.CART_PRIMARY_CURRENCY].symbol}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shipping-address">
        <h3>{__('address')}</h3>

        <div class="ty-tabs clearfix">
            <ul class="ty-tabs__list">
                <li id="self-call" class="address-tab-item ty-tabs__item active">
                    <a class="ty-tabs__a">{__('shipping')}</a>
                </li>
                <li id="shipping" class="address-tab-item ty-tabs__item">
                    <a class="ty-tabs__a">{__('pickup')}</a>
                </li>
            </ul>
        </div>

        <div class="self-call-tab-content d-none">
            <div style="display: flex; align-items: center;">
                <div>
                    <svg width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12.0001 12.7155C10.9572 12.7155 10.1083 11.8619 10.1083 10.8134C10.1083 9.76482 10.9572 8.91122 12.0001 8.91122C13.043 8.91122 13.892 9.76482 13.892 10.8134C13.892 11.8619 13.043 12.7155 12.0001 12.7155ZM11.9998 7.96022C10.4359 7.96022 9.16208 9.24021 9.16208 10.8135C9.16208 12.3867 10.4359 13.6667 11.9998 13.6667C13.5638 13.6667 14.8376 12.3867 14.8376 10.8135C14.8376 9.24021 13.5638 7.96022 11.9998 7.96022ZM16.2833 15.3446L11.9998 19.6514L7.71638 15.3446C5.35474 12.9701 5.35474 9.10635 7.71638 6.73182C8.89721 5.54377 10.4477 4.95014 11.9998 4.95014C13.5511 4.95014 15.1024 5.54456 16.2833 6.73182C18.6449 9.10635 18.6449 12.9701 16.2833 15.3446ZM16.9527 6.05902C14.2213 3.31358 9.77867 3.31358 7.04732 6.05902C4.31756 8.80447 4.31756 13.2722 7.04732 16.0176L11.6658 20.6604C11.758 20.754 11.8794 20.7999 12 20.7999C12.1206 20.7999 12.242 20.754 12.3342 20.6604L16.9527 16.0176C19.6824 13.2722 19.6824 8.80447 16.9527 6.05902Z"
                              fill="#FF7643"/>
                    </svg>
                </div>
                <div>
                    <h3 class="ty-m-none">{$company['full_address']}</h3>
                    {*                    <p>{__('company_phone')}: +{$company_phone}</p>*}
                </div>
            </div>
        </div>

        <div class="shipping-tab-content">
            <div class="row ty-m-none">
                <div class="span5">
                    <p for="inputAddress">{__('country')}</p>
                    <input class="repeat-input" type="text" id="inputAddress" disabled value="Узбекистан">
                </div>
                <div class="span5">
                    <p for="formAddress2">{__('city')}</p>
                    <div class="input-paying__unique">
                        <select name="formAddress2" id="formAddress2">
                            {foreach $city as $key => $value}
                                {if $value['city_id'] == 228171787}
                                    <option selected value="{$value['city_id']}">{$value['city_name']}</option>
                                {else }
                                    <option value="{$value['city_id']}">{$value['city_name']}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="span5">
                    <p for="formAddress3">{__('district')}</p>
                    <div class="input-paying__unique">
                        <select name="formAddress3" id="formAddress3" class="tashkent-regions d-none">
                        </select>
                        <input type="text" placeholder="{__('district')}" class="not-tashkent-region">
                    </div>
                </div>
            </div>
            <div class="row ty-m-none">
                <div class="span5">
                    <p for="story">{__('apartment')} </p>
                    <input id="story" type="text">
                </div>
                <div class="span5">
                    <p for="story2">{__('house')}</p>
                    <input id="story2" type="text">
                </div>
                <div class="span5">
                    <p for="story3">{__('street')}</p>
                    <input id="story3" type="text">
                </div>
            </div>
        </div>
    </section>

    <section class="ty-center ty-mt-m">
        <button id="myBtn" class="form-button__item ty-btn ty-btn__primary" type="submit" form="form1">
            {__('apply_for_an_installment')}
        </button>
    </section>

    {if ($notifier)}
        <!-- Balance not enough to buy Modal -->
        <div id="myModal5" class="modal5">
            <div class="modal-content5">
                <div class="modal-content5__item">
                    <img src="/design/themes/abt__unitheme2/media/images/addons/installment/cancel.png" alt="">
                    <h1 class="ty-mt-m">{__('text_customer_support')}</h1>
                    <h3 class="modal-content5__item">{$settings.Company.company_phone}</h3>
                </div>
                <a href="{$redirect_url|fn_url}" class="ty-btn ty-btn__secondary">
                    {__('abt__ut2.light_menu.back_to_main')}
                </a>
            </div>
        </div>
    {/if}
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">
            <img src="/design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
        </span>
        <div class="card-add__page">
            <div class="card-confirm">
                <h1>{__('authentication.title_sms_code')}</h1>

                <p>{__('authentication.sent_phone', ['[n]' => $user['phone']])}</p>

                <div class="ty-control-group">
                    <input type="tel" hidden class="ty-login__input confirm-contract"/>
                </div>
                <div id="card-pin-wrapper"></div>

                <p class="resend-sms-card">
                    {__('authentication.text_resend_sms', ['[n]' => '<span class="card-resend-sms-timer">60</span>'])}
                </p>

                <span class="modal-error"></span>

                <div class="resend-sms-card__ok" style="display: none;">{__('vendor_communication.send_message')}</div>

                <button disabled class="ty-btn ty-btn__secondary" type="button" id="modal-sent">
                    {__('continue')}
                </button>
            </div>
        </div>
    </div>
</div>

{*the second modal*}

<div id="myModal1" class="modal1" style="display: none;">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">
            <img src="/design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
        </span>
        <div class="card-add__page">
            <div class="card-confirm">

            </div>
        </div>
    </div>
</div>

<script>
    $('#card-pin-wrapper').pinlogin({
        placeholder: '*',
        hideinput: false,
        fields: 4,
        reset: false,
        disable: true,
        focus: false,
        autofocus: false,
        complete: function (pin) {
            $('.confirm-contract').attr('value', pin);
            $('#modal-sent').removeAttr('disabled');
            $('#modal-sent').click();
            $('.pinlogin-field').attr('disable');
        },
    });
</script>