{** block-description:my_account **}

{*{capture name="title"}*}
{*    <a class="ty-account-info__title" href="{"profiles.update"|fn_url}">*}
{*        {include_ext file="common/icon.tpl" class="ty-icon-user"}&nbsp;<span class="ty-account-info__title-txt" {live_edit name="block:name:{$block.block_id}"}>{$title}</span>*}
{*        {include_ext file="common/icon.tpl" class="ty-icon-down-micro ty-account-info__user-arrow"}*}
{*    </a>*}
{*{/capture}*}

{*<div id="account_info_{$block.snapping_id}">*}
{*    {assign var="return_current_url" value=$config.current_url|escape:url}*}
{*    <ul class="ty-account-info">*}
{*        {hook name="profiles:my_account_menu"}*}
{*        {if $auth.user_id}*}
{*            {if $user_info.firstname || $user_info.lastname}*}
{*                <li class="ty-account-info__item  ty-account-info__name ty-dropdown-box__item">{$user_info.firstname} {$user_info.lastname}</li>*}
{*            {else}*}
{*                <li class="ty-account-info__item ty-dropdown-box__item ty-account-info__name">{$user_info.email}</li>*}
{*            {/if}*}
{*            <li class="ty-account-info__item ty-dropdown-box__item"><a class="ty-account-info__a underlined" href="{"profiles.update"|fn_url}" rel="nofollow" >{__("profile_details")}</a></li>*}
{*            {if $settings.General.enable_edp == "Y"}*}
{*                <li class="ty-account-info__item ty-dropdown-box__item"><a class="ty-account-info__a underlined" href="{"orders.downloads"|fn_url}" rel="nofollow">{__("downloads")}</a></li>*}
{*            {/if}*}
{*        {elseif $user_data.firstname || $user_data.lastname}*}
{*            <li class="ty-account-info__item  ty-dropdown-box__item ty-account-info__name">{$user_data.firstname} {$user_data.lastname}</li>*}
{*        {elseif $user_data.email}*}
{*            <li class="ty-account-info__item ty-dropdown-box__item ty-account-info__name">{$user_data.email}</li>*}
{*        {/if}*}
{*            <li class="ty-account-info__item ty-dropdown-box__item"><a class="ty-account-info__a underlined" href="{"orders.search"|fn_url}" rel="nofollow">{__("orders")}</a></li>*}
{*        {if $settings.General.enable_compare_products == 'Y'}*}
{*            {assign var="compared_products" value=""|fn_get_comparison_products}*}
{*            <li class="ty-account-info__item ty-dropdown-box__item"><a class="ty-account-info__a underlined" href="{"product_features.compare"|fn_url}" rel="nofollow">{__("view_comparison_list")}{if $compared_products} ({$compared_products|count}){/if}</a></li>*}
{*        {/if}*}
{*        {/hook}*}
{*    </ul>*}

{*    {if $settings.Appearance.display_track_orders == 'Y'}*}
{*        <div class="ty-account-info__orders updates-wrapper track-orders" id="track_orders_block_{$block.snapping_id}">*}
{*            <form action="{""|fn_url}" method="POST" class="cm-ajax cm-post cm-ajax-full-render" name="track_order_quick">*}
{*                <input type="hidden" name="result_ids" value="track_orders_block_*" />*}
{*                <input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}" />*}

{*                <div class="ty-account-info__orders-txt">{__("track_my_order")}</div>*}

{*                <div class="ty-account-info__orders-input ty-control-group ty-input-append">*}
{*                    <label for="track_order_item{$block.snapping_id}" class="cm-required hidden">{__("track_my_order")}</label>*}
{*                    <input type="text" size="20" class="ty-input-text cm-hint" id="track_order_item{$block.snapping_id}" name="track_data" value="{__("order_id")}{if !$auth.user_id}/{__("email")}{/if}" />*}
{*                    {include file="buttons/go.tpl" but_name="orders.track_request" alt=__("go")}*}
{*                    {include file="common/image_verification.tpl" option="track_orders" align="left" sidebox=true}*}
{*                </div>*}
{*            </form>*}
{*            <!--track_orders_block_{$block.snapping_id}--></div>*}
{*    {/if}*}

{*    <div class="ty-account-info__buttons buttons-container">*}
{*        {if $auth.user_id}*}
{*            {$is_vendor_with_active_company="MULTIVENDOR"|fn_allowed_for && ($auth.user_type == "V") && ($auth.company_status == "A")}*}
{*            {if $is_vendor_with_active_company}*}
{*                <a href="{$config.vendor_index|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary" target="_blank">{__("go_to_admin_panel")}</a>*}
{*            {/if}*}
{*            <a href="{"auth.logout?redirect_url=`$return_current_url`"|fn_url}" rel="nofollow" class="ty-btn {if $is_vendor_with_active_company}ty-btn__tertiary{else}ty-btn__primary{/if}">{__("sign_out")}</a>*}
{*        {else}*}
{*            <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}" data-ca-target-id="login_block{$block.snapping_id}" class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary" rel="nofollow">{__("sign_in")}</a><a href="{"profiles.add"|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary">{__("register")}</a>*}
{*            <div  id="login_block{$block.snapping_id}" class="hidden" title="{__("sign_in")}">*}
{*                <div class="ty-login-popup">*}
{*                    {include file="views/auth/login_form.tpl" style="popup" id="popup`$block.snapping_id`"}*}
{*                </div>*}
{*            </div>*}
{*        {/if}*}
{*    </div>*}
{*    <!--account_info_{$block.snapping_id}--></div>*}

{** block-description:my_account **}
<div class="ty-dropdown-box" id="account_info_{$block.snapping_id}">
    <div id="sw_dropdown_{$block.block_id}" class="ty-dropdown-box__title cm-combination">
        <div>
            {hook name="my_account:dropdown_title"}
                <a class="ac-title" href="{"profiles.update"|fn_url}">
                    <i class="ut2-icon-outline-account-circle"></i>
                    <span {live_edit name="block:name:{$block.block_id}"}>{$title}<i
                                class="ut2-icon-outline-expand_more"></i></span>
                </a>
            {/hook}
        </div>
    </div>

    <div id="dropdown_{$block.block_id}" class="cm-popup-box ty-dropdown-box__content hidden">
        {assign var="return_current_url" value=$config.current_url|escape:url}
        <ul class="ty-account-info">
            {*            {hook name="profiles:my_account_menu"}*}
            {if $auth.user_id}
                <li class="ty-account-info__item  ty-account-info__name ty-dropdown-box__item" style="padding-bottom: 0;">
                    {__('vendor_payouts.current_balance_text')}
                </li>
                <li class="ty-account-info__item ty-dropdown-box__item user-balance">

                    <span class="balance-number">{$user_info.i_limit|default:0|number_format:false:false:' '}</span>
                    <span class="balance-symbol">{$currencies[$smarty.const.CART_PRIMARY_CURRENCY].symbol}</span>
                </li>
                <hr>
                {if $user_info.firstname || $user_info.lastname}
                    <li class="ty-account-info__item  ty-account-info__name ty-dropdown-box__item">{$user_info.firstname} {$user_info.lastname}</li>
                    {*                {else}*}
                    {*                    <li class="ty-account-info__item ty-dropdown-box__item ty-account-info__name">{$user_info.email}</li>*}
                {/if}
                {*<li class="ty-account-info__item ty-dropdown-box__item">
                    <a class="ty-account-info__a underlined"
                       href="{"profiles.update"|fn_url}"
                       rel="nofollow"
                    >
                        {__("profile_details")}
                    </a>
                </li>*}
                {if $settings.General.enable_edp == "YesNo::YES"|enum}
                    <li class="ty-account-info__item ty-dropdown-box__item">
                        <a class="ty-account-info__a underlined"
                           href="{"orders.downloads"|fn_url}"
                           rel="nofollow">{__("downloads")}</a>
                    </li>
                {/if}
                {if $user_info.i_step==4}
                    <li class="ty-account-info__item ty-dropdown-box__item">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.33301 19.841V15.334C5.33301 14.229 6.22801 13.334 7.33301 13.334H16.666C17.771 13.334 18.666 14.229 18.666 15.334V19.841M14.9634 7.12303C14.9634 8.75945 13.6368 10.086 12.0004 10.086C10.364 10.086 9.03738 8.75945 9.03738 7.12303C9.03738 5.48661 10.364 4.16003 12.0004 4.16003C13.6368 4.16003 14.9634 5.48661 14.9634 7.12303Z"
                                      stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round"
                                      stroke-linejoin="round" />
                            </svg>
                        </span>
                        <a class="ty-account-info__a underlined"
                           href="{$smarty.const.PAYMART_CLIENT_BASE_URL}/{$smarty.const.CART_LANGUAGE|lower}/profile?api_token={$user_info.api_key}"
                           rel="nofollow">
                            {__("text_cabinet")}
                        </a>
                    </li>
                {/if}
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.99999 5.33595H13.333M16 5.33595H18.333C19.99 5.33595 21.333 6.67895 21.333 8.33595V18.3329C21.333 19.9899 19.99 21.3329 18.333 21.3329H5.66699C4.00999 21.3329 2.66699 19.9899 2.66699 18.3329V8.33595C2.66699 6.67895 4.00999 5.33595 5.66699 5.33595M2.66699 12.0009H17.333M7.99999 8.00095V2.66895M16 8.00095V2.66895"
                                  stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round"
                                  stroke-linejoin="round" />
                        </svg>
                    </span>
                    <a class="ty-account-info__a underlined" href="{"installment_product.profile-contracts"|fn_url}"
                       rel="nofollow">
                        {__("installment_contracts")}
                    </a>
                </li>
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.33411 21.8319C9.61025 21.8319 9.83411 21.608 9.83411 21.3319C9.83411 21.0558 9.61025 20.8319 9.33411 20.8319V21.8319ZM6.28711 21.3319V21.8319V21.3319ZM3.28711 18.3319H2.78711H3.28711ZM3.28711 5.66589H3.78711H3.28711ZM6.28711 2.66589V3.16589V2.66589ZM9.33411 3.16589C9.61025 3.16589 9.83411 2.94204 9.83411 2.66589C9.83411 2.38975 9.61025 2.16589 9.33411 2.16589V3.16589ZM15.9647 5.96734C15.7694 5.77208 15.4528 5.77208 15.2576 5.96734C15.0623 6.1626 15.0623 6.47919 15.2576 6.67445L15.9647 5.96734ZM21.3241 12.0339L21.6777 12.3874C21.7714 12.2937 21.8241 12.1665 21.8241 12.0339C21.8241 11.9013 21.7714 11.7741 21.6777 11.6803L21.3241 12.0339ZM15.2576 17.3933C15.0623 17.5886 15.0623 17.9052 15.2576 18.1004C15.4528 18.2957 15.7694 18.2957 15.9647 18.1004L15.2576 17.3933ZM8.01111 11.5339C7.73497 11.5339 7.51111 11.7578 7.51111 12.0339C7.51111 12.31 7.73497 12.5339 8.01111 12.5339V11.5339ZM21.3081 12.5339C21.5843 12.5339 21.8081 12.31 21.8081 12.0339C21.8081 11.7578 21.5843 11.5339 21.3081 11.5339V12.5339ZM9.33411 20.8319H6.28711V21.8319H9.33411V20.8319ZM6.28711 20.8319C4.90625 20.8319 3.78711 19.7128 3.78711 18.3319H2.78711C2.78711 20.265 4.35397 21.8319 6.28711 21.8319V20.8319ZM3.78711 18.3319L3.78711 5.66589H2.78711L2.78711 18.3319H3.78711ZM3.78711 5.66589C3.78711 4.28504 4.90625 3.16589 6.28711 3.16589V2.16589C4.35397 2.16589 2.78711 3.73275 2.78711 5.66589H3.78711ZM6.28711 3.16589L9.33411 3.16589V2.16589L6.28711 2.16589V3.16589ZM15.2576 6.67445L20.9706 12.3874L21.6777 11.6803L15.9647 5.96734L15.2576 6.67445ZM20.9706 11.6803L15.2576 17.3933L15.9647 18.1004L21.6777 12.3874L20.9706 11.6803ZM8.01111 12.5339H21.3081V11.5339H8.01111V12.5339Z"
                                  fill="#FF7643" />
                        </svg>
                    </span>
                    <a href="{fn_url('auth.logout')}" rel="nofollow"
                       class="ty-account-info__a underlined">
                        {__("sign_out")}
                    </a>
                </li>
            {elseif $user_data.firstname || $user_data.lastname}
                <li class="ty-account-info__item  ty-dropdown-box__item ty-account-info__name">{$user_data.firstname} {$user_data.lastname}</li>
            {elseif $user_data.email}
                <li class="ty-account-info__item ty-dropdown-box__item ty-account-info__name">{$user_data.email}</li>
            {else}
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33301 19.841V15.334C5.33301 14.229 6.22801 13.334 7.33301 13.334H16.666C17.771 13.334 18.666 14.229 18.666 15.334V19.841M14.9634 7.12303C14.9634 8.75945 13.6368 10.086 12.0004 10.086C10.364 10.086 9.03738 8.75945 9.03738 7.12303C9.03738 5.48661 10.364 4.16003 12.0004 4.16003C13.6368 4.16003 14.9634 5.48661 14.9634 7.12303Z"
                                  stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round"
                                  stroke-linejoin="round" />
                        </svg>
                    </span>
                    <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}"
                       data-ca-target-id="login_block{$block.snapping_id}"
                       class="cm-dialog-opener cm-dialog-auto-size"
                       rel="nofollow"
                    >
                        {__("log_in_as_user")}
                    </a>
                </li>
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.927 9.55698V9.55698C22.0459 9.152 22.0132 8.71758 21.835 8.33498L19.9 3.75698V3.75698C19.5557 2.98236 18.7826 2.48779 17.935 2.49998H6.065V2.49998C5.21741 2.48778 4.44427 2.98236 4.1 3.75698L2.165 8.33498H2.165C1.9868 8.71758 1.95409 9.152 2.073 9.55698V9.55698C2.43578 10.5622 3.39744 11.2257 4.466 11.208H4.466C5.81479 11.2444 6.93833 10.1817 6.977 8.83298V8.83298C7.01567 10.1821 8.13982 11.2449 9.489 11.208H9.489C10.8378 11.2444 11.9613 10.1817 12 8.83298V8.83298C12.0733 10.22 13.2571 11.2851 14.6441 11.2118C15.9288 11.144 16.9552 10.1176 17.023 8.83298V8.83298C17.0617 10.1817 18.1852 11.2444 19.534 11.208V11.208C20.6026 11.2257 21.5642 10.5622 21.927 9.55698V9.55698Z"
                                  stroke="#FF7643" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M19.5 13V21.5H4.5V13" stroke="#FF7643" stroke-linecap="round"
                                  stroke-linejoin="round" />
                            <path d="M17.5 12.5V16.5C17.5 17.0523 17.0523 17.5 16.5 17.5H7.5V17.5C6.94771 17.5 6.5 17.0523 6.5 16.5V16.5V12.5"
                                  stroke="#FF7643" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <a href="{'vendor_login.login_form'|fn_url}" rel="nofollow">
                        {__("log_in_as_vendor")}
                    </a>
                </li>
                <div id="login_block{$block.snapping_id}" class="hidden" title="{__("sign_in")}">
                    <div class="ty-login-popup">
                        {include file="views/auth/login_form.tpl" style="popup" id="popup`$block.snapping_id`"}
                    </div>
                </div>
            {/if}
            {*<li class="ty-account-info__item ty-dropdown-box__item">
                <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}"
                   data-ca-target-id="login_block{$block.snapping_id}"
                   class="cm-dialog-opener cm-dialog-auto-size"
                   rel="nofollow">
                    {__("sign_in")}
                </a>
            </li>
            <li class="ty-account-info__item ty-dropdown-box__item">
                <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}"
                   data-ca-target-id="login_block{$block.snapping_id}"
                   class="cm-dialog-opener cm-dialog-auto-size"
                   rel="nofollow">
                    {__("sign_in")}
                </a>
            </li>
            {if $settings.General.enable_compare_products == 'Y'}
                {assign var="compared_products" value=""|fn_get_comparison_products}
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <a class="ty-account-info__a underlined"
                       href="{"product_features.compare"|fn_url}"
                       rel="nofollow">{__("view_comparison_list")}{if $compared_products} ({$compared_products|count}){/if}</a>
                </li>
            {/if}
            {if $addons.wishlist && $addons.wishlist.status == 'A'}
                <li class="ty-account-info__item ty-dropdown-box__item">
                    <a href="{"wishlist.view"|fn_url}">{__("wishlist")}</a>
                </li>
            {/if}
            {/hook}*}
        </ul>

        {*{if $settings.Appearance.display_track_orders == 'Y'}
            <div class="ty-account-info__orders updates-wrapper track-orders"
                 id="track_orders_block_{$block.snapping_id}">
                <form action="{""|fn_url}" method="POST" class="cm-ajax cm-post cm-ajax-full-render"
                      name="track_order_quick">
                    <input type="hidden" name="result_ids" value="track_orders_block_*"/>
                    <input type="hidden" name="return_url"
                           value="{$smarty.request.return_url|default:$config.current_url}"/>

                    <div class="ty-account-info__orders-txt">{__("track_my_order")}</div>

                    <div class="ty-account-info__orders-input ty-control-group ty-input-append">
                        <label for="track_order_item{$block.snapping_id}"
                               class="cm-required hidden">{__("track_my_order")}</label>
                        <input type="text" size="20" class="ty-input-text cm-hint"
                               id="track_order_item{$block.snapping_id}" name="track_data"
                               value="{__("order_id")}{if !$auth.user_id}/{__("email")}{/if}"/>
                        {include file="buttons/go.tpl" but_name="orders.track_request" alt=__("go")}
                        {include file="common/image_verification.tpl" option="track_orders" align="left" sidebox=true}
                    </div>
                </form>
                <!--track_orders_block_{$block.snapping_id}--></div>
        {/if}*}

        {*<div class="ty-account-info__buttons buttons-container">
            {if $auth.user_id}
                {$is_vendor_with_active_company="MULTIVENDOR"|fn_allowed_for && ($auth.user_type == "V") && ($auth.company_status == "A")}
                {if $is_vendor_with_active_company}
                    <a href="{$config.vendor_index|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary"
                       target="_blank">{__("go_to_admin_panel")}</a>
                {/if}
                <a href="{fn_url('auth.logout')}" rel="nofollow"
                   class="ty-btn {if $is_vendor_with_active_company}ty-btn__tertiary{else}ty-btn__primary{/if}">{__("sign_out")}</a>
            {else}
                <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}"
                   data-ca-target-id="login_block{$block.snapping_id}"
                   class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"
                   rel="nofollow">{__("sign_in")}</a>
                                <a href="{"profiles.add"|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary">{__("register")}</a>
                <div id="login_block{$block.snapping_id}" class="hidden" title="{__("sign_in")}">
                    <div class="ty-login-popup">
                        {include file="views/auth/login_form.tpl" style="popup" id="popup`$block.snapping_id`"}
                    </div>
                </div>
            {/if}
        </div>*}
        <!--account_info_{$block.snapping_id}--></div>
</div>
{*
{if $auth.user_id}
    {$is_vendor_with_active_company="MULTIVENDOR"|fn_allowed_for && ($auth.user_type == "V") && ($auth.company_status == "A")}
    {if $is_vendor_with_active_company}
        <a href="{$config.vendor_index|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary"
           target="_blank">{__("go_to_admin_panel")}</a>
    {/if}
    <a href="{"auth.logout?redirect_url=`$return_current_url`"|fn_url}" rel="nofollow"
       class="ty-btn {if $is_vendor_with_active_company}ty-btn__tertiary{else}ty-btn__primary{/if}">{__("sign_out")}</a>
{else}
    <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}
{$config.current_url|fn_url}
{else}
{"auth.login_form?return_url=`$return_current_url`"|fn_url}

{/if}"
       data-ca-target-id="login_block{$block.snapping_id}"
       class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"
       rel="nofollow">
        {__("sign_in")}
    </a>
                <a href="{"profiles.add"|fn_url}" rel="nofollow" class="ty-btn ty-btn__primary">{__("register")}</a>
    <div id="login_block{$block.snapping_id}" class="hidden" title="{__("sign_in")}">
        <div class="ty-login-popup">
            {include file="views/auth/login_form.tpl" style="popup" id="popup`$block.snapping_id`"}
        </div>
    </div>
{/if}*}
