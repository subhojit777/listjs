`theme('listjs')` usage
-----------------------
You can use `theme('listjs')` to render your own list in listjs formatted.

```php
theme('listjs', array(
  'placeholder_text' => t('Kittens'),
  'items' => array(
    array(
      'data' => '<h2 class="value_name-house">Jones\'s</h2><div class="value_name-cat">Kitty</div>',
    ),
    array(
      'data' => '<h2 class="value_name-house">Hudson\'s</h2><div class="value_name-cat">Binky</div>',
    ),
    array(
      'data' => '<h2 class="value_name-house">Paul\'s</h2><div class="value_name-cat">Chinky</div>',
    ),
    array(
      'data' => '<h2 class="value_name-house">Singh\'s</h2><div class="value_name-cat">Tabby</div>',
    ),
  ),
  'list_attributes' => array(
    'class' => array(
      'mykittens',
    ),
  ),
  'list_id' => 'mykittens-are-unique',
  'value_names' => array(
    'value_name-cat' => array(
      'sort' => TRUE,
      'sort_text' => t('Sort kittens'),
    ),
    'value_name-house' => array(
      'sort' => FALSE,
    ),
  ),
));
```

JavaScript hooks
----------------

```js
$(document).bind('listJsUpdated', function(event, listObject) {
  console.log('List has been updated', listObject);
});
```

Check out other list.js events here [http://www.listjs.com/docs/list-api](http://www.listjs.com/docs/list-api)

List.js event     | Module JS hooks
------------------|----------------
`updated`         | `listJsUpdated`
`searchStart`     | `listJsSearchStart`
`searchComplete`  | `listJsSearchComplete`
`filterStart`     | `listJsFilterStart`
`filterComplete`  | `listJsFilterComplete`
`sortStart`       | `listJsSortStart`
`sortComplete`    | `listJsSortComplete`
