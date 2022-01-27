{if $bundles}
    <div class="ty-mainbox-title">{__("product_bundles.active_bundles")}</div>
    <div class="ab__product_bundles clearfix">
    {foreach $bundles as $bundle}
        {include file="addons/product_bundles/components/bundle_promotion.tpl"}
    {/foreach}
    </div>
{/if}