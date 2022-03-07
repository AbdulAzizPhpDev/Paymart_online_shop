<div class="clock-change">
    <div class="clock-change__items">
        <lottie-player
                src="/js/lib/anim.json"
                background="transparent"
                speed="1"
                style="width: 300px; height: 300px"
                loop
                autoplay
        ></lottie-player>

        <div class="clock-main">

            <h1 class="clock-title">
                Ваша заявка обрабатывается
            </h1>
            <p class="clock-text">Это может занять несколько минут. Вам придет смс сообщеие о подписание договора</p>

            <div class="btn-otp btn-clock">
                <button class="button-item btn-otp__item" onclick="toastr.warning('nimadir')" type="submit" id="clocked">Войти</button>
            </div>
        </div>
    </div>
</div>


<script>

    let urlFileClock = 'https://market.paymart.uz/api/v1/buyer/check_status'
    // let urls = 'https://test.paymart.uz/api/v1/buyer/check_status'
    let baseUrls = 'http://market.paymart.uz/index.php?dispatch=register_form.index&id=';

    $('#clocked').on('click', function () {
        $("#clocked").addClass("myspinner2");
        console.log('clocked')
        toastr.warning('ishladi')
        setTimeout(function () {
            $("#clocked").removeClass("myspinner2");
        }, 3000);
        //     form.append("step", 2);
        $.ajax({
            type: 'GET',
            url: urlFileClock,
            headers: {
                Authorization: "Bearer" + " " + Cookies.get('token'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    const userStatus = response.data.status;
                    console.log('response', response)
                    const userId = response.data.user_id;
                    // state.user_id = userId
                    const token = response.data.api_token;

                    console.log('userstatus', userStatus)

                    if (userStatus == 1) {
                        console.log('status 1')
                        window.location.href = baseUrls + "card";
                        // $("#card-form").css("display", "block");
                        // $(".main-otp").css("display", "none");

                    }
                    if (userStatus == 2 || userStatus == 6) {
                        console.log('status 2')
                        location.reload()
                    }
                    if (userStatus == 4) {
                        console.log('status 4')
                        window.location.href = baseUrls + "product-status&phone=" + phone;


                    }
                    if (userStatus == 5) {
                        console.log('status 5');

                        $(".main-otp").css("display", "none");
                        $("#card-form").css("display", "none");
                        // $(".second-popup__last").css("display", "block");
                        $(".main__input").css("display", "block");

                    }
                } else {
                    let wrongCode = response.response.message[0]?.text;
                    $(".isWrong").css("display", "block");
                    $('.isWrong').text(wrongCode);
                    $(".sendMessageCodeText").css("display", "none");

                }

                // error: function () {
                //     console.log('main Errror')
                // }
            }

        })
    })
</script>

{*switch (response.data.status) {*}
{*case 0:*}
{*// window.location.href = baseUrl + "contact-number";*}
{*// $("#myModal").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 1:*}
{*// window.location.href = baseUrl + "card";*}
{*// $("#card-card-form").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 2 || 6:*}
{*window.location.href = baseUrl + "contact-number";*}
{*// $("#card-form").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 4:*}
{*// window.location.href = baseUrl + "contact-number";*}
{*// $("#card-form").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 5:*}
{*// window.location.href = baseUrl + "password-selfie";*}
{*// $(".main__input2").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 8:*}
{*// window.location.href = baseUrl + "refusal";*}
{*// $(".main__input").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 10:*}
{*// window.location.href = baseUrl + "contact-number";*}
{*// $(".main__input").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 11:*}
{*// window.location.href = baseUrl + "password-adress";*}
{*// $(".main__input3").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*case 12:*}
{*// window.location.href = baseUrl + "guarant";*}
{*// $(".trust").css("display", "block");*}
{*// $(".clock-change").css("display", "none");*}
{*break*}
{*}*}