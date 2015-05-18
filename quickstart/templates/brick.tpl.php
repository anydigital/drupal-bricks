<?php print $prefix ?>
<?php print $view_mode == 'teaser' ? '&lt;' . drupal_ucfirst($brick->type) . '&gt;' : '' ?>
<?php print render($bricks) ?>
<?php print $suffix ?>
