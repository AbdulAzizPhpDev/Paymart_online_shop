(function (_, $) {
    console.log('contract create page init');
})(Tygh, Tygh.$);


// Get the modal
var modal = document.getElementById('myModal');
var modal1 = document.getElementById('myModal1');

// Get the button that opens the modal
var myBtn = document.getElementById('myBtn');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// let value = $('.confirm-contract').val();
let e = document.getElementById('selectedId');
let formAdress = document.getElementById('formAddress2');
let formAdress3 = document.getElementById('formAddress3');

var selectedMonth = e.options[e.selectedIndex].value;

const $select = $('.tashkent-regions');
const $input = $('.not-tashkent-region');

const otpState = {
    baseUrl: 'https://test.paymart.uz/api/v1',
    setContract: 'installment_product.set_contracts',
    api_token: Cookies.get('api_token'),
    buyerPhone: Cookies.get('buyer-phone'),
    timer: 20,
    interval: null,
    expDate: null,
    selectedFirst: selectedMonth,
    selectedFirstAdress: selectedMonth,
    selectedFirstAdress3: null,
    contractId: null,
    cityModal: null,
};

let urlLast = otpState.baseUrl + '/buyers/credit/add'
let calculate = otpState.baseUrl + '/order/calculate'
let price = document.getElementById('price').value
let quantity = document.getElementById('quantity').value
let name_product = document.getElementById('name_product').value
let seller_token = document.getElementById('seller_token').value
let seller_id = document.getElementById('seller_id').value
let user_id = document.getElementById('user_id').value
// setUrl = fn_url('installment_product.set_contracts');


$(document).ready(function () {
    $("#selectedId").change(function () {
        var selectedOption = e.options[e.selectedIndex].value;
        otpState.selectedFirst = selectedOption;
        let formattedProducts = {};
        formattedProducts[seller_id] = [
            {
                price: price,
                amount: quantity,
                name: name_product,
            }
        ];
        $.ajax({
            type: 'POST',
            url: calculate,
            headers: {
                Authorization: 'Bearer ' + seller_token
            },
            data: {
                type: 'credit',
                period: selectedOption,
                products: formattedProducts,
                partner_id: seller_id,
                user_id: user_id,
            },
            success: function (response) {
                $('.input-paying__text-p').html(response.data.price.total + ' сум');
                $('.input-paying__text-a').html(response.data.price.month + ' сум');
                // $(".orange").html(response.data.price.total + ' сум')
            }
        });
    });

});

$(document).ready(function () {
    $('#formAddress2').change(function () {
        var selectedOptionAdress = formAdress.options[formAdress.selectedIndex].value;
        otpState.selectedFirstAdress = selectedOptionAdress;
        $.ceAjax('request', fn_url('get_city.city'), {
            method: 'post',
            data: {
                city_id: selectedOptionAdress,
            },
            callback: function (response) {
                if (response.result == null) {
                    $input.removeClass('d-none').focus();
                    $select.addClass('d-none');
                } else {
                    $select.removeClass('d-none');
                    $input.addClass('d-none');
                    response.result.forEach(number => {
                        const option = `<option value="${number.city_id}" selected>${number.city_name}</option>`;
                        $select.append(option);
                    });
                }
            },
        });
    });

});

$(document).ready(function () {
    $($select).change(function () {
        var selectedOptionAdress3 = formAdress3.options[formAdress3.selectedIndex].value;
        otpState.selectedFirstAdress3 = selectedOptionAdress3;
    });
});


// When the user clicks on the button, open the modal
myBtn.onclick = function () {
    let valNullInputt = document.querySelector('.not-tashkent-region');
    if (!$input.hasClass('d-none')) {
        if (/^\s*$/g.test(valNullInputt.value) || valNullInputt.value.indexOf('\n') != -1) {
            $('.not-tashkent-region').css('border', '1px solid red').focus();
            return;
        }
    }

    var val = document.querySelector('#story2').value;
    if (/^\s*$/g.test(val) || val.indexOf('\n') != -1) {
        $('#story2').css('border', '1px solid red').focus();
        return;
    }
    var val2 = document.querySelector('#story3').value;
    if (/^\s*$/g.test(val2) || val2.indexOf('\n') != -1) {
        $('#story3').css('border', '1px solid red').focus();
        return;
    }

    let city = $('#formAddress2').val();
    otpState.cityModal = city;
    let region = (otpState.selectedFirstAdress3 == null) ? ((!$input.hasClass('d-none')) ? $input.val() : $select.val()) : otpState.selectedFirstAdress3;
    let txt = document.getElementsByTagName('textarea');
    let apartment = $('#story').val();
    let building = $('#story2').val();
    let street = $('#story3').val();
    // let district = $('#story6').val();
    span.onclick = function () {
        modal.style.display = 'none';
    };

    $.ceAjax('request', fn_url('installment_product.set_contracts'), {
        method: 'POST',
        data: {
            limit: otpState.selectedFirst,
            city: city,
            region: region,
            apartment: apartment,
            building: building,
            street: street,
        },
        callback: function (response) {
            otpState.contractId = response.result.paymart_client.contract_id;
            modal.style.display = "block";
        },
    });
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

$('.resend-sms-card').css('display', 'none');
$('#modal-sent').click(function () {
    let region = $('#formAddress2').val();
    let apartment = $('#story').val();
    let building = $('#story2').val();
    let street = $('#story3').val();
    $(this).attr('disabled', true);
    let otpInputVal = $('.ty-login__input').val();
    $('.resend-sms-card').css('display', 'block');
    var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
    function timer() {
        otpState.timer = otpState.timer - 1;
        if (otpState.timer <= 0) {
            clearInterval(counter);
            $('#modal-sent').attr('disabled', false).click(function () {
                $.ceAjax('request', fn_url('installment_product.set_confirm_contract'), {
                    method: 'POST',
                    data: {
                        code: otpInputVal,
                        contract_id: otpState.contractId,
                        city: !($select).hasClass('d-none') ? $($select).val() : $($input).val(),
                        region: region,
                        apartment: apartment,
                        building: building,
                        street: street,
                    },
                    callback: function (response) {
                        let spanError = $('.modal-error');
                        console.log('response-timer', response);
                        if (response.status === 'success') {
                            window.location.href = fn_url('installment_product.profile-contracts');
                            console.log('shut timer success');
                        } else {
                            spanError.text(response.result.response.message).css('color', 'red');
                            $('#modal-sent').attr('disabled', true);
                        }
                    },
                });
            });
            //counter ended, do something here
            return;
        }
        document.querySelector('.card-resend-sms-timer').innerHTML = otpState.timer + ' secs';
    }
    $.ceAjax('request', fn_url('installment_product.set_confirm_contract'), {
        method: 'POST',
        data: {
            code: otpInputVal,
            contract_id: otpState.contractId,
            city: !($select).hasClass('d-none') ? $($select).val() : $($input).val(),
            region: region,
            apartment: apartment,
            building: building,
            street: street,
        },
        callback: function (response) {
            let spanError = $('.modal-error');
            console.log('response-first', response);
            if (response.result.status === 'success') {
                window.location.href = fn_url('installment_product.profile-contracts');
                console.log('shut second success');
            } else {
                spanError.text(response.result.response.message).css('color', 'red');
                $('#modal-sent').attr('disabled', true);
            }
        },


    })
})
// Get the modal
var modal5 = document.getElementById('myModal5');

