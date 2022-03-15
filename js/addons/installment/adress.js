const $select = $('.tashkent-regions');
const $input = $('.not-tashkent-region');

$(document).ready(function () {
  $('#formAddress__select').change(function (e) {
    // var selectedOptionAdress = formAdressSelect.options[formAdressSelect.selectedIndex].value;
    const city_id = e.target.value;
    $.ceAjax('request', fn_url('get_city.city'), {
      method: 'post',
      data: {
        city_id: city_id,
      },
      callback: function (response) {
        if (response.result == null) {
          $input.removeClass('d-none').focus();
          $select.addClass('d-none');
        } else {
          $select.removeClass('d-none');
          $input.addClass('d-none');
          response.result.forEach(number => {
            const option = `<option value="${number.city_id}" selected>${number.city_name}</option>`;
            $select.append(option);
          });
        }
      },
    });
  });
});