<div class="trust">
    <div class="trust-page" >
        <h1 class="trust-page_title">Доверительное лицо</h1>
        <p class="trust-page_text">
            Введите данные доверительных лиц
        </p>

        <div class="trust-page__main">

            <div class="main-first">
                <h3>
                    Контакное лицо - 1
                </h3>
                <p>ИФО</p>
                <input type="text" class="main-first__input" placeholder="Введите ИФО">
                <p>Номер телефона</p>
                <input type="tel" class="main-first__phone" id="main-first__phone" placeholder="+998">
            </div>
            <div class="main-second">
                <h3>
                    Контакное лицо - 2
                </h3>
                <p>ИФО</p>
                <input type="text" class="main-second__input" placeholder="Введите ИФО">
                <p>Номер телефона</p>
                <input type="tel" class="main-second__phone" id="main-first__phone-second" placeholder="+998">
            </div>
        </div>
        <div class="btn-otp btn_continue continue_trust">
            <button type="submit" id="trust-page__button" class="btn-otp__item">Продолжить</button>

        </div>
    </div>
</div>

<script>
    let urlGuarant = 'https://dev.paymart.uz/api/v1/buyer/add-guarant';

    $('#trust-page__button').click(function () {
        state.firstName = $(".main-first__input").val();
        state.firstPhone = $(".main-first__phone").val();
        state.secondName = $(".main-second__input").val();
        state.secondPhone = $(".main-second__phone").val();
        $("#trust-page__button").addClass("myspinner5");
        console.log(state.secondName, state.secondName, state.firstPhone, state.firstName);
        console.log('buyer', Cookies.get('userId'))
        setTimeout(function () {
            $("#trust-page__button").removeClass("myspinner5");
        }, 3000);
        $.ajax({
            type: "POST",
            url: urlGuarant,
            data: {
                api_token: Cookies.get('token'),
                buyer_id: Cookies.get('userId'),
                name: state.firstName,
                phone: state.firstPhone.replace(/[^0-9\.]/g, ''),

                // api_token:  Cookies.get('token'),
                // buyer_id:  Cookies.get('userId'),
                // name: state.secondName,
                // phone: state.secondPhone.replace(/[^0-9\.]/g, ''),
            },
            // headers: {
            //     Authorization: "Bearer" + " " + Cookies.get('token'),
            // },
            success: function (response) {
                console.log(response);
                // let reged = response.data.data.user_status;
                if (response.status === 'success') {
                    console.log('success trust');
                    window.location.href = baseUrl + "waiting-clock";
                    $(".clock-change").css("display", "block");
                    $(".trust").css("display", "none");
                    // let timer = 30;
                    // let interval = setInterval(function () {
                    //     timer = timer - 1;
                    //     if (timer === 0) {
                    //         clearInterval(interval);
                    //         let sendMessageBtn = document.getElementById("sendMessageCode");
                    //         sendMessageBtn.style.display = "block";
                    //     }
                    //     document.getElementById('timeReverse').innerHTML = timer;
                    // }, 1000);
                }

            },
            // error: function (jqXHR, textStatus, errorThrown) {
            //     console.log('error', textStatus, errorThrown);
            //  }
            error: function (response) {

            }
        });

    })
</script>