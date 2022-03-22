{script src="js/addons/installment/card-add.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">

<div class="card-add-page">
    <div class="card-info">
        <h1>{__('authentication.card.title')}</h1>
        <div class="ty-control-group">
            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                {__('authentication.card.number')}
            </label>
            <input type="tel" placeholder="0000 0000 0000 0000"
                   class="ty-login__input buyer-card-installment" required />
        </div>

        <div class="ty-control-group">
            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                {__('authentication.card.exp')}
            </label>
            <input type="tel" placeholder="00/00"
                   class="ty-login__input buyer-card-exp-installment" required />
        </div>

        <div class="politic-confidence-container">
            <a href="#">
                <img src="/design/themes/responsive/media/icons/politic-confidence.svg" alt="politic-confidence">
                <div>{__('authentication.card.text_cybersecurity')}</div>
                <img src="/design/themes/responsive/media/icons/chevron-right.svg" alt="icon-right-arrow">
            </a>
        </div>

        <button disabled class="ty-btn ty-btn__secondary" type="button" id="installmentSendSMSCardBtn">
            {__("continue")}
        </button>
    </div>

    <div class="card-confirm d-none">
        <h1>{__('authentication.title_sms_code')}</h1>

        <div class="ty-control-group">
            <p>{__('authentication.sent_phone', ['[n]' => '<span class="sent-phone-number"></span>'])}</p>

            <input type="tel" hidden
                   class="ty-login__input buyer-card-code-installment" />
        </div>
        <div id="card-pin-wrapper"></div>

        <p class="resend-sms-card">
            {__('authentication.text_resend_sms', ['[n]' => '<span class="card-resend-sms-timer">60</span>'])}
        </p>

        <button class="ty-btn ty-btn__secondary" type="button" id="installmentSendCardCodeBtn">
            {__("continue")}
        </button>
    </div>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-card-installment"></span>
    </div>

    <ul class="stepper">
        <li class="step active"></li>
        <li class="step"></li>
        <li class="step"></li>
    </ul>
</div>

<script>
$('#card-pin-wrapper').pinlogin({
  placeholder: '*',
  hideinput: false,
  fields: 4,
  reset: false,
  complete: function (pin) {
    $('.buyer-card-code-installment').attr('value', pin);
    $('#installmentSendCardCodeBtn').click();
  },
});
</script>