<?php print $prefix ?>
<?php $_class = 'col-md-' . 12 / count($content['bricks']) ?>
<div class="row">
  <?php foreach ($content['bricks'] as $brick): ?>
  <div class="<?php print $_class ?>">
    <?php print render($brick) ?>
  </div>
  <?php endforeach ?>
</div>
<?php print $suffix ?>
