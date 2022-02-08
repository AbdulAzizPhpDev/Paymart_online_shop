const self = new Vue({
  delimiters: ['%%', '%%'],
  el: '#auth-form',
  data: {
    isSMSSent: false,
    hasError: false,
    errors: null,
    error: null,
    buyerPhone: null,
    buyerCode: null,
    timer: 60,
    interval: null,
  },
  methods: {
    sendSMS(event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: self.buyerPhone.replace('+', '') || null,
        },
        callback: function callback(response) {
          const { result } = response;
          if (result) {
            if (result.status === 'success') {
              self.isSMSSent = true;
              self.interval = setInterval(() => {
                if (self.timer !== 0) {
                  self.timer -= 1;
                } else {
                  clearInterval(self.interval);
                }
              }, 1000);

            } else {
              self.hasError = true;
              if (typeof result.response.message !== 'string') {
                self.errors = result.response.message;
              } else {
                self.error = result.response.message;
              }
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.send_sms]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
    resendSMS(event) {
      if (self.timer === 0) {
        self.sendSMS();
        self.timer = 60;
      } else {
        event.preventDefault();
      }
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: self.buyerPhone.replace('+', ''),
          code: self.buyerCode,
          redirect_url: $('input[name="redirect_url"]').val(),
        },
        callback: function callback(response) {
          const { result } = response;

          if (response) {
            if (result.status === 'success') {
              window.location.reload();
            } else {
              self.hasError = true;
              if (typeof result.response.message !== 'string') {
                self.errors = result.response.message;
              } else {
                self.error = result.response.message;
              }
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.confirm]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
  },
  created() {
    console.log('created auth func.js');
  },
});


const installmentAuth = new Vue({
  delimiters: ['%%', '%%'],
  el: '#login_block_installment',
  data: {
    isSMSSent: false,
    hasError: false,
    errors: null,
    error: null,
    buyerPhone: null,
    buyerCode: null,
    timer: 60,
    interval: null,
  },
  methods: {
    sendSMS(event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: installmentAuth.buyerPhone.replace('+', '') || null,
        },
        callback: function callback(response) {
          const { result } = response;
          if (result) {
            if (result.status === 'success') {
              installmentAuth.isSMSSent = true;
              installmentAuth.interval = setInterval(() => {
                if (installmentAuth.timer !== 0) {
                  installmentAuth.timer -= 1;
                } else {
                  clearInterval(installmentAuth.interval);
                }
              }, 1000);

            } else {
              installmentAuth.hasError = true;
              if (typeof result.response.message !== 'string') {
                installmentAuth.errors = result.response.message;
              } else {
                installmentAuth.error = result.response.message;
              }
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.send_sms]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
    resendSMS(event) {
      if (installmentAuth.timer === 0) {
        installmentAuth.sendSMS();
        installmentAuth.timer = 60;
      } else {
        event.preventDefault();
      }
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: installmentAuth.buyerPhone.replace('+', ''),
          code: installmentAuth.buyerCode,
          redirect_url: $('input[name="redirect_url"]').val(),
        },
        callback: function callback(response) {
          const { result } = response;

          if (response) {
            if (result.status === 'success') {
              window.location.reload();
            } else {
              installmentAuth.hasError = true;
              if (typeof result.response.message !== 'string') {
                installmentAuth.errors = result.response.message;
              } else {
                installmentAuth.error = result.response.message;
              }
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.confirm]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
  },
});

/*(function (_, $) {
  const $phone = $('#buyer-phone');
  const $phoneContainer = $('.phone');
  const $sendSMSBtn = $('#sendSMSBtn');

  const $code = $('#buyer-phone-code');
  const $codeContainer = $('.code');
  const $confirmCodeBtn = $('#confirmCodeBtn');

  const $errorContainer = $('.ty-error-text');

  const authState = {};

  const methods = {
    showErrors(errors) {
      if (!Array.isArray(errors)) {
        const p = document.createElement('p');
        p.classList.add('ty-error-text');
        p.textContent = text;
        data.$errorContainer.append(p);
      } else {
        errors.forEach(({ text }) => {
          const p = document.createElement('p');
          p.classList.add('ty-error-text');
          p.textContent = text;
          data.$errorContainer.append(p);
        });
      }
    },
    sendSMS: function (event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: $phone.val(),
        },
        callback: function callback(response) {
          const { result } = response;

          if (response) {
            if (result.status === 'success') {
              $phoneContainer.css('display', 'none');
              $sendSMSBtn.css('display', 'none');
              $codeContainer.css('display', 'block');
              $confirmCodeBtn.css('display', 'block');
            } else {
              methods.showErrors(result.response.message);
            }
          } else {
            console.error('response does not exist!');
          }
        },
      });
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: $phone.val(),
          code: $code.val(),
          redirect_url: $('input[name="redirect_url"]').val(),
        },
        callback: function callback(/!*response*!/) {
          window.location.reload();
          /!*const { result } = response;

          if (response) {
            if (result.status === 'success') {
              console.log('success');
            } else {
              methods.showErrors(result.response.message);
            }
          } else {
            console.error('response does not exist!');
          }*!/
        },
      });
    },
  };

  $(_.doc).on('click', '#sendSMSBtn', methods.sendSMS);

  $(_.doc).on('click', '#confirmCodeBtn', methods.confirmCode);

})(Tygh, Tygh.$);*/

