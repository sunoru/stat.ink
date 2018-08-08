/*! Copyright (C) 2018 AIZAWA Hina | MIT License */
($ => {
  $(() => {
    const getUrl = () => {
      const $link = $('link[rel="canonical"]');
      if ($link.length > 0) {
        return $link.attr('href');
      }

      const $twitter = $('meta[name="twitter:url"]');
      if ($twitter.length > 0) {
        return $twitter.attr('content');
      }

      return window.location.href;
    };

    $('.badge-permalink').click(ev => {
      const $this = $(ev.target);
      const $dialog = $($this.data('target'));
      const $input = $('input', $dialog)
        .val(getUrl())
        .on('focus', ev => {
          $(ev.target).select();
        });

      $dialog.on('shown.bs.modal', () => {
        $input.focus();
      });

      $dialog.modal();
    });
  });
})(jQuery);
