`theme('listjs')` usage
-----------------------
You can use `theme('listjs')` to render your own list in listjs formatted.

```php
theme('listjs', array(
  'placeholder_text' => t('Kittens'),
  'items' => array(
    array(
      'data' => '<div class="cats">Kitty</div>',
    ),
    array(
      'data' => '<div class="cats">Binky</div>',
    ),
    array(
      'data' => '<div class="cats">Chinky</div>',
    ),
    array(
      'data' => '<div class="cats">Tabby</div>',
    ),
  ),
  'list_attributes' => array(
    'class' => array(
      'mykittens',
    ),
  ),
  'list_id' => 'mykittens-are-unique',
  'value_names' => array(
    array(
      'value_name' => 'cats',
      'sort' => TRUE,
      'sort_text' => t('Sort kittens'),
    ),
  ),
));
```

JavaScript hooks
----------------

```js
$(document).bind('listJsUpdated', function(event, listObject) {
  console.log('List has been updated');
});
$(document).bind('listJsSearchStart', function(event, listObject) {
  console.log('List search has started');
});
$(document).bind('listJsSearchComplete', function(event, listObject) {
  console.log('List search has completed');
});
```

Check out more hooks here [http://www.listjs.com/docs/list-api](http://www.listjs.com/docs/list-api)
