{script src="js/addons/authentication/vendor-login-form.js"}

<div class="row-fluid ">
    <div class="span6 offset4 main-content-grid ">
        <div class="ty-mainbox-container clearfix">
            <div class="ty-mainbox-body"><!-- Inline script moved to the bottom of the page -->
                <div class="ty-account-benefits">
                    <h1 class="ty-mainbox-title" style="text-align: center;">{__('authentication.vendor.title')}</h1>

                    <form class="vendor-login-from" method="post" action={fn_url('vendor_login.login')}>
                        <div class="ty-control-group">
                            <label for="vendor_id" class="ty-control-group__title cm-required">
                                {__('authentication.vendor.id')}
                            </label>
                            <input style="width: 100%;" type="text" id="vendor_id" name="id"
                                   placeholder="{__('authentication.vendor.placeholder_id')}" maxlength="10" />
                        </div>

                        <div class="ty-control-group">
                            <label for="password"
                                   class="ty-control-group__title cm-required ">{__("password")}</label>
                            <input style="width: 100%;" type="password" id="password" name="password"
                                   placeholder="{__("password")}" />
                        </div>

                        <button class="ty-btn ty-btn__primary">{__('sign_in')}</button>
                    </form>
                </div>

                <div class="ty-login-form__wrong-credentials-container">
                    <span class="ty-login-form__wrong-credentials-text ty-error-text error-vendor-login"></span>
                </div>
            </div>
        </div>
    </div>


    {*<div class="span8 profile-information-grid ">
        <div class="ty-account-benefits">
            <h1>Оставте заявку и получите предложение</h1>
*}{*            <img width="180" src="https://paymart.uz/img/order-form-bg.a1119ab3.png" alt="order-form">*}{*
            <div id="bitrixForm">
                *}{* Todo Bitrix Form  *}{*

                <button class="ty-btn ty-btn__primary" style="margin-top: 16px;">Оставить заявку</button>
            </div>
        </div>
    </div>*}
</div>
