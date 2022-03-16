{script src="js/addons/installment/guarant.js"}

<div class="guarant-page">
    <h1>Доверительное лицо</h1>
    <span>Введите данные доверительных лиц</span>

    <div class="guarants">
        <div class="guarant">
            <h3>Контакное лицо - 1</h3>

            <p class="ty-mt-s"><label for="first-guarant-name">{__('fullname')}</label></p>
            <input id="first-guarant-name" type="text" placeholder="Введите ФИО">

            <p class="ty-mt-s"><label for="first-guarant-phone">Номер телефона</label></p>
            <input id="first-guarant-phone" type="text" placeholder="+998">
        </div>
        <div class="guarant">
            <h3>Контакное лицо - 2</h3>

            <p class="ty-mt-s"><label for="second-guarant-name">{__('fullname')}</label></p>
            <input id="second-guarant-name" type="text" placeholder="Введите ФИО">

            <p class="ty-mt-s"><label for="second-guarant-phone">Номер телефона</label></p>
            <input id="second-guarant-phone" type="text" placeholder="+998">
        </div>
    </div>

    <button class="ty-btn ty-btn__secondary" type="button" id="add-guarant-btn">
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
