<?php print $prefix ?>
<?php $_class = 'col-md-' . 12 / count($content['atoms']) ?>
<div class="row">
  <?php foreach ($content['atoms'] as $atom): ?>
  <div class="<?php print $_class ?>">
    <?php print render($atom) ?>
  </div>
  <?php endforeach ?>
</div>
<?php print $suffix ?>
