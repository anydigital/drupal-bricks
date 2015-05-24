<?php print $prefix ?>
<?php print $view_mode == 'teaser' ? '&lt;Row&gt;' : '' ?>
<?php if ($bricks): ?>
<table>
  <tr>
    <?php foreach ($bricks as $brick): ?>
    <td width="<?php print 100 / count($bricks) ?>%">
      <?php print render($brick) ?>
    </td>
    <?php endforeach ?>
  </tr>
</table>
<?php endif ?>
<?php print $suffix ?>
