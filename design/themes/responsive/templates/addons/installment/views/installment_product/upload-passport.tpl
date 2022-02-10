{script src="js/addons/installment/upload-passport.js"}

<div class="upload-passport-page">
    <h1>Фото паспорта</h1>
    <span class="subtitle">Пример фотографии передней части</span>

    <div class="upload-photos">

        <div class="file-input">
            <div class="preview passport_first_page">
                <img src="/design/themes/responsive/media/images/passport/first-page.png" width="96" alt="">
            </div>
            <input id="passport_first_page" type="file" accept="image/*" hidden>
            <label for="passport_first_page">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Фото паспорта</span>
            </label>
        </div>

        <div class="file-input">
            <div class="preview passport_with_address">
                <img src="/design/themes/responsive/media/images/passport/address.png" width="130" alt="">
            </div>
            <input id="passport_with_address" type="file" accept="image/*" hidden>
            <label for="passport_with_address">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Прописка</span>
            </label>
        </div>

        <div class="file-input">
            <div class="preview passport_selfie">
                <img src="/design/themes/responsive/media/images/passport/selfie.png" width="207" alt="">
            </div>
            <input id="passport_selfie" type="file" accept="image/*" hidden>
            <label for="passport_selfie">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Селфи с паспортом</span>
            </label>
        </div>
    </div>

    <button class="ty-btn ty-btn__secondary" type="button" id="upload-passport-photos-btn">
        Продолжить
    </button>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-passport-installment"></span>
    </div>

    <div data-ca-overlay=".loader_container, .ty-ajax-loading-box" class="loader_container"></div>
</div>