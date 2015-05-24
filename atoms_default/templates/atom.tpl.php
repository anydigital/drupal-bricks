<?php print $prefix ?>
<?php $rendered = render($content) ?>
<?php print $rendered ? $rendered : $view_mode == 'teaser' ? '&lt;' . drupal_ucfirst($brick->type) . '&gt;' : '' ?>
<?php print render($bricks) ?>
<?php print $suffix ?>
