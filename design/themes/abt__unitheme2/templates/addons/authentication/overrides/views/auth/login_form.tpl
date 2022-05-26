{assign var="id" value=$id|default:"main_login"}
{script src="js/addons/authentication/func.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">
{assign var="id" value=$id|default:"main_login"}

{capture name="login"}
    <form action="{"profiles.send_sms"|fn_url}" id="auth-form-{$id}" method="post">
        <input class="form-id" type="hidden" value="{$id}">
        <div class="ty-control-group phone-container">

            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label">
                {__('rapidaphone')}
            </label>

            <input id="buyer-phone"
                   type="text"
                   name="phone"
                   placeholder="{__('rapidaphone')}"
                   class="ty-login__input"
            />

            <p class="ty-error-text"></p>

            <button type="submit" id="sendSMSBtn" style="width: 100%" class="ty-btn ty-btn__primary">
                {__('continue')}
            </button>
        </div>

        <div class="ty-control-group code-container d-none">
            <h1 class="ty-center">{__('authentication.title_sms_code')}</h1>

            <p class="ty-mtb-s ty-center">
                {__('authentication.sent_phone', ['[n]' => '<span class="user-auth-phone-sms-sent"></span>' ])}
            </p>

            <input type="hidden" class="ty-login__input auth-confirmation-code" />
            <div id="confirmation-pin-code"></div>

            <p class="resend-sms-phone ty-mt-m ty-center">
                {__('authentication.text_resend_sms', ['[n]' => '<span class="phone-timer">60</span>'])}
            </p>

            <p class="ty-error-text"></p>

            <button type="submit" id="confirmCodeBtn" style="width: 100%"
                    class="ty-btn ty-btn__primary auth-confirm-btn">
                {__("continue")}
            </button>

            <button type="button" style="width: 100%; margin-left: 0; margin-top: 8px;" class="ty-btn ty-btn__secondary auth-change-phone-number">
                {__("text_change_number")}
            </button>
        </div>
    </form>
{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
    </div>
{/if}

<script>
$('#confirmation-pin-code').pinlogin({
  placeholder: '*',
  hideinput: false,
  fields: 4,
  reset: false,
  complete: function (pin) {
    $('.auth-confirmation-code').attr('value', pin);
    $('.auth-confirm-btn').click();
  },
});
</script>