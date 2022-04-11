(function (_, $) {
  const $cancelContractBtn = $('.cancel-contract');
  const $confirmCancel = $('.confirm-cancel-contract');
  const $cancelModal = $('.cancel-contract-modal');

  // upload-act (vendor)
  const $uploadActBtn = $('.upload-act');
  const $confirmUploadAct = $('.confirm-upload-act');
  const $uploadActModal = $('.upload-act-modal');
  const $imeiUploader = $('#imei-uploader');
  const $previewContainer = $('.imei-preview');

// accept contract (vendor)
  const $acceptContractBtn = $('.accept-contract');
  const $confirmAccept = $('.confirm-accept-contract');
  const $acceptModal = $('.accept-contract-modal');


// bar code contract (vendor)
  const $barCodeBtn = $('.show-bar-code');
  const $barCodeModal = $('.bar-code-modal');
  const $barCodeModalBody = $('.bar-code-modal-body');

// tracking contract (admin)
  const $trackingContractBtn = $('.tracking-contract');
  const $trackingModal = $('.tracking-contract-modal');
  const $trackingModalBody = $('.tracking-modal-body');

  const $tabs = $('.order-status-tabs span');
  // const $errorContainer = $('.cancel-contract-error');
  const $paginationContainer = $('.pagination-contracts');

  const params = new URLSearchParams(document.location.search);
  const pageNumber = params.get('page');

  const adminContractsState = {
    order_id: null,
    contract_id: null,
    buyer_phone: null,
    page: pageNumber,
    status: null,
    file: {
      imei: null,
    },
  };

  const adminContractsMethods = {
    showUploadActModal: function (event) {
      adminContractsMethods.getParamsFromDom($(this));
      $previewContainer.css({
        display: 'none',
      });
      $uploadActModal.modal('show');
    },
    showCancelContractModal: function (event) {
      adminContractsMethods.getParamsFromDom($(this));
      $cancelModal.modal('show');
    },
    showAcceptContractModal: function () {
      adminContractsMethods.getParamsFromDom($(this));
      $acceptModal.modal('show');
    },
    showTrackingContractModal: function () {
      const timeline = document.querySelector('.timeline');
      timeline.innerHTML = '';

      adminContractsMethods.getParamsFromDom($(this));
      adminContractsMethods.trackingContract();
      $trackingModal.modal('show');
    },
    showBarCodeModal: function () {
      $barCodeModalBody.html(_.tr('file_uploading_in_progress_please_wait'));
      adminContractsMethods.getParamsFromDom($(this));
      adminContractsMethods.getBarCode();
      $barCodeModal.modal('show');
    },
    getParamsFromDom: function ($button) {
      adminContractsState.order_id = $button.data('order-id');
      adminContractsState.contract_id = $button.data('contract-id');
    },
    uploadAct: function () {
      console.log(`uploading... act ${adminContractsState.contract_id}`);
      console.log(`uploading.. file ${adminContractsState.file.imei}`);

      if (adminContractsState.file.imei === null) {
        return alert('choose file');
      }

      const formData = new FormData();
      formData.append('contract_id', adminContractsState.contract_id);
      formData.append('file', adminContractsState.file.imei);
      formData.append('security_hash', _.security_hash);
      formData.append('is_ajax', '1');

      $.ajax({
        url: fn_url('installment_orders.upload_imei'),
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
          window.location.reload();
        },
      });

      // $.ceAjax('request', fn_url('installment_orders.upload_imei'), {
      //     method: 'POST',
      //     data: {
      //         contract_id: adminContractsState.contract_id,
      //         file: adminContractsState.file.imei,
      //     },
      //     callback: function (response) {
      //         window.location.reload();
      //     },
      // });

      $uploadActModal.modal('hide');
    },
    selectFile: function (event) {
      const imei = event.target.files[0];
      const preview = URL.createObjectURL(imei);

      $previewContainer.css({
        display: 'block',
        background: `url("${preview}") center center`,
        backgroundSize: 'cover',
        width: 250,
        height: 250,
        marginBottom: 16,
      });

      adminContractsState.file.imei = imei;
    },
    cancelContract: function () {
      $.ceAjax('request', fn_url('installment_orders.change_status'), {
        method: 'POST',
        data: {
          order_id: adminContractsState.order_id,
          status: false,
        },
        callback: function (response) {
          window.location.reload();
        },
      });

      $cancelModal.modal('hide');
    },
    acceptContract: function () {
      $.ceAjax('request', fn_url('installment_orders.change_status'), {
        method: 'POST',
        data: {
          order_id: adminContractsState.order_id,
          status: true,
        },
        callback: function (response) {
          console.log(response);
          window.location.reload();
        },
      });

      $acceptModal.modal('hide');

    },
    trackingContract: function () {
      $.ceAjax('request', fn_url('installment_orders.order_tracking'), {
        method: 'POST',
        data: {
          order_id: adminContractsState.order_id,
        },
        callback: function (response) {
          if (response.hasOwnProperty('result')) {
            const { result } = response;
            adminContractsMethods.generateModalContent(result.list.reverse());
          }
        },
      });
    },
    getBarCode: function () {
      // console.log('getting bar code url...');
      $.ceAjax('request', fn_url('installment_orders.get_barcode'), {
        method: 'POST',
        data: {
          order_id: adminContractsState.order_id,
        },
        callback: function (response) {
          if (response.result === null) {
            return $barCodeModalBody.html(_.tr('nothing_found'));
          }

          const iframe = document.createElement('iframe');

          iframe.setAttribute('src', response.result);
          iframe.setAttribute('frameborder', '0');
          iframe.setAttribute('height', '650');
          iframe.setAttribute('width', '100%');

          $barCodeModalBody.html(iframe);
        },
      });

    },
    generateModalContent: function (trackingList = []) {
      const timeline = document.querySelector('.timeline');

      trackingList.forEach(({ status, date }) => {
        const li = document.createElement('li');
        const eventDate = new Date(date);

        li.classList.add('event');
        li.setAttribute('data-date', eventDate.toLocaleString());
        li.innerHTML = `<h3>${status}</h3>`;

        timeline.appendChild(li);
      });
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
    initPagination: function () {
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
    },
  };

  adminContractsMethods.initPagination();

  // uploading contract (vendor)
  $confirmUploadAct.on('click', adminContractsMethods.uploadAct);
  $uploadActBtn.on('click', adminContractsMethods.showUploadActModal);
  $imeiUploader.on('change', adminContractsMethods.selectFile);
  $('.close-upload-act-modal').on('click', function () {
    $uploadActModal.modal('hide');
  });

// cancelling contract (vendor)
  $confirmCancel.on('click', adminContractsMethods.cancelContract);
  $cancelContractBtn.on('click', adminContractsMethods.showCancelContractModal);
  $('.close-cancel-contract-modal').on('click', function () {
    $cancelModal.modal('hide');
  });

// accept contract (vendor)
  $confirmAccept.on('click', adminContractsMethods.acceptContract);
  $acceptContractBtn.on('click', adminContractsMethods.showAcceptContractModal);
  $('.close-accept-contract-modal').on('click', function () {
    $acceptModal.modal('hide');
  });


// bar code (vendor)
  $barCodeBtn.on('click', adminContractsMethods.showBarCodeModal);
  $('.close-bar-code-modal').on('click', function () {
    $barCodeModal.modal('hide');
  });

// tracking contract (admin)
  $trackingContractBtn.on('click', adminContractsMethods.showTrackingContractModal);
  $('.close-tracking-contract-modal').on('click', function () {

    $trackingModal.modal('hide');
  });

// change contract status
  $.each($tabs, function (tab) {
    $(this).on('click', adminContractsMethods.onChangeTabs);
  });

})(Tygh, Tygh.$);

