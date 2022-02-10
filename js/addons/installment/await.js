(function (_, $) {
  const $lottie = $('.lottie-player');
  const $awaitBtn = $('#await-btn');

  const $errorContainer = $('.error-await-installment');

  const awaitState = {
    baseUrl: 'https://dev.paymart.uz/api/v1',
    api_token: Cookies.get('api_token'),
    buyerPhone: Cookies.get('buyer-phone'),
    userStatus: 0,
  };

  const awaitMethods = {
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
    checkStatus: function () {
      const { baseUrl, api_token } = awaitState;

      $.ajax({
        url: `${baseUrl}/buyer/check_status`,
        type: 'GET',
        headers: {
          Authorization: `Bearer ${api_token}`,
        },
        success: function (response) {
          if (response) {
            if (response.status === 'success') {
              if (Number(response.data.status) !== 2) {
                window.location.reload();
              }
            } else {
              awaitMethods.renderErrors(response.response.message)
            }
          } else {
            console.error('Result does not exist. %cmethod[/buyer/check_status] P.S. await-page', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        },
      });
    },
  };

  $awaitBtn.on('click', awaitMethods.checkStatus);
  $lottie.attr('src', '/design/themes/responsive/media/json/waiting.json');
})(Tygh, Tygh.$);