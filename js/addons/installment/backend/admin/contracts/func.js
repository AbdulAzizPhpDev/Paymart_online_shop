(function (_, $) {
  const $cancelContractBtn = $('.cancel-contract');
  const $confirmCancel = $('.confirm-cancel-contract');
  const $modal = $('.cancel-contract-modal');

  const $acceptContractBtn = $('.accept-contract');
  const $confirmAccept = $('.confirm-accept-contract');
  const $acceptModal = $('.accept-contract-modal');

  const $tabs = $('.order-status-tabs span');
  const $errorContainer = $('.cancel-contract-error');
  const $paginationContainer = $('.pagination-contracts');

  // const $code = $('#cancel-contract-code');

  const params = new URLSearchParams(document.location.search);
  const pageNumber = params.get('page');

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
      $modal.modal('show');
    },
    acceptContractModalShow: function () {
      adminContractsState.order_id = $(this).data('contract-id');
      adminContractsState.buyer_phone = $(this).data('buyer_phone');
      $acceptModal.modal('show');
    },
    cancelContract: function () {
      $.ceAjax('request', fn_url('installment_orders.change_status'), {
        method: 'POST',
        data: {
          contract_id: adminContractsState.order_id,
          status: false,
        },
        callback: function (response) {
          $errorContainer.text(response.text);
        },
      });

      $modal.modal('hide');
    },
    acceptContract: function () {
      $.ceAjax('request', fn_url('installment_orders.change_status'), {
        method: 'POST',
        data: {
          contract_id: adminContractsState.order_id,
          status: true,
        },
        callback: function (response) {
          $errorContainer.text(response.text);
        },
      });

      $acceptModal.modal('hide');
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

  $confirmAccept.on('click', adminContractsMethods.acceptContract);
  $acceptContractBtn.on('click', adminContractsMethods.acceptContractModalShow);

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
      const controller = params.get('dispatch');

      if (page !== Number(adminContractsState.page)) {
        if (controller === 'installment_orders.vendor') {
          window.location.href = fn_url('installment_orders.vendor') + `&status=${status}&page=${page}`;
        } else {
          window.location.href = fn_url('installment_orders.index') + `&status=${status}&page=${page}`;
        }
      }
    },
  });

})(Tygh, Tygh.$);

