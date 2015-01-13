<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Wslider extends Controller_Index {
   
    public $template;
    
    public function action_index() {
        static $widget = 0;
        
        parent::$styles[] = 'styles/'.$this->template_index . 'stylesheet/nivo-slider.css';
        parent::$scripts[] = 'styles/'.$this->template_index . 'javascript/jquery/nivo-slider/jquery.nivo.slider.js';
        parent::$scripts[] = 'styles/'.$this->template_index . 'javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js';
        
        //извлекаем данные для отображения виджета, т.е. виджет с настройками, позицией и сортировкой
        $setting = Kohana_Widget::$params;
        
        $adverts = $this->cache->get('wslider'); //извлекаем изображения слайдреа из кэша
        //если кэша нет, то
        if($adverts == NULL)
        {
            $adverts = array();
    		
    		if (isset($setting['advert_id'])) {
    	        $results = DB::select()
                    ->from('advertsimages')   
                    ->join('advertsdescriptions')
                    ->on('advertsimages.id', '=', 'advertsdescriptions.image_id')
                    ->where('advertsimages.advert_id', '=', $setting['advert_id'])
                    ->and_where('advertsdescriptions.language_id', '=', $this->language_id)
                    ->execute()->as_array();
    			
                foreach ($results as $result) {
    				if (file_exists(DIR_IMAGE . $result['image'])) {
    					$adverts[] = array(
    						'title' => $result['title'],
    						'link'  => $result['link'],
    						'image' => $this->resizer($result['image'], $setting['width'], $setting['height'])
    					);
    				}
    			}
    		}
            
            $this->cache->set('wslider', $adverts); //сохраняем данные в кэш
        }
        
        $widget = $widget++;

        $this->template = View::factory($this->template_index.'widgets/w_slider')
            ->bind('width',         $setting['width'])
            ->bind('widget',        $widget)
            ->bind('adverts',       $adverts)
            ->bind('height',        $setting['height']);

    }
}
