{assign var="id" value=$id|default:"main_login"}
{script src="js/addons/authentication/func.js"}
{capture name="login"}

    {*    test*}

    {*    <div class="bitrix-container">*}


    {*        <button type="submit" > click</button>*}

    {*    </div>*}

    {*    test*}
{*    {if isset($data)}*}
{*        {$data|fn_print_r}*}
{*    {/if}*}
    <form name="{$id}_form" action="{"profiles.send_sms"|fn_url}" method="post"
          class="cm-ajax ">
        {if $style == "popup"}
            <input type="hidden" name="result_ids" value="{$id}_login_popup_form_container"/>
            <input type="hidden" name="login_block_id" value="{$id}"/>
            <input type="hidden" name="quick_login" value="1"/>
        {/if}

        <input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}"/>
        <input type="hidden" name="redirect_url" value="{$redirect_url|default:$config.current_url}"/>

        {if $style == "checkout"}
        <div class="ty-checkout-login-form">
            {include file="common/subheader.tpl" title=__("returning_customer")}
            {/if}
            <div class="ty-control-group">
                <label for="login_{$id}"
                       class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                    {__("phone")}
                </label>
                <input type="text" id="login_{$id}" name="phone"
                       maxlength="17"
                       class="ty-login__input"/>
            </div>

            {*                    <div class="ty-control-group ty-password-forgot">*}
            {*                        <label for="psw_{$id}" class="ty-login__filed-label ty-control-group__label ty-password-forgot__label cm-required">{__("password")}</label><a href="{"auth.recover_password"|fn_url}" class="ty-password-forgot__a"  tabindex="5">{__("forgot_password_question")}</a>*}
            {*                        <input type="password" id="psw_{$id}" name="password" size="30" value="{$config.demo_password}" class="ty-login__input" maxlength="32" />*}
            {*                    </div>*}

            {if $style == "popup"}
                {if $login_error}
                    <div class="ty-login-form__wrong-credentials-container">
                        <span class="ty-login-form__wrong-credentials-text ty-error-text">{__("error_incorrect_login")}</span>
                    </div>
                {/if}
{*                <div class="ty-login-reglink ty-center">*}
{*                    <a class="ty-login-reglink__a" href="{"profiles.add"|fn_url}"*}
{*                       rel="nofollow">{__("register_new_account")}</a>*}
{*                </div>*}
            {/if}

            {include file="common/image_verification.tpl" option="login" align="left"}

            {if $style == "checkout"}
        </div>
        {/if}

        {hook name="index:login_buttons"}
            <div class="buttons-container clearfix">
                <div class="ty-float-right">
                    <button class="cm-form-dialog-closer ty-btn ty-btn__secondary" type="submit">SEND SMS</button>
                </div>
{*                <div class="ty-login__remember-me">*}
{*                    <label for="remember_me_{$id}" class="ty-login__remember-me-label">*}
{*                        <input class="checkbox"*}
{*                               type="checkbox"*}
{*                               name="remember_me"*}
{*                               id="remember_me_{$id}"*}
{*                               value="Y"/>{__("remember_me")}*}
{*                    </label>*}
{*                </div>*}
            </div>
        {/hook}
    </form>
{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
        <button type="button" class="auth_popup" id="test" >click</button>
        <!--{$id}_login_popup_form_container-->
    </div>
{else}
    <div class="ty-login">
        {$smarty.capture.login nofilter}
    </div>
    {*    {capture name="mainbox_title"}{__("sign_in")}{/capture}*}
{/if}

{*<script>*}
{*    const btxcontainer = document.querySelector('.bitrix-container');*}

{*    const scriptTag = document.createElement('script');*}

{*    scriptTag.setAttribute('data-b24-form', 'click/4/143zah');*}
{*    scriptTag.setAttribute('data-skip-moving', 'true');*}
{*    scriptTag.innerHTML = `*}
{*        (function (w, d, u) {*}
{*          var s = d.createElement('script');*}
{*          s.async = true;*}
{*          s.src = u + '?' + (Date.now() / 180000 | 0);*}
{*          var h = d.getElementsByTagName('script')[0];*}
{*          h.parentNode.insertBefore(s, h);*}
{*        })(window, document, 'https://cdn-ru.bitrix24.ru/b17065524/crm/form/loader_4.js')*}
{*      `;*}

{*    btxcontainer.prepend(scriptTag)*}
{*</script>*}
