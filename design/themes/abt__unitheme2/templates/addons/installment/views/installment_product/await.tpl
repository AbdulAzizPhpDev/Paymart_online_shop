{script src="js/addons/installment/await.js"}
{script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/lottie-player.js"}

<div class="await-page">
    <lottie-player
            class="lottie-player"
            autoplay
            loop
            mode="normal"
            style="width: 310px"
    ></lottie-player>

    <h1>Ваша заявка обрабатывается</h1>
    <span>Это может занять несколько минут</span>

    <button class="ty-btn ty-btn__secondary" type="button" id="await-btn">
        Посмотреть статус
    </button>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-await-installment"></span>
    </div>
</div>
