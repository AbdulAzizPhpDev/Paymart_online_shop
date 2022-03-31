(function (_, $) {
  const $lottie = $('.lottie-player');
  const $awaitBtn = $('#await-btn');

  const $errorContainer = $('.error-await-installment');

  const awaitState = {
    baseUrl: 'https://test.paymart.uz/api/v1',
    api_token: $('.user-api-token').val(),
  };

  const awaitMethods = {
    renderErrors: function (errors) {
      if (typeof errors === 'string') {
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
    checkStatus: function () {
      const { baseUrl, api_token } = awaitState;

      $.ajax({
        url: `${baseUrl}/buyer/check_status`,
        type: 'GET',
        headers: {
          Authorization: `Bearer ${api_token}`,
        },
        success: function (response) {
          if (!response) {
            return console.error('Result does not exist. %cmethod[/buyer/check_status] P.S. await-page', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }

          if (response.status === 'error') {
            return awaitMethods.renderErrors(response.response.message);
          }

          if (Number(response.data.status) !== 2) {
            window.location.reload();
          }
        },
      });
    },
  };

  $awaitBtn.on('click', awaitMethods.checkStatus);
  $lottie.attr('src', '/design/themes/responsive/media/json/waiting.json');
})(Tygh, Tygh.$);