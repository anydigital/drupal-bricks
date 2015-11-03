<?php print $prefix ?>
<div class="row">
  <?php $i = 0 ?>
  <?php foreach ($content['bricks'] as $brick): ?>
  <?php if ($i && ($i % 2 == 0)): ?>
  <div class="clearfix"></div>
  <?php endif ?>
  <div class="col-md-6">
    <?php print render($brick) ?>
  </div>
  <?php $i++ ?>
  <?php endforeach ?>
</div>
<?php print $suffix ?>
