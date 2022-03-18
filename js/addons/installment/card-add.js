(function (_, $) {
  const $cardNumberContainer = $('.card-info');
  const $cardNumber = $('.buyer-card-installment');
  const $cardNumber2 = $('.buyer-card-installment').focus();

  const $cardExpContainer = $('.card-confirm');
  const $cardExp = $('.buyer-card-exp-installment');
  const $cardConfirmCode = $('.buyer-card-code-installment');
  const $cardPin = $('#card-pin-wrapper');

  const $errorContainer = $('.error-card-installment');

  const $sentPhoneNumber = $('.sent-phone-number');
  const $timerSlot = $('.card-resend-sms-timer');
  const $resendCardSms = $('.resend-sms-card');
  const $sendBtn = $('#installmentSendSMSCardBtn');

  const cardState = {
    baseUrl: 'https://test.paymart.uz/api/v1',
    api_token: Cookies.get('api_token'),
    buyerPhone: Cookies.get('buyer-phone') || 998999000009,
    timer: 60,
    interval: null,
  };

  const cardMethods = {
    makeRoute({ controller = 'installment_product', action = 'index' }) {
      return window.location.href = `http://market.paymart.uz/index.php?dispatch=${controller}.${action}`;
    },
    renderErrors: function (errors) {
      if (typeof errors !== 'string') {
        errors.forEach(error => {
          if (error.hasOwnProperty('text')) {
            $errorContainer.text(error.text);
          } else {
            let errorText = '';
            errorText += error + '<br>';
            $errorContainer.append(errorText);
          }
        });
      } else {
        $errorContainer.text(errors);
      }
    },
    timerResendSms: function () {
      let { interval, timer } = cardState;
      interval = setInterval(() => {
        $resendCardSms.removeClass('active');
        timer -= 1;
        $timerSlot.text(timer);

        if (timer === 0) {
          clearInterval(interval);
          $resendCardSms.addClass('active');
        }
      }, 1000);
    },
    makePhoneNumberHidden: function () {
      const buyerPhone = typeof cardState.buyerPhone !== 'string'
        ? String(cardState.buyerPhone)
        : cardState.buyerPhone;

      const phoneNumberArray = buyerPhone.split('');
      phoneNumberArray.splice(5, 5, '*', '*', '*', '*', '*');

      return phoneNumberArray.join('');
    },
    fieldsValidation: function () {
      const cardNumberUnmasked = $cardNumber.inputmask('unmaskedvalue');
      const cardExpUnmasked = $cardExp.inputmask('unmaskedvalue');

      return cardNumberUnmasked.length >= 16 && cardExpUnmasked.length >= 4;
    },
    onChangeInput: function (event) {
      if (!cardMethods.fieldsValidation()) {
        $sendBtn.attr('disabled', 'disabled');
      } else {
        $sendBtn.removeAttr('disabled');
      }
    },
    sendSMS: function () {
      $errorContainer.text('');
      const isValid = cardMethods.fieldsValidation();
      const cardNumberUnmasked = $cardNumber.inputmask('unmaskedvalue');
      const cardExpUnmasked = $cardExp.inputmask('unmaskedvalue');

      if (isValid) {
        $.ceAjax('request', fn_url('installment_product.set_card'), {
          method: 'POST',
          data: {
            card: cardNumberUnmasked,
            exp: cardExpUnmasked,
          },
          callback: function (response) {
            if (response) {
              const { result } = response;

              if (result.status === 'success') {
                $cardNumberContainer.addClass('d-none');
                cardMethods.timerResendSms();

                $cardExpContainer.removeClass('d-none');
                $cardPin.removeClass('d-none');

              } else {
                if (result.hasOwnProperty('info')) {
                  if (result.info === 'error_card_equal') {
                    cardMethods.renderErrors([
                      result.info,
                      result.card_data?.card_owner,
                      result.card_data?.card_phone,
                      result.card_data.total_debt,
                    ]);
                  } else {
                    cardMethods.renderErrors(result.info);
                  }
                } else {
                  cardMethods.renderErrors(result.status);
                }
              }
            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
        });
      } else {
        cardMethods.renderErrors('Fields are valid');
      }
    },
    confirmCode: function (event) {
      const isValid = Boolean($cardExp.val());

      const cardNumberUnmasked = $cardNumber.inputmask('unmaskedvalue');
      const cardExpUnmasked = $cardExp.inputmask('unmaskedvalue');

      if (isValid) {
        $.ceAjax('request', fn_url('installment_product.confirm_card'), {
          method: 'POST',
          data: {
            card_number: cardNumberUnmasked,
            card_valid_date: cardExpUnmasked,
            code: $cardConfirmCode.val(),
          },
          callback: function (response) {
            if (response) {
              const { result } = response;

              if (result.status === 'success') {
                window.location.reload();
                // cardMethods.makeRoute({ action: 'type-passport' });
              } else {
                cardMethods.renderErrors(result.response.message);
              }
            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
        });
      } else {
        cardMethods.renderErrors('Fields are valid');
      }
    },
  };

  $(_.doc).on('click', '#installmentSendSMSCardBtn', cardMethods.sendSMS);
  $(_.doc).on('click', '#installmentSendCardCodeBtn', cardMethods.confirmCode);

  $sentPhoneNumber.text(cardMethods.makePhoneNumberHidden);

  $resendCardSms.on('click', cardMethods.sendSMS);

  $cardNumber.on('input', cardMethods.onChangeInput);
  $cardExp.on('input', cardMethods.onChangeInput);

  $cardNumber.inputmask('9999 9999 9999 9999', { placeholder: '*' });
  $cardExp.inputmask('99/99', { placeholder: '*' });

})(Tygh, Tygh.$);
