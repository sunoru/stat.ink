($ => {
  const storage = window.localStorage;
  const colorLocked = storage.getItem('colorLock') == 1;

  $(() => {
    const $elem = $('.toggle-color-lock');
    const $icon = $('.fa-fw', $elem);

    $elem.click(() => {
      storage.setItem('colorLock', colorLocked ? 0 : 1);
      window.location.reload();
    });

    if (colorLocked) {
      $icon.removeClass('fa-square').addClass('fa-check-square');
      $('body').addClass('color-locked');
    } else {
      $icon.removeClass('fa-check-square').addClass('fa-square');
      $('body').removeClass('color-locked');
    }
  });
})(jQuery);
