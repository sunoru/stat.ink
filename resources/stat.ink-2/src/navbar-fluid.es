($ => {
  const storage = window.localStorage;
  let useContainerFluid = storage.getItem('useFluid') == 1;

  $(() => {
    const $elem = $('.toggle-use-fluid');
    const $icon = $('.fa-fw', $elem);
    const update = () => {
      const $container = $([
        'body>main>.container',
        'body>main>.container-fluid',
        'nav.navbar>.container-fluid>.container',
        'nav.navbar>.container-fluid>.container-fluid',
        'footer>.container',
        'footer>.container-fluid',
      ].join(','));

      if (useContainerFluid) {
        $icon.removeClass('fa-square').addClass('fa-check-square');
        $container.removeClass('container').addClass('container-fluid');
        $('body').addClass('use-fluid');
      } else {
        $icon.removeClass('fa-check-square').addClass('fa-square');
        $container.removeClass('container-fluid').addClass('container');
        $('body').removeClass('use-fluid');
      }
    };

    $elem.click(() => {
      useContainerFluid = !useContainerFluid;
      storage.setItem('useFluid', useContainerFluid ? 1 : 0);
      update();
    });

    update();
  });
})(jQuery);
