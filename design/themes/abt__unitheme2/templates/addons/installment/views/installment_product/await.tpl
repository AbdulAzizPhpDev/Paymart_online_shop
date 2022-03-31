{script src="js/addons/installment/await.js"}
{script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/lottie-player.js"}

<div class="await-page">
    <input type="hidden" value="{$user_api_token}" class="user-api-token">
    <lottie-player
            class="lottie-player"
            autoplay
            loop
            mode="normal"
            style="width: 310px"
    ></lottie-player>

    <h1>{__('authentication.await.title')}</h1>
    <span>{__('authentication.await.subtitle')}</span>

    <button class="ty-btn ty-btn__secondary" type="button" id="await-btn">
        {__('authentication.await.show_status')}
    </button>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-await-installment"></span>
    </div>
</div>
