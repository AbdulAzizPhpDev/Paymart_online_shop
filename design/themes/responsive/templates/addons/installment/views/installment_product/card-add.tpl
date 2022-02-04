{script src="js/addons/installment/card-add.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">

<div class="wrapper">
    <div class="card-info">
        <h1>Пройдите одноразувую верификацию</h1>
        <div class="ty-control-group">
            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                Номер карты
            </label>
            <input type="tel" placeholder="0000 0000 0000 0000" maxlength="16"
                   class="ty-login__input buyer-card-installment" required />
        </div>

        <div class="ty-control-group">
            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                Срок карты
            </label>
            <input type="tel" placeholder="00/00" maxlength="4"
                   class="ty-login__input buyer-card-exp-installment" required />
        </div>

        <button class="ty-btn ty-btn__secondary" type="button" id="installmentSendSMSCardBtn">
            Продолжить
        </button>
    </div>

    <div class="card-confirm d-none">
        <h1>Введите SMS код </h1>

        <div class="ty-control-group">
            <label for="buyer-phone" class="ty-login__filed-label ty-control-group__label cm-required cm-trim ">
                Отправленный на номер <span class="sent-phone-number"></span>
            </label>

            <input type="tel" hidden
                   class="ty-login__input buyer-card-code-installment" />
        </div>
        <div id="card-pin-wrapper"></div>

        <p>Отправить SMS еще раз (через <span class="timer">60</span> сек.)</p>

        <button class="ty-btn ty-btn__secondary" type="button" id="installmentSendCardCodeBtn">
            Продолжить
        </button>
    </div>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-card-installment"></span>
    </div>
</div>

<script>
$('#card-pin-wrapper').pinlogin({
  placeholder: '*',
  hideinput: false,
  fields: 4,
  reset: false,
  complete: function (pin) {
    $('.buyer-card-code-installment').attr('value', pin);
  },
});
</script>