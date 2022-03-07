{script src="js/addons/installment/contract-create.js"}
{script src="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.min.js"}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-pinlogin@1.0.3/src/jquery.pinlogin.css">


<div class="main-page">
    {if isset($redirect_url)}
        <a href="{$redirect_url|fn_url}" class="back-button">
            <img src="/design/themes/responsive/media/images/addons/installment/back-arrow.png" alt="Arrow image">
        </a>
    {else}
        <a href="/" class="back-button">
            <img src="/design/themes/responsive/media/images/addons/installment/back-arrow.png" alt="Arrow image">
        </a>
    {/if}
    <div class="container table-page">
        <div>
            <div class="section-one">
                <div class="main">
                    <div class="main-first">
                        <div class="main-profile">
                            <img class="main-profile__img"
                                    {*                                 src="/design/themes/responsive/media/images/addons/installment/profile.png"*}
                                 src="/design/themes/responsive/media/images/user.png"
                                 alt="Profile image">
                            <div class="main-profile__text">
                                <span class="main-profile__text-item">{$user['firstname']}  {$user['lastname']}</span>
                                <span class="main-profile__text-second">Тел: {$user['phone']}</span>
                                <input id="phone_input" type="hidden" value="{$user['phone']}">
                            </div>
                        </div>
                        <div class="text-items__second">
                            <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="text-items__second-items">
                                <div class="first-item">Доступная рассрочка:</div>
                                <div class="second-item">{$user['i_limit']} сум</div>
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
                            <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="input-paying__text">
                                <div class="input-paying__text-title">Ежемесячный платеж:</div>
                                <div class="input-paying__text-a">{$month} сум</div>
                            </div>
                        </div>
                        <div class="input-link">
                            <img src="/design/themes/responsive/media/images/addons/installment/billing-ico.png"
                                 alt="Billing ico">
                            <div class="input-paying__text">
                                <div class="input-paying__text-title">Итого с учетом наценки:</div>
                                <div class="input-paying__text-p">{$total} сум</div>
                            </div>
                        </div>
                    </div>
                    <div class="main-form__another">
                        <div class="main-form__another-item">
                            <label for="inputAddress">Страна</label>
                            <input class="repeat-input" type="text" id="inputAddress" disabled value="Узбекистан">
                        </div>
                        <div class="main-form__another-item">
                            <label for="formAddress2">Город</label>
                            <div class="input-paying__unique">
                                <select name="formAddress2" id="formAddress2">
                                    {foreach $city as $value}
                                        <option value="{$value['city_id']}">{$value['city_name']}</option>
                                    {/foreach}
                                </select>

{*                                {foreach $city as $value}*}
{*                                    {$value . “<br>”}*}
{*                                {/foreach}*}

                            </div>
                        </div>
                        <div class="main-form__last-input">
                            {*                            <label for="formAddress">Район</label>*}
                            {*                            <div class="input-paying__unique">*}
                            {*                                <select name="formAddress" id="formAddress">*}
                            {*                                    <option value="uzb">Ташкент</option>*}
                            {*                                    <option value="ru">Россия</option>*}
                            {*                                    <option value="kz">Казахстан</option>*}
                            {*                                </select>*}
                            {*                            </div>*}
                            {*                            <div class="last-item__style">*}
                            {*                                <label for="story6">Район</label>*}
                            {*                                <select name="formAddress2" id="story6">*}
                            {*                                    <option value="{$value['city_id']}">{$value['city_name']}</option>*}
                            {*                                </select>*}
                            {*                            </div>*}
                            <div class="main-form__another-item">
                                <label for="formAddress3">Район</label>
                                <div class="input-paying__unique">
                                    <div class="last-item__style" id="formAddress-div">
                                        <select name="formAddress3" id="formAddress3" class="tashkent-regions d-none">
                                            {*                                        <option disabled="disabled" selected="selected"></option>*}
                                        </select>
                                        <input type="text" placeholder="Region" class="not-tashkent-region">
                                    </div>
                                    {*                                    <div class="last-item__style" id="formAddress7" style="display: none">*}
                                    {*                                    </div>*}
                                    {*                                    <div class="last-item__style" id="formAddress4" style="display: none">*}
                                    {*                                        <input type="text" placeholder="region">*}
                                    {*                                    </div>*}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-form__last">
                        <div class="main-form__last-item">
                            <div class="last-item__style">
                                <label for="story">Квартира </label>
                                <input id="story" type="text">
                            </div>
                            <div class="last-item__style">
                                <label for="story2">Дом </label>
                                <input id="story2" type="text">
                            </div>
                            <div class="last-item__style">
                                <label for="story3">Улица</label>
                                <input id="story3" type="text">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="form-button">
                    <span>
                        {if $notifier }
                            <!-- The Modal -->
                            <div id="myModal5" class="modal5">
                                   <a href="{$redirect_url|fn_url}">
                                <!-- Modal content -->
                                      <div class="modal-content5">
    {*                                    <span class="close5">&times;</span>*}
                                        <div class="modal-content5__item">
                                            <p> Mablag' yetarli emas, call centerga murojaat qiling.</p>
                                            <span>+998 71 209 2500</span>
                                        </div>&nbsp; &nbsp;
                                               <div>
                                                    <img src="/design/themes/responsive/media/images/addons/installment/back-arrow.png"
                                                         alt="Arrow image">
                                               </div>
                                      </div>
                                   </a>
                                </div>
                        {/if}
                    </span>
                    <button id="myBtn" class="form-button__item" type="submit" form="form1">Оформить
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
            <img src="/design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
        </span>
        <div class="card-add__page">
            <div class="card-confirm">
                <h1>Введите SMS код </h1>

                <div class="ty-control-group">
                    {*                    <p>Отправленный на номер <span class="">{$user['phone']}</span></p>*}

                    <input type="tel" hidden
                           class="ty-login__input confirm-contract" />
                </div>
                <div id="card-pin-wrapper"></div>

                <p class="resend-sms-card">Отправить SMS еще раз (через <span class="card-resend-sms-timer">60</span>
                    сек.)</p>
                <span class="modal-error"></span>
                <button disabled class="ty-btn ty-btn__secondary" type="button" id="modal-sent">
                    Продолжить
                </button>
            </div>
        </div>
    </div>
</div>

{*the second modal*}

<div id="myModal1" class="modal1" style="display: none;">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">
            <img src="/design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
        </span>
        <div class="card-add__page">
            <div class="card-confirm">

            </div>
        </div>
    </div>
</div>
{*<div id="mySecondModal" class="secondModal">*}
{*    <div class="modal-content__second">*}
{*        <span class="close2">&times;</span>*}

{*    </div>*}
{*</div>*}

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