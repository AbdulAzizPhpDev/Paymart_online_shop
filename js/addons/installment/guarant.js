(function (_, $) {
  const $firstPersonName = $('#first-guarant-name');
  const $firstPersonPhone = $('#first-guarant-phone');

  const $secondPersonName = $('#second-guarant-name');
  const $secondPersonPhone = $('#second-guarant-phone');

  const $errorContainer = $('.error-guarant-installment');

  const $addGuarantBtn = $('#add-guarant-btn');

  const guarantState = {
    api_token: Cookies.get('api_token'),
    baseUrl: 'https://test.paymart.uz/api/v1',
    user_id: Cookies.get('user_id') || 23455,
  };

  const guarantMethods = {
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
    fieldsIsValid() {
      return Boolean($firstPersonName.val())
        && Boolean($firstPersonPhone.val())
        && Boolean($secondPersonName.val())
        && Boolean($secondPersonPhone.val());
    },
    confirm: function (event) {
      const isValid = guarantMethods.fieldsIsValid();
      const $this = $(event.target);

      if (isValid) {
        $errorContainer.text('');
        $.ajax({
          url: fn_url('installment_product.set_guarantee'),
          type: 'POST',
          data: {
            guarantees: [
              {
                name: $firstPersonName.val(),
                phone: $firstPersonPhone.val().replace(/[ -]/g, ''),
              },
              {
                name: $secondPersonName.val(),
                phone: $secondPersonPhone.val().replace(/[ -]/g, ''),
              },
            ],
            is_ajax: 1,
            security_hash: _.security_hash
          },
          beforeSend: function () {
            $this.attr('disabled', 'disabled');
          },
          success: function (response) {
            console.log(response);
            if (response.result) {
              const { result } = response;

              if (result.status === 'success') {
                window.location.reload();
              } else {
                guarantMethods.renderErrors(result.response.message);
              }
            } else {
              console.error('Result does not exist. %cmethod[/buyer/send-sms-code-uz]', 'color: white; padding: 2px 5px; border: 1px dashed green');
            }
          },
          error: function (error) {
            guarantMethods.renderErrors('Server Error');
          },
          complete: function () {
            $this.removeAttr('disabled');
          },
        });
      } else {
        guarantMethods.renderErrors('Fields are valid');
      }
    },
  };

  $addGuarantBtn.on('click', guarantMethods.confirm);
  $firstPersonPhone.inputmask('[999 99 999-99-99]', {
    placeholder: '*',
  });
  $secondPersonPhone.inputmask('[999 99 999-99-99]', {
    placeholder: '*',
  });
})(Tygh, Tygh.$);