<div id="listjs-wrapper">
  <input class="search" placeholder="<?php print $placeholder_text; ?>" />
  <ul class="list">
    <?php foreach ($items as $item): ?>
      <li>
        <div class="name"><?php print $item['title']; ?></div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
