(function ($) {
  $(document).on('click', '.references-dialog-links .er-remove', function (e) {
    e.preventDefault();
    var $this = $(this),
      $item = $this.parents('tr.draggable').first(),
      $target = $item.find('input[id$="-target-id"]');

    if ($target.data('removed-id')) {
      $target.val($target.data('removed-id'));
      $target.removeData('removed-id');
      $this.text('Remove');
      $item.removeClass('er-removed');
    }
    else {
      $target.data('removed-id', $target.val());
      $target.val('');
      $this.text('Restore');
      $item.addClass('er-removed');
    }
  });
})(jQuery);
