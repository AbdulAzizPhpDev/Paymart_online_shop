{** block-description:ab__deal_of_the_day **}

{if $promotion && $promotion.status == 'A' &&
(!$promotion.to_date || $promotion.to_date > $smarty.now) &&
(!$promotion.from_date || $promotion.from_date < $smarty.now)}

    {$products = $promotion|fn_ab__dotd_get_promotion_products:$block.properties}

    {if $products}
        <div class="ab__deal_of_the_day {if $block.properties.product_full_width == "Y"}pd-fullwidth{/if}">
            <div class="pd-block">
                <div class="action-title">{$promotion.name}</div>

                <div class="promotion-descr">
                    {if $settings.abt__device != "mobile"}
	                    {$promotion.short_description nofilter}
	                {/if}
	                <a class="more" href="{"promotions.view?promotion_id=`$promotion.promotion_id`"|fn_url}" title="{__('ab__dotd.detailed')}">{__('ab__dotd.detailed')}</a>
                </div>
                
                {if $block.properties.ab__dotd_enable_countdown_timer == 'Y' || !$block.properties.ab__dotd_enable_countdown_timer}
                    <div class="time-left">{__('ab__dotd_time_left')}:</div>
                    {include file="addons/ab__deal_of_the_day/components/init_countdown.tpl"}
                {/if}
                
                {if $settings.abt__device != "mobile"}
                    <div class="all-promotions__button"><a href="{"promotions.list"|fn_url}" title="{__("ab__dotd.all_promotions_list")}"><span>{__("ab__dotd.all_promotions_list")}</span></a></div>
                {/if}
            </div>
            <div class="pd-content-block">
                {include file="addons/ab__deal_of_the_day/blocks/products/components/products_scroller_pd.tpl" items=$products}
            </div>
            {if $settings.abt__device == "mobile"}
                <div class="all-promotions__button"><a href="{"promotions.list"|fn_url}" title="{__("ab__dotd.all_promotions_list")}"><span>{__("ab__dotd.all_promotions_list")}</span></a></div>
            {/if}
        </div>
    {/if}
{/if}