{script src="js/addons/installment/contract-create.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">


<div class="main-page">
    <div class="back-button">
        <img src="design/themes/responsive/media/images/addons/installment_image/back-arrow.png" alt="Arrow image">
    </div>
    <div class="container table-page">
        <div>
            <div class="section-one">
                <div class="main">
                    <div class="main-first">
                        <div class="main-profile">
                            <img class="main-profile__img"
                                 src="design/themes/responsive/media/images/addons/installment_image/profile.png"
                                 alt="Profile image">
                            <div class="main-profile__text">
                                <span class="main-profile__text-item">{$user['firstname']}  {$user['lastname']}</span>
                                <span class="main-profile__text-second">Тел: {$user['phone']}</span>
                            </div>
                        </div>
                        <div class="text-items__second">
                            <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png"
                                 alt="Billing ico">
                            <div class="text-items__second-items">
                                <div class="first-item">Доступная рассрочка:</div>
                                <div class="second-item">3 000 000 сум</div>
                            </div>
                        </div>
                    </div>
                    <div class="status">
                <span class="status-item">
                    Не верефицирован
                </span>
                    </div>
                </div>
                {*        <div class="main">*}
                {*            <div class="text-items">*}
                {*                <span class="text-items__span">998990778444</span>*}
                {*                <p>Вы не верефецированны, оформив договор вы пройдете регистрацию чтоб сделка состоялась</p>*}
                {*            </div>*}
                {*            <div class="status">*}
                {*            <span class="status-item">*}
                {*                Не верефицирован*}
                {*            </span>*}
                {*            </div>*}
                {*        </div>*}
            </div>
            <hr width="100%">

            <div class="section-two">
                <h2 class="second-title">
                    Товары
                </h2>

                <table>
                    <tr>
                        <td class="bolded">Наименование</td>
                        <td class="bolded">Кол-во</td>
                        <td class="bolded">Сумма НДС</td>
                    </tr>
                    <tr>
                        <td>
                            {$product_info['product_descriptions']['product']}
                        </td>
                        <td>{$product_quantity}</td>
                       
                        <td>{$product_quantity * $product_info['product_price']['price'] }</td>
                    </tr>
                    <tr>
                        <td class="orange">{$total}</td>
                        <td>{$product_quantity}</td>
                        <td class="orange">{$product_quantity * $product_info['product_price']['price'] }</td>
                    </tr>
                </table>


                <h2 class="second-title">
                    Расчет стоимости
                </h2>


                <div class="input-paying">


                </div>
            </div>

            <div class="section-three">

                <form style="margin-top:4px;">
                    <div class="d-flex flex-column">
                        <label for="cars">Выберите срок:</label>
                        <div class="input-paying">
                            <select name="cars" id="cars">
                                <option value="twelve">12 месяцев</option>
                                <option value="nine">9 месяцев</option>
                                <option value="six">6 месяцев</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-link">
                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png"
                             alt="Billing ico">
                        <div class="input-paying__text">
                            <div class="input-paying__text-title">Ежемесячный платеж:</div>
                            <div class="input-paying__text-p">{$month} сум</div>
                        </div>
                    </div>
                    <div class="input-link">
                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png"
                             alt="Billing ico">
                        <div class="input-paying__text">
                            <div class="input-paying__text-title">Ежемесячный платеж:</div>
                            <div class="input-paying__text-p">{$total} сум</div>
                        </div>
                    </div>
                    <div>
                        <label for="cars">Выберите срок:</label>
                        <div class="input-paying">
                            <select name="cars" id="cars">
                                <option value="twelve">12 месяцев</option>
                                <option value="nine">9 месяцев</option>
                                <option value="six">6 месяцев</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="form-button">
                    <button id="myBtn" class="form-button__item" type="submit" form="form1" value="Submit">Оформить
                        рассрочку
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">
            <img src="design/themes/responsive/media/images/addons/installment_image/Thin.png" alt="Close img">
        </span>
        <div class="card-add__page">
            <div class="card-confirm">
                <h1>Введите SMS код </h1>

                <div class="ty-control-group">
                    <p>Отправленный на номер <span class="sent-phone-number"></span></p>

                    <input type="tel" hidden
                           class="ty-login__input confirm-contract"/>
                </div>
                <div id="card-pin-wrapper"></div>

                <p class="resend-sms-card">Отправить SMS еще раз (через <span class="card-resend-sms-timer">60</span>
                    сек.)</p>

                <button class="ty-btn ty-btn__secondary" type="button" id="modal-sent">
                    Продолжить
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#card-pin-wrapper').pinlogin({
        placeholder: '*',
        hideinput: false,
        fields: 4,
        reset: false,
        complete: function (pin) {
            $('.confirm-contract').attr('value', pin);
        },
    });


</script>