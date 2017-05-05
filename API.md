Theme usage
-----------
You can use `#theme` as `listjs` to render your own list in listjs format.

```php
$build = [];

$build['render'] = [
  '#theme' => 'listjs',
  '#placeholder_text' => $this->t('Kittens'),
  '#items' => [
    [
      'data' => [
        '#markup' => '<h2 class="value_name-house">Jones\'s</h2><div class="value_name-cat">Kitty</div>',
      ],
    ],
    [
      'data' => [
        '#markup' => '<h2 class="value_name-house">Hudson\'s</h2><div class="value_name-cat">Binky</div>',
      ],
    ],
    [
      'data' => [
        '#markup' => '<h2 class="value_name-house">Paul\'s</h2><div class="value_name-cat">Chinky</div>',
      ],
    ],
    [
      'data' => [
        '#markup' => '<h2 class="value_name-house">Singh\'s</h2><div class="value_name-cat">Tabby</div>',
      ],
    ],
  ],
  '#attributes' => [
    'class' => [
      'mykittens',
    ],
  ],
  '#list_id' => 'mykittens-are-unique',
  '#value_names' => [
    'value_name-cat' => [
      'sort' => TRUE,
      'sort_text' => $this->t('Sort Kittens'),
    ],
    'value_name-house' => [
      'sort' => FALSE,
    ],
  ],
];

return $build;
```

JavaScript hooks
----------------

```js
$(document).bind('listJsUpdated', function(event, listObject) {
  console.log('List has been updated', listObject);
});
```

Check out other list.js events here
[http://www.listjs.com/docs/list-api](http://www.listjs.com/docs/list-api)

List.js event     | Module JS hooks
------------------|----------------
`updated`         | `listJsUpdated`
`searchStart`     | `listJsSearchStart`
`searchComplete`  | `listJsSearchComplete`
`filterStart`     | `listJsFilterStart`
`filterComplete`  | `listJsFilterComplete`
`sortStart`       | `listJsSortStart`
`sortComplete`    | `listJsSortComplete`
