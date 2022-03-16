(function (_, $) {
  const $vendorForm = $('.vendor-login-from');
  const $errorContainer = $('.error-vendor-login');
  const $bitrixContainer = $('#bitrixForm');

  const vendorAuthState = {};

  const vendorAuthMethods = {
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
    bitrixFormAppend: function () {
      const scriptTag = document.createElement('script');

      scriptTag.setAttribute('data-b24-form', 'click/4/143zah');
      scriptTag.setAttribute('data-skip-moving', 'true');
      scriptTag.innerHTML = `
        (function (w, d, u) {
          var s = d.createElement('script');
          s.async = true;
          s.src = u + '?' + (Date.now() / 180000 | 0);
          var h = d.getElementsByTagName('script')[0];
          h.parentNode.insertBefore(s, h);
        })(window, document, 'https://cdn-ru.bitrix24.ru/b17065524/crm/form/loader_4.js')
      `;

      return scriptTag;
    },
    submit: function (event) {
      event.preventDefault();
      $errorContainer.text('');
      const values = {};

      $.each($(this).serializeArray(), function (i, field) {
        values[field.name] = field.value;
      });

      const vendor_id = values['id'];
      const vendor_password = values['password'];

      if (Boolean(vendor_id) && Boolean(vendor_password)) {
        $.ceAjax('request', fn_url(event.target.action), {
          method: 'POST',
          data: {
            id: vendor_id,
            password: vendor_password,
          },
          callback: function (response) {
            if (response.result) {
              const { result } = response;

              if (result.status === 'success') {
                if (result.url) {
                  window.location.href = result.url;
                }
              }

              if (result.status === 'error') {
                if (result.response.errors.hasOwnProperty('partner_id')) {
                  vendorAuthMethods.renderErrors(result.response.errors.partner_id);
                } else {
                  vendorAuthMethods.renderErrors(result.response.message);
                }
              }
            } else {
              document.write(response.text);
            }
          },
        });
      } else {
        vendorAuthMethods.renderErrors('Fields are valid');
      }
    },
  };

  // $('vendor_id').func({
  //
  // });

  $vendorForm.on('submit', vendorAuthMethods.submit);
  $bitrixContainer.prepend(vendorAuthMethods.bitrixFormAppend);
})(Tygh, Tygh.$);