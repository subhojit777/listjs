`theme('listjs')` usage
-----------------------
You can use `theme('listjs')` to render your own list in listjs formatted.

```php
theme('listjs', array(
  'placeholder_text' => t('Kittens'),
  'items' => array(
    array(
      'data' => '<div class="value_name-cat">Kitty</div>',
    ),
    array(
      'data' => '<div class="value_name-cat">Binky</div>',
    ),
    array(
      'data' => '<div class="value_name-cat">Chinky</div>',
    ),
    array(
      'data' => '<div class="value_name-cat">Tabby</div>',
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
      'sort' => 1,
      'sort_text' => t('Sort kittens'),
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
