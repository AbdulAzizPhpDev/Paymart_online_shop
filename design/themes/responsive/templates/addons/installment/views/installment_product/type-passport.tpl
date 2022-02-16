{script src="js/addons/installment/type-passport.js"}

<div class="type-passport-page">
    <h1>Фото Интетифицирующего документа</h1>
    <span>Выберите что у вас </span>

    <div class="passports">
        <a href="{'installment_product.upload-passport'|fn_url}" class="passport">
            <img src="/design/themes/responsive/media/images/passport/first-page.png" width="84" alt="">
            <p>Паспорта</p>
        </a>
        <a href="{'installment_product.upload-passport'|fn_url}" class="id-card passport">
            <img src="/design/themes/responsive/media/images/passport/id-first-page.png" width="90" alt="">
            <img src="/design/themes/responsive/media/images/passport/id-second-page.png" width="90" alt="">
            <p>ID карта</p>
        </a>
    </div>

    <ul class="stepper">
        <li class="step"></li>
        <li class="step active"></li>
        <li class="step"></li>
    </ul>
</div>