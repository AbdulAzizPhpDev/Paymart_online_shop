(function (_, $) {
  const $uploadBtn = $('#upload-passport-photos-btn');
  const $passportFirstPage = $('#passport_first_page');
  const $passportSecondPage = $('#passport_second_page');
  const $passportAddress = $('#passport_with_address');
  const $passportSelfie = $('#passport_selfie');

  const $errorContainer = $('.error-passport-installment');

  const passportState = {
    api_token: Cookies.get('api_token'),
    baseUrl: 'https://test.paymart.uz/api/v1',
    files: {},
  };

  const passportMethods = {
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
    chooseFiles: function (event) {
      const { updateFiles } = passportMethods;
      const files = event.target.files;
      const name = event.target.id;

      if (files.length > 0) {
        switch (name) {
          case 'passport_first_page':
            updateFiles(name, files[0]);
            break;

          case 'passport_second_page':
            updateFiles(name, files[0]);
            break;

          case 'passport_with_address':
            updateFiles(name, files[0]);
            break;

          case 'passport_selfie':
            updateFiles(name, files[0]);
            break;
        }
      } else {
        console.error(`el: ${event.target.id} files empty`);
      }
    },

    updateFiles: function (name, file) {
      const preview = URL.createObjectURL(file);
      const $previewContainer = $('.' + name);

      const $image = $(`.${name} img`);
      $image.css('display', 'none');

      $previewContainer.css({
        background: `url("${preview}") center center`,
        backgroundSize: 'cover',
      });

      passportState.files[name] = file;
    },

    upload: function () {
      const isValid = passportState.files.hasOwnProperty('passport_first_page')
        && passportState.files.hasOwnProperty('passport_with_address')
        && passportState.files.hasOwnProperty('passport_selfie');

      if (isValid) {
        const formData = new FormData();

        // formData.append('api_token', passportState.api_token);

        Object.entries(passportState.files).forEach(([name, file]) => {
          formData.append(name, file);
        });

        formData.append('step', '2');
        formData.append('security_hash', _.security_hash);
        formData.append('is_ajax', '1');

        $.ajax({
          url: fn_url('installment_product.set_passport_id'),
          type: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function (response) {
            if (response) {
              const { result } = response;

              if (result.status === 'success') {
                fn_url('guarant.index');

                // passportMethods.makeRoute({ action: 'guarant' });

              } else {
                passportMethods.renderErrors(result.response.message);
              }

            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
        });
      } else {
        passportMethods.renderErrors('Fields are valid');
      }
    },
  };

  $passportFirstPage.on('change', passportMethods.chooseFiles);
  $passportSecondPage.on('change', passportMethods.chooseFiles);
  $passportAddress.on('change', passportMethods.chooseFiles);
  $passportSelfie.on('change', passportMethods.chooseFiles);

  $uploadBtn.on('click', passportMethods.upload);
})(Tygh, Tygh.$);