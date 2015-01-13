<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Wnews extends Controller_Index {
   
    public $template;
    
    public function action_index() {
        static $widget = 0;
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/widgets/wnews');
        
        $text = array(
            'heading_title'           => __('heading_title'),
        );
                
        //извлекаем данные для отображения виджета, т.е. виджет с настройками, позицией и сортировкой
        $setting = Kohana_Widget::$params;
        
        $news = $this->cache->get('wnews'); //извлекаем новости из кэша
        
        //если кэша нет, то
        if($news == NULL)
        {
            $news = array();
    		if (isset($setting['limit'])) {
    	        $results = DB::select()
                    ->from('news')   
                    ->join('newsdescriptions')
                    ->on('news.id', '=', 'newsdescriptions.new_id')
                    ->where('news.status', '=', 1)
                    ->and_where('newsdescriptions.language_id', '=', $this->language_id)
                    ->limit($setting['limit'])
                    ->order_by('news.date_modified','DESC')
                    ->execute()->as_array();
    			
                foreach ($results as $result) {
    				$cut_descr_symbols = $setting['count'];
                    $descr_plaintext = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
    				if( mb_strlen($descr_plaintext, 'UTF-8') > $cut_descr_symbols )
    				{
    					$descr_plaintext = mb_substr($descr_plaintext, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
    				}
                    $news[] = array(
        				'title'        => HTML::anchor('news/'.$result['alias'].'.html', $result['title']),
        				'description'  => HTML::anchor('news/'.$result['alias'].'.html', $descr_plaintext),
        				'date_added'   => $result['date_modified']
        			);
    			}
    		}
            $this->cache->set('wnews', $news); //сохраняем данные в кэш
        }
        
        if(isset($setting['head'])) $head = 1;
        else $head = 0;

        $widget = $widget++;
        $all_news = HTML::anchor('news/', '<span>'.__('text_all_news').'</span>', array('class' => 'button'));

        $this->template = View::factory($this->template_index.'widgets/w_news')
            ->bind('head',          $head)
            ->bind('text',          $text)
            ->bind('widget',        $widget)
            ->bind('news',          $news)
            ->bind('all_news',      $all_news);


    }
}
