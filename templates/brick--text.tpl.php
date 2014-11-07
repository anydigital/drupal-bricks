<?php print render($content['field_text']) ?>

<?php if ($bricks): ?>
<ul>
  <?php foreach ($bricks as $brick): ?>
  <li><?php print render($brick) ?></li>
  <?php endforeach ?>
</ul>
<?php endif ?>
