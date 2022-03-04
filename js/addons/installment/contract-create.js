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

var selectedMonth = e.options[e.selectedIndex].value;


const otpState = {
    baseUrl: 'https://test.paymart.uz/api/v1',
    setContract: 'installment_product.set_contracts',
    api_token: Cookies.get('api_token'),
    buyerPhone: Cookies.get('buyer-phone'),
    timer: 60,
    interval: null,
    expDate: null,
    selectedFirst: selectedMonth,
    contractId: null,
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
        console.log('plrice', price, quantity, name_product, selectedOption)
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
                console.log(response.data.price.total)
                $(".input-paying__text-p").html(response.data.price.total + ' сум')
                $(".input-paying__text-a").html(response.data.price.month + ' сум')
                // $(".orange").html(response.data.price.total + ' сум')
            }
        });
    });

});


// When the user clicks on the button, open the modal
myBtn.onclick = function () {
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
    let city = $('#formAddress').val();
    let region = $('#formAddress2').val();
    // let txt = document.getElementsByTagName("textarea");
    let apartment = $('#story').val();
    let building = $('#story2').val();
    let street = $('#story3').val();
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

    let city = $('#formAddress').val();
    let region = $('#formAddress2').val();
    let apartment = $('#story').val();
    let building = $('#story2').val();
    let street = $('#story3').val();
    let otpInputVal = $('.ty-login__input').val();
    $('.resend-sms-card').css('display', 'block');
    var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
    function timer() {
        otpState.timer = otpState.timer - 1;
        if (otpState.time <= 0) {
            clearInterval(counter);
            //counter ended, do something here
            return;
        }
        document.querySelector('.card-resend-sms-timer').innerHTML = otpState.timer + ' secs';
        //Do code for showing the number of seconds here
    }


    $.ceAjax('request', fn_url('installment_product.set_confirm_contract'), {
        method: "POST",
        data: {
            code: otpInputVal,
            contract_id: otpState.contractId,
            city: city,
            region: region,
            apartment: apartment,
            building: building,
            street: street,
        },
        callback: function (response) {
            let spanError = $('.modal-error');

            if (response.result.result.status === 0) {
                spanError.text('tasdiqlash kodi xato! Iltimos, to\'g\'ri kiriting.').css('color', 'red');

            } else if (response.result.result.status === 1) {
                window.location.href = fn_url('installment_product.profile-contracts');

            }

        },
    })

})




