import { fn_url } from '../../core/src/core/utils';

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
      $.ceAjax('request', fn_url('installment_product.check_status'), {
        method: 'POST',
        callback: function (response) {
          console.log(response);
          /*if (response) {
            if (response.status === 'success') {
              switch (response.data.status) {
                case 0:
                  awaitMethods.makeRoute({ action: 'index' });
                  break;
                case 1:
                  awaitMethods.makeRoute({ action: 'card-add' });
                  break;
                case 2:
                case 6:
                  awaitMethods.makeRoute({ action: 'await' });
                  break;
                case 4:
                  awaitMethods.makeRoute({ action: 'contract-create' });
                  break;
                case 5:
                case 10:
                case 11:
                  awaitMethods.makeRoute({ action: 'type-passport' });
                  break;
                case 12:
                  awaitMethods.makeRoute({ action: 'guarant' });
                  break;
                case 8:
                  awaitMethods.makeRoute({ action: 'refusal' });
                  break;
                default:
                  console.error('User status not responded' + response.data.status);
                  break;
              }
            } else {
              awaitMethods.renderErrors(response.response.message);
            }
          } else {
            console.error('Result does not exist. %cmethod[/buyer/detail] P.S. await-page', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }*/
        },
      });
    },
  };

  $awaitBtn.on('click', awaitMethods.checkStatus);
  $lottie.attr('src', '/design/themes/responsive/media/json/waiting.json');
})(Tygh, Tygh.$);