(function (_, $) {
  const $firstPersonName = $('#first-guarant-name');
  const $firstPersonPhone = $('#first-guarant-phone');

  const $secondPersonName = $('#second-guarant-name');
  const $secondPersonPhone = $('#second-guarant-phone');

  const $errorContainer = $('.error-guarant-installment');

  const $addGuarantBtn = $('#add-guarant-btn');

  const guarantState = {
    api_token: Cookies.get('api_token'),
    baseUrl: 'https://dev.paymart.uz/api/v1',
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

      if (isValid) {
        $.ajax({
          url: `${guarantState.baseUrl}/buyer/add-guarant`,
          type: 'POST',
          data: {
            name: $firstPersonName.val(),
            phone: $firstPersonPhone.val(),
            buyer_id: guarantState.user_id,
          },
          headers: {
            Authorization: `Bearer ${guarantState.api_token}`,
          },
          success: function (response) {
            const { data: result } = response;

            if (response) {
              if (result.status === 'success') {
                $.ajax({
                  url: `${guarantState.baseUrl}/buyer/add-guarant`,
                  type: 'POST',
                  data: {
                    name: $secondPersonName.val(),
                    phone: $secondPersonPhone.val(),
                    buyer_id: guarantState.user_id,
                  },
                  headers: {
                    Authorization: `Bearer ${guarantState.api_token}`,
                  },
                  success: function (response) {
                    const { data: result } = response;

                    if (response) {
                      if (result.status === 'success') {
                        guarantMethods.makeRoute({ action: 'await' });
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
                });
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
        });
      } else {
        guarantMethods.renderErrors('Fields are valid');
      }
    },
  };

  $addGuarantBtn.on('click', guarantMethods.confirm);
})(Tygh, Tygh.$);