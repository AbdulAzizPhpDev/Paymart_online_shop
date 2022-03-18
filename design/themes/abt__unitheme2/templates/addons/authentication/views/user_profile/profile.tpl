{script src="js/addons/authentication/user_profile.js"}


<div class="main-tab">

    {include file='addons/authentication/views/user_profile/sidebar.tpl'}


    <div id="London" class="tabcontent">
        <div class="container profile-main">
            <h1 class="profile-title">Профиль</h1>
            <div class="profile">
                <div class="profile-image">
                    <div class="profile-image__left">
                        <img src="https://via.placeholder.com/72" height="72" alt="Profile image">
                    </div>
                    <div class="profile-text">
                        <h1>Jane Cooper</h1>
                        <p>+998 99 077 84 44</p>
                    </div>
                </div>
                <div class="profile-numbers">
                    <div class="profile-number">
                        <h2 class="profile-number__title">Лимит рассрочки:</h2>
                        <p class="profile-number__text">3 023 343.15<span>Сум</span></p>
                    </div>
                    <div class="profile-number__vl"></div>
                    <div class="profile-number">
                        <h2 class="profile-number__title">Лицевой счет:</h2>
                        <p class="profile-number__text text-unique">3 023 343.15<span>Сум</span></p>
                    </div>
                </div>
            </div>
            <div class="infos">
                <div class="card-infos">
                    <div class="card-info">
                        <div class="card-info__img">
                            <img src="/design/themes/responsive/media/images/addons/authentication/image/stud.png"
                                 alt="Stud image">
                        </div>
                        <div class="card-info__img-text">
                            <p>Cкидки:</p>
                            <span>6%</span>
                        </div>
                    </div>
                    <div class="card-info__second">
                        Улучшить
                    </div>
                    <div class="card-info__progress">
                        <div class="card-info__progress__item"></div>
                    </div>
                </div>
                <div class="card-infos">
                    <div class="card-info">
                        <div class="card-info__img">
                            <img src="/design/themes/responsive/media/images/addons/authentication/image/earbuds.png"
                                 alt="Stud image">
                        </div>
                        <div class="card-info__img-text">
                            <p>Макс период:</p>
                            <span>15 мес.</span>
                        </div>
                    </div>
                    <div class="card-info__second">
                        Улучшить
                    </div>
                    <div class="card-info__progress">
                        <div class="card-info__progress__item"></div>
                    </div>
                </div>
                <div class="card-infos">
                    <div class="card-info">
                        <div class="card-info__img">
                            <img src="/design/themes/responsive/media/images/addons/authentication/image/pinned.png"
                                 alt="Stud image">
                        </div>
                        <div class="card-info__img-text">
                            <p>Лимит:</p>
                            <span>8 млн сум</span>
                        </div>
                    </div>
                    <div class="card-info__second">
                        Улучшить
                    </div>
                    <div class="card-info__progress">
                        <div class="card-info__progress__item"></div>
                    </div>
                </div>
            </div>
            <div class="next-section">
                <h1 class="profile-title">Мои карты</h1>
                <div class="plus">
                    <a href="#" style="text-decoration: none;"> Добавить карту <span class="plus-card">+</span></a>
                </div>
            </div>
            <div class="products-cards__profile">
            </div>
            <div id="myModalCard" class="modalCard">
                <!-- Modal content -->
                <div class="modal-content__card">
        <span class="closeBtn">
            <img src="/design/themes/responsive/media/images/addons/installment/Thin.png" alt="Close img">
        </span>
                    <div class="card-add__page-profile">
                        <div class="card-confirm">
                            <div class="card-confirm__profile">
                                <label for="firstPut">Номер карты</label>
                                <input type="number" name="" id="firstPut">
                            </div>
                            <div class="card-confirm__profile">
                                <label for="SecondPut">Срок карты</label>
                                <input type="number" name="" id="secondPut">
                            </div>
                            <div class="">
                                <span class="modal-error__profile"></span>

                                <div class="radioButton">
                                    <input type="radio" id="contactChoice1"
                                           name="contact" value="orange">
                                    <label for="contactChoice1" id="contactChoice1__orange">orange</label>

                                    <input type="radio" id="contactChoice2"
                                           name="contact" value="black">
                                    <label for="contactChoice2" id="contactChoice2__black">black</label>
                                </div>

                                <button class="unique-btn__modal-item" type="button" id="modal-sent__last">
                                    Продолжить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br>
                <br><br><br><br><br>
                <br><br><br><br><br>
            </div>
        </div>
    </div>


</div>

