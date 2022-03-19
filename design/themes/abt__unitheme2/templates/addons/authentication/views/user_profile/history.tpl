{script src="js/addons/authentication/user_profile.js"}
<div class="main-tab">
    {include file='addons/authentication/views/user_profile/sidebar.tpl'}
    <div class="tabSec">
        <button class="tablinksSec" onclick="openCitySec(event, 'London')">London</button>
        <button class="tablinksSec" onclick="openCitySec(event, 'Paris')">Paris</button>
        <button class="tablinksSec" onclick="openCitySec(event, 'Tokyo')">Tokyo</button>
    </div>

    <div id="London" class="tabcontentSec">
        <h3>London</h3>
        <p>London is the capital city of England.</p>
    </div>

    <div id="Paris" class="tabcontentSec">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Tokyo" class="tabcontentSec">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>
</div>