{script src="js/addons/authentication/profile_card.js"}

<div class="main-tabs">
    <div class="main-tab">
        <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'London')">Профиль</button>
        <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Paris')">Договора</button>
        <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Tokyo')">История</button>
        <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Tokyo')">Бонусные суммы</button>
        <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Tokyo')">Приглосить <друга></друга></button>
    </div>
    <div class="main-content__items">
        <div id="London" class="w3-container city">
            <h2>London</h2>
            <p>London is the capital city of England.</p>
            <p>It is the most populous city in the United Kingdom, with a metropolitan area of over 13 million
                inhabitants.</p>
        </div>
        <div id="Paris" class="w3-container city">
            <h2>Paris</h2>
            <p>Paris is the capital of France.</p>
            <p>The Paris area is one of the largest population centers in Europe, with more than 12 million
                inhabitants.</p>
        </div>
        <div id="Tokyo" class="w3-container city">
            <h2>Tokyo</h2>
            <p>Tokyo is the capital of Japan.</p>
            <p>It is the center of the Greater Tokyo Area, and the most populous metropolitan area in the world.</p>
        </div>
    </div>
</div>