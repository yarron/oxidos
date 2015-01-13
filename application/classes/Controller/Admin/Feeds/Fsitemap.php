<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Feeds_Fsitemap extends Controller_Admin_Feeds {
    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/feeds/fsitemap');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/feeds/fsitemap', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию 
    public function action_index() {
        $file = 'sitemap.xml';
        $url = URL::base(true).$file;
        
        if (file_exists($file)) 
            $time = filemtime($file); 
        else 
            $time = null;
        
        if(isset($_POST['fsitemap']['status']) && $this->validate($_POST["fsitemap"]) && $this->validateModify()){

            $this->saveEncode($_POST);                  //кодируем массив в строку и сохраняем
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            HTTP::redirect('admin/feeds/'); //переадресация
        }
        elseif($_SERVER["REQUEST_METHOD"]=="POST" && !isset($_POST['fsitemap']['status']) && $this->validateModify()){
            $this->delete("fsitemap"); 
            @unlink($file);
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            HTTP::redirect('admin/feeds/'); //переадресация
        }
	    
        //текстовые переменные
        $text = array(
            'entry_status'              => __('entry_status'),
            'entry_priority_page'       => __('entry_priority_page'),
            'entry_priority_news'       => __('entry_priority_news'),
            'entry_priority_category'   => __('entry_priority_category'),
            'entry_priority_article'    => __('entry_priority_article'),
            'entry_info'                =>  sprintf(__('entry_info'), date("Y-m-d H:i", $time), HTML::anchor($url,$url,array('target' =>'_blank'))),

            'button_map'                => __('button_map'),
            'button_robot'              => __('button_robot'),
            'button_save'   	        => __('button_save'),
            'button_abort'              => __('button_abort'),
            'button_loading'            => __('button_loading'),
            'button_connect'            => __('button_connect'),
        );
        
        if(empty($this->data)){
            //извлекаем канал, если есть
        	$feed = ORM::factory('Admin_Extension')->where("key","=","fsitemap")->find();
        	if( ! $feed->loaded())
                    $feed = array();	
        	else
                    $feed = $this->extractDecode($feed);      //декодируем строку обратно в массив
        }
        else{
            $feed = $this->data;
        }

    	//формируем значения для шаблона
        $content = View::factory($this->template_admin.'feeds/f_sitemap')
            ->bind('template',$this->template_admin)
			->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) 
            ->bind('feed', $feed) 
            ->bind('time', $time) 
            ->bind('url', $url)
            ->bind('text', $text);   

        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_map(){
        if($this->request->is_ajax() && $this->request->post() && $this->validateModify()){
            Controller_Admin_Sitemap::map($_POST['page'], $_POST['news'], $_POST['category'], $_POST['article']);
            die();
        }
        else echo __('error_permission'); die();
    }

    public function action_robot(){
        if($this->request->is_ajax() && isset($_POST['url']) && $this->validateModify()){
            $robots = Controller_Admin_Sitemap::ping($_POST['url']);
            $html = "";
            foreach($robots as $k=>$value){
                if($value == 200) 
                    $html .= sprintf(__('entry_response_ok'),$k);
                else 
                    $html .= sprintf(__('entry_response_bad'),$k);
            }
            echo $html;  die();
        }
        else echo __('error_permission'); die();
    }

    private function validate($row) {

            $post = Validation::factory($row);

            $post->rule('priority_page',    'not_empty')    ->rule('priority_page',    'numeric'  )   ->label('priority_page'     ,__('entry_priority_page'))
                 ->rule('priority_article', 'not_empty')    ->rule('priority_article', 'numeric'  )   ->label('priority_article'  ,__('entry_priority_article'))
                 ->rule('priority_category', 'not_empty')   ->rule('priority_category', 'numeric'  )  ->label('priority_category'  ,__('entry_priority_category'))
                 ->rule('priority_news', 'not_empty')       ->rule('priority_news', 'numeric'  )      ->label('priority_news'  ,__('entry_priority_news'));

            if (!$post->check())
            {
                $this->errors = $post->errors('admin/'.$this->language_folder.'/feed');
            }


        if(empty($this->errors)) return true;
        else{
            $this->data = $row;
            return false;
        }
    }
}
