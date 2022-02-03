(function (_, $) {
  const $sendSmsBtn = $('#installmentSendSMSBtn');
  const $buyerPhone = $('.buyer-phone-installment');
  const $buyerPhoneContainer = $('.installment-phone-container');

  const $confirmCodeBtn = $('#installmentConfirmCodeBtn');
  const $buyerSmsCode = $('.buyer-sms-code-installment');
  const $buyerSmsCodeContainer = $('.installment-code-container');

  const $errorContainer = $('.error-installment');

  const installmentState = {
    interval: null,
    timer: 60,
    userStatus: 0,
    errors: [],
    error: null,
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
      installmentState.interval = setInterval(() => {
        if (installmentState.timer !== 0) {
          installmentState.timer -= 1;
        } else {
          clearInterval(installmentState.interval);
        }
      }, 1000);
    },
    sendSMS: function (event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: $buyerPhone.val().replace('+', '') || null,
        },
        callback: function callback(response) {
          const { result } = response;
          if (result) {
            if (result.status === 'success') {
              $buyerSmsCodeContainer.removeClass('d-none');
              $confirmCodeBtn.removeClass('d-none');

              $buyerPhoneContainer.addClass('d-none');
              $sendSmsBtn.addClass('d-none');
            } else {
              methods.renderErrors(result.response.message);
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.send_sms]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
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
          const { result } = response;

          if (response) {
            if (result.status === 'success') {
              installmentState.userStatus = result.data.user_status;
              Cookies.set('api_token', result.data.api_token, { expires: 2 });
              Cookies.set('buyer-phone', $buyerPhone.val());

              if (result.data.id) {
                Cookies.set('user_id', result.data.id);
              } else {
                Cookies.set('user_id', result.data.user_id);
              }

              switch (installmentState.userStatus) {
                case 0:
                  methods.makeRoute({ action: 'index' });
                  break;
                case 1:
                  methods.makeRoute({ action: 'card-add' });
                  break;
                case 2 || 6:
                  methods.makeRoute({ action: 'await' });
                  break;
                case 4:
                  methods.makeRoute({ action: 'contract-create' });
                  break;
                case 5 || 10 || 11:
                  methods.makeRoute({ action: 'type-passport' });
                  break;
                case 12:
                  methods.makeRoute({ action: 'guarant' });
                  break;
                case 8:
                  methods.makeRoute({ action: 'refusal' });
                  break;
                default:
                  methods.makeRoute({ action: 'index' });
                  break;
              }
            } else {
              methods.renderErrors(result.response.message);
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.confirm]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
  };

  $(_.doc).on('click', '#installmentSendSMSBtn', methods.sendSMS);
  $(_.doc).on('click', '#installmentConfirmCodeBtn', methods.confirmCode);
})(Tygh, Tygh.$);
/*
$(document).on('click', '#installmentSendSMSBtn', function () {
  console.log('asdasd');
});*/
