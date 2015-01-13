<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Widgets_Whtml extends  Controller_Admin_Widgets {
    private $languages;
    public function before() {
        parent::before();

        $this->template->styles[] = 'styles/admin/bower_components/font-awesome/css/font-awesome.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/summernote/dist/summernote.css';

        $this->template->scripts[] = 'styles/admin/bower_components/summernote/dist/summernote.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/lang/summernote-ru-RU.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-video.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-fontstyle.js';
        $this->template->scripts[] = 'styles/'.$this->template_admin.'javascript/common.js';

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/widgets/whtml');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/widgets/whtml', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию 
    public function action_index() {

        //извлекаем языки
        $this->languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
          
        if(isset($_POST["whtml"]) && $this->validate($_POST["whtml"]) && $this->validateModify()){
            
            $this->saveEncode($_POST);                  //кодируем массив в строку и сохраняем
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            HTTP::redirect('admin/widgets/'); //переадресация
        }
        elseif($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST) && $this->validateModify()){
            $this->delete("whtml"); 
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            HTTP::redirect('admin/widgets/'); //переадресация
        }
	    //текстовые переменные
        $text = array(
            
            'entry_layout'            => __('entry_layout'),
            'entry_position'          => __('entry_position'),
            'entry_status'            => __('entry_status'),
            'entry_sort_order'        => __('entry_sort_order'),
            'entry_description'       => __('entry_description'),
            'entry_title'             => __('entry_title'),
	    
            'text_content_top'        => __('text_content_top'),
            'text_content_bottom'     => __('text_content_bottom'),
            'text_column_left'        => __('text_column_left'),
            'text_column_right'       => __('text_column_right'),
            'text_slider'      	      => __('text_slider'),	

            'button_abort'            => __('button_abort'),
            'button_save'             => __('button_save'),
            'button_add_widget'       => __('button_add_widget'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),

            'tab_widget'              => __('tab_widget'),
            
        );
        
    	if(empty($this->data)){
            //извлекаем виджет категорий, если есть
        	$widget = ORM::factory('Admin_Extension')->where("key","=","whtml")->find();
        	if( ! $widget->loaded())
        	{
        		$widget = array();	
        	}
        	else{
        		$widget = $this->extractDecode($widget);      //декодируем строку обратно в массив
        	}
        }
        else{
            $widget = $this->data;
        }
        
    	//извлекаем схемы
    	$layouts = ORM::factory('Admin_Layout')->find_all();

    	//формируем значения для шаблона
        $content = View::factory($this->template_admin.'widgets/w_html')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) 
            ->bind('widgets', $widget)
            ->bind('locale', $this->language_folder)
            ->bind('layouts', $layouts) 
            ->bind('languages', $this->languages) 
            ->bind('text', $text);   

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    private function validate($rows) {
        foreach($rows as $row){
            foreach($this->languages as $language){

                $post = Validation::factory($row);
                $post->rule("title", 'not_empty', array($row['title'][$language->id]))->rule("title", 'min_length', array($row['title'][$language->id], '3'))->label("title" ,__('entry_title')." (".$language->code.")")
                     ->rule('description', 'not_empty', array($row['description'][$language->id]))->label('description' ,__('entry_description')." (".$language->code.")");
                if (!$post->check())
                {
                    $this->errors = $post->errors('admin/'.$this->language_folder.'/widget');
                }
            }
		}

        if(empty($this->errors)) return true;
        else{
            $this->data = $rows;
            return false;
        }
	}
}
