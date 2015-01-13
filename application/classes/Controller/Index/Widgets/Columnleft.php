<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Columnleft extends Controller_Index {
   
    public $template;
    
    public function action_index() {
        $params = Kohana_Widget::$params;

		if (isset($params['route'])) {
			$route = (string)$params['route'];
		} else {
			$route = '/';
		}

        $layout_id = 0;
        foreach($this->layouts as $layout){
            if($layout['route'] == $route){
                $layout_id = $layout['id'];
                break;
            }
        }

		$widget_data = array();
        
        foreach ($this->extensions as $extension) {
            
    		$widgets = unserialize($extension['value']);
            
			if ($widgets) {
				foreach ($widgets as $widget) {
				    if(!isset($widget['status'])) 
                        $status = 0;
                    else  
                        $status = 1;
                    
					if ($widget['layout_id'] == $layout_id && $widget['position'] == 'column_left' && $status) {
					   
						$widget_data[] = array(
							'code'       => $extension['key'],
							'setting'    => $widget,
							'sort_order' => $widget['sort_order']
						);				
					}
				}
			}
		}

		$sort_order = array(); 
		foreach ($widget_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}
		array_multisort($sort_order, SORT_ASC, $widget_data);

		$data_widgets = array();
		
        foreach ($widget_data as $widget) {
            $wid = Kohana_Widget::load($widget['code'], $widget['setting']);
			if ($wid) {
				$data_widgets[] = $wid;
			}
		}

        $this->template = View::factory($this->template_index.'widgets/column_left')
            ->bind('column_left',          $data_widgets);
    }
}