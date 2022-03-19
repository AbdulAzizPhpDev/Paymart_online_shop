(function (_, $) {
  const $cancelContractBtn = $('.cancel-contract');
  const $confirmCancel = $('.confirm-cancel-contract');
  // const $code = $('#cancel-contract-code');
  const $modal = $('.cancel-contract-modal');
  const $errorContainer = $('.cancel-contract-error');
  const $tabs = $('.order-status-tabs span');

  const params = new URLSearchParams(document.location.search);
  const pageNumber = params.get('page');
  const $paginationContainer = $('.pagination-contracts');

  const adminContractsState = {
    order_id: null,
    buyer_phone: null,
    PAYMART_API_BASE_URL: 'https://test.paymart.uz/api/v1/',
    page: pageNumber,
    status: null,
  };

  const adminContractsMethods = {
    cancelContractModalShow: function (event) {
      adminContractsState.order_id = $(this).data('contract-id');
      adminContractsState.buyer_phone = $(this).data('buyer_phone');
      console.log('Sending confirmation SMS to user');
      $modal.modal('show');
    },
    cancelContract: function () {
      // const isValid = Boolean($code.val());

      // if (!isValid) {
      //   return $errorContainer.text('field is empty');
      // }

      $.ajax({
        url: adminContractsState.PAYMART_API_BASE_URL + 'buyers/credit/cancel',
        type: 'POST',
        data: {
          contract_id: adminContractsState.order_id,
          buyer_phone: adminContractsState.buyer_phone,
          api_token: '',
        },
        success: function (response) {

        },
        error: function (error) {

        },
      });

      // console.log('code: ' + $code.val());
      console.log('cancelled contract with id: ' + adminContractsState.order_id);

      $modal.modal('hide');
    },
    onChangeTabs: function () {
      const status = $(this).data('status');
      const params = new URLSearchParams(document.location.search);
      const controller = params.get('dispatch');

      if (status === undefined) {
        adminContractsState.status = String(status);
        if (controller === 'installment_orders.vendor') {
          return window.location.href = fn_url('installment_orders.vendor');
        }
        return window.location.href = fn_url('installment_orders.index');
      }

      if (controller === 'installment_orders.vendor') {
        window.location.href = fn_url('installment_orders.vendor') + `&status=${String(status)}`;
      } else {
        window.location.href = fn_url('installment_orders.index') + `&status=${String(status)}`;
      }
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

  const contractsLength = Number($paginationContainer.data('contracts-count'));
  const fakeData = [...new Array(contractsLength)].map(() => Math.round(Math.random() * contractsLength));

  $paginationContainer.pagination({
    pageSize: 10,
    pageNumber: adminContractsState.page,
    dataSource: fakeData,
    afterPaging: function (page) {
      const params = new URLSearchParams(document.location.search);
      const status = params.get('status');

      if (page !== Number(adminContractsState.page)) {
        window.location.href = fn_url('installment_orders.vendor') + `&status=${status}&page=${page}`;
      }
    },
  });

})(Tygh, Tygh.$);

