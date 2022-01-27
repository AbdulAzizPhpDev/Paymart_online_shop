(function (_, $) {
  const data = {
    $phone: $('#buyer-phone'),
    $phoneContainer: $('.phone'),
    $sendSMSBtn: $('#sendSMSBtn'),

    $code: $('#buyer-phone-code'),
    $codeContainer: $('.code'),
    $confirmCodeBtn: $('#confirmCodeBtn'),
    $errorContainer: $('.ty-error-text'),
  };

  const methods = {
    sendSMS: function (event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: data.$phone.val(),
        },
        callback: function callback(response) {
          const { result } = response;
          if (result.status === 'success') {
            data.$phoneContainer.css('display', 'none');
            data.$sendSMSBtn.css('display', 'none');
            data.$codeContainer.css('display', 'block');
            data.$confirmCodeBtn.css('display', 'block');
          }
        },
      });
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: data.$phone.val(),
          code: data.$code.val(),
        },
        callback: function callback(response) {
          const { result } = response;

          if (result.status === 'success') {
            console.log('success');
          } else {
            result.response.message.forEach(({ text }) => {
              const p = document.createElement('p');
              p.classList.add('ty-error-text')
              p.textContent = text;
              data.$errorContainer.append(p);
            });
          }
        },
      });
    },
  };


  $(_.doc).on('click', '#sendSMSBtn', methods.sendSMS);

  $(_.doc).on('click', '#confirmCodeBtn', methods.confirmCode);

})(Tygh, Tygh.$);

