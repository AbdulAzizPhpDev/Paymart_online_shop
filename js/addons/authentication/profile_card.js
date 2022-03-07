function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName('city');
  for (i = 0; i < x.length; i++) {
    x[i].style.display = 'none';
  }
  tablinks = document.getElementsByClassName('tablink');
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(' w3-red', '');
  }
  document.getElementById(cityName).style.display = 'block';
  evt.currentTarget.className += ' w3-red';
}

var span = document.getElementsByClassName('closeBtn')[0];
let modal = document.getElementById('myModalCard');

span.onclick = function () {
  modal.style.display = 'none';
};

$('.plus').click(function () {
  $('#myModalCard').css('display', 'block');
});


const valuesCards = [
  {
    cardNumber: 8600123364354566,
    cardDate: 1240,
    cardType: 'humo',
  },
  {
    cardNumber: 8600123364354566,
    cardDate: 1244,
    cardType: 'Union',
  },
  {
    cardNumber: 8600123364354566,
    cardDate: 4444,
    cardType: 'humo',
  },
];

// valuesCards.map((item) => {
//   cardHtml.innerHTML = `
//             <div class="orange-unique">
//                <div class="orange-unique__main">
//                 <div class="orange-unique__main-top">
//                     <div class="orange-unique__main-item">
//                         <p>Зарплатная карта</p>
//                         <h1>3 534 030.12 сум</h1>
//                     </div>
//                     <div class="item-second">
//                         <img src="/design/themes/responsive/media/images/addons/authentication/image/humo.png"
//                              alt="Ico">
//                     </div>
//                 </div>
//                 <div class="orange-unique__second">
//                     <p class="cardNumber" style="color: #fff !important;">${item.cardNumber}</p>
//                     <p class="cardDate">${item.cardDate}</p>
//                 </div>
//             </div>
//             </div>
//        `;
//   document.querySelector('.products-cards')[0].appendChild(cardHtml);
// });

var container = document.querySelector('.products-cards__profile');

function returnCards(valuesCards) {
  return '<div class="products-cards">' + valuesCards.map(valuesCard => `
    <div class="orange-unique">
               <div class="orange-unique__main">
                <div class="orange-unique__main-top">
                    <div class="orange-unique__main-item">
                        <p>Зарплатная карта</p>
                        <h1>3 534 030.12 сум</h1>
                    </div>
                    <div class="item-second">
                        <img src="/design/themes/responsive/media/images/addons/authentication/image/${valuesCard.cardType}.png"
                             alt="Ico">
                    </div>
                </div>
                <div class="orange-unique__second">
                    <p class="cardNumber" style="color: #fff !important;">${valuesCard.cardNumber}</p>
                    <p class="cardDate">${valuesCard.cardDate}</p>
                </div>
            </div>
            </div>  `).join('');
}

console.log('functionr', returnCards(valuesCards));
container.innerHTML = returnCards(valuesCards);