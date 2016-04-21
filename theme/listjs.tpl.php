<div id="<?php print $list_id; ?>">
  <div class="filter-wrapper">
    <?php print theme('textfield', array('element' => array('#attributes' => array('class' => array('search'), 'placeholder' => $placeholder_text), '#autocomplete_path' => FALSE))); ?>
  </div>
  <div class="sort-wrapper">
    <?php foreach ($value_names as $conf): ?>
      <?php if ($conf['sort'] == 1): ?>
        <?php print theme('button', array('element' => array('#attributes' => array('class' => array('sort'), 'data-sort' => $conf['value_name']), '#button_type' => 'button', '#value' => $conf['sort_text']))); ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <ul <?php print drupal_attributes($list_attributes); ?>>
    <?php foreach ($items as $item): ?>
      <li><?php print $item['data']; ?></li>
    <?php endforeach; ?>
  </ul>
</div>
