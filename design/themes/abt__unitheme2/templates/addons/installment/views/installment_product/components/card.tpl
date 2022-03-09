<div class="container-content__card" id="card-form">
    <div class="content-main">
        <div class="main-form">
            <form method="post">
                <div id="London" class="city">
                    <div class="main-content">
                        <div class="text-main">
                            <product-card :products="[1,2,3,4]"></product-card>
                            <h2 v-if="true" style="text-align: center;">Пройдите одноразувую верификацию</h2>
                            <p>Номер карты</p>
                            <input class="contact" type="text" id="card"
                                   name="result_ids" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="text-main">
                            <p>Срок карты</p>
                            <input class="contact" type="text" id="exp"
                                   name="result_ids" placeholder="00/00">
                        </div>
                        {*                        <div class="text-main">*}
                        {*                            <br>*}
                        {*                            <input class="contact-check" type="checkbox" id="contactChoice2"*}
                        {*                                   name="result_ids"> just check something*}
                        {*                            <br>*}
                        {*                        </div>*}

                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="error_validate"></div>
    <div class="button-main_form">
        <button class="button-item__card" type="submit" id="send-btn">Войти</button>
        <button class="button-item__card" id="btn-return" style="display: none; margin: 3px 0" type="submit">
            Регистрация
        </button>
    </div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-center",
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


    var urlCard = "https://test.paymart.uz/api/v1/buyer/send-sms-code-uz";

    const params = new URLSearchParams(window.location.search)

    const phone = params.get('phone')
    console.log('params', phone)
    // if (phone != null) {
    //     let number6 = phone.slice(0, 6) + '*****' + phone.slice(10, 15);
    // }

    // document.querySelector("#prompt-span").innerHTML = number6.replace(/[()]/g, '');

    $('#send-btn').on('click', function () {
        // const params6 = new URLSearchParams(window.location.search)


        // var card = $("#card").val().replace(/[^0-9\.]/g, '');
        // var exp = $("#exp").val().replace(/[^0-9\.]/g, '');
        // state.cardValue = card;
        // state.expValue = exp;
        // console.log('telku',phone)
        // let number6 = phone.slice(0, 6) + '*****' + phone.slice(10, 15);
        // var checked = $("input[type='tel'][name='result_ids']:focus").val();
        $("#send-btn").addClass("myspinner1");
        var card = $("#card").val().replace(/[^0-9\.]/g, '');
        var exp = $("#exp").val().replace(/[^0-9\.]/g, '');
        state.cardValue = card;
        state.expValue = exp;
        console.log(card, exp);
        setTimeout(function () {
            $("#send-btn").removeClass("myspinner1");
        }, 3000);
        // let number2 = state.phone.slice(0, 6) + '*****' + state.phone.slice(10, 15);
        // document.querySelector("#prompt-span1").innerHTML = number2.replace(/[()]/g, '');
        $.ajax({
            type: "POST",
            url: urlCard,
            data: {
                // phone: state.phone,
                card: card,
                exp: exp,
            },
            headers: {
                Authorization: "Bearer" + " " + Cookies.get('token'),
            },
            success: function (response) {
                $("#send-btn").removeClass("myspinner1");
                const statusSecond = response.status;
                const phoneNotEqual = response.info;

                if (statusSecond == 'error_card_scoring') {
                    console.log(response);
                    document.querySelector('.error_validate').innerHTML = 'scoring fail';

                     window.location.href = baseUrl + "passport-firstpage";///////////////////////////////////////////////////////////////////////////////////////////////////
                } else if (phoneNotEqual == 'error_phone_not_equals') {
                    console.log(response);
                    document.querySelector('.error_validate').innerHTML = 'phone not equal';
                    $("#btn-return").css("display", "block");

                    $('#btn-return').on('click', function () {
                        window.location.href = baseUrl + "contact-number"
                        Cookies.remove('token');
                        location.reload();
                        // setTimeout(function(){
                        //     document.getElementById("myModal").style.display = 'block';
                        //     $("#myModal").css("display", "block");
                        // }, 3000);
                    });
                } else if (phoneNotEqual == 'error_card_sms_off') {
                    console.log(response);
                    document.querySelector('.error_validate').innerHTML = 'error card sms off';
                    // toastr.error('card message off')
                    toastr.warning('card message off')

                } else if (phoneNotEqual == 'error_card_equal') {
                    console.log(response);
                    document.querySelector('.error_validate').innerHTML = 'error card equal';
                    // toastr.error('card is not equal');
                    toastr.warning('card equal')


                } else if (statusSecond == 'success') {
                    //tekishiraman
                    window.location.href = baseUrl + "otp-card&phone=" + phone + "&card=" + card + "&exp=" + exp;


                    // $(".main-otp__card").css("display", "block");
                    // $('#card-form').css("display", "none");
                }
                console.log(response);
            }
        });
    })


    $(function () {
        //2. Получить элемент, к которому необходимо добавить маску
        $(".contact").mask("9999 9999 9999 9999");
    });
    $(function () {
        //2. Получить элемент, к которому необходимо добавить маску
        $("#exp").mask("99 / 99");
    });
</script>