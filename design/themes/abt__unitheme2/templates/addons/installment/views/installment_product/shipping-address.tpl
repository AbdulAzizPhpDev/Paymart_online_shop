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
                          fill="#FF7643" />
                </svg>
            </div>
            <div>
                <h3 class="ty-m-none">{$company['full_address']}</h3>
                {*                    <p>{__('company_phone')}: +{$company_phone}</p>*}
            </div>
        </div>
    </div>

    <div class="shipping-tab-content">
        <div class="alert alert-info delivery-date-container" style="padding: 10px 16px;" role="alert">
            <span>{__('approximate_delivery_days')}</span>
            <span class="delivery-date__days"></span>
        </div>

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
                            <option value="{$value['id']}" data-delivery-days="{$value['days']}">{$value['city_name']}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="span5">
                <p for="formAddress3">{__('district')}</p>
                <div class="input-paying__unique">
                    <select name="formAddress3" id="formAddress3" class="tashkent-regions"></select>
                    {*                        <input type="text" placeholder="{__('district')}" class="not-tashkent-region">*}
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