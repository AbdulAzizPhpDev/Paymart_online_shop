{fn_print_die("sadassad")}
<div class="modal-content">
    <div class="container-content">
        <div class="content-main">
            <div class="main-form" id="modal-popup">
                <form method="post" action="https://dev.paymart.uz/api/v1/login/send-sms-code">
                    <div id="London" class="city">
                        <div class="main-content">
{*                            <span class="close">&times;</span>*}
                            <img src="https://via.placeholder.com/184x48.png" id="brand-image" alt="brand">
                            <p class="main-content__title">
                                Войдите в ваш кабинет
                            </p>
                            <div class="text-main">
                                <p> номер телефона</p>
                                <input class="contact_number" type="text" id="phone-form"
                                       name="result_ids" placeholder="+(998)97-777-77-77">
                            </div>
                            <div class="info-ico">
                                <img src="/images/icons/info-ico.png" alt="info ico" class="image-png__size">
                                Публичная оферта
                            </div>
                            <div class="text-main__last">
                                <input class="contact-check" type="radio" id="contactChoice2"
                                       name="result_ids">
                                <label for="contactChoice2">just check something</label>
                                <br>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- modal-popup -->
        <p id="notif" style="display: none;"></p>
        <div class="button-main_form">

            <button class="button-item" type="submit" id="submit">Войти</button>
        </div>

    </div>


</div>

<script>
    const params6 = new URLSearchParams(window.location.search)
    const exp = params6.get('exp')
    const card = params6.get('card')

    console.log('obwit',exp, card)

    $('#submit').click(function () {
        console.log('clicked')
        let phoneFirst = $(".contact_number").val().replace(/[+()-]/g, '');
        $("#submit").addClass("myspinner8");

        // var checked = $("input[type='checkbox'][name='result_ids']:checked").val();
        // let number = state.phone.slice(0, 6) + '*****' + state.phone.slice(10, 15);
        // document.querySelector("#prompt-span").innerHTML = number.replace(/[()]/g, '');
        // console.log(state.phone)
        setTimeout(function () {
            $("#submit").removeClass("myspinner8");
        }, 3000);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                phone: phoneFirst,
            },
            success: function (response) {
                console.log(response);
                // let reged = response.data.data.user_status;
                console.log('responseStatus', response.status)
                if (response.status === 'success') {
                    console.log('responseStatus', response.status)
                    window.location.href = baseUrl + "otp&phone=" + phoneFirst;


                }
                else {
                    let notification = document.getElementById('notif');
                    $(notification).css("display", "block");
                    $(notification).css("fontSize", "18px");
                    $(notification).css("fontWeight", "bold");
                    notification.innerHTML = response.info;

                }


            },
            // error: function (jqXHR, textStatus, errorThrown) {
            //     console.log('error', textStatus, errorThrown);
            //  }
            error: function (response) {

            }
        });

    })


    $(function () {
        //2. Получить элемент, к которому необходимо добавить маску
        $("#phone-form").mask("+999(99)-999-99-99");
    });




</script>