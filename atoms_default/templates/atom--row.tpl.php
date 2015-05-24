<?php print $prefix ?>
<?php print $view_mode == 'teaser' ? '&lt;Row&gt;' : '' ?>
<?php if ($atoms): ?>
<table>
  <tr>
    <?php foreach ($atoms as $atom): ?>
    <td width="<?php print 100 / count($atoms) ?>%">
      <?php print render($atom) ?>
    </td>
    <?php endforeach ?>
  </tr>
</table>
<?php endif ?>
<?php print $suffix ?>
