<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Wcategory extends Controller_Index {
    public $template;
    
    public function action_index() {
        $path = "";
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/widgets/wcategory');
        
        $text = array(
            'heading_title'           => __('heading_title'),
        );

        //если в запросе есть категория, то извлекаем её название
        if (Request::initial()->param('category')) {
			$path = Request::initial()->param('category');
		} 
        
        // ищем все узлы данного дерева
        $parts = array();
        if ($path) {
            $parents = ORM::factory('Index_Category',array("alias" => $path))->where('status', '=', 1)->get_parents(true,true);
            foreach($parents as $cat){
                $parts[] = $cat->alias;
            } 
        }	
        
        //присваеваем первый узел,т.е. его alias, чтобы делать категорию активной
        if (isset($parts[0])) {
			$category_id = $parts[0];
		} else {
			$category_id = "";
		}
		
        //извлекаем путь, чтобы делать потомка активным
		if ($path && isset($parts[1])) {
			$child_id = $parts[1];
		} else {
			$child_id = "";
		}
        
        $cats = $this->cache->get('wcategories'); //извлекаем категории из кэша
        
        //если кэша нет, то
        if($cats == NULL){
            $cats = array();
            $categories = Model_Index_Category::getCategories(0,'by_parent',$this->language_id);
    		foreach ($categories as $category) {
    			$children_data = array();
    			$children = Model_Index_Category::getCategories($category['category_id'],'by_parent',$this->language_id);
                
    			foreach ($children as $child) {
    				$children_data[] = array(
    					'category_id' => $child['category_id'],
    					'name'        => $child['title'],
                        'alias'       => $child['alias'],
    					'href'        => 'c/'.$child['alias'],	
    				);		
    			}
    			$cats[] = array(
    				'category_id' => $category['category_id'],
    				'name'        => $category['title'],
                    'alias'       => $category['alias'],
    				'children'    => $children_data,
    				'href'        => 'c/'.$category['alias'],
    			);	
    		}
            $this->cache->set('wcategories', $cats); //сохраняем данные в кэш
        }

        $this->template = View::factory($this->template_index.'widgets/w_category')
            ->bind('categories',    $cats)
            ->bind('text',          $text)
            ->bind('category_id',   $category_id)
            ->bind('child_id',      $child_id);

    }
    
 }