<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Comment extends ORM {
    protected $_table_name = 'comments';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';

    protected $_belongs_to = array(
        'articles' => array(
                'model' => 'Index_Article',
                'foreign_key' => 'article_id',
        ),
    );
    
    public function rules()
    {
        return array(
            'article_id' => array(
                array('not_empty'),
                array(array($this, 'is_article'), array(':value'))
            ),
            'text' => array(
                array('not_empty'),
                array('min_length', array(':value', 17))
            ),
            'author' => array(
                array('not_empty'),
                array('min_length', array(':value', 3))
            ),
            'email' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('email'),
            ),

        );
    }

    public function is_article($value)
    {
        $article = ORM::factory('Index_Article')->where('id', '=', $value)->count_all();
        
        if($article > 0)
            return true;
        else
            return false;
    }
} 
