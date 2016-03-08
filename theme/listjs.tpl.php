<div id="<?php print $list_id; ?>">
  <input class="search" placeholder="<?php print $placeholder_text; ?>" />
  <ul <?php print drupal_attributes($list_attributes); ?>>
    <?php foreach ($items as $item): ?>
      <li><?php print $item['data']; ?></li>
    <?php endforeach; ?>
  </ul>
</div>
