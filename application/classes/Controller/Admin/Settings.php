<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Настройки
 */
class Controller_Admin_Settings extends Controller_Admin {
    protected $errors;
    protected $languages;
    protected $pages;
    protected $roles;
   
    public function before() {
        parent::before();

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/settings');

        //извлекаем все языки
        $this->languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
        
        //извлекаем все статические страницы
        $this->pages = DB::select()
                ->from('pages')   
                ->join('pagesdescriptions')
                ->on('pages.id', '=', 'pagesdescriptions.page_id')
                ->where('pagesdescriptions.language_id', '=', $this->language_id)
                ->and_where('pages.status', '=', 1)
                ->as_object()->execute();
        
        //извлекаем все Роли
        $this->roles = ORM::factory('Admin_Role')->find_all();
        
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/settings', $this->template->page_title);
    }

    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);
        
        if (isset($_POST['settings']) && $this->validateModify()){
            $this->check($_POST['settings']);
        }

        //формируем массив языков
        $languages = array();
        foreach ($this->languages as $language){
                $languages[$language->id] = $language->name;
        }
        
        //формируем массив страниц
        $pages = array();
        $pages[] = __('text_no_select');
        foreach ($this->pages as $page){
                $pages[$page->page_id] = $page->title;
        }
        
        //формируем массив ролей
        $roles = array();
        foreach ($this->roles as $role){
                $roles[$role->id] = $role->name;
        }
        
        //формируем значения для проверки сайта на обслуживание
        $maintenance = $this->config->get('maintenance');
        if($maintenance){ $server["yes"] = true; $server["no"] = false; }   
        else{ $server["yes"] = false; $server["no"] = true; }
        
        $mail['protocol'] = array(
            "native"  => "Mail",
            "smtp"  => "SMTP"
        );   
        
        //формируем значения для проверки на отправку почты
        $mail_registration = $this->config->get('mail_registration');
        if($mail_registration){ $mail["yes"] = true; $mail["no"] = false;}   
        else{ $mail["yes"] = false; $mail["no"] = true; }

        //формируем значения для проверки режима комментариев
        $mode_comment = $this->config->get('mode_comment');
        if($mode_comment){ $comment["yes"] = true; $comment["no"] = false;}   
        else{ $comment["yes"] = false; $comment["no"] = true; }
        
        //формируем значения для проверки режима модерирования комментариев
        $comment_moderation = $this->config->get('comment_moderation');
        if($comment_moderation){ $moderation["yes"] = true; $moderation["no"] = false;}
        else{ $moderation["yes"] = false; $moderation["no"] = true; }

        //формируем значения для проверки гостей у комментариев
        $comment_guest = $this->config->get('comment_guest');
        if($comment_guest){ $guest["yes"] = true; $guest["no"] = false;}
        else{ $guest["yes"] = false; $guest["no"] = true; }

        //формируем значения для проверки сжатия кеширования
        $cache_compression = $this->config->get('cache_compression');
        if($cache_compression){ $compression["yes"] = true; $compression["no"] = false;}   
        else{ $compression["yes"] = false; $compression["no"] = true; }
        
        $cache = array(
            "file"          => "File",
            "memcache"      => "Memcache",
            "apc"           => "Apc",
            "wincache"      => "Wincache",
        ); 

        //инициализируем текстовые переменные
        $text = array(
            'tab-general'               => __('tab-general'),
            'tab-meta'                  => __('tab-meta'),
            'tab-local'                 => __('tab-local'),
            'tab-mail'                  => __('tab-mail'),
            'tab-image'                 => __('tab-image'),
            'tab-option'                => __('tab-option'),
            'tab-server'                => __('tab-server'),
            'tab-stat'                  => __('tab-stat'),
            
            'head_user'                 => __('head_user'),
            'head_article'              => __('head_article'),
            'head_new'                  => __('head_new'),
            'head_comment'              => __('head_comment'),
            'head_search'               => __('head_search'),

            'button_apply'              => __('button_apply'),
            'button_save'               => __('button_save'),
            'button_abort'              => __('button_abort'),
            'button_loading'            => __('button_loading'),

            'text_yes'                  => __('text_yes'),
            'text_no'                   => __('text_no'),
            
            'text_company_name'         => __('text_company_name'),
            'text_company_description'  => __('text_company_description'),
            'text_company_director'     => __('text_company_director'),
            'text_company_email'        => __('text_company_email'),
            'text_company_address'      => __('text_company_address'),
            'text_company_phone'        => __('text_company_phone'),
            'text_company_fax'          => __('text_company_fax'),
            'text_company_code'         => __('text_company_code'),
            'text_company_code_tooltip' => __('text_company_code_tooltip'),
            
            'text_mail_protocol'        => __('text_mail_protocol'),
            'text_smtp_host'            => __('text_smtp_host'),
            'text_smtp_login'           => __('text_smtp_login'),
            'text_smtp_password'        => __('text_smtp_password'),
            'text_smtp_port'            => __('text_smtp_port'),
            'text_smtp_timeout'         => __('text_smtp_timeout'),
            'text_mail_registration'    => __('text_mail_registration'),
            'text_optional_address'     => __('text_optional_address'),
            'text_optional_address_tooltip'     => __('text_optional_address_tooltip'),
            
            'text_logotype'             => __('text_logotype'),
            'text_icon'                 => __('text_icon'),
            'text_icon_tooltip'         => __('text_icon_tooltip'),
            'text_browse'               => __('text_browse'),
            'text_clear'                => __('text_clear'),
            'text_image_manager'        => __('text_image_manager'),
            
            'text_image_category'       => __('text_image_category'),
            'text_image_article'        => __('text_image_article'),
            'text_image_popup'          => __('text_image_popup'),
            'text_image_news'           => __('text_image_news'),
            'text_image_search'         => __('text_image_search'),
            
            'text_limit_article'        => __('text_limit_article'),
            'text_count_article'        => __('text_count_article'),
            'text_limit_new'            => __('text_limit_new'),
            'text_count_new'            => __('text_count_new'),
            'text_mode_comment'         => __('text_mode_comment'),
            'text_count_comment'        => __('text_count_comment'),
            'text_limit_search'         => __('text_limit_search'),
            'text_count_search'         => __('text_count_search'),
            'text_comment_moderation'   => __('text_comment_moderation'),
            'text_comment_guest'        => __('text_comment_guest'),
            'text_newsletter'           => __('text_newsletter'),
            'text_newsletter_tooltip'   => __('text_newsletter_tooltip'),
            'text_user_role'            => __('text_user_role'),
            'text_user_role_tooltip'    => __('text_user_role_tooltip'),
            'text_admin_role'           => __('text_admin_role'),
            'text_admin_role_tooltip'   => __('text_admin_role_tooltip'),
            
            'text_site_name'            => __('text_site_name'),
            'text_site_description'     => __('text_site_description'),
            'text_title'                => __('text_title'),
            'text_meta_description'     => __('text_meta_description'),
            'text_meta_keywords'        => __('text_meta_keywords'),
            'text_template_index'       => __('text_template_index'),
            'text_template_admin'       => __('text_template_admin'),
            
            'text_language_index'       => __('text_language_index'),
            'text_language_admin'       => __('text_language_admin'),
            'text_maintenance'          => __('text_maintenance'),
            'text_maintenance_tooltip'  => __('text_maintenance_tooltip'),
            'text_maintenance_info'     => __('text_maintenance_info'),
            'text_maintenance_info_tooltip' => __('text_maintenance_info_tooltip'),

            'text_cache'                => __('text_cache'),
            'text_cache_tooltip'        => __('text_cache_tooltip'),
            'text_cache_time'           => __('text_cache_time'),
            'text_cache_time_tooltip'   => __('text_cache_time_tooltip'),
            'text_cache_compression'    => __('text_cache_compression'),
            'text_cache_host'           => __('text_cache_host'),
            'text_cache_port'           => __('text_cache_port'),
            'text_cache_mem_tooltip'    => __('text_cache_mem_tooltip'),

            'text_google'               => __('text_google'),
            'text_google_login'         => __('text_google_login'),
            'text_google_password'      => __('text_google_password'),
            'text_google_report_id'     => __('text_google_report_id'),
            'text_google_check'         => __('text_google_check'),
            'text_google_start'         => __('text_google_start'),
            'text_google_check_tooltip' => __('text_google_check_tooltip'),
        );
        
        if ($this->config->get('logo') && file_exists(DIR_IMAGE . $this->config->get('logo'))) {
            $logo = $this->config->get('logo');
        } else {
            $logo = 'no_image.jpg';
        }
        
        if ($this->config->get('icon') && file_exists(DIR_IMAGE . $this->config->get('icon'))) {
            $png = $this->config->get('icon');
        } else {
            $png = 'no_image.jpg';
        }
        
        $logotype = array(
            "logo"          => $logo,
            "thumb"         => $this->resizer($logo, 150, 100),
            "no_image"      => $this->resizer('no_image.jpg', 100, 100),
        );
        
        $icon = array(
            "icon"          => $png,
            "thumb"         => $this->resizer($png, 30, 30),
            "no_image"      => $this->resizer('no_image.jpg', 30, 30),
        );
        
        $templates_index = array();
		$directories_index = glob('styles/index/templates/*', GLOB_ONLYDIR);
		foreach ($directories_index as $directory_i) $templates_index[] = basename($directory_i);
        $config_template_index = $this->config->get('template_index');
        
        $templates_admin = array();
		$directories_admin = glob('styles/admin/templates/*', GLOB_ONLYDIR);
		foreach ($directories_admin as $directory_a) $templates_admin[] = basename($directory_a);
        $config_template_admin = $this->config->get('template_admin');
        
        $content = View::factory($this->template_admin.'settings/v_settings')
                ->bind('template',				$this->template_admin)
				->bind('box_title',             $this->template->page_title)
                ->bind('errors',                $this->errors) //ошибки
                ->bind('message',               $this->message) //сообщения
                ->bind('languages',             $languages) //массив языков
                ->bind('text',                  $text) //массив текста для полей
                ->bind('server',                $server) //массив текста для полей
                ->bind('cache',                 $cache) //массив текста кэширования
                ->bind('compression',           $compression) //массив текста кэширования
                ->bind('mail',                  $mail) //
                ->bind('moderation',            $moderation) //
                ->bind('guest',            		$guest) //
                ->bind('comment',               $comment) //
                ->bind('logotype',              $logotype) //
                ->bind('icon',                  $icon) //
                ->bind('pages',                 $pages) //массив текста для полей
                ->bind('roles',                 $roles) //массив текста для полей
                ->bind('templates_index',       $templates_index) //массив шаблонов
                ->bind('config_template_index', $config_template_index) //шаблон
                ->bind('templates_admin',       $templates_admin) //массив шаблонов
                ->bind('config_template_admin', $config_template_admin) //шаблон
                ->bind('data',                  $this->config);    //передаваемые данные;

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    //функция проверки на валидацию
    private function check($settings){
        
        $data = Validation::factory($settings);
        
        //проверка полей на валидацию
        $data->rule('company_name', 'not_empty')        ->label('company_name' ,        __('text_company_name'))   
             ->rule('company_director', 'not_empty')    ->label('company_director' ,    __('text_company_director'))   
             ->rule('company_email', 'email')           
             ->rule('company_email', 'not_empty')       ->label('company_email' ,       __('text_company_email'))
             ->rule('company_address', 'not_empty')     ->label('company_address' ,     __('text_company_address'))
             ->rule('company_phone', 'phone')           
             ->rule('company_phone', 'not_empty')       ->label('company_phone' ,       __('text_company_phone'))
             ->rule('site_name', 'not_empty')           ->label('site_name' ,           __('text_site_name'))
             ->rule('site_description', 'not_empty')    ->label('site_description' ,    __('text_site_description'))
             ->rule('title', 'not_empty')               ->label('title' ,               __('text_title'))
             
             ->rule('limit_article', 'not_empty')      
             ->rule('limit_article', 'digit')           ->label('limit_article' ,       __('text_limit_article'))
             ->rule('count_article', 'not_empty')      
             ->rule('count_article', 'digit')           ->label('count_article' ,       __('text_count_article'))
             ->rule('limit_new', 'not_empty')      
             ->rule('limit_new', 'digit')               ->label('limit_new' ,           __('text_limit_new'))
             ->rule('count_new', 'not_empty')      
             ->rule('count_new', 'digit')               ->label('count_new' ,           __('text_count_new'))
             ->rule('count_comment', 'not_empty')      
             ->rule('count_comment', 'digit')           ->label('count_comment' ,       __('text_count_comment'))
             ->rule('limit_search', 'not_empty')      
             ->rule('limit_search', 'digit')            ->label('limit_search' ,        __('text_limit_search'))
             ->rule('count_search', 'not_empty')      
             ->rule('count_search', 'digit')            ->label('count_search' ,        __('text_count_search'))
                
             ->rule('image_category', 'not_empty')      
             ->rule('image_category', 'digit')          ->label('image_category' ,      __('text_image_category'))
             ->rule('image_article', 'not_empty')      
             ->rule('image_article', 'digit')           ->label('image_article' ,       __('text_image_article'))
             ->rule('image_news', 'not_empty')      
             ->rule('image_news', 'digit')              ->label('image_news' ,          __('text_image_news'))
             ->rule('image_search', 'not_empty')      
             ->rule('image_search', 'digit')            ->label('image_search' ,        __('text_image_search'))
             ->rule('image_popup', 'not_empty')      
             ->rule('image_popup', 'digit')             ->label('image_popup' ,         __('text_image_popup')) 
             
             ->rule('cache',array($this,'is_extension'))->label('cache' ,               $settings['cache'])
             ->rule('cache_time', 'not_empty')      
             ->rule('cache_time', 'digit')              ->label('cache_time' ,          __('text_cache_time'));
        
     
        if ($data->check())
        {
            $this->config->set('company_name',          $settings['company_name'] );
            $this->config->set('company_description',   $settings['company_description'] );
            $this->config->set('company_director',      $settings['company_director'] );
            $this->config->set('company_email',         $settings['company_email'] );
            $this->config->set('company_address',       $settings['company_address'] );
            $this->config->set('company_phone',         $settings['company_phone'] );
            $this->config->set('company_fax',           $settings['company_fax'] );
            $this->config->set('company_code',          $settings['company_code'] );
            
            $this->config->set('site_name',             $settings['site_name'] );
            $this->config->set('site_description',      $settings['site_description'] );
            $this->config->set('title',                 $settings['title'] );
            $this->config->set('meta_description',      $settings['meta_description'] );
            $this->config->set('meta_keywords',         $settings['meta_keywords'] );
            $this->config->set('template_index',        $settings['template_index'] );
            $this->config->set('template_admin',        $settings['template_admin'] );
            $this->config->set('mail_protocol',         $settings['mail_protocol'] );
            
            if($settings['mail_protocol'] == "smtp"){
                $this->config->set('smtp_host',             $settings['smtp_host'] );
                $this->config->set('smtp_login',            $settings['smtp_login'] );
                $this->config->set('smtp_password',         $settings['smtp_password'] );
                $this->config->set('smtp_port',             $settings['smtp_port'] );
                $this->config->set('smtp_timeout',          $settings['smtp_timeout'] );
            }
            
            $this->config->set('mail_registration',     $settings['mail_registration'] );
            $this->config->set('optional_address',      $settings['optional_address'] );
            
            $this->config->set('logo',                  $settings['logo'] );
            $this->config->set('icon',                  $settings['icon'] );
            
            $this->config->set('limit_article',         $settings['limit_article'] );
            $this->config->set('count_article',         $settings['count_article'] );
            $this->config->set('limit_new',             $settings['limit_new'] );
            $this->config->set('count_new',             $settings['count_new'] );
            $this->config->set('count_comment',         $settings['count_comment'] );
            $this->config->set('mode_comment',          $settings['mode_comment'] );

            $this->config->set('comment_moderation',    $settings['comment_moderation'] );
            $this->config->set('comment_guest',         $settings['comment_guest'] );

            $this->config->set('limit_search',          $settings['limit_search'] );
            $this->config->set('count_search',          $settings['count_search'] );
            
            $this->config->set('image_category',        $settings['image_category'] );
            $this->config->set('image_article',         $settings['image_article'] );
            $this->config->set('image_news',            $settings['image_news'] );
            $this->config->set('image_search',          $settings['image_search'] );
            $this->config->set('image_popup',           $settings['image_popup'] );

            $this->config->set('maintenance',           $settings['maintenance'] );
            $this->config->set('maintenance_info',      $settings['maintenance_info'] );
            $this->config->set('newsletter',            $settings['newsletter'] );
            $this->config->set('user_role',             $settings['user_role'] );
            $this->config->set('admin_role',            $settings['admin_role'] );
           
            $this->config->set('cache',                 $settings['cache'] );
            $this->config->set('cache_time',            $settings['cache_time'] );
            
            $this->cache->delete_all(); //очищаем кэш
            if($settings['cache'] == "memcache"){
                $this->config->set('cache_compression',     $settings['cache_compression'] );
                $this->config->set('cache_host',            $settings['cache_host'] );
                $this->config->set('cache_port',            $settings['cache_port'] );
            }
            
            $this->config->set('google',                $settings['google'] );
            $this->config->set('google_login',          $settings['google_login'] );
            $this->config->set('google_password',       $settings['google_password'] );
            $this->config->set('google_report_id',      $settings['google_report_id'] );
               
            foreach($this->languages as $language){
                if($language->id == $settings['admin_language_id']){
                    $this->config->set('admin_language_id',$settings['admin_language_id'] );
                    $this->config->set('admin_language_folder',$language->code );
                }
                if($language->id == $settings['index_language_id']){
                    $this->config->set('index_language_id',$settings['index_language_id'] );
                    $this->config->set('index_language_folder',$language->code );
                }
            }
            
            //загрузка языкового файла
            i18n::lang('admin/'.$this->language_folder.'/settings');
            $this->session->set('message', __('message_edit'));
            HTTP::redirect('admin/settings');
        }
        else{
            $this->errors = $data->errors('admin/'.$this->language_folder.'/setting');
        }
        $this->config->get = $settings;
            
    }
    
   
    public function is_extension($value) {
        if ( ! extension_loaded($value) && $value!= 'file') 
            return false;
        else 
            return true;
    }
    
    public function action_info() {
        $template = basename($this->request->param('id'));
		
		if (file_exists(DIR_IMAGE. 'templates/'.$template. '.png')) {
			$image = HTTP_IMAGE .'templates/'.$template. '.png';
		} else {
			$image = HTTP_IMAGE . 'no_image.jpg';
		}
		
		echo '<img src="' . $image . '" alt="" title="" class="img-thumbnail" />'; die();
        
	}	
}