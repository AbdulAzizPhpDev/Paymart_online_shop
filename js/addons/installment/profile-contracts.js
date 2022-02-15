(function (_, $) {
  const $percentageActive = $('.progress.active');

  $percentageActive.each(function () {
    const percentage = $(this).data('percentage');

    $(this).css('width', `${percentage}%`);
  });
})(Tygh, Tygh.$);