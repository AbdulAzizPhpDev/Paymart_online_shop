<div class="second-popup">
    <div class="container-content__second">
        <div class="content-main">
            <div class="content-main__form" id="modal-popup">
                <div class="popup-head">
                    <h2 class="second-popup__title" id="phone-number"></h2>
                    <div class="popup-head__text">
                        <p class="second-popup__description">Вы не верефецированны, оформив договор вы пройдете
                            регистрацию чтоб сделка состоялась</p>
                        <span class="popup-head__status">Не верефицирован</span>
                    </div>
                </div>
                <hr class="popup-line-rule">
                <div class="popup-main__content">
                    <h1 class="content-header">
                        Товары
                    </h1>
                    <table border="bordered" class="content-table">
                        <tr>
                            <th class="table-first">Наименование</th>
                            <th>Кол-во</th>
                            <th>Сумма НДС</th>
                        </tr>
                        <tr>
                            <td class="table-first">Alfreds Futterkiste</td>
                            <td>Maria Anders</td>
                            <td>Germany</td>
                        </tr>
                        <tr>
                            <td class="table-sum table-first">Итого</td>
                            <td>Francisco Chang</td>
                            <td>Mexico</td>
                        </tr>
                    </table>
                    <h1 class="content-header">Расчет стоимости</h1>

                    <div class="content-footer">
                        <div class="content-footer__item item-input">
                            <label for="options">Срок рассрочки</label>
                            <select name="options" id="options">
                                <option value="first">на 3 месяцев</option>
                                <option value="second">на 6 месяцев</option>
                                <option value="third">на 9 месяцев</option>
                                <option value="fourth">на 12 месяцев</option>
                            </select>
                            <br><br>

                        </div>
                        <div class="content-footer__item">
                            <img src="/images/companies/1/news/cart.png" alt="money ico">
                            <div class="second_item"><h3>Ежемесячный платеж:</h3>
                                <p>120 000 сум</p>
                            </div>
                        </div>
                        <div class="content-footer__item">
                            <img src="/images/companies/1/news/money.png" alt="money ico">
                            <div class="third_item"><h3>Итого с учетом расрочки:</h3>
                                <p>3 600 000 сум</p>
                            </div>
                        </div>

                    </div>
                    <button class="btn-submit_send" id="registered" type="submit">Оформить рассрочку</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>


    var e = document.getElementById("options");
    var value = e.options[e.selectedIndex].value;

    console.log(value)

    $('#registered').on('click', function () {
        $("#registered").addClass("myspinner");
        setTimeout(function () {
            $("#registered").removeClass("myspinner");
        }, 3000);


        var e = document.getElementById("options");
        var SelectValue = e.options[e.selectedIndex].value;
        console.log(SelectValue)

        // let vuela = document.querySelector("#prompt-span").innerHTML = number2.replace(/[()]/g, '');
        // state.phone = $(".contact_number").val();
        // var checked = $("input[type='checkbox'][name='result_ids']:checked").val();
        // let number2 = state.phone.slice(0, 6) + '*****' + state.phone.slice(10, 15);
        // document.querySelector("#prompt-span1").innerHTML = number3.replace(/[()]/g, '');

        //
        // let valueCardType = $("#digitcard-1").val();
        // valueCardType += $("#digitcard-2").val();
        // valueCardType += $("#digitcard-3").val();
        // valueCardType += $("#digitcard-4").val();
        // console.log('valuecard', valueCardType)

        // if (valueCardType.length == 0 || valueCardType.length < 4) {
        //     alert("empty")
        // }
        //
        // $.ajax({
        //     type: "post",
        //     url: urlSecCardCheck,
        //     headers: {
        //         Authorization: "Bearer" + " " + Cookies.get('token'),
        //     },
        //     data: {
        //         code: valueCardType,
        //         card_number:card,
        //         card_valid_date: exp,
        //
        //
        //     },
        //
        //     success: function (response) {
        //         $("#otp__card").removeClass("myspinner");
        //         console.log('sucesscard', response.error)
        //         console.log(response)
        //         if (response.status === 'success') {
        //             // $("#otp__card").removeClass("myspinner");
        //             // $(".main-otp__card").css("display", "none");
        //             // $(".main__input").css("display", "block");
        //             let luck = response.response.message[0].text;
        //             window.location.href = baseUrl + "passport-firstpage";
        //             $('.isWrong__card').text(luck);
        //             // $('.isWrong').text(wrongCode);
        //             // const userStatus = response.data.user_status;
        //             // const userId = response.data.user_id;
        //             // state.user_id = userId
        //             // const token = response.data.api_token;
        //             // Cookies.set('token', token);
        //             // Cookies.set('userId', userId);
        //             // console.log('userstatus', userStatus)
        //             //
        //             // if (userStatus == 1) {
        //             //     console.log('status 1')
        //             //     $("#card-form").css("display", "block");
        //             //     $(".main-otp").css("display", "none");
        //             //
        //             // }
        //             // if (userStatus == 4) {
        //             //     console.log('status 1')
        //             //     $(".second-popup").css("display", "block");
        //             //     $(".main-otp").css("display", "none");
        //             //
        //             // }
        //             // if(userStatus == 5) {
        //             //     console.log('status 5');
        //             //
        //             //     $(".main-otp").css("display", "none");
        //             //     $("#card-form").css("display", "none");
        //             //     // $(".second-popup__last").css("display", "block");
        //             //     $(".main__input").css("display", "block");
        //             //
        //             // }
        //         } else {
        //             let wrongCode = response.error;
        //             $(".isWrong__card").css("display", "block");
        //             $('.isWrong__card').text(wrongCode);
        //             $(".sendMessageCodeText").css("display", "none");
        //
        //         }
        //         // console.log('wrong', wrong);
        //
        //         // $(".second-popup__last").css("display", "block");
        //
        //     },
        //     error: function (response, error) {
        //         // var errorMessage = response.data.message + ': '
        //         // alert('Error - ' + errorMessage);
        //     }
        // });


    })

</script>