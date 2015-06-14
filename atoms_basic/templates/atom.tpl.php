<?php print $prefix ?>
<?php $rendered = render($content) ?>
<?php print $rendered ? $rendered : $view_mode == 'teaser' ? '&lt;' . drupal_ucfirst($atom->type) . '&gt;' : '' ?>
<?php print render($atoms) ?>
<?php print $suffix ?>
