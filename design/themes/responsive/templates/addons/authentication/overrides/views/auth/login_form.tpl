{assign var="id" value=$id|default:"main_login"}

{script src="js/addons/authentication/func.js"}

{capture name="login"}

    <form name="{$id}_form" action="{"profiles.send_sms"|fn_url}" method="post"
          class="cm-ajax ">
        {if $style == "popup"}
            <input type="hidden" name="result_ids" value="{$id}_login_popup_form_container"/>
            <input type="hidden" name="login_block_id" value="{$id}"/>
            <input type="hidden" name="quick_login" value="1"/>
        {/if}

        <input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}"/>
        <input type="hidden" name="redirect_url" value="{$redirect_url|default:$config.current_url}"/>

        <div class="ty-control-group">
            <label
                for="login_{$id}"
                class="ty-login__filed-label ty-control-group__label cm-required cm-trim "
            >
                {__("phone")}
            </label>
            <input
                type="text" id="login_{$id}" name="phone"
                maxlength="17"
                class="ty-login__input"
            />
        </div>

        {if $style == "popup"}
            {if $login_error}
                <div class="ty-login-form__wrong-credentials-container">
                    <span class="ty-login-form__wrong-credentials-text ty-error-text">{__("error_incorrect_login")}</span>
                </div>
            {/if}
        {/if}


        {hook name="index:login_buttons"}
            <div class="buttons-container clearfix">
                <div class="ty-float-right">
                    <button class="cm-form-dialog-closer ty-btn ty-btn__secondary" type="submit">SEND SMS</button>
                </div>
            </div>
        {/hook}
    </form>

{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
        <button type="button" class="auth_popup" id="test" >click</button>
    </div>
{/if}
