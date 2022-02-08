{script src="js/addons/installment/contract-create.js"}
{*<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">*}
{*<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>*}



<div class="main-page">
    <div class="back-button">
        <img src="design/themes/responsive/media/images/addons/installment_image/back-arrow.png" alt="Arrow image">
    </div>
    <div class="container table-page" >

        <div class="container">
            <div class="section-one">
                <div class="main">
                    <div class="main-first">
                        <div class="main-profile">
                            <img class="main-profile__img" src="design/themes/responsive/media/images/addons/installment_image/profile.png" alt="Profile image">
                            <div class="main-profile__text">
                                <span class="main-profile__text-item">Robert Fox</span>
                                <span class="main-profile__text-second">Тел: +998990778444</span>
                            </div>
                        </div>
                        <div class="text-items__second">
                            <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png" alt="Billing ico">
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
                        <td>intel-core i3 10100F 4C\8T 3.6-4,3 GHz, 6M, TRAY, LGA1200, Comet Lake (Только с материнкской платой) (tray)</td>
                        <td>2</td>
                        <td>3 000 000</td>
                    </tr>
                    <tr>
                        <td class="orange">Итого</td>
                        <td>2</td>
                        <td class="orange">3 000 000</td>
                    </tr>
                </table>


                <h2 class="second-title">
                    Расчет стоимости
                </h2>


                <div class="input-paying">


                </div>
            </div>

            <div class="section-three">
                <label for="fname">Срок рассрочки</label>
                <form style="margin-top:4px;">

                    <div class="input-paying">
                        <input type="text" id="fname" name="fname" placeholder="Введите срок">
                    </div>
                    <div class="input-link">
                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png" alt="Billing ico">
                        <div class="input-paying__text">
                            <div class="input-paying__text-title">Ежемесячный платеж:</div>
                            <div class="input-paying__text-p">120 000 сум</div>
                        </div>
                    </div>
                    <div class="input-link">
                        <img src="design/themes/responsive/media/images/addons/installment_image/billing-ico.png" alt="Billing ico">
                        <div class="input-paying__text">
                            <div class="input-paying__text-title">Ежемесячный платеж:</div>
                            <div class="input-paying__text-p">120 000 сум</div>
                        </div>
                    </div>
                </form>
                <div class="form-button">
                    <button class="form-button__item" type="submit" form="form1" value="Submit">Оформить рассрочку</button>
                </div>
            </div>
        </div>
    </div>
</div>

