{script src="js/addons/installment/guarant.js"}

<div class="guarant-page">
    <h1>{__('authentication.guarantee.title')}</h1>
    <span>{__('authentication.guarantee.subtitle')}</span>

    <div class="guarants">
        <div class="guarant">
            <h3>{__('authentication.guarantee.contact', ['[n]' => 1])}</h3>

            <p class="ty-mt-s"><label for="first-guarant-name">{__('fullname')}</label></p>
            <input id="first-guarant-name" type="text" placeholder="{__('ph_fullname')}">

            <p class="ty-mt-s"><label for="first-guarant-phone">{__('rapidaphone')}</label></p>
            <input id="first-guarant-phone" type="text" placeholder="+998">
        </div>
        <div class="guarant">
            <h3>{__('authentication.guarantee.contact', ['[n]' => 2])}</h3>

            <p class="ty-mt-s"><label for="second-guarant-name">{__('fullname')}</label></p>
            <input id="second-guarant-name" type="text" placeholder="{__('ph_fullname')}">

            <p class="ty-mt-s"><label for="second-guarant-phone">{__('rapidaphone')}</label></p>
            <input id="second-guarant-phone" type="text" placeholder="+998">
        </div>
    </div>

    <button class="ty-btn ty-btn__primary" type="button" id="add-guarant-btn">
        {__('continue')}
    </button>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-guarant-installment"></span>
    </div>

    <ul class="stepper">
        <li class="step"></li>
        <li class="step"></li>
        <li class="step active"></li>
    </ul>
</div>
