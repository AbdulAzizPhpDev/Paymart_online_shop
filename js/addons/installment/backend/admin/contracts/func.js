const $cancelContractBtn = $('.cancel-contract');
const $confirmCancel = $('.confirm-cancel-contract');
const $cancelModal = $('.cancel-contract-modal');

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

const $tabs = $('.order-status-tabs span');
const $errorContainer = $('.cancel-contract-error');
const $paginationContainer = $('.pagination-contracts');


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
                window.open('https://shipox-prod.s3.amazonaws.com/9689bedc-b907-439c-b4aa-03b80caedbdc?X-Amz-Security-Token=IQoJb3JpZ2luX2VjEOz%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJHMEUCIQDfpvxnUbKZdnQ5GgLjpiij3J%2BqxwEzN4ka8hXT5FQ7OQIgTp33tGOGn9PbxQorEvJgIsuxA1OvP1%2BgFpgY5T5GVTkq%2BgMIdRACGgw1Mzg3MDY2MzYwNzEiDDZRCrlpUpgJr4KrcCrXA1lCmyCVtQpknpy1KJHgXtnnLpfXmDAnSvzzyyGvV5jK8OWmH3QHdQTu80gdLGha5uhmSi614wE6bAaygvbkDO6YMOZjubScuAgzvNX8LFlCY4YutWFMm6%2FUw27l2KEhNDu3RoMwyrqO9FDTNr6MGw9ccRIWyXGbkTiJk1mdqr9ybPlQlYkH4W4FG1WXYmNaVveWmP17aPg0aSLAGG3GwFtu40TzQRSC%2Fp%2FqgkBg4vRe0MdXfhXboAeGQ2tF0ML%2BhMPOBvrNV1yipah50FvBwcb7qM5S6Us%2F0lQIlSmiRGDk1NIB8j7asOR%2Bs%2Byn%2BIgBTFuVnDbrsLzQ40bz0X2qHF70WYJ8tilftm8O6CP%2BFEXl1Bna1%2BWBXtfcV1PtFKEbZfRmLyxsFzKThrTPKauRkKI%2B3LGW3ZCG5%2BdDbakaCNKqS5zFUzB2gYfuRqERuFOQThsO7Gny6bzsI3bdapGLqvHNcKjfa4tcALA3rdY0CBrcUC8F6NSednyJFpmMAtBkFsalbYnoWzEIGXUiY4NKhxJrba8TGEMdWwau27eCZhZV2DiTY0BDy48RZd%2BuGQOq9rj9D47vnCwRLr1PvUBOU9KJ27WoAl071FC%2BZCzW0M0S%2FXyYw2UKyzDy0vaRBjqlAaA%2Bx32xS2YxfamOPxF%2BqG8URjT1g4cG7w3TIWbthwluHU0rmN4jDf5sjxDj9jXMJ7jqFA4SOW%2FiF0hkIHhTf0tk2Edz93%2F7tdDw3D9XP3%2FyBORwf%2Bn4up87%2FYghjETKTBIAPjGd%2FUu9rxY5J7uXPeHgFUkxorQJEuhCrxEuokvGe3DWbd%2BUIt7hvsD2AsO1MNBVGk6fsj3TKUTIwMX%2BjK0Vv50XfQ%3D%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20220325T124117Z&X-Amz-SignedHeaders=host&X-Amz-Expires=86399&X-Amz-Credential=ASIAX23LK5UT4YEN6LO2%2F20220325%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=bbc68cb1e78cc10c1e249c0fee3f397dbadeb4f8cd6ec644888cf0eeba18dcde');
                // if (!response.hasOwnProperty('result')) {
                //     console.log(response.result)
                //     return $barCodeModalBody.text('Error!');
                // }
                //
                // $barCodeModalBody.find('img').attr('src', response.result);
            },
        });
    },
    generateModalContent: function (trackingList = []) {
        const timeline = document.querySelector('.timeline');
        timeline.innerHTML = '';n

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

