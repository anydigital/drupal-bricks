<?php print $prefix ?>
<div class="row">
  <?php $i = 0 ?>
  <?php foreach ($content['atoms'] as $atom): ?>
  <?php if ($i && ($i % 2 == 0)): ?>
  <div class="clearfix"></div>
  <?php endif ?>
  <div class="col-md-6">
    <?php print render($atom) ?>
  </div>
  <?php $i++ ?>
  <?php endforeach ?>
</div>
<?php print $suffix ?>
