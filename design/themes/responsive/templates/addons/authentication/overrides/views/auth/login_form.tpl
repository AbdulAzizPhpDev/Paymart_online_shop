{assign var="id" value=$id|default:"main_login"}

{script src="js/addons/authentication/func.js"}

{capture name="login"}
    <form
            name="{$id}_form"
            action="{"profiles.send_sms"|fn_url}"
            method="post"
            class="cm-ajax "
    >
        {if $style == "popup"}
            <input type="hidden" name="result_ids" value="{$id}_login_popup_form_container" />
            <input type="hidden" name="login_block_id" value="{$id}" />
            <input type="hidden" name="quick_login" value="1" />
        {/if}

        <input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}" />
        <input type="hidden" name="redirect_url" value="{$redirect_url|default:$config.current_url}" />

        <div class="ty-control-group phone">
            <label
                    for="buyer-phone"
                    class="ty-login__filed-label ty-control-group__label cm-required cm-trim "
            >
                {__("phone")}
            </label>
            <input
                    type="text" id="buyer-phone" name="phone"
                    maxlength="17"
                    class="ty-login__input"
            />
        </div>

        <div class="ty-control-group code" style="display: none">
            <label
                    for="buyer-phone-code"
                    class="ty-login__filed-label ty-control-group__label cm-required cm-trim "
            >
                Code
            </label>
            <input
                    type="text" id="buyer-phone-code" name="phone-code"
                    maxlength="17"
                    class="ty-login__input"
            />
        </div>

        {if $style == "popup"}
            <div class="ty-login-form__wrong-credentials-container">
                <span class="ty-login-form__wrong-credentials-text ty-error-text">

                </span>
            </div>
        {/if}


        {*{hook name="index:login_buttons"}
            <div class="buttons-container clearfix">
                <div class="ty-float-right">
                    <button class="cm-form-dialog-closer ty-btn ty-btn__secondary" type="submit">SEND SMS</button>
                </div>
            </div>
        {/hook}*}
    </form>
{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
        <button
                type="button"
                class="auth_popup"
                id="sendSMSBtn"
        >
            Send SMS
        </button>

        <button
                type="button"
                class="auth_popup"
                id="confirmCodeBtn"
                style="display: none;"
        >
            Confirm Code
        </button>
    </div>
{/if}
