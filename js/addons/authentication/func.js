(function (_, $) {
  const $form = $('#auth-form');
  const $errorContainer = $('.ty-error-text');
  const $phoneContainer = $('.phone-container');
  const $codeContainer = $('.code-container');
  const $userPhoneSmsSent = $('.user-auth-phone-sms-sent');
  const $changePhoneNumberBtn = $('.auth-change-phone-number');
  const $timerSlot = $('.phone-timer');
  const $resendSms = $('.resend-sms-phone');

  const $buyerPhone = $('#buyer-phone');
  const $code = $('.auth-confirmation-code');

  const authState = {
    userPhoneNumber: '99899*****99',
    interval: null,
    timer: 60,
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
    sendSMS: function () {
      $resendSms.removeClass('active');
      authState.userPhoneNumber = $buyerPhone.inputmask('unmaskedvalue');

      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: $buyerPhone.inputmask('unmaskedvalue'),
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
    confirmCode: function () {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: $buyerPhone.inputmask('unmaskedvalue'),
          code: $code.val(),
        },
        callback: function (response) {
          if (response && response.hasOwnProperty('result')) {
            const { result } = response;

            if (result.status === 'success') {
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

  $buyerPhone.inputmask('999 99 999-99-99', { placeholder: '*' });
  $changePhoneNumberBtn.on('click', authMethods.changePhoneNumber);
  $resendSms.on('click', authMethods.sendSMS);

  // $(_.doc).on('click', '#sendSMSBtn', methods.sendSMS);

  // $(_.doc).on('click', '#confirmCodeBtn', methods.confirmCode);

})(Tygh, Tygh.$);

