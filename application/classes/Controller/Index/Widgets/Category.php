<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Меню сайта"
 */
class Controller_Index_Widgets_Category extends Controller_Index {
    public $template;
    public function action_index()
    {
        $params = Kohana_Widget::$params;
        $categories_res = $this->cache->get('categories'); //извлекаем категории из кэша
       
        // Menu
        $parts = array();
        if (isset($params['category'])) {
            $category = ORM::factory('Index_Category')->where('alias','=',$params['category'])->find();
        
            $categories = ORM::factory('Index_Category')->where('scope','=',$category->scope)->find_all(); 
            foreach($categories as $cat){
                $parts[] = $cat->alias;
            } 
            
        }
        //если кэша нет, то
        if($categories_res == NULL)
        {
            $categories_res = array();
            $categories = Model_Index_Category::getCategories(0,'by_parent',$this->language_id);
            foreach ($categories as $category) {
                if ($category['top']) {
                    $children_data = array();
    
                    $children = Model_Index_Category::getCategories($category['category_id'],'by_parent', $this->language_id);
    
                    foreach ($children as $child) {
                            $data = array(
                                    'filter_category_id'  => $child['category_id'],
                                    'filter_sub_category' => true
                            );
    
                            $children_data[] = array(
                                    'name'  => $child['title'],
                                    'href'  => 'c/'. $child['alias'],	
                            );						
                    }
    
                    // Level 1
                    $categories_res[] = array(
                            'name'     => $category['title'],
                            'children' => $children_data,
                            'alias'    => $category['alias'],
                            'column'   => $category['column'] ? $category['column'] : 1,
                            'href'     => 'c/'. $category['alias'],
                    );
                }
            }
            $this->cache->set('categories', $categories_res); //сохраняем данные в кэш
        }

        $this->template = View::factory($this->template_index.'widgets/category')
            ->bind('categories',    $categories_res)
            ->bind('parts',         $parts);

    }

}