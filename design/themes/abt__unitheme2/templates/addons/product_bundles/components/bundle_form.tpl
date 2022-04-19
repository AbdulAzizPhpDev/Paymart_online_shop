{$obj_prefix = "pb_`$bundle.bundle_id`"}

{script src="js/addons/product_bundles/installment-bundles.js"}

<form class="cm-ajax cm-ajax-full-render" action="{""|fn_url}" method="post" name="bundle_form_{$bundle.bundle_id}" enctype="multipart/form-data">
    <input type="hidden" name="result_ids" value="cart_status*,wish_list*,checkout*,account_info*">
    <input type="hidden" name="redirect_url" value="{$config.current_url}" />
    <input type="hidden" value="{$bundle.bundle_id}" class="installment-bundle-id">
    {$product_bundle_options_class = "cm-reload-{$obj_prefix}{$bundle.product_id}_{$bundle.bundle_id}"}

    {if $bundle.products}
        {foreach $bundle.products as $_id => $_product}
            {$product_bundle_options_class = "{$product_bundle_options_class} cm-reload-{$obj_prefix}{$_product.product_id}"}
        {/foreach}
    {/if}

    {if $bundle.description && $settings.abt__device == "mobile"}
        <div class="ty-product-bundle__description">
            {$bundle.description nofilter}
        </div>
    {/if}

    <div class="ty-product-bundle clearfix">
        {$target_id_div = "pb_bundle_products_`$key`"}

        <div class="ty-product-bundle__products ty-scroll-x clearfix" id="{$target_id_div}">
            {foreach $bundle.products as $_id => $_product}
                {if $_product.aoc}
                    {$repetition_array = 1|range:$_product.amount}

                    {foreach $repetition_array as $repetition_index}
                        {include file="addons/product_bundles/components/bundle_product.tpl" bundle=$bundle product=$_product amount=1 product_index=$repetition_index}
                    {/foreach}
                {else}
                    {include file="addons/product_bundles/components/bundle_product.tpl" bundle=$bundle product=$_product}
                {/if}
            {/foreach}
        <!--{$target_id_div}--></div>

        {if !(!$auth.user_id && $settings.Checkout.allow_anonymous_shopping == "hide_price_and_add_to_cart")}
            <span class="ty-product-bundle__plus chain-equally"><svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" class="b5d8"><path fill-rule="evenodd" clip-rule="evenodd" d="M21 8a1 1 0 00-1-1H4a1 1 0 000 2h16a1 1 0 001-1zm0 8a1 1 0 00-1-1H4a1 1 0 100 2h16a1 1 0 001-1z" fill="currentColor"></path></svg></span>

            <div class="ty-product-bundle-price {$product_bundle_options_class}" id="pb_total_price_{$obj_prefix}_{$bundle.bundle_id}">
                {if $bundle.total_price != $bundle.discounted_price}
                <div class="ty-product-bundle-price__old">
                    <span class="ty-product-bundle-price__title">{__("product_bundles.total_list_price")}</span>
                    <span class="chain-old-line ty-strike">{include file="common/price.tpl" value=$bundle.total_price}</span>
                </div>
                <div class="ty-checkout-summary__order_discount">
                    <span class="ty-product-bundle-price__title">{__("product_bundles.order_discount")}</span>
                    {include file="common/price.tpl" value=$bundle.total_price - $bundle.discounted_price}
                </div>
                {/if}
                <div class="ty-product-bundle-price__new">
                    <span class="ty-product-bundle-price__title">{__("product_bundles.price_for_all")}</span>
                    {include file="common/price.tpl" value=$bundle.discounted_price}
                    <input type="hidden" value="{$bundle.discounted_price}" class="bundle-discounted-price">
                </div>
                {if !(!$auth.user_id && $settings.Checkout.allow_anonymous_shopping == "hide_add_to_cart_button")}
                    installment button here
                    <div width="100%" class="buttons-container cm-ty-product-bundle-submit" id="wrap_chain_button_{$bundle.bundle_id}">

                        {include file="buttons/button.tpl" but_text=__("installment") but_meta="ty-btn__primary installment-bundle-btn"}
                    </div>
                {/if}
            <!--pb_total_price_{$obj_prefix}_{$bundle.bundle_id}--></div>
        {else}
            <p>{__("product_bundles.sign_in_to_view_price")}</p>
        {/if}

        {if $bundle.description && $settings.abt__device != "mobile"}
            <div class="ty-product-bundle__description hidden-phone">
                {$bundle.description nofilter}
            </div>
        {/if}
    </div>
</form>
