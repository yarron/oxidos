<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Feeds_Frss extends Controller_Admin_Feeds {
    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/feeds/frss');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/feeds/frss', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию 
    public function action_index() {

        if(isset($_POST["frss"]) && $this->validateModify()){
            $this->saveEncode($_POST);                  //кодируем массив в строку и сохраняем
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            $this->cache->delete('rss');
            HTTP::redirect('admin/feeds/'); //переадресация
        }
        elseif($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST) && $this->validateModify()){
            $this->delete("frss"); 
            $this->cache->delete('rss');
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            HTTP::redirect('admin/feeds/'); //переадресация
        }
	    
        //текстовые переменные
        $text = array(
            'entry_url'             => __('entry_url'),
            'entry_status'          => __('entry_status'),
	        'url'		            => URL::base(true).'rss.xml',
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
        if(empty($this->data)){
            //извлекаем канал, если есть
        	$feed = ORM::factory('Admin_Extension')->where("key","=","frss")->find();
        	if( ! $feed->loaded())
        	{
        		$feed = array();	
        	}
        	else{
        		$feed = $this->extractDecode($feed);      //декодируем строку обратно в массив
        	}
        }
        else{
            $feed = $this->data;
        }
    	

    	
    	//формируем значения для шаблона
        $content = View::factory($this->template_admin.'feeds/f_rss')
            ->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) 
            ->bind('feed', $feed) 
            ->bind('text', $text);   

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
}
