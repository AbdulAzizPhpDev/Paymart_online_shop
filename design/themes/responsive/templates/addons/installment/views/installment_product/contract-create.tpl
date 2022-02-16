{script src="js/addons/installment/contract-create.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">


<div class="main-page">
    <div class="back-button">
        <img src="design/themes/responsive/media/images/addons/installment/back-arrow.png" alt="Arrow image">
    </div>
    <div class="container table-page">
        <div>
            <div class="section-one">
                <div class="main">
                    <div class="main-first">
                        <div class="main-profile">
                            <img class="main-profile__img"
                                 src="design/themes/responsive/media/images/addons/installment/profile.png"
                                 alt="Profile image">
                            <div class="main-profile__text">
                                <span class="main-profile__text-item">{$user['firstname']}  {$user['lastname']}</span>
                                <span class="main-profile__text-second">Тел: {$user['phone']}</span>
                            </div>
                        </div>
                        <div class="text-items__second">
                            <img src="design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="text-items__second-items">
                                <div class="first-item">Доступная рассрочка:</div>
                                <div class="second-item">3 000 000 сум</div>
                            </div>
                        </div>
                    </div>
                    <div class="status">
{*                <span class="status-item">*}
{*                    Не верефицирован*}
{*                </span>*}
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
{*                        {fn_print_die($product_info)}*}
                        <td>
                            {$product_info['product_descriptions']['product']}
                        </td>
                        <td>{$product_quantity}</td>

                        <td class="">{$product_quantity * $product_info['product_price']['price'] }</td>
                    </tr>
                    <tr>
                        <td class="orange">Итого</td>
{*                        {$total}*}
                        <td>{$product_quantity}</td>
                        <td class="orange">{$product_quantity * $product_info['product_price']['price'] }</td>
                    </tr>
                </table>

                <input type="hidden" value="{$product_info['product_price']['price']}" id="price">
                <input type="hidden" value="{$product_quantity}" id="quantity">
                <input type="hidden" value="{$product_info['product_descriptions']['product']}" id="name_product">
                <input type="hidden" value="{$product_info['p_c_token']}" id="seller_token">
                <input type="hidden" value="{$product_info['p_c_id']}" id="seller_id">
                <input type="hidden" value="{$user['p_user_id']}" id="user_id">

                <h2 class="second-title">
                    Расчет стоимости
                </h2>


                <div class="input-paying">


                </div>
            </div>

            <div class="section-three">

{*<<<<<<< HEAD*}
{*                <form style="margin-top:4px;">*}
{*                    <div class="d-flex flex-column">*}
{*                        <label for="cars">Выберите срок:</label>*}
{*                        <div class="input-paying">*}
{*                            <select name="cars" id="cars">*}
{*                                <option value="twelve">12 месяцев</option>*}
{*                                <option value="nine">9 месяцев</option>*}
{*                                <option value="six">6 месяцев</option>*}
{*                            </select>*}
{*                        </div>*}
{*                    </div>*}
{*                    <div class="input-link">*}
{*                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png"*}
{*                             alt="Billing ico">*}
{*                        <div class="input-paying__text">*}
{*                            <div class="input-paying__text-title">Ежемесячный платеж:</div>*}
{*                            <div class="input-paying__text-p">{$month} сум</div>*}
{*                        </div>*}
{*                    </div>*}
{*                    <div class="input-link">*}
{*                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png"*}
{*                             alt="Billing ico">*}
{*                        <div class="input-paying__text">*}
{*                            <div class="input-paying__text-title">Ежемесячный платеж:</div>*}
{*                            <div class="input-paying__text-p">{$total} сум</div>*}
{*                        </div>*}
{*                    </div>*}
{*                    <div>*}
{*                        <label for="cars">Выберите срок:</label>*}
{*                        <div class="input-paying">*}
{*                            <select name="cars" id="cars">*}
{*                                <option value="twelve">12 месяцев</option>*}
{*                                <option value="nine">9 месяцев</option>*}
{*                                <option value="six">6 месяцев</option>*}
{*                            </select>*}
{*                        </div>*}
{*=======*}
                <form class="d-flex" style="margin-top:4px;">
                    <div class="main-form">
                        <div class="d-flex flex-column">
                            <label for="cars">Выберите срок:</label>
                            <div class="input-paying">
                                <select name="selectName" id="selectedId">
                                    <option value="12">12 месяцев</option>
                                    <option value="9">9 месяцев</option>
                                    <option value="6">6 месяцев</option>
                                    <option value="3">3 месяцев</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-link">
                            <img src="design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="input-paying__text">
                                <div class="input-paying__text-title">Ежемесячный платеж:</div>
                                <div class="input-paying__text-a">{$month} сум</div>
                            </div>
                        </div>
                        <div class="input-link">
                            <img src="design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="input-paying__text">
                                <div class="input-paying__text-title">Итого с учетом расрочки:</div>
                                <div class="input-paying__text-p">{$total} сум</div>
                            </div>
                        </div>
                    </div>
                    <div class="main-form__another justify-content-center">
                        <div class="main-form__another-item">
                            <label for="inputAddress">Страна</label>
                            <input class="repeat-input" type="text" id="inputAddress" disabled value="Узбекистан">
                        </div>
                        <div class="main-form__another-item">
                               <label for="formAddress2">Город</label>
                               <div class="input-paying__unique">
                                   <select name="formAddress2" id="formAddress2">
                                       <option value="uzb">Ташкент</option>
                                       <option value="uzb">Ургенч</option>
                                       <option value="uzb">Фергана</option>
                                       <option value="ru">Нурафшон</option>
                                       <option value="ru">Гулистан</option>
                                       <option value="ru">Термез</option>
                                       <option value="ru">Самарканд</option>
                                       <option value="ru">Наманган</option>
                                       <option value="ru">Навои</option>
                                       <option value="ru">Карши</option>
                                       <option value="ru">Джизак</option>
                                       <option value="ru">Бухара</option>
                                       <option value="ru">Андижан</option>
                                       <option value="kz">Нукус</option>
                                   </select>
                               </div>
                        </div>
                        <div class="main-form__another-item">
                               <label for="formAddress">Район</label>
                               <div class="input-paying__unique">
                                   <select name="formAddress" id="formAddress">
                                       <option value="uzb">Ташкент</option>
                                       <option value="ru">Россия</option>
                                       <option value="kz">Казахстан</option>
                                   </select>
                               </div>
                        </div>
                    </div>
                    <div class="main-form__last">
                       <div class="main-form__last-item">
                           <label for="story">Адрес</label>
                           <textarea id="story" name="story"
                                     rows="5" cols="33"></textarea>
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
            <img src="design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
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

                   <button disabled class="ty-btn ty-btn__secondary" type="button" id="modal-sent">
                    Продолжить
                </button>
            </div>
        </div>
    </div>
</div>

{*the second modal*}

<div id="mySecondModal" class="secondModal">
    <div class="modal-content__second">
        <span class="close2">&times;</span>

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
            $('#modal-sent').removeAttr('disabled');
        },
    });


</script>