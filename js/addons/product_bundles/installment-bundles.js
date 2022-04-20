(function (_, $) {
  const $installmentBundleBtn = $('.installment-bundle-btn');

  const productBundleMethods = {
    buyInstallment: function () {
      const $button = $(this);
      const bundleId = $button.data('bundle-id');
      const totalPrice = $button.data('bundle-total-price');

      $.ceAjax('request', fn_url('installment_product.bundle_products'), {
        method: 'POST',
        data: {
          bundle_id: bundleId,
          total_price: totalPrice,
        },
        callback: function (response) {
          window.location.href = fn_url('installment_product.index');
        },
      });
    },
  };

  $installmentBundleBtn.on('click', productBundleMethods.buyInstallment);
})(Tygh, Tygh.$);