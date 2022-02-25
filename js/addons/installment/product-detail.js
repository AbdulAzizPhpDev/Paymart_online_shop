(function (_, $) {

  const $installmentButton = $('.set_qty');

  const productDetailState = {
    PAYMART_API_BASE_URL: 'https://test.paymart.uz/api/v1/',
    company_id: $('.company-id-for-calculate-price').val(),
    product: {
      id: $('.product-id-for-calculate').val(),
      name: $('.product-name-for-calculate').val(),
      price: $('.product-price-for-calculate-price').val(),
      qty: $('.cm-amount').val(),
    },
    installment_period: 12,
  };

  const productDetailMethods = {
    getInstallmentPeriod: function (period = 12) {
      const $radios = $('.installment-periods input[type="radio"]');

      $.each($radios, function (index, element) {
        if ($(element).is(':checked')) {
          period = $(this).val();
        }
      });

      return period;
    },
    setSessionProductQtyAndPeriod: function (event) {
      const qty = $('.cm-amount').val();
      const { product } = productDetailState;

      const period = productDetailMethods.getInstallmentPeriod();

      $.ceAjax('request', fn_url('installment_product.get_qty'), {
        method: 'GET',
        data: {
          qty,
          product_id: product.id,
          period,
        },
        callback: function (response) {
          if (response.result) {
            window.location.href = fn_url(response.result.redirect_to);
          } else {
            document.write(response);
          }
        },
      });
    },

    getProductPrice: function () {
      const { company_id, product, installment_period, PAYMART_API_BASE_URL } = productDetailState;

      let formattedProducts = {};
      formattedProducts[company_id] = [
        {
          price: product.price,
          amount: product.qty,
          name: product.name,
        },
      ];

      $.ceAjax('request', PAYMART_API_BASE_URL + '/order/calculate', {
        method: 'POST',
        data: {
          type: 'credit',
          period: installment_period,
          products: formattedProducts,
          partner_id: company_id,
          user_id: '',
        },
        callback: function (response) {
          console.log(response);
        },
      });
    },
  };

  $installmentButton.on('click', productDetailMethods.setSessionProductQtyAndPeriod);

})(Tygh, Tygh.$);