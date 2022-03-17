{script src="js/addons/installment/func.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">

<div class="wrapper">

    <form class="cm-ajax ">
        {* ------------------------------------------------------------------------------------- *}
        {* Sending SMS *}
        <div class="sending-sms">
            <h1 class="sending-sms__title">{__('mobile_app.mobile_auth')}</h1>

            <div class="ty-control-group installment-phone-container">
                <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                    {__('rapidaphone')}
                </label>
                <input type="tel" class="ty-login__input buyer-phone-installment" va/>
            </div>

            <div class="oferta-container">
                <a href="#">
                    <img src="/design/themes/responsive/media/icons/oferta.svg" alt="oferta">
                    <span>{__("authentication.oferta")}</span>
                </a>
            </div>

            <div class="agreement">
                <label>
                    <input type="checkbox">
                    Согласие на обработку персональных данных
                </label>
            </div>

            <button class="ty-btn ty-btn__secondary" type="button" disabled id="installmentSendSMSBtn">
                Отправить заявку
            </button>
        </div>

        {* ------------------------------------------------------------------------------------- *}
        {* Confirmation code *}
        <div class="confirmation d-none">
            <h1>Введите SMS код </h1>
            <p>Отправленный на номер <span class="user-phone-sms-sent"></span></p>

            <div class="ty-control-group installment-code-container">
                <input type="text" hidden class="ty-login__input buyer-sms-code-installment" />
            </div>
            <div id="pinwrapper"></div>

            <p class="resend-sms-phone">Отправить SMS еще раз (через <span class="phone-timer">60</span> сек.)</p>

            <button class="ty-btn ty-btn__secondary" type="button" id="installmentConfirmCodeBtn">
                {__("continue")}
            </button>

            <button class="ty-btn ty-btn__secondary" type="button" id="installmentChangePhoneBtn">
                {__("addons.installment.change_phone_number")}
            </button>
        </div>

        {* ------------------------------------------------------------------------------------- *}
        {* Rendering Errors *}
        <div class="ty-login-form__wrong-credentials-container">
            <span class="ty-login-form__wrong-credentials-text ty-error-text error-installment"></span>
        </div>
    </form>
</div>

<script>
$('#pinwrapper').pinlogin({
  placeholder: '*',
  hideinput: false,
  fields: 4,
  reset: false,
  complete: function (pin) {
    $('.buyer-sms-code-installment').attr('value', pin);
    $('#installmentConfirmCodeBtn').click();
  },
});
</script>
