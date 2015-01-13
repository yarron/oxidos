<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'Model_Admin_Category::cat_delete'    => 'Категории нельзя удалить пока она содержит вложенные категории',
    'Model_Admin_Category::cat_article'   => 'Категорию нельзя удалить пока она привязана к статье',
    'cat_child'                           => 'Категорию с вложенными категориями нельзя перемещать в другую корневую категорию. Сначала удалите вложенные категории.',
    'unique'                              => '":field" со значением ":value" уже существует',
    'not_empty'                             => 'Поле ":field" должно быть не пустым',
);