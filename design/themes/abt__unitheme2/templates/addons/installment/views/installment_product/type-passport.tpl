{script src="js/addons/installment/type-passport.js"}

<div class="type-passport-page">
    <h1>{__('authentication.type_passport.title')}</h1>
    <span>{__('authentication.type_passport.subtitle')}</span>

    <div class="passports">
        <a href="{'installment_product.upload-passport'|fn_url}" class="passport">
            <img src="/design/themes/responsive/media/images/passport/first-page.png" width="84" alt="">
            <p>{__('authentication.type_passport.passport')}</p>
        </a>
        <a href="{'installment_product.upload-passport-id'|fn_url}" class="id-card passport">
            <img src="/design/themes/responsive/media/images/passport/id-first-page.png" width="90" alt="">
            <img src="/design/themes/responsive/media/images/passport/id-second-page.png" width="90" alt="">
            <p>{__('authentication.type_passport.id_card')}</p>
        </a>
    </div>

    <ul class="stepper">
        <li class="step"></li>
        <li class="step active"></li>
        <li class="step"></li>
    </ul>
</div>