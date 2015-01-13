<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Feeds extends Controller_Admin {

    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/feeds');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/feeds', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию список каналов прожвижения
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);

        $feeds = array();
        $feeds_obj = ORM::factory('Admin_Extension')->where("group","=","feed")->find_all();
        
        foreach ($feeds_obj as $feed){
                $feeds[] = $feed->key;
        }
        
        //текстовые переменные
        $text = Array(
            'column_action'         => __('column_action'),
            'column_name'           => __('column_name'),
            'column_status'         => __('column_status'),
            'message_no'            => __('message_no'),
            'text_edit'             => __('text_edit'),
        );
    
        //извлекаем пути к каналам				
		$files = glob(APPPATH . 'classes/Controller/Admin/Feeds/*.php');
        //если каналы есть, то формируем ссылки из названия каналов
        if ($files) {
			foreach ($files as $file) {
				$feed = basename(UTF8::strtolower($file), '.php');

                if (!in_array(UTF8::strtolower($feed), $feeds))  $status = 0;
                else $status = 1;
                
                //загружаем язык канала и формируем ссылку
                i18n::lang('admin/'.$this->language_folder.'/feeds/'. $feed);   								
                $this->data['feeds'][] = array(
					'name'   => __('heading_title'),
					'action' => $feed,
                    'status' => $status,
				);
                //загружаем язык контроллера снова
                i18n::lang('admin/'.$this->language_folder.'/feeds');
			}
		}

       
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'feeds/v_feeds_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)    
            ->bind('feeds', $this->data['feeds'])
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //сохранение данных канала в базу	
    protected function saveEncode($data){ 
    	$key = key($data);	//извлекаем ключ из массива (название канала)
    	$value = serialize($data[$key]);	//создаем строку из массива
    	
    	//проверяем, а есть ли запись в базе данных
    	$count = ORM::factory('Admin_Extension')->where("key","=",$key)->count_all();
    	
    	if($count == 0){
    		$feed = ORM::factory('Admin_Extension');	
    	}
    	else{
    		$feed = ORM::factory('Admin_Extension')->where("key","=",$key)->find();
    	}
    	$feed->group = "feed";
	    $feed->key = $key;
    	$feed->value = $value;
    	$feed->save();

    }

    //извлечение данных канала из базы
    protected function extractDecode($data){ 
	   return unserialize($data->value);
    }
    
    //удаление данных канала из базы
    protected function delete($data){ 
	   $feed = ORM::factory('Admin_Extension')->where("key","=",$data)->find();
        if( $feed->loaded())
        {
        	$feed->delete();
        }
        
    }

}
