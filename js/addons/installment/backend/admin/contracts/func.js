(function (_, $) {
  const $cancelContractBtn = $('.cancel-contract');
  const $confirmCancel = $('.confirm-cancel-contract');
  const $code = $('#cancel-contract-code');
  const $modal = $('.cancel-contract-modal');
  const $errorContainer = $('.cancel-contract-error');
  const $tabs = $('.order-status-tabs span');

  const adminContractsState = {
    contract_id: null,
  };

  const adminContractsMethods = {
    cancelContractModalShow: function (event) {
      adminContractsState.contract_id = $(this).data('contract-id');
      console.log('Sending confirmation SMS to user');
      $modal.modal('show');
    },
    cancelContract: function () {
      const isValid = Boolean($code.val());

      if (!isValid) {
        return $errorContainer.text('field is empty');
      }

      console.log('code: ' + $code.val());
      console.log('cancelled contract with id: ' + adminContractsState.contract_id);

      $modal.modal('hide');
    },
    onChangeTabs: function () {
      const $this = $(this);
      const status = String($this.data('status'));

      if (status === 'undefined') {
        return window.location.href = fn_url('installment_orders.index');
      }

      window.location.href = fn_url('installment_orders.index') + `&status=${status}`;
    },
  };

  $confirmCancel.on('click', adminContractsMethods.cancelContract);
  $cancelContractBtn.on('click', adminContractsMethods.cancelContractModalShow);
  $('.close-cancel-contract-modal').on('click', function () {
    $modal.modal('hide');
  });
  $.each($tabs, function (tab) {
    $(this).on('click', adminContractsMethods.onChangeTabs);
  });

})(Tygh, Tygh.$);