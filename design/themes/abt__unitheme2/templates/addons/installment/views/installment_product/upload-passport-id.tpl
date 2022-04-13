{script src="js/addons/installment/upload-passport-id.js"}

<div class="upload-passport-id-page">
    <h1>{__('authentication.id_card.title')}</h1>
    <span class="subtitle">{__('authentication.passport.subtitle')}</span>

    <div class="upload-photos">

        <div class="file-input">
            <div class="preview passport_second_page">
                <img src="/design/themes/responsive/media/images/passport/id-first-page.png" width="96" alt="">
            </div>
            <input id="passport_second_page" type="file" accept="image/*" hidden>
            <label for="passport_second_page">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{__('authentication.id_card.front')}</span>
            </label>
        </div>

        <div class="file-input">
            <div class="preview passport_first_page">
                <img src="/design/themes/responsive/media/images/passport/id-second-page.png" width="96" alt="">
            </div>
            <input id="passport_first_page" type="file" accept="image/*" hidden>
            <label for="passport_first_page">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{__('authentication.id_card.back')}</span>
            </label>
        </div>

        <div class="file-input">
            <div class="preview passport_selfie">
                <img src="/design/themes/responsive/media/images/passport/id-selfie.png" width="207" alt="">
            </div>
            <input id="passport_selfie" type="file" accept="image/*" hidden>
            <label for="passport_selfie">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{__('authentication.passport.selfie')}</span>
            </label>
        </div>

        <div class="file-input">
            <div class="preview passport_with_address">
                <img src="/design/themes/responsive/media/images/passport/id-address.png" width="130" alt="">
            </div>
            <input id="passport_with_address" type="file" accept="image/*" hidden>
            <label for="passport_with_address">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9.016V14.984M9.016 12H14.984M18.332 21.332H5.66797C4.01097 21.332 2.66797 19.989 2.66797 18.332V5.66797C2.66797 4.01097 4.01097 2.66797 5.66797 2.66797H18.332C19.989 2.66797 21.332 4.01097 21.332 5.66797V18.332C21.332 19.989 19.989 21.332 18.332 21.332Z"
                          stroke="#FF7643" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{__('authentication.passport.address')}</span>
            </label>
        </div>
    </div>

    <button class="ty-btn ty-btn__secondary" type="button" id="upload-passport-photos-btn"
            data-error-image-select="{__('drop_images_select')}">
        {__("continue")}
    </button>

    <div class="ty-login-form__wrong-credentials-container">
        <span class="ty-login-form__wrong-credentials-text ty-error-text error-passport-installment"></span>
    </div>
</div>