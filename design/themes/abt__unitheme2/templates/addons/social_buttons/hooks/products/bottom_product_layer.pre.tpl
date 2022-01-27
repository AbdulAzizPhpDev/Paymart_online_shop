{strip}
{if $provider_settings && $settings.abt__ut2.products.addon_social_buttons.view[$settings.abt__device] == 'Y'}
	{include file="addons/social_buttons/hooks/products/product_detail_bottom.post.tpl" abt__do_not_mute=true}
{/if}
{/strip}