<?php print $prefix ?>
<?php if (!empty($content['bricks'])): ?>
<div class="row">
  <?php foreach ($content['bricks'] as $brick): ?>
  <div class="<?php print 'col-md-' . 12 / count($content['bricks']) ?>">
    <?php print render($brick) ?>
  </div>
  <?php endforeach ?>
</div>
<?php else: ?>
<?php print $placeholder ?>
<?php endif ?>
<?php print $suffix ?>
