(function (_, $) {
  const $cardNumberContainer = $('.card-info');
  const $cardNumber = $('.buyer-card-installment');

  const $cardExpContainer = $('.card-confirm');
  const $cardExp = $('.buyer-card-exp-installment');
  const $cardConfirmCode = $('.buyer-card-code-installment');
  const $cardPin = $('#card-pin-wrapper');

  const $errorContainer = $('.error-card-installment');

  const $sentPhoneNumber = $('.sent-phone-number');
  const $timerSlot = $('.card-resend-sms-timer');
  const $resendCardSms = $('.resend-sms-card');

  const cardState = {
    baseUrl: 'https://dev.paymart.uz/api/v1',
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
    sendSMS: function () {
      $errorContainer.text('');
      const isValid = Boolean($cardNumber.val()) && $cardNumber.val().length >= 16 && Boolean($cardExp.val());

      if (isValid) {
        $.ceAjax('request', fn_url('installment_product.set_card'), {
          method: 'POST',
          data: {
            card: $cardNumber.val(),
            exp: $cardExp.val(),
          },
          callback: function (response) {
            if (response) {
              if (response.status === 'success') {
                $cardNumberContainer.addClass('d-none');
                cardMethods.timerResendSms();

                $cardExpContainer.removeClass('d-none');
                $cardPin.removeClass('d-none');

              } else {
                if (response.hasOwnProperty('info')) {
                  if (response.info === 'error_card_equal') {
                    cardMethods.renderErrors([
                      response.info,
                      response.card_data?.card_owner,
                      response.card_data?.card_phone,
                      response.card_data.total_debt,
                    ]);
                  } else {
                    cardMethods.renderErrors(response.info);
                  }
                } else {
                  cardMethods.renderErrors(response.status);
                }
              }
            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
        });

        /*$.ceAjax('request', `${cardState.baseUrl}/buyer/send-sms-code-uz`, {
          method: 'POST',
          data: {
            card: $cardNumber.val(),
            exp: $cardExp.val(),
            api_token: cardState.api_token,
          },
          callback: function callback(response) {
            const { data: result } = response;

            if (result) {
              if (result.status === 'success') {
                $cardNumberContainer.addClass('d-none');
                $cardExpContainer.removeClass('d-none');
              } else {
                cardMethods.renderErrors(result.response.message);
              }
            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
        });*/
      } else {
        cardMethods.renderErrors('Fields are valid');
      }
    },
    confirmCode: function (event) {
      const isValid = Boolean($cardExp.val());

      if (isValid) {
        $.ceAjax('request', fn_url('installment_product.confirm_card'), {
          method: 'POST',
          data: {
            card_number: $cardNumber.val(),
            card_valid_date: $cardExp.val(),
            code: $cardConfirmCode.val(),
          },
          callback: function (response) {
            const { data: result } = response;

            if (response) {
              if (result.status === 'success') {
                cardMethods.makeRoute({ action: 'type-passport' });
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
})(Tygh, Tygh.$);
