(function (_, $) {
  const id = $('.form-id').val();
  const $form = $(`#auth-form-${id}`);
  const $beforeCheckoutForm = $('#auth-form-auth_login');
  const $errorContainer = $('.ty-error-text');
  const $phoneContainer = $('.phone-container');
  const $codeContainer = $('.code-container');

  let $userPhoneSmsSent = $('.user-auth-phone-sms-sent');
  const $changePhoneNumberBtn = $('.auth-change-phone-number');

  let $timerSlot = $('.phone-timer');
  let $resendSms = $('.resend-sms-phone');

  const $buyerPhone = $('#buyer-phone');
  const $code = $('.auth-confirmation-code');

  const authState = {
    userPhoneNumber: '99899*****99',
    interval: null,
    timer: 60,
    phone: null,
    code: null,
  };

  const authMethods = {
    showErrors: function (error) {
      if (!Array.isArray(error)) {
        return $errorContainer.text(error);
      }

      error.forEach(({ text }) => {
        $errorContainer.text(text);
      });
    },
    makePhoneNumberHidden: function () {
      const { userPhoneNumber } = authState;
      const buyerPhone = typeof userPhoneNumber !== 'string'
        ? String(userPhoneNumber)
        : userPhoneNumber;

      const phoneNumberArray = buyerPhone.split('');

      phoneNumberArray.splice(5, 5, '*', '*', '*', '*', '*');

      return phoneNumberArray.join('');
    },
    changePhoneNumber: function () {
      $form.attr('action', fn_url('profiles.send_sms'));
      $codeContainer.addClass('d-none');
      $phoneContainer.removeClass('d-none');
      $userPhoneSmsSent.text('');
      $timerSlot.text('60');
      $buyerPhone.val('998');
      // clearInterval(authState.interval);
    },
    timerResendSms: function () {
      let { interval, timer } = authState;
      interval = setInterval(() => {
        timer -= 1;
        $timerSlot.text(timer);

        if (timer === 0 || $codeContainer.hasClass('d-none')) {
          clearInterval(interval);
          $resendSms.addClass('active');
          $resendSms.css('pointer-events', 'auto');
        }
      }, 1000);
    },
    submit: function (event) {
      event.preventDefault();
      const { sendSMS, confirmCode } = authMethods;

      const action = event.target.action;

      if (action === fn_url('profiles.send_sms')) {
        sendSMS();
      } else {
        confirmCode();
      }
    },
    sendSMS: function (phone = null) {
      $resendSms.removeClass('active');
      const unmaskedPhoneNumber = Inputmask.unmask($buyerPhone.val(), { mask: '999 ## ###-##-##' });
      authState.userPhoneNumber = phone || unmaskedPhoneNumber;

      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: phone || unmaskedPhoneNumber,
        },
        callback: function (response) {
          if (response.hasOwnProperty('result')) {
            const { result } = response;

            if (result.status === 'success') {
              $form.removeAttr('action');
              $codeContainer.removeClass('d-none');
              $phoneContainer.addClass('d-none');
              $resendSms.css('pointer-events', 'none');
              authMethods.timerResendSms();
              $userPhoneSmsSent.text(authMethods.makePhoneNumberHidden);
            } else {
              authMethods.showErrors(result.response.message);
            }

          } else {
            document.write(response.text);
          }
        },
      });
    },
    confirmCode: function (phone = null, code = null, redirectUrl = '') {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: phone || Inputmask.unmask($buyerPhone.val(), { mask: '999 ## ###-##-##' }),
          code: code || $code.val(),
        },
        callback: function (response) {
          if (response && response.hasOwnProperty('result')) {
            const { result } = response;

            if (result.status === 'success') {

              if (redirectUrl !== '') {
                window.location.href = redirectUrl;
                return false;
              }

              window.location.reload();
            } else {
              authMethods.showErrors(result.response.message);
            }
          } else {
            document.write(response.text);
          }
        },
      });
    },
  };

  $form.on('submit', authMethods.submit);
  $beforeCheckoutForm.on('submit', authMethods.submit);

  $.mask.definitions['#'] = $.mask.definitions['9'];
  delete $.mask.definitions['9'];

  $buyerPhone.mask('998 ## ###-##-##', {
    placeholder: '*',
  });

  // before checkout auth form
  $.ceEvent('on', 'ce.ajaxdone', function (elms, inline_scripts, params) {
    for (let i in elms) {
      const form_id = elms[i].find('.form-id').val();
      const $formCheckout = elms[i].find(`form#auth-form-${form_id}`);
      const $buyerPhone = $formCheckout.find('input#buyer-phone');
      $resendSms = $formCheckout.find('.resend-sms-phone').remove();

      $buyerPhone.mask('998 ## ###-##-##', {
        placeholder: '*',
      });

      $formCheckout.on('submit', function (e) {
        e.preventDefault();
        const { sendSMS, confirmCode } = authMethods;

        const action = e.target.action;

        const $codeInput = $(this).find('input.auth-confirmation-code');
        const $codeContainer = $(this).find('.code-container');
        const $phoneContainer = $(this).find('.phone-container');
        $userPhoneSmsSent = $(this).find('.user-auth-phone-sms-sent');
        $timerSlot = $(this).find('.phone-timer');

        const code = $codeInput.val();
        const unmaskedBuyerPhone = Inputmask.unmask($buyerPhone.val(), { mask: '999 ## ###-##-##' });


        $(this).find('.auth-change-phone-number').remove();

        if (action === fn_url('profiles.send_sms')) {
          if (!unmaskedBuyerPhone) {
            return alert('Введите номер телефона.');
          }

          sendSMS(unmaskedBuyerPhone);

          $(this).removeAttr('action');

          $codeContainer.removeClass('d-none');
          $phoneContainer.addClass('d-none');
          $codeInput.attr('type', 'number');
          $codeInput.attr('maxlength', 4);
        } else {

          if (!code) {
            return alert('Введите SMS код пожалуйста.');
          }

          confirmCode(unmaskedBuyerPhone, code, '/checkout');
        }
      });
    }

  });

  $changePhoneNumberBtn.on('click', authMethods.changePhoneNumber);
  $resendSms.on('click', authMethods.sendSMS);

})(Tygh, Tygh.$);



