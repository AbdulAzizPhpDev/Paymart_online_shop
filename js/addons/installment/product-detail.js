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
    calculate: function (price = 1000, month = 3) {
      const formattedPrice = Number(price);
      const formattedMonth = Number(month);
      let result;

      switch (formattedMonth) {
        case 3:
          result = formattedPrice + (formattedPrice / 100) * 11;
          break;
        case 6:
          result = formattedPrice + (formattedPrice / 100) * 22;
          break;
        case 9:
          result = formattedPrice + (formattedPrice / 100) * 33;
          break;
        case 12:
          result = formattedPrice + (formattedPrice / 100) * 38;
          break;
      }

      return Math.round(result);
    },
    perMonth: function (price = 1000, month = 3) {
      return Math.round(productDetailMethods.calculate(price, month) / month);
    },
    showProductInstallmentPrice: function (price = 0) {
      const { product } = productDetailState;
      const { perMonth } = productDetailMethods;
      const $installmentProductPriceContainer = $('.installment-product-monthly-payment');

      let priceLabel;

      if (price !== 0) {
        priceLabel = `Рассрочка ${price} UZS мес.`;
        return $installmentProductPriceContainer.text(priceLabel);
      }

      price = `Рассрочка ${perMonth(product.price, 12)} UZS мес.`;

      $installmentProductPriceContainer.text(price);
    },
    onPeriodPicked: function (event) {
      const { perMonth, showProductInstallmentPrice } = productDetailMethods;
      const { product } = productDetailState;
      const pricePerMonth = perMonth(product.price, event.target.value);

      showProductInstallmentPrice(pricePerMonth);
    },
    radioHandler: function () {
      const $radios = $('.installment-periods input[type="radio"]');

      $.each($radios, function (index, radio) {
        $(radio).on('change', productDetailMethods.onPeriodPicked);
      });
    },
  };

  productDetailMethods.showProductInstallmentPrice();
  productDetailMethods.radioHandler();

  $installmentButton.on('click', productDetailMethods.setSessionProductQtyAndPeriod);

  $.ceEvent('on', 'ce.ajaxdone', function (response_data) {
    productDetailMethods.showProductInstallmentPrice();
    productDetailMethods.radioHandler();
  });

})(Tygh, Tygh.$);