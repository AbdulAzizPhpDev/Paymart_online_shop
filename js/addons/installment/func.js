(function (_, $) {
  const $sendSmsBtn = $('#installmentSendSMSBtn');

  const $buyerPhone = $('.buyer-phone-installment');
  const $buyerSmsCode = $('.buyer-sms-code-installment');

  const $changePhoneBtn = $('#installmentChangePhoneBtn');
  const $userPhoneSmsSent = $('.user-phone-sms-sent');
  const $timerSlot = $('.phone-timer');
  const $agreementCheckbox = $('.agreement input[type="checkbox"]');
  const $resendSms = $('.resend-sms-phone');

  const $confirmation = $('.confirmation');
  const $sendingSms = $('.sending-sms');

  const $errorContainer = $('.error-installment');

  const installmentState = {
    interval: null,
    timer: 60,
    userStatus: 0,
    errors: [],
    error: null,
    userPhoneNumber: Cookies.get('buyer-phone') || '+998 ********',
    hasAgree: false,
  };

  const methods = {
    makeRoute({ controller = 'installment_product', action = 'index' }) {
      return window.location.href = `http://market.paymart.uz/index.php?dispatch=${controller}.${action}`;
    },
    renderErrors: function (errors) {
      if (typeof errors !== 'string') {
        errors.forEach(error => {
          $errorContainer.text(error.text);
        });
      } else {
        $errorContainer.text(errors);
      }
    },
    timerResendSms: function () {
      let { interval, timer } = installmentState;
      interval = setInterval(() => {
        timer -= 1;
        $timerSlot.text(timer);

        if (timer === 0) {
          clearInterval(interval);
          $resendSms.addClass('active');
        }
      }, 1000);
    },
    sendSMS: function (event) {
      installmentState.userPhoneNumber = $buyerPhone.val();
      console.log($buyerPhone.val().replace(/[ +-]/g, ''));

      /*$.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: $buyerPhone.val().replace(/[ +-]/, '') || null,
        },
        callback: function callback(response) {
          if (response) {
            const { result } = response;

            if (result.status === 'success') {
              $confirmation.removeClass('d-none');
              methods.timerResendSms();

              $sendingSms.addClass('d-none');
            } else {
              methods.renderErrors(result.response.message);
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.send_sms]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });*/
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: $buyerPhone.val().replace('+', ''),
          code: $buyerSmsCode.val(),
          redirect_url: $('input[name="redirect_url"]').val(),
        },
        callback: function callback(response) {
          if (response) {
            const { result } = response;

            if (result.status === 'success') {
              Cookies.set('api_token', result.data.api_token, { expires: 2 });
              Cookies.set('buyer-phone', $buyerPhone.val());

              if (result.data.id) {
                Cookies.set('user_id', result.data.id);
              } else {
                Cookies.set('user_id', result.data.user_id);
              }

              window.location.reload();
            } else {
              methods.renderErrors(result.response.message);
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.confirm]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
    changePhone: function () {
      $confirmation.addClass('d-none');
      $sendingSms.removeClass('d-none');
    },
    agreement: function (e) {
      const hasChecked = e.target.checked;

      if (hasChecked && Boolean($buyerPhone.val())) {
        $sendSmsBtn.removeAttr('disabled', 'disabled');
      } else {
        $sendSmsBtn.attr('disabled', 'disabled');
      }
    },
    makePhoneNumberHidden: function () {
      const buyerPhone = typeof installmentState.buyerPhone !== 'string'
        ? String(installmentState.buyerPhone)
        : installmentState.buyerPhone;

      const phoneNumberArray = buyerPhone.split('');

      phoneNumberArray.splice(5, 5, '*', '*', '*', '*', '*');

      return phoneNumberArray.join('');
    },
  };

  $(_.doc).on('click', '#installmentSendSMSBtn', methods.sendSMS);
  $(_.doc).on('click', '#installmentConfirmCodeBtn', methods.confirmCode);
  $changePhoneBtn.on('click', methods.changePhone);
  $agreementCheckbox.on('change', methods.agreement);
  $resendSms.on('click', methods.sendSMS);

  $userPhoneSmsSent.text(methods.makePhoneNumberHidden);

  $buyerPhone.inputmask('998 [99 999-99-99]', {
    placeholder: '998 ** ***-**-**',
  });

})(Tygh, Tygh.$);
/*
$(document).on('click', '#installmentSendSMSBtn', function () {
  console.log('asdasd');
});*/
