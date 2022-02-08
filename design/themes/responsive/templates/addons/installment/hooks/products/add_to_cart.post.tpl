{if $auth.user_id}
    {include file="buttons/button.tpl"
    but_id="button_cart_`$obj_prefix``$obj_id`"
    but_text=__("installment")
    but_href=""
    but_name="dispatch[installment_product.get_quantity]"
    but_role="submit"
    but_meta="ut2-btn__options ty-btn__primary ty-btn__big"}
{else}

    {$getContent.content nofilter}
    {include file="buttons/button.tpl"
    but_id="login_block{$block.snapping_id}"
    but_text=__("installment")
    but_href="auth.login_form"
    but_role="button"
    but_name=""
    but_target=""
    but_target_id = "login_block_installment"
    but_meta="ut2-btn__options ty-btn__primary ty-btn__big cm-dialog-opener cm-dialog-auto-size"}

    {*    <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}*}
    {*{$config.current_url|fn_url}*}
    {*{else}*}
    {*{"auth.login_form?return_url=`$return_current_url`"|fn_url}*}

    {*{/if}"*}
    {*       data-ca-target-id="login_block{$block.snapping_id}"*}
    {*       class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"*}
    {*       rel="nofollow">*}
    {*        {__("sign_in")}*}
    {*    </a>*}
    <div id="login_block_installment" class="hidden" title="{__("sign_in")}">
        <div class="ty-login-popup">
            {include file="views/auth/login_form.tpl" style="popup" id="popup`$block.snapping_id`"}
        </div>
    </div>
{/if}
