const $cancelContractBtn = $('.cancel-contract');
const $confirmCancel = $('.confirm-cancel-contract');
const $cancelModal = $('.cancel-contract-modal');

// accept contract (vendor)
const $acceptContractBtn = $('.accept-contract');
const $confirmAccept = $('.confirm-accept-contract');
const $acceptModal = $('.accept-contract-modal');

<
<
<
<
<
<< HEAD
    // tracking contract (admin)
    const $trackingContractBtn=$('.tracking-contract'
)
;
const $confirmTracking = $('.confirm-tracking-contract');
const $trackingModal = $('.tracking-contract-modal');

const $trackingModalBody = $('.tracking-modal-body');

const $tabs = $('.order-status-tabs span');
const $errorContainer = $('.cancel-contract-error');
const $paginationContainer = $('.pagination-contracts');
======
=
// bar code contract (vendor)
const $barCodeBtn = $('.show-bar-code');
const $barCodeModal = $('.bar-code-modal');
const $barCodeModalBody = $('.bar-code-modal-body');

// tracking contract (admin)
const $trackingContractBtn = $('.tracking-contract');
const $trackingModal = $('.tracking-contract-modal');

const $tabs = $('.order-status-tabs span');
const $errorContainer = $('.cancel-contract-error');
const $paginationContainer = $('.pagination-contracts');
>>>>>>>
0
a1f759f021734c6e15c5ceff6914dcf70a31c23

// const $code = $('#cancel-contract-code');

const params = new URLSearchParams(document.location.search);
const pageNumber = params.get('page');

const adminContractsState = {
    order_id: null,
    buyer_phone: null,
    page: pageNumber,
    status: null,
};

const adminContractsMethods = {
    showCancelContractModal: function (event) {
        adminContractsMethods.getParamsFromDom($(this));
        $cancelModal.modal('show');
    },
    showAcceptContractModal: function () {
        adminContractsMethods.getParamsFromDom($(this));
        $acceptModal.modal('show');
    },
    showTrackingContractModal: function () {
        // $trackingModalBody.text('');
        adminContractsMethods.getParamsFromDom($(this));
        adminContractsMethods.trackingContract();
        $trackingModal.modal('show');
    },
    showBarCodeModal: function () {
        console.log('opening bar code modal...');
        adminContractsMethods.getParamsFromDom($(this));
        adminContractsMethods.getBarCode();
        $barCodeModal.modal('show');
    },
    getParamsFromDom: function ($button) {
        <
        <
        <
        <
        <
        << HEAD
            adminContractsState.order_id=$button.data('order-id'
    )
        ;
        adminContractsState.contract_id = $button.data('contract-id');
    },
    cancelContract: function () {
        $.ceAjax('request', fn_url('installment_orders.change_status'), {
            method: 'POST',
            data: {
                contract_id: adminContractsState.contract_id,
                order_id: adminContractsState.order_id,
                status: false,
            },
            callback: function (response) {
                console.log(response);
                window.location.reload();
            },
        });

        $cancelModal.modal('hide');
    },
    acceptContract: function () {
        $.ceAjax('request', fn_url('installment_orders.change_status'), {
            method: 'POST',
            data: {
                contract_id: adminContractsState.contract_id,
                order_id: adminContractsState.order_id,
                status: true,
            },
            callback: function (response) {
                console.log(response);
                window.location.reload();
            },
        });

        $acceptModal.modal('hide');
    ======
        =
            adminContractsState.order_id = $button.data('order-id');
    },
    cancelContract: function () {
        $.ceAjax('request', fn_url('installment_orders.change_status'), {
            method: 'POST',
            data: {
                order_id: adminContractsState.order_id,
                status: false,
            },
            callback: function (response) {
                console.log(response);
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
    >>>>>>>
        0
        a1f759f021734c6e15c5ceff6914dcf70a31c23
    },
    trackingContract: function () {
        $.ceAjax('request', fn_url('installment_orders.order_tracking'), {
            method: 'POST',
            data: {
                order_id: adminContractsState.order_id,
            },
            callback: function (response) {
                if (response.hasOwnProperty('result')) {
                    const {result} = response;

                    if (result.status === 'success') {
                        adminContractsMethods.generateModalContent(result.data.list);
                    }
                }
            },
        });
    },
    getBarCode: function () {
        console.log('getting bar code url...');
        $.ceAjax('request', fn_url('installment_orders.get_barcode'), {
            method: 'POST',
            data: {
                order_id: adminContractsState.order_id,
            },
            callback: function (response) {
                if (!response.hasOwnProperty('result')) {
                    return $barCodeModalBody.text('Error!');
                }

                $barCodeModalBody.find('img').attr('src', response.result);
            },
        });
    },
    generateModalContent: function (trackingList = []) {
        const timeline = document.querySelector('.timeline');
        timeline.innerHTML = '';

        trackingList.forEach(({status, date}) => {
            const li = document.createElement('li');
            const eventDate = new Date(date);
            const text_status = _.tr(status);

            li.classList.add('event');
            li.setAttribute('data-date', eventDate.toLocaleString());
            li.innerHTML = `<h3>${text_status}</h3>`;

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

(Tygh, Tygh.$);

