<?php

/**
 * @file
 * Displays a list with listjs filter and sort buttons.
 *
 * Available variables:
 * - $placeholder_text: Placeholder text for the filter textfield.
 * - $items: An array of items to be rendered as list.
 *   - $item['data']: HTML of the list item.
 * - $list_attributes: An associative array suitable for drupal_attributes().
 * - $list_id: Unique HTML id of the listjs list.
 * - $value_names: An array of attribute names.
 *   - $value_name['value_name']: Attribute name.
 *   - $value_name['sort']: Is 1 if you want this attribute to be sortable. Is 0
 *     if you do not want this attribute to be sortable.
 *   - $value_name['sort_text']: Text that you want to use for the sort button
 *     of this attribute.
 *
 * @see template_preprocess_listjs()
 *
 * @ingroup themeable
 */
?>
<div id="<?php print $list_id; ?>">
  <div class="filter-wrapper">
    <?php print theme('textfield', array('element' => array('#attributes' => array('class' => array('search'), 'placeholder' => $placeholder_text, 'name' => $list_id . '-filter'), '#autocomplete_path' => FALSE))); ?>
  </div>
  <div class="sort-wrapper">
    <?php foreach ($value_names as $value_name => $conf): ?>
      <?php if ($conf['sort'] == 1): ?>
        <?php print theme('button', array('element' => array('#attributes' => array('class' => array('sort'), 'data-sort' => $value_name), '#button_type' => 'button', '#value' => $conf['sort_text']))); ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <ul <?php print drupal_attributes($list_attributes); ?>>
    <?php foreach ($items as $item): ?>
      <li><?php print $item['data']; ?></li>
    <?php endforeach; ?>
  </ul>
</div>
