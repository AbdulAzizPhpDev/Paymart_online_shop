{script src="js/addons/authentication/vendor-login-form.js"}
test

<div class="row-fluid ">
    <div class="span8 main-content-grid ">
        <div class="ty-mainbox-container clearfix">
            <h1 class="ty-mainbox-title">
                Создать учетную запись
            </h1>
            <div class="ty-mainbox-body"><!-- Inline script moved to the bottom of the page -->
                <div class="ty-account">
                    <form method="post" action={fn_url('vendor_login.login')}>
                        <div class="ty-control-group">
                            <label for="vendor_id" class="ty-control-group__title cm-required">{__("id")}</label>
                            <input type="number" id="vendor_id" name="id" size="32" maxlength="32"/>
                        </div>

                        <div class="ty-control-group">
                            <label for="password"
                                   class="ty-control-group__title cm-required ">{__("password")}</label>
                            <input type="password" id="password" name="password" size="32" maxlength="32"/>
                        </div>


                        <button>submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="span8 profile-information-grid ">
        <div class="ty-account-benefits">
            <h4>Преимущества зарегистрированного пользователя:</h4>
            <ul>
                <li>Отслеживание заказов на персональной странице</li>
                <li>Возможность настроить магазин под себя для более удобных покупок</li>
                <li>Ускоренное оформление последующих заказов</li>
            </ul>
        </div>
    </div>
</div>


{*<div class="ty-account-benefits">*}
{*    {__("text_profile_benefits")}*}
{*</div>*}

