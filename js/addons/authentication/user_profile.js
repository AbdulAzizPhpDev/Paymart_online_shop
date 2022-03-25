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

var span = $('.closeBtn')[0];
let modal = document.getElementById('myModalCard');

if ($('div').hasClass('.plus')) {
  $('.plus').click(function () {
    $('#myModalCard').css('display', 'block');
  });
}

// tab
const valuesCards = [
  {
    cardNumber: 8600123364354566,
    cardDate: 1240,
    cardType: 'humo',
    attr: 'orange',
  },
  {
    cardNumber: 8600123364354566,
    cardDate: 1244,
    cardType: 'Union',
    attr: 'orange',
  },
  {
    cardNumber: 8600123364354566,
    cardDate: 4444,
    cardType: 'humo',
    attr: 'black',
  },
];


var radioValue = null;
$('input[type=\'radio\']').click(function () {
  radioValue = $('input[name=\'contact\']:checked').val();
});

$('#modal-sent__last').click(function () {
  const firstPut = $('#firstPut').val();
  const secondPut = $('#secondPut').val();

  valuesCards.push({
    cardNumber: firstPut,
    cardDate: secondPut,
    attr: radioValue,
  });
  container.innerHTML = returnCards(valuesCards);
  $('#myModalCard').css('display', 'none');
});

if ($('div').hasClass('.products-cards__profile')) {
  var container = document.querySelector('.products-cards__profile');

  function returnCards(valuesCards) {
    return '<div class="products-cards">' + valuesCards.map(valuesCard => `
    <div class="orange-unique">
               <div class="orange-unique__${valuesCard.attr}">
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

  container.innerHTML = returnCards(valuesCards);
}

function openTab(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName('tabcontent');
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = 'none';
  }
  tablinks = document.getElementsByClassName('tablinks');
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(' active', '');
  }
  document.getElementById(cityName).style.display = 'flex';
  evt.currentTarget.className += ' active';
}

// OnloadOpenCity();
//
// function OnloadOpenCity(evt, cityName) {
//   var i, tabcontent, tablinks;
//   tabcontent = document.getElementsByClassName('tabcontent');
//   for (i = 1; i < tabcontent.length; i++) {
//     tabcontent[i].style.display = 'none';
//   }
//   tablinks = document.getElementsByClassName('tablinks');
//   for (i = 1; i < tablinks.length; i++) {
//     tablinks[i].className = tablinks[i].className.replace(' active', '');
//   }
//   let smth = document.getElementById(cityName);
//
//   $(smth).css('display', 'none');
//   // evt.currentTarget.className += 'none';
// }


//
//
// const btn = document.getElementById('btn_first');
//
// btn.addEventListener('click', function onClick() {
//   // btn.style.backgroundColor = 'salmon';
//   btn.css('backgroundColor', '#FF7643');
// });
//
// const btn2 = document.getElementById('btn_second');
//
// $(btn2).click(function () {
//   // btn2.style.backgroundColor = 'salmon';
//   btn2.css('background', '#FF7643');
// });

$(function () {
  $('#tabs').tabs({
    activate: function (event, ui) {
      var $activeTab = $('#tabs').tabs('option', 'active');
      if ($activeTab == 1) {
        alert('tab1');
      }
    },
  });
});

function openCitySec(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName('tabcontentSec');
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = 'none';
  }
  tablinks = document.getElementsByClassName('tablinksSec');
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(' active', '');
  }
  document.getElementById(cityName).style.display = 'block';
  evt.currentTarget.className += ' active';
}

if ($('button').hasClass('tablinksSec')) {

  const btnFirst = document.querySelector('#firstButton');
  const btnLast = document.querySelector('#secondButton');

  btnFirst.addEventListener('click', function onClick() {
    console.log('clicked first');
    btnFirst.style.backgroundColor = '#FF7643';
    btnFirst.style.color = '#FF7643';
    btnLast.style.backgroundColor = 'transparent';
    btnLast.style.color = '#FF7643';
    btnFirst.style.color = '#fff';
  });

  btnLast.addEventListener('click', function onClick() {
    console.log('clicked second');
    btnFirst.style.backgroundColor = 'transparent';
    btnLast.style.backgroundColor = '#FF7643';
    btnLast.style.color = '#fff';
    btnFirst.style.color = '#FF7643';
  });

}

const valuesMiniCards = [
  {
    image: '/design/themes/responsive/media/images/addons/profile_card/image/text-image.png',
    time: '23:23',
    date: '#12/05 от 23.04.2020',
  },
  {
    image: '/design/themes/responsive/media/images/addons/profile_card/image/text-image.png',
    time: '23:23',
    date: '#12/05 от 23.04.2020',
  },
  {
    image: '/design/themes/responsive/media/images/addons/profile_card/image/text-image.png',
    time: '23:23',
    date: '#12/05 от 23.04.2020',
  },
  {
    image: '/design/themes/responsive/media/images/addons/profile_card/image/text-image.png',
    time: '23:23',
    date: '#12/05 от 23.04.2020',
  },
];

function returnMiniCards(valuesMiniCards) {
  return '<div class="mini-card">' + valuesMiniCards.map(valuesMiniCard => `
    <div class="mini-card__items">
                    <div class="mini-card__item">
                        <img src="${valuesMiniCard.image}" alt="Mini image">
                        <p>${valuesMiniCard.time}</p>
                    </div>
                    <div class="mini-card__item mini-item-second">
                        <p>Договор: </p>
                        <p>${valuesMiniCard.date}</p>
                    </div>
                </div>
            </div>
            </div>  `).join('');
}

var historyDoc = document.querySelector('.products-cards__mini-profile');

historyDoc.innerHTML = returnMiniCards(valuesMiniCards);