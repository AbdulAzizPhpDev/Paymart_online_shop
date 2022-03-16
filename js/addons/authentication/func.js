(function (_, $) {
  const $form = $('#auth-form');
  const $errorContainer = $('.ty-error-text');
  const $phoneContainer = $('.phone-container');
  const $codeContainer = $('.code-container');
  const $userPhoneSmsSent = $('.user-auth-phone-sms-sent');

  const $buyerPhone = $('#buyer-phone');
  const $code = $('.auth-confirmation-code');

  const authState = {
    userPhoneNumber: '99899*****99'
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
              $userPhoneSmsSent.text(authMethods.makePhoneNumberHidden);
            } else {
              authMethods.showErrors(result.response.message);
            }

          } else {
            document.write(response.text)
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
            document.write(response.text)
          }
        },
      });
    },
  };

  $form.on('submit', authMethods.submit);

  $buyerPhone.inputmask('999 99 999-99-99', { placeholder: '*' });

  // $(_.doc).on('click', '#sendSMSBtn', methods.sendSMS);

  // $(_.doc).on('click', '#confirmCodeBtn', methods.confirmCode);

})(Tygh, Tygh.$);

