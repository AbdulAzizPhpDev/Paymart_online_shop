(function (_, $) {
    console.log('contract create page init');
})(Tygh, Tygh.$);






// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var myBtn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// let value = $('.confirm-contract').val();
let e = document.getElementById("selectedId");

var selectedMonth = e.options[e.selectedIndex].value;


const otpState = {
    baseUrl: 'https://dev.paymart.uz/api/v1',
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



$(document).ready(function() {
    $("#selectedId").change(function(){
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

        $.ajax( {
            type: 'POST',
            url: calculate,
            headers:{
                Authorization: 'Bearer '+ seller_token
            },
            data: {
                type: 'credit',
                period: selectedOption,
                products: formattedProducts,
                partner_id:seller_id,
                user_id: user_id,
            },
            success:function (response) {
                console.log(response.data.price.total)
                $(".input-paying__text-p").html(response.data.price.total + ' сум')
                $(".input-paying__text-a").html(response.data.price.month + ' сум')
                $(".orange").html(response.data.price.total + ' сум')
            }
        });
    });

});


// When the user clicks on the button, open the modal
myBtn.onclick = function () {

    let city = $('#formAddress').val();
    let region = $('#formAddress2').val();
    // let txt = document.getElementsByTagName("textarea");
    let txt = $("#story").val();

    // console.log('address', txt)
    // $.ceAjax('request', 'installment_product.set_contracts', {
    //     result_ids: otpState.setContract,
    //     method: 'post',
    //     full_render: true,
    //     data: {
    //
    //     }
    // });

    $.ceAjax('request', fn_url('installment_product.set_contracts'), {
        method: 'POST',
        data: {
            limit: otpState.selectedFirst,
            city: city,
            region: region,
            textarea: txt,
        },
        callback: function (response) {
            console.log('success', response)
            // let contract_id = response.result.paymart_client.contract_id;
            otpState.contractId = response.result.paymart_client.contract_id;
               // When the user clicks on <span> (x), close the modal
            modal.style.display = "block";
                // When the user clicks on <span> (x), close the modal
                // span.onclick = function() {
                //     modal.style.display = "none";
                // }
                // // When the user clicks anywhere outside of the modal, close it
                // window.onclick = function(event) {
                //     if (event.target == modal) {
                //         modal.style.display = "none";
                //     }
                // }

        },
    });

};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
Cookies.set('buyer-phone', 998917779799)

let number2 = otpState.buyerPhone.slice(0, 6) + '*****' + otpState.buyerPhone.slice(10, 15);
let vue = document.querySelector(".sent-phone-number").innerHTML = number2.replace(/[()]/g, '');
console.log('vue', vue)

$(".resend-sms-card").css("display", "none");

Cookies.set('buyer-phone', 998917779799)

//

$('#modal-sent').click(function () {
    let otpInputVal = $(".ty-login__input").val()
    $(".resend-sms-card").css("display", "block");
    var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
    function timer() {
        otpState.timer = otpState.timer - 1;
        if (otpState.time <= 0) {
            clearInterval(counter);
            //counter ended, do something here
            return;
        }
        document.querySelector(".card-resend-sms-timer").innerHTML = otpState.timer + " secs";
        //Do code for showing the number of seconds here
    }
//  modal click
//     $("#modal-sent").addClass("myspinner");
//     setTimeout(function () {
//         $("#modal-sent").removeClass("myspinner");
//     }, 3000);
//     // console.log('value', value)
    $.ceAjax('request', fn_url('installment_product.set_confirm_contract'), {
        method: "POST",
        data: {
            code: otpInputVal,
            contract_id: otpState.contractId,
        },
        callback: function (response) {
            // $("#otp").removeClass("myspinner");
            console.log(response);
            window.location.href = fn_url('installment_product.profile-contracts');
            // modal.style.display = "none";


            // if (response.result.data){}

            // $( "#otp" ).removeClass( "myspinner" );
            // $("#otp").attr("disabled", false);
            // if (response.status === 'success') {
            //     const userStatus = response.data.user_status;
            //     const userId = response.data.user_id;
            //     console.log('userId', userId)
            //     // state.user_id = userId
            //     const token = response.data.api_token;
            //     Cookies.set('token', token);
            //     Cookies.set('userId', userId);
            //     console.log('userstatus', userStatus)
            //
            //     if (userStatus == 1) {
            //         console.log('status 1')
            //         window.location.href = this.otpState.baseUrl + "card&phone=" + this.otpState.buyerPhone;
            //         // $("#card-form").css("display", "block");
            //         // $(".main-otp").css("display", "none");
            //
            //     }
            //     if (userStatus == 2) {
            //         console.log('status 2')
            //         window.location.href = baseUrls + "waiting-clock";
            //         // $("#card-form").css("display", "block");
            //         // $(".main-otp").css("display", "none");
            //
            //     }
            //     if (userStatus == 4) {
            //         console.log('status 4')
            //         window.location.href = baseUrls + "product-status";
            //         // $(".second-popup").css("display", "block");
            //         // $(".main-otp").css("display", "none");
            //
            //     }
            //     if (userStatus == 5) {
            //         console.log('status 5');
            //
            //         // $(".main-otp").css("display", "none");
            //         // $("#card-form").css("display", "none");
            //         // // $(".second-popup__last").css("display", "block");
            //         // $(".main__input").css("display", "block");
            //         window.location.href = baseUrl + "passport-firstpage";
            //
            //     }
            //     if (userStatus == 10) {
            //         console.log('status 10');
            //         window.location.href = baseUrl + "passport-selfie";
            //
            //     }
            // } else {
            //     let wrongCode = response.response.message[0]?.text;
            //     $(".isWrong").css("display", "block");
            //     $('.isWrong').text(wrongCode);
            //     $(".sendMessageCodeText").css("display", "none");
            //
            // }
            // console.log('wrong', wrong);

            // $(".second-popup__last").css("display", "block");

        },

        // error: function (response, error) {
        //     $("#otp").removeClass("myspinner");
        //     // var errorMessage = response.data.message + ': '
        //     // alert('Error - ' + errorMessage);
        // }
    })

})




