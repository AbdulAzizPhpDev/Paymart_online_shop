{script src="js/tygh/exceptions.js"}
{assign var="days_left" value=(1-($smarty.now-$bundle.date_to)/86400)|floor}

{if $bundle}
    <div class="ab__pb--item {if $days_left >= 1 || !$bundle.date_to}active{/if}">
        <div class="ab__pb--image">
            {if $bundle.main_pair|is_array}
            <a class="cm-dialog-opener cm-dialog-auto-size" data-ca-target-id="content_product_bundle_promotions_{$bundle.bundle_id}">
                {include file="common/image.tpl"
                    images=$bundle.main_pair
                    image_id="`$bundle.bundle_id`"
                    class="ty-grid-promotions__image"
                    image_width=$promotion_image_width|default:'330'
                    image_height=$promotion_image_height|default:'200'
                }
            </a>
            {/if}
        </div>

        {if $bundle.date_to && $days_left >= 1}
            <div class="ab__pb--available">
                {if $days_left >= 1}
                    {__('ab__pb.days_left', [$days_left])}
                {/if}
            </div>
        {/if}

        <div class="ab__pb--content">
            <a class="cm-dialog-opener cm-dialog-auto-size" data-ca-target-id="content_product_bundle_promotions_{$bundle.bundle_id}">
                <span class="ab__pb--header">{$bundle.storefront_name}</span>
            </a>

            {if "MULTIVENDOR"|fn_allowed_for && ($company_name || $bundle.company_id)}
                <div class="ab__pb--company">
                    <a href="{"companies.products?company_id=`$bundle.company_id`"|fn_url}" class="ty-grid-promotions__company-link">
                        {if $company_name}{$company_name}{else}{$bundle.company_id|fn_get_company_name}{/if}
                    </a>
                </div>
            {/if}

            {if $bundle.description}
                <div class="ab__pb--description">
                    {$bundle.description nofilter}
                </div>
            {/if}
        </div>
    </div>

    <div class="hidden" id="content_product_bundle_promotions_{$bundle.bundle_id}" title="{$bundle.storefront_name}">
        {include file="addons/product_bundles/components/bundle_form.tpl"}
    </div>
{/if}
