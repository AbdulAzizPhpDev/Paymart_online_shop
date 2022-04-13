(function (_, $) {
  const $uploadBtn = $('#upload-passport-photos-btn');
  const $passportFirstPage = $('#passport_first_page');
  const $passportSecondPage = $('#passport_second_page');
  const $passportAddress = $('#passport_with_address');
  const $passportSelfie = $('#passport_selfie');

  const $errorContainer = $('.error-passport-installment');

  const passportState = {
    files: {},
  };

  const passportMethods = {
    renderErrors: function (errors) {
      if (typeof errors !== 'string') {
        return $errorContainer.text(errors);
      }

      errors.forEach(error => {
        if (error.hasOwnProperty('text')) {
          $errorContainer.text(error.text);
        } else {
          let errorText = '';
          errorText += error + '<br>';
          $errorContainer.append(errorText);
        }
      });
    },
    chooseFiles: function (event) {
      const { updateFiles } = passportMethods;
      const files = event.target.files;
      const name = event.target.id;

      if (files.length === 0) {
        return console.error(`el: ${event.target.id} files empty`);
      }

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
        && passportState.files.hasOwnProperty('passport_second_page')
        && passportState.files.hasOwnProperty('passport_with_address')
        && passportState.files.hasOwnProperty('passport_selfie');

      if (!isValid) {
        return passportMethods.renderErrors('Fields are valid');
      }

      const formData = new FormData();

      Object.entries(passportState.files).forEach(([name, file]) => {
        formData.append(name, file);
      });

      formData.append('step', '2');
      // formData.append('passport_type', '0');
      formData.append('security_hash', _.security_hash);
      formData.append('is_ajax', '1');

      $.ajax({
        url: fn_url('installment_product.set_passport_id'),
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
          $uploadBtn.attr('disabled', 'disabled');
        },
        success: function (response) {
          if (!response.hasOwnProperty('result')) {
            return console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }

          if (response.result.status === 'error') {
            return passportMethods.renderErrors(result.response.message);
          }

          window.location.href = fn_url('installment_product.guarant');
        },
        error: function (error) {
          passportMethods.renderErrors('Server Error');
        },
        complete: function () {
          $uploadBtn.removeAttr('disabled');
        },
      });
    },
  };

  $passportFirstPage.on('change', passportMethods.chooseFiles);
  $passportSecondPage.on('change', passportMethods.chooseFiles);
  $passportAddress.on('change', passportMethods.chooseFiles);
  $passportSelfie.on('change', passportMethods.chooseFiles);

  $uploadBtn.on('click', passportMethods.upload);
})(Tygh, Tygh.$);