<div class="main-otp">
    <div class="prompt">
        <h1 style="font-weight: bold;">Введите SMS КОД</h1>
        <p style="font-weight: bold;"> Отправленный <br>на номер <span id="prompt-span"></span></p>
    </div>

    <form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
        <input type="text" id="digit-1" name="digit-1" data-next="digit-2"/>
        <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1"/>
        <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2"/>
        <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3"/>
    </form>
    <div class="main-send-message">
        <p class="sendMessageCodeText" style="display:block;">Отправить SMS еще раз (через <span
                    id="timeReverse"></span>сек.)</p>
        <p class="isWrong"
           style="display: none; color: #FF0000; font-size: 15px;font-weight: 700; margin: 2px; padding: 6px 10px;"></p>
        <button type="submit" id="sendMessageCode" style="display: none">Отправить</button>
    </div>
    <div class="btn-otp">
        <button id="otp" class="btn-otp__item" type="submit">Войти</button>
        <button id="otp-change" class="btn-otp__second" type="submit">Изменить номер</button>
    </div>
</div>


<script>

    let baseUrls = 'https://dev.paymart.uz/api/v1/';

    let urlSec = "https://market.paymart.uz/api/v1/login/auth";
    const params = new URLSearchParams(window.location.search)
    const phone = params.get('phone')
    let number2 = phone.slice(0, 6) + '*****' + phone.slice(10, 15);
    let vuela = document.querySelector("#prompt-span").innerHTML = number2.replace(/[()]/g, '');
    console.log('vuela', vuela, phone)

    let timer = 30;
    let interval = setInterval(function () {
        timer = timer - 1;
        if (timer === 0) {
            clearInterval(interval);
            let sendMessageBtn = document.getElementById("sendMessageCode");
            sendMessageBtn.style.display = "block";
        }
        document.getElementById('timeReverse').innerHTML = timer;
    }, 1000);

    $("#sendMessageCode").click(function () {
        sendSmsCode()
        document.getElementById("digit-1").value = "";
        document.getElementById("digit-2").value = "";
        document.getElementById("digit-3").value = "";
        document.getElementById("digit-4").value = "";

        $('#sendMessageCode').attr('disabled', true);
        $('#sendMessageCode').css("background", "#d0d0bd");

        setTimeout(function () {
            $('#sendMessageCode').attr('disabled', false);

            $('#sendMessageCode').css("background", "rgba(101,248,103,0.6)");
        }, 2000);
    });

    $('#otp').on('click', function () {

        $("#otp").addClass("myspinner");



        console.log('statetsp', phone)
        let value = $("#digit-1").val();
        value += $("#digit-2").val();
        value += $("#digit-3").val();
        value += $("#digit-4").val();
        console.log('value', value)
        setTimeout(function () {
            $("#otp").removeClass("myspinner");
        }, 3000);

        if (value.length == 0 || value.length < 4) {
            alert("empty")
        }

        $.ajax({

            type: "post",
            url: urlSec,
            data: {
                phone,
                code: value,

            },
            success: function (response) {
                $("#otp").removeClass("myspinner");
                console.log(response)
                // $( "#otp" ).removeClass( "myspinner" );
                // $("#otp").attr("disabled", false);
                if (response.status === 'success') {
                    const userStatus = response.data.user_status;
                    const userId = response.data.user_id;
                    console.log('userId', userId)
                    // state.user_id = userId
                    const token = response.data.api_token;
                    Cookies.set('token', token);
                    Cookies.set('userId', userId);
                    console.log('userstatus', userStatus)

                    if (userStatus == 1) {
                        console.log('status 1')
                        window.location.href = baseUrls + "card&phone=" + phone;
                        // $("#card-form").css("display", "block");
                        // $(".main-otp").css("display", "none");

                    }
                    if (userStatus == 2) {
                        console.log('status 2')
                        window.location.href = baseUrls + "waiting-clock";
                        // $("#card-form").css("display", "block");
                        // $(".main-otp").css("display", "none");

                    }
                    if (userStatus == 4) {
                        console.log('status 4')
                        window.location.href = baseUrls + "product-status";
                        // $(".second-popup").css("display", "block");
                        // $(".main-otp").css("display", "none");

                    }
                    if (userStatus == 5) {
                        console.log('status 5');

                        // $(".main-otp").css("display", "none");
                        // $("#card-form").css("display", "none");
                        // // $(".second-popup__last").css("display", "block");
                        // $(".main__input").css("display", "block");
                        window.location.href = baseUrl + "passport-firstpage";

                    }
                    if (userStatus == 10) {
                        console.log('status 10');
                        window.location.href = baseUrl + "passport-selfie";

                    }
                } else {
                    let wrongCode = response.response.message[0]?.text;
                    $(".isWrong").css("display", "block");
                    $('.isWrong').text(wrongCode);
                    $(".sendMessageCodeText").css("display", "none");

                }
                // console.log('wrong', wrong);

                // $(".second-popup__last").css("display", "block");

            },

            error: function (response, error) {
                $("#otp").removeClass("myspinner");
                // var errorMessage = response.data.message + ': '
                // alert('Error - ' + errorMessage);
            }
        });
    })

    $('#otp-change').on('click', function () {
        Cookies.remove('token');
        window.location.href = baseUrl + "contact-number";

    })
</script>