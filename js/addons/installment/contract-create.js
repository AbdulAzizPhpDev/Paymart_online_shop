// Get the modal
var modal = document.getElementById('myModal');
var modal1 = document.getElementById('myModal1');

var myBtn = document.getElementById('myBtn');
var span = document.getElementsByClassName('close')[0];

let e = document.getElementById('selectedId');
let formAdress = document.getElementById('formAddress2');
let formAdress3 = document.getElementById('formAddress3');

var selectedMonth = e.options[e.selectedIndex].value;

const $select = $('.tashkent-regions');
const $input = $('.not-tashkent-region');
const $alertContainer = $('.delivery-date-container');
const $deliveryDateContainer = $('.delivery-date__days');
let deliveryDays = 2;
let totalDeliveryDays = 0;

const otpState = {
  baseUrl: $('.api_base_url').val(),
  setContract: 'installment_product.set_contracts',
  buyerPhone: Cookies.get('buyer-phone'),
  timer: 60,
  interval: null,
  expDate: null,
  selectedFirst: selectedMonth,
  selectedFirstAdress: selectedMonth,
  selectedFirstAdress3: null,
  contractId: null,
  cityModal: null,
  addressType: 'shipping',
};

let calculate = otpState.baseUrl + '/order/calculate';
let price = document.getElementById('price').value;
let quantity = document.getElementById('quantity').value;
let name_product = document.getElementById('name_product').value;
let seller_token = document.getElementById('seller_token').value;
let seller_id = document.getElementById('seller_id').value;
let user_id = document.getElementById('user_id').value;
const $selfCall = $('#self-call');
const $shipping = $('#shipping');
const $selfCallTabContent = $('.self-call-tab-content');
const $shippingTabContent = $('.shipping-tab-content');

$(document).ready(function () {
  const $tabs = $('.address-tab-item');

  $.each($tabs, function () {
    $(this).on('click', function () {
      if ($selfCall.hasClass('active')) {
        otpState.addressType = 'self';

        $selfCall.removeClass('active');
        $selfCallTabContent.removeClass('d-none');

        $shipping.addClass('active');
        $shippingTabContent.addClass('d-none');

      } else {
        otpState.addressType = 'shipping';

        $selfCall.addClass('active');
        $selfCallTabContent.addClass('d-none');

        $shipping.removeClass('active');
        $shippingTabContent.removeClass('d-none');
      }
    });
  });

  $('#selectedId').change(function () {
    var selectedOption = e.options[e.selectedIndex].value;
    otpState.selectedFirst = selectedOption;
    let formattedProducts = {};
    formattedProducts[seller_id] = [
      {
        price: price,
        amount: quantity,
        name: name_product,
      },
    ];

    $.ajax({
      type: 'POST',
      url: calculate,
      headers: {
        Authorization: 'Bearer ' + seller_token,
      },
      data: {
        type: 'credit',
        period: selectedOption,
        products: formattedProducts,
        partner_id: seller_id,
        user_id: user_id,
      },
      success: function (response) {
        const total = new Intl.NumberFormat().format(response.data.price.total);
        const monthly = new Intl.NumberFormat().format(response.data.price.month);

        $('.total-price .text .price span').html(total);
        $('.monthly-payment .text .price-month span').html(monthly);
      },
    });
  });

});

$(document).ready(function () {

  Date.prototype.addDays = function (days) {
    const date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
  };

  const calculateDeliveryDate = (deliveryDay, extraDay = 0) => {
    const now = new Date();
    const deliveryDate = now.addDays(deliveryDay + extraDay);
    totalDeliveryDays = deliveryDay + extraDay;
    const extraDeliveryDate = deliveryDate.addDays(2).toLocaleDateString();
    const labelDelivery = `${deliveryDate.toLocaleDateString()} - ${extraDeliveryDate}`;

    $deliveryDateContainer.text(labelDelivery);
  };

  let selectedOptionAdress = $('#formAddress2 :selected').val();

  $.ceAjax('request', fn_url('get_city.city'), {
    method: 'post',
    data: {
      city_id: selectedOptionAdress,
    },
    callback: function (response) {
      if (response.result == null) {
        $input.removeClass('d-none').focus();
        $select.addClass('d-none');
      } else {
        $select.removeClass('d-none');
        $input.addClass('d-none');

        calculateDeliveryDate(deliveryDays, 0);

        response.result.forEach(number => {
          const option = `<option value="${number.city_id}" data-extra-days="${number.extra_days}">${number.city_name}</option>`;
          $select.append(option);
        });
      }
    },
  });

  $('#formAddress2').change(function () {
    var selectedOptionAdress = formAdress.options[formAdress.selectedIndex].value;
    otpState.selectedFirstAdress = selectedOptionAdress;

    $.ceAjax('request', fn_url('get_city.city'), {
      method: 'post',
      data: {
        city_id: selectedOptionAdress,
      },
      callback: function (response) {
        if ($alertContainer.hasClass('d-none')) {
          $alertContainer.removeClass('d-none');
        }

        if (!response.hasOwnProperty('result') || response.result === null) {
          console.error('result does not exist');
          return false;
        }

        deliveryDays = $(formAdress.options[formAdress.selectedIndex]).data('delivery-days') + Number(response.result[0].extra_days);

        calculateDeliveryDate(deliveryDays, 0);

        $($select).empty();

        response.result.forEach(number => {
          const option = `<option value="${number.city_id}" data-extra-days="${number.extra_days}">${number.city_name}</option>`;
          $select.append(option);
        });
        // }
      },
    });
  });

  $($select).change(function () {
    var selectedOptionAdress3 = formAdress3.options[formAdress3.selectedIndex].value;
    otpState.selectedFirstAdress3 = selectedOptionAdress3;

    const extraDays = $(formAdress3.options[formAdress3.selectedIndex]).data('extra-days');

    if ($alertContainer.hasClass('d-none')) {
      $alertContainer.removeClass('d-none');
    }

    calculateDeliveryDate(deliveryDays, extraDays);

  });
});

// When the user clicks on the button, open the modal
myBtn.onclick = function () {
  if (otpState.addressType === 'shipping') {
    // let valNullInputt = document.querySelector('.not-tashkent-region');
    // if (!$input.hasClass('d-none')) {
    //   if (/^\s*$/g.test(valNullInputt.value) || valNullInputt.value.indexOf('\n') != -1) {
    //     $('.not-tashkent-region').css('border', '1px solid red').focus();
    //     return;
    //   }
    // }

    var val = document.querySelector('#story2').value;
    if (/^\s*$/g.test(val) || val.indexOf('\n') != -1) {
      $('#story2').css('border', '1px solid red').focus();
      return;
    }
    var val2 = document.querySelector('#story3').value;
    if (/^\s*$/g.test(val2) || val2.indexOf('\n') != -1) {
      $('#story3').css('border', '1px solid red').focus();
      return;
    }
  }

  let city = $('#formAddress2').val();

  otpState.cityModal = city;

  let region = (otpState.selectedFirstAdress3 == null) ? ((!$input.hasClass('d-none')) ? $input.val() : $select.val()) : otpState.selectedFirstAdress3;
  let txt = document.getElementsByTagName('textarea');
  let apartment = $('#story').val();
  let building = $('#story2').val();
  let street = $('#story3').val();
  // let district = $('#story6').val();
  span.onclick = function () {
    modal.style.display = 'none';
  };


  $.ceAjax('request', fn_url('installment_product.set_contracts'), {
    method: 'POST',
    data: {
      limit: otpState.selectedFirst,
      city: city,
      region: region,
      apartment: apartment,
      building: building,
      street: street,
    },
    callback: function (response) {
      otpState.contractId = response.result.paymart_client.contract_id;
      modal.style.display = 'block';

      $('.resend-sms-card').css('display', 'block');
      var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
      function timer() {
        otpState.timer = otpState.timer - 1;
        if (otpState.timer <= 0) {
          clearInterval(counter);
          $('#modal-sent').attr('disabled', false);
          $('.resend-sms-card').css('display', 'none');
          $('.resend-sms-card__ok').css('display', 'block');
          $('.modal-error').css('display', 'none');
          //counter ended, do something here
          return;
        }
        // document.querySelector('.card-resend-sms-timer').innerHTML = otpState.timer;
      }
    },
  });
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
};

$('.resend-sms-card').css('display', 'none');

const confirmContract = () => {
  let spanError = $('.modal-error');
  // spanError.css('display', 'none');

  let region = $('#formAddress2').val();
  let apartment = $('#story').val();
  let building = $('#story2').val();
  let street = $('#story3').val();
  $(this).attr('disabled', true);
  let otpInputVal = $('.ty-login__input').val();

  $.ceAjax('request', fn_url('installment_product.set_confirm_contract'), {
    method: 'POST',
    data: {
      code: otpInputVal,
      contract_id: otpState.contractId,
      city: !($select).hasClass('d-none') ? $($select).val() : $($input).val(),
      region: region,
      apartment: apartment,
      building: building,
      street: street,
      address_type: otpState.addressType,
      delivery_day: totalDeliveryDays,
    },
    callback: function (response) {
      console.log('response-first', response);
      if (response.result.status === 'success') {
        window.location.href = fn_url('installment_product.profile-contracts');
        console.log('shut second success');
      } else {
        spanError.text(response.result.response.message).css({
          display: 'block',
          color: 'red',
        });
        $('#modal-sent').attr('disabled', true);
      }
    },
  });
};

$('#modal-sent').on('click', confirmContract);

$('.resend-sms-card__ok').on('click', function () {
  otpState.timer = 60;
  $(this).css('display', 'none');
  $('#myBtn').click();
});

// Get the modal
var modal5 = document.getElementById('myModal5');

