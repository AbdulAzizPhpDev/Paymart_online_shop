{*<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"*}
{*        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="*}
{*        crossorigin="anonymous" referrerpolicy="no-referrer"></script>*}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="/js/jquery.maskedinput.min.js" type="text/javascript"></script>
{style src="addons/installment/i_styles.less"}
{*{include file="views/installment/components/credit-script.tpl"}*}
{*<button id="myBtn">Open Modals</button>*}
{*<button id="logOut">Log out</button>*}
{*{fn_print_r($id)}*}
{if $id=="contact-number"}

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
{elseif $id=="card"}
    {*    {include file="views/installment_product/components/card.tpl" }*}
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


        var urlCard = "https://dev.paymart.uz/api/v1/buyer/send-sms-code-uz";

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
{elseif $id=="otp-card"}
    {include file="views/installment_product/components/otp-card.tpl"}
{elseif $id=="otp"}
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

        let baseUrls = 'http://market.paymart.uz/index.php?dispatch=installment_product.index&id=';

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
{elseif $id=="guarant"}
    {include file="views/installment_product/components/guarant.tpl"}
{elseif $id=="passport-firstpage"}
    <div class="main__input2">
        <h1 class="main__input-title">first page</h1>
        <form method="post">
            <div class="flex-vertical__centered">
                <div class="main__input-smth">
                    <label id="getFileLabel_1" class="getFileLabel" for="getFile2"></label>
                    <input type="file" onchange="fileChange('getFileLabel_1')" class="getFiles" id="getFile2"/>
                    <div class="fileMain">
                        <label class="getfile" for="getFile2" id="getFile">+</label>
                        <label class="getfile-span" for="getFile2">фото прописки</label>
                    </div>
                </div>
            </div>
        </form>
        <div class="btn-otp btn_continue">
            <p id="userNotFound" style="font-weight:bold;"></p>
            <button type="submit" id="sender2" class="btn-otp__item">Продолжить</button>
        </div>
    </div>

    <script>
        let urlFile = 'https://dev.paymart.uz/api/v1/buyer/verify/modify';
        let baseUrlPass = 'http://new-cs-cart.log/index.php?dispatch=register_form.index&id=';
        $('#sender2').on('click', function () {
            console.log(state);
            $("#sender2").addClass("myspinner4");
            let form = new FormData();
            form.append("passport_first_page", state.firstPageFile);
            // form.append("first_page_file", state.firstPageFile);
            // form.append("passport_adress", state.passportAdress);
            setTimeout(function () {
                $("#sender2").removeClass("myspinner4");
            }, 3000);
            // form.append("buyer_id", state.user_id);
            // form.append("api_token", Cookies.get('token'));
            // form.append("buyer_id", Cookies.get('userId'));
            // Cookies.set('token', token);
            // setTimeout(function(){
            //     $( "#sender" ).removeClass( "myspinner" );
            // }, 3000);
            if (form != null) {
                form.append("step", 2);
                form.append("type", 2);
                $.ajax({
                    type: 'POST',
                    url: urlFile,
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {
                        Authorization: "Bearer" + " " + Cookies.get('token'),
                    },
                    success: function (response) {
                        if (response.status === 'success') {

                            console.log('fileget', response);
                            // const status = response.data.user_status;
                            const saved = response.response.message[0].text;
                            $("#userNotFound").text(saved);
                            // window.location.href = baseUrl + "otp-card&phone=" + phone
                            window.location.href = baseUrlPass + "passport-selfie"
                            // $(".main__input2").css("display", "none");
                            // $(".main__input3").css("display", "block");
                            // Cookies.set('token', token);
                            // if (status == 1) {
                            //     console.log('status 1')
                            //
                            //     $(".main-otp").css("display", "none");
                            //
                            // }
                            // if(status == 5) {
                            //     console.log('status 5');
                            //
                            //     $(".main-otp").css("display", "none");
                            //     $("#card-form").css("display", "none");
                            //     // $(".second-popup__last").css("display", "block");
                            //     $(".main__input").css("display", "block");
                            //
                            // }
                            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            //     if (userStatus == 1) {
                            //         console.log('status 1')
                            //         window.location.href = baseUrlPass + "card";
                            //         $("#card-form").css("display", "block");
                            //         $(".main-otp").css("display", "none");
                            //
                            //     }
                            //     if (userStatus == 4) {
                            //         console.log('status 1')
                            //         $(".second-popup").css("display", "block");
                            //         $(".main-otp").css("display", "none");
                            //
                            //     }
                            //     if (userStatus == 5) {
                            //         console.log('status 5');
                            //
                            //         $(".main-otp").css("display", "none");
                            //         $("#card-form").css("display", "none");
                            //         // $(".second-popup__last").css("display", "block");
                            //         $(".main__input").css("display", "block");
                            //
                            //     }
                            // }  else {
                            //     let fileGetWrong = response.response.message[0]?.text;
                            //     $('#userNotFound').text(fileGetWrong);
                            //
                            //
                            // }

                            // }

                        } else {
                            $("#userNotFound").text('iltimos rasm yuklang');
                        }
                    }
                })
            }
        })
    </script>

{*    {include file="views/installment_product/components/passport-firstpage.tpl"}*}
{elseif $id=="passport-selfie"}
    {include file="views/installment_product/components/passport-selfie.tpl"}
{elseif $id=="passport-adress"}
    {include file="views/installment_product/components/passport-adress.tpl"}
{elseif $id=="credit-script"}
    {include file="views/installment_product/components/credit-script.tpl"}
{elseif $id=="product-status"}
    {include file="views/installment_product/components/product-status.tpl"}
{elseif $id=="refusal"}
    {include file="views/installment_product/components/refusal.tpl"}
{elseif $id=="waiting-clock"}
    {include file="views/installment_product/components/waiting-clock.tpl"}
{/if}


<script type="text/javascript">
    // $(document).ready(function(){
    //
    // });

    // new Vue({
    //     el:'#card-form',
    //     components: {
    //         ProductCard
    //     },
    //     created(){
    //         console.log('vue created')
    //     }
    // })
    //
    // if (Cookies.get('token')) {
    //     $(".clock-change").css("display", "block");
    // }

    let state = {
        phone: null,
        selfie: null,
        firstPageFile: null,
        passportAdress: null,
        user_id: null,
        cardValue: null,
        expValue: null,
        firstPhone: null,
        firstName: null,
        secondName: null,
        secondPhone: null,
    };


    var url = 'https://dev.paymart.uz/api/v1/login/send-sms-code';


    function sendSmsCode() {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                phone: state.phone,
            },
            success: function (response) {
                console.log('success');
                console.log(response);
                $(".main-otp").css("display", "block");
                let timer = 30;
                let interval = setInterval(function () {
                    timer = timer - 1;
                    if (timer === 0) {
                        clearInterval(interval)

                    }
                    document.getElementById('timeReverse').innerHTML = timer;
                }, 1000);

            },

        });

    }

    // if (response.status === 'success'){
    //     const status = response.data.user_status;
    //     const token = response.data.api_token;
    //
    let baseUrl = 'http://market.paymart.uz/index.php?dispatch=installment_product.index&id=';


    console.log(state.phone)
    // var modal = document.getElementById("myModal");
    // var btnMain = document.getElementById("submit");
    // btnMain.onclick = function () {
    //     modal.style.display = "none";
    // }

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    // btn.onclick = function () {
    //     modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal
    // span.onclick = function () {
    //     modal.style.display = "none";
    // }

    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function (event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // }

    $('.digit-group').find('input').each(function () {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function (e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if (prev.length) {
                    $(prev).select();
                }
            } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if (next.length) {
                    $(next).select();
                } else {
                    if (parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    // $('#otp-change').click(function () { // click to
    //     modal.style.display = "block";
    //
    // });


    // var urlSec = "https://market.paymart.uz/api/v1/login/auth";
    var urlSecCard = "https://market.paymart.uz/api/v1/buyer/send-sms-code-uz";

    var resStatus = "https://market.paymart.uz/api/v1/buyer/check_status";


    $('.digit-groups').find('input').each(function () {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function (e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if (prev.length) {
                    $(prev).select();
                }
            } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if (next.length) {
                    $(next).select();
                } else {
                    if (parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });


    // if(Cookies.get('token')){
    //     $("#card-form").css("display", "block");
    // }
    let productsurl = 'https://market.paymart.uz/api/v1/buyers/credit/add';

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
    // document.getElementsByClassName("prompt-span").innerHTML = number;



    // $('#logOut').on('click', function () {
    //     Cookies.remove('token');
    //     Cookies.remove('userId');
    //     location.reload();
    // })

    // $('#otp-change__card').on('click', function () {
    //     Cookies.remove('token');
    //     $(".main-otp__card").css("display", "none");
    //     location.reload();
    //     $('#myModal').css("display", "block");
    //
    // })
    // boshi 8600 98 60 boliwi kk, 7 8 - raqamlari: 08 32 bomasligi keraK
    //     cardNumber
    //         if(cardNumber.slice(0,4) !=  || cardNumber != 9860 ){
    //             alert()
    //         }
    //         elseif()

    //file get

    var form = new FormData();





    // $(function () {
    //     //2. Получить элемент, к которому необходимо добавить маску
    //     $("#main-first__phone").mask("+999(99)-999-99-99");
    //
    //
    //     $("#main-first__phone-second").mask("+999(99)-999-99-99");
    // });


</script>

