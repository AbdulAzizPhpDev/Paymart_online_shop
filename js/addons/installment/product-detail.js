(function (_, $) {

  const $installmentButton = $('.set_qty');

  const productDetailState = {
    PAYMART_API_BASE_URL: 'https://test.paymart.uz/api/v1/',
    company_id: $('.company-id-for-calculate-price').val(),
    // company_id: 215049,
    product: {
      id: $('.product-id-for-calculate').val(),
      name: $('.product-name-for-calculate').val(),
      price: $('.product-price-for-calculate-price').val(),
      qty: $('.cm-amount').val() || 1,
    },
    vendor_token: $('.vendor-token').val(),
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
    getProductPrice: function (price = 0, period = 12) {
      const { company_id, product, PAYMART_API_BASE_URL, vendor_token } = productDetailState;
      const { printPricePretty } = productDetailMethods;
      const $installmentProductPriceContainer = $('.installment-product-monthly-payment');

      let formattedProducts = {};
      formattedProducts[company_id] = [
        {
          price: price === 0 ? product.price : price,
          amount: product.qty,
          name: product.name,
        },
      ];

      $.ajax({
        url: PAYMART_API_BASE_URL + 'order/marketplace-calculate',
        method: 'POST',
        data: {
          type: 'credit',
          period,
          products: formattedProducts,
          partner_id: company_id,
        },
        headers: {
          Authorization: `Bearer ${vendor_token}`,
        },
        success: function (response) {
          if (response) {
            if (response.status === 'success') {
              const { data: result } = response;
              let priceLabel;
              priceLabel = `${printPricePretty(result.price.month)} UZS / мес.`;

              $installmentProductPriceContainer.text(priceLabel);

            } else {
              console.log(response.response.message);
            }

          } else {
            console.error('method [order/marketplace-calculate] don\'t work');
          }
        },
      });
    },
    /*calculate: function (price = 1000, month = 3) {
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

      return $installmentProductPriceContainer.text(price);
    },*/
    onPeriodPicked: function (event) {
      /*const pricePerMonth = perMonth(product.price, event.target.value);
      showProductInstallmentPrice(pricePerMonth);*/

      const { getProductPrice } = productDetailMethods;
      const { product } = productDetailState;

      getProductPrice(product.price, event.target.value);
    },
    radioHandler: function () {
      const $radios = $('.installment-periods input[type="radio"]');

      $.each($radios, function (index, radio) {
        $(radio).on('change', productDetailMethods.onPeriodPicked);
      });
    },
    redirectVendor: function () {
      const params = new URLSearchParams(document.location.search);
      const vendor_id = params.get('vendor_id');

      if (Number(vendor_id) === 0) {
        const $vendorLinks = $('.ty-sellers-list__price-link');

        if ($vendorLinks.length > 0) {
          $vendorLinks[0].click();
        }
      }
    },
    printPricePretty: function (price = 0) {
      return Intl.NumberFormat().format(price)
    },
  };

  productDetailMethods.getProductPrice();
  productDetailMethods.radioHandler();
  productDetailMethods.redirectVendor();

  $installmentButton.on('click', productDetailMethods.setSessionProductQtyAndPeriod);

  $.ceEvent('on', 'ce.ajaxdone', function (response_data) {
    const $installmentButton = $('.set_qty');
    let { product } = productDetailState;
    const { radioHandler, getProductPrice, getInstallmentPeriod } = productDetailMethods;

    const period = getInstallmentPeriod();
    const updatedPrice = $(`#sec_discounted_price_${product.id}`).text().replace(/(\u00a0)|( )/g, '');

    if (updatedPrice) {
      product.price = updatedPrice;
      $installmentButton.on('click', productDetailMethods.setSessionProductQtyAndPeriod);

      return getProductPrice(product.price, period);
    }

    product.id = $('.product-id-for-calculate').val();
    product.name = $('.product-name-for-calculate').val();
    product.price = $('.product-price-for-calculate-price').val();
    product.qty = $('.cm-amount').val();

    getProductPrice();
    radioHandler();
    $installmentButton.on('click', productDetailMethods.setSessionProductQtyAndPeriod);

    /*let { product } = productDetailState;
    const updatedPrice = $(`#sec_discounted_price_${product.id}`).text().replace(/(&nbsp;)|( )/g, '');

    if (updatedPrice) {
      // product.price = Number(updatedPrice);
      const period = getInstallmentPeriod();
      const text = perMonth(updatedPrice, period);

      return showProductInstallmentPrice(text);
    } else {
      product.id = $('.product-id-for-calculate').val();
      product.name = $('.product-name-for-calculate').val();
      product.price = $('.product-price-for-calculate-price').val();
      product.qty = $('.cm-amount').val();
      showProductInstallmentPrice();
      radioHandler();
    }*/
  });

})(Tygh, Tygh.$);