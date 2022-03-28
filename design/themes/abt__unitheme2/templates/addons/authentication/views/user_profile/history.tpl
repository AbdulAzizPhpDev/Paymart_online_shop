{script src="js/addons/authentication/user_profile.js"}
<div class="main-tab">
    {include file='addons/authentication/views/user_profile/sidebar.tpl'}
    <div class="tabSec">
        <button class="tablinksSec" id="firstButton" onclick="openCitySec(event, 'salement')">Платежи</button>
        <button class="tablinksSec" id="secondButton" onclick="openCitySec(event, 'doc')">Документы</button>
    </div>

    <div id="salement" class="tabcontentSec">
        <div class="">another one</div>
    </div>

    <div id="doc" class="tabcontentSec">
        <div class="products-cards__mini-profile"></div>
    </div>
</div>