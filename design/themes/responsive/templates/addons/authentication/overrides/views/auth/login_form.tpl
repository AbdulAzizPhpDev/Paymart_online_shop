{assign var="id" value=$id|default:"main_login"}

{capture name="login"}
    <form action="{"profiles.send_sms"|fn_url}" id="auth-form" method="post">
        <div class="ty-control-group phone-container">
            <h1 class="ty-center">{__('authentication.title')}</h1>

            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label">
                {__("phone")}
            </label>

            <input id="buyer-phone"
                   type="text"
                   name="phone"
                   placeholder="Phone Number"
                   class="ty-login__input"
            />

            <p class="ty-error-text"></p>

            <button type="submit" id="sendSMSBtn" class="ty-btn ty-btn__secondary">
                Send SMS
            </button>
        </div>

        <div class="ty-control-group code-container d-none">
            <label for="buyer-phone-code" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                Code
            </label>

            <input id="confirmation-code"
                   type="tel"
                   maxlength="4"
                   name="code"
                   placeholder="SMS Code"
                   class="ty-login__input"
            />

            <p class="ty-error-text"></p>

            <button type="submit" id="confirmCodeBtn" class="ty-btn ty-btn__secondary">
                Confirm Code
            </button>

            {*<button type="button" id="confirmCodeBtn" class="ty-btn ty-btn__secondary">
                Resend SMS
            </button>*}
        </div>
    </form>
{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
    </div>
{/if}

{script src="js/addons/authentication/func.js"}

