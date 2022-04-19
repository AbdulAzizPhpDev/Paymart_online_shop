(function (_, $) {
  const bundleId = $('.installment-bundle-id').val();
  const discountedPrice = $('.bundle-discounted-price').val();
  const $installmentBundleBtn = $('.installment-bundle-btn');

  const productBundleMethods = {
    buyInstallment: function () {
      $.ceAjax('request', fn_url('installment_product.bundle_products'), {
        method: 'POST',
        data: {
          bundle_id: bundleId,
          total_price: discountedPrice,
        },
        callback: function (response) {

          console.log(response);

          // window.location.href = fn_url('installment_product.index');
        },
      });
    },
  };

  $installmentBundleBtn.on('click', productBundleMethods.buyInstallment);
})(Tygh, Tygh.$);