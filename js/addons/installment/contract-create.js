(function (_, $) {
    console.log('contract create page init');
})(Tygh, Tygh.$);

const otpState = {
    baseUrl: 'https://dev.paymart.uz/api/v1',
    api_token: Cookies.get('api_token'),
    buyerPhone: Cookies.get('buyer-phone'),
    timer: 60,
    interval: null,
    expDate: null,
};


// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

let inputDate = null;
let value = $('.confirm-contract').val();
let urlLast = otpState.baseUrl + '/buyers/credit/add'

// When the user clicks on the button, open the modal
btn.onclick = function () {
    modal.style.display = "block";
    inputDate = document.querySelector('#cars').value;
    otpState.expDate = inputDate
    console.log('input-date', inputDate);
    $.ajax({
        type: "post",
        url: urlLast,
        data: {
            code: value,
        },
        success: function (response) {
            $("#otp").removeClass("myspinner");
            console.log(response)
            console.log('url', this.url)
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

        error: function (response, error) {
            $("#otp").removeClass("myspinner");
            // var errorMessage = response.data.message + ': '
            // alert('Error - ' + errorMessage);
        }
    })
}



// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

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
    console.log('exp', otpState.expDate)
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
    $("#modal-sent").addClass("myspinner");
    setTimeout(function () {
        $("#modal-sent").removeClass("myspinner");
    }, 3000);
    //

    console.log('value', value)
    console.log('urlLast', urlLast)
    $.ajax({
        type: "post",
        url: urlLast,
        data: {
            code: value,
        },
        success: function (response) {
            $("#otp").removeClass("myspinner");
            console.log(response)
            console.log('url', this.url)
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

        error: function (response, error) {
            $("#otp").removeClass("myspinner");
            // var errorMessage = response.data.message + ': '
            // alert('Error - ' + errorMessage);
        }
    })
})



