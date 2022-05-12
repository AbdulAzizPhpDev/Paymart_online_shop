(function (_, $) {
  const $showCancelModalBtn = $('.return-cancel-btn');
  const $cancelModal = $('.return-cancel-modal');
  const $cancelTextarea = $('.return-cancel-modal .modal-body textarea');
  const $closeCancelModalBtn = $('.close-return-cancel');
  const $confirmCancelBtn = $('.confirm-return-cancel');

  const $showAcceptModalBtn = $('.return-accept-btn');
  const $acceptModal = $('.return-accept-modal');
  const $confirmAcceptBtn = $('.confirm-accept-return');

  // const $tabs = $('.order-status-tabs span');
  // const $paginationContainer = $('.pagination-contracts');

  const params = new URLSearchParams(document.location.search);
  const pageNumber = params.get('page');

  const adminContractsState = {
    order_id: null,
    user_id: null,
    company_id: null,
    page: pageNumber,
    status: null,
    file: {
      imei: null,
    },
  };

  const adminContractsMethods = {
    showCancelModal: function () {
      adminContractsMethods.getParamsFromDom($(this));
      $cancelModal.modal('show');
    },
    showAcceptModal: function () {
      adminContractsMethods.getParamsFromDom($(this));
      $acceptModal.modal('show');
    },
    getParamsFromDom: function ($button) {
      adminContractsState.order_id = $button.data('order-id');
      adminContractsState.user_id = $button.data('user-id');
      adminContractsState.company_id = $button.data('company-id');
    },
    cancel: function () {
      const { company_id, order_id, user_id } = adminContractsState;
      const description = $cancelTextarea.val();

      $.ceAjax('request', fn_url('returned_product.response'), {
        method: 'POST',
        data: {
          company_id,
          order_id,
          user_id,
          description,
          status: 'canceled',
        },
        callback: function (response) {
          console.log(response);
        },
      });

      $cancelModal.modal('hide');
    },
    accept: function () {
      const { company_id, order_id, user_id } = adminContractsState;

      $.ceAjax('request', fn_url('returned_product.response'), {
        method: 'POST',
        data: {
          company_id,
          order_id,
          user_id,
          status: 'accepted',
        },
        callback: function (response) {
          console.log(response);
        },
      });

      $acceptModal.modal('hide');
    },
    /*onChangeTabs: function () {
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
    },*/
    /*initPagination: function () {
      const contractsLength = Number($paginationContainer.data('contracts-count')) || 0;
      if (contractsLength === 0) return;

      // Generating fake data for pagination plugin
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
    },*/
  };

  // adminContractsMethods.initPagination();

  $showCancelModalBtn.on('click', adminContractsMethods.showCancelModal);
  $confirmCancelBtn.on('click', adminContractsMethods.cancel);
  $closeCancelModalBtn.on('click', function () {
    $cancelModal.modal('hide');
  });

  $showAcceptModalBtn.on('click', adminContractsMethods.showAcceptModal);
  $confirmAcceptBtn.on('click', adminContractsMethods.accept);
  $('.close-accept-return').on('click', function () {
    $acceptModal.modal('hide');
  });

  // change contract status
  // $.each($tabs, function (tab) {
  //   $(this).on('click', adminContractsMethods.onChangeTabs);
  // });

})(Tygh, Tygh.$);

