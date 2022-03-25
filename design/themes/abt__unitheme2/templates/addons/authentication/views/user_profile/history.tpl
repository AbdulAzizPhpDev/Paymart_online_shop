{script src="js/addons/authentication/user_profile.js"}
<div class="main-tab">
    {include file='addons/authentication/views/user_profile/sidebar.tpl'}
    <div class="tabSec">
        <button class="tablinksSec" id="firstButton" onclick="openCitySec(event, 'salement')">Платежи</button>
        <button class="tablinksSec" id="secondButton" onclick="openCitySec(event, 'doc')">Документы</button>
    </div>

    <div id="salement" class="tabcontentSec">
        <h3>London</h3>
        <p>London is the capital city of England.</p>
    </div>

    <div id="doc" class="tabcontentSec">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>
</div>