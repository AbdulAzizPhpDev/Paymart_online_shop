<div class="main-otp__card">
    <div class="prompt">
        <h1 style="font-weight: bold;">Введите SMS КОД</h1>
        <p style="font-weight: bold;"> Отправленный <br>на номер <span id="prompt-span1"></span></p>
    </div>

    <form method="post" class="digit-groups" data-group-name="digits" data-autosubmit="false" autocomplete="off">
        <input type="text" id="digitcard-1" name="digitcard-1" data-next="digitcard-2"/>
        <input type="text" id="digitcard-2" name="digitcard-2" data-next="digitcard-3" data-previous="digitcard-1"/>
        <input type="text" id="digitcard-3" name="digitcard-3" data-next="digitcard-4" data-previous="digitcard-2"/>
        <input type="text" id="digitcard-4" name="digitcard-4" data-next="digitcard-5" data-previous="digitcard-3"/>
    </form>
    <div class="main-send-message">
        <p class="isWrong__card"
           style="display: none; color: #FF0000; font-size: 15px;font-weight: 700; margin: 2px; padding: 6px 10px;"></p>
        <button type="submit" id="sendMessageCode" style="display: none">Отправить</button>
    </div>
    <div class="btn-otp">
        <button id="otp__card" class="btn-otp__item" type="submit">Войти</button>
        <button id="otp-change__card1" class="btn-otp__second" type="submit">Изменить номер</button>
    </div>
</div>

<script>
    var urlSecCardCheck = "https://dev.paymart.uz/api/v1/buyer/check-sms-code-uz";
    const params3 = new URLSearchParams(window.location.search)
    const phone3 = params3.get('phone')
    const exp = params3.get('exp')
    const card = params3.get('card')
    console.log('params', card, exp, phone3)
    let number3 = phone3.slice(0, 6) + '*****' + phone3.slice(10, 15);
    document.querySelector("#prompt-span1").innerHTML = number3.replace(/[()]/g, '');


    $('#otp__card').on('click', function () {
        $("#otp__card").addClass("myspinner");
        setTimeout(function () {
            $("#otp__card").removeClass("myspinner");
        }, 3000);


        // let vuela = document.querySelector("#prompt-span").innerHTML = number2.replace(/[()]/g, '');
        // state.phone = $(".contact_number").val();
        // var checked = $("input[type='checkbox'][name='result_ids']:checked").val();
        // let number2 = state.phone.slice(0, 6) + '*****' + state.phone.slice(10, 15);
        document.querySelector("#prompt-span1").innerHTML = number3.replace(/[()]/g, '');


        let valueCardType = $("#digitcard-1").val();
        valueCardType += $("#digitcard-2").val();
        valueCardType += $("#digitcard-3").val();
        valueCardType += $("#digitcard-4").val();
        console.log('valuecard', valueCardType)

        if (valueCardType.length == 0 || valueCardType.length < 4) {
            alert("empty")
        }

        $.ajax({
            type: "post",
            url: urlSecCardCheck,
            headers: {
                Authorization: "Bearer" + " " + Cookies.get('token'),
            },
            data: {
                code: valueCardType,
                card_number:card,
                card_valid_date: exp,


            },

            success: function (response) {
                $("#otp__card").removeClass("myspinner");
                console.log('sucesscard', response.error)
                console.log(response)
                if (response.status === 'success') {
                    // $("#otp__card").removeClass("myspinner");
                    // $(".main-otp__card").css("display", "none");
                    // $(".main__input").css("display", "block");
                    let luck = response.response.message[0].text;
                    window.location.href = baseUrl + "passport-firstpage";
                    $('.isWrong__card').text(luck);
                    // $('.isWrong').text(wrongCode);
                    // const userStatus = response.data.user_status;
                    // const userId = response.data.user_id;
                    // state.user_id = userId
                    // const token = response.data.api_token;
                    // Cookies.set('token', token);
                    // Cookies.set('userId', userId);
                    // console.log('userstatus', userStatus)
                    //
                    // if (userStatus == 1) {
                    //     console.log('status 1')
                    //     $("#card-form").css("display", "block");
                    //     $(".main-otp").css("display", "none");
                    //
                    // }
                    // if (userStatus == 4) {
                    //     console.log('status 1')
                    //     $(".second-popup").css("display", "block");
                    //     $(".main-otp").css("display", "none");
                    //
                    // }
                    // if(userStatus == 5) {
                    //     console.log('status 5');
                    //
                    //     $(".main-otp").css("display", "none");
                    //     $("#card-form").css("display", "none");
                    //     // $(".second-popup__last").css("display", "block");
                    //     $(".main__input").css("display", "block");
                    //
                    // }
                } else {
                    let wrongCode = response.error;
                    $(".isWrong__card").css("display", "block");
                    $('.isWrong__card').text(wrongCode);
                    $(".sendMessageCodeText").css("display", "none");

                }
                // console.log('wrong', wrong);

                // $(".second-popup__last").css("display", "block");

            },
            error: function (response, error) {
                // var errorMessage = response.data.message + ': '
                // alert('Error - ' + errorMessage);
            }
        });


    })

    $('#otp-change__card1').on('click', function () {
        Cookies.remove('token');
        window.location.href = baseUrl + "contact-number";

    })
</script>