<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'Model_Admin_Category::cat_delete'    => 'Categories can not be removed until it contains nested categories',
    'Model_Admin_Category::cat_article'   => 'Category can not be deleted while it is bound to article',
    'cat_child'                           => 'Category level categories can not be moved to another root category. First remove nested categories.',
    'unique'                                => '":field" with value ":value" not unique',
    'not_empty'                             => '":field" must not be empty',
);