<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Базовый класс главной страницы админки
 */
class Controller_Admin extends Controller_Core {

    public $template;
    protected $language_id;
    protected $language_folder;
    protected $message;
    protected $errors;
    protected $data = array();
    private $authorization = false;
    
    public function  before() {

        $this->template = 'admin/templates/'.kohana::$config->load('config')->template_admin.'/v_admin';
        parent::before();

	    //проверка, залогинен ли пользователь
        if (!$this->auth->logged_in() && Request::initial()->controller() !='Auth') {
            $this->session->set('reffer', Request::current()->uri());
            HTTP::redirect('admin/login');
        }
        elseif($this->auth->logged_in() && Request::initial()->controller() =='Auth' && Request::initial()->action() !='logout'){
            HTTP::redirect('admin');
        }
        elseif($this->auth->logged_in()){
            $this->authorization = true;
        }

    	//проверка доступа к контроллерам (доступ на чтение)
    	if($this->authorization && Request::current()->controller() != "Widgets" && Request::current()->controller() != "Feeds" && Request::current()->controller() != "Auth" && Request::current()->controller() != "Image"){
    		if (!$this->checkPermission('access', Request::current()->directory().'/'.Request::current()->controller())) {
                		if(Request::current()->controller() != "Errors" )
                            throw new HTTP_Exception_403(Request::current()->controller());
            }
    	}

        //идентификатор выбранного языка по-умолчанию
        $this->language_id = $this->config->get('admin_language_id');
        $this->language_folder = $this->config->get('admin_language_folder');

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/common');
        $select = Request::initial()->controller();

        // Вывод в шаблон
        $this->template->auth = $this->authorization;

        $this->template->menu = $this->menu();
        $this->template->icon = $this->icon();
        $this->template->language = $this->language_folder;

        $this->template->select = UTF8::strtolower($select);
        $this->template->page_url = array();
        $this->template->page_url[] = HTML::anchor('admin/main', __("heading_title"));
        $this->template->text = Array(
            "text_site"                 => __("text_site"),
            "text_admin"                => __("text_admin"),
            "text_footer_href"          => __("text_footer_href"),
            "text_footer_title"         => __("text_footer_title"),
            "text_footer_version"       => VERSION,
        );
        if($this->authorization){
            $this->template->text['entry_username']     = $this->user->username;
            $this->template->text['entry_profile']      = __("entry_profile");
            $this->template->text['entry_exit']         = __("entry_exit");
            $this->template->text['entry_settings']     = __("entry_settings");
            $this->template->text['entry_logs']         = __("entry_logs");
            $this->template->text['entry_help']         = __("entry_help");
            $this->template->text['profile']            = $this->user->id;
        }
        
        $this->template->template = $this->template_admin;
        $this->template->style = 'styles/'.$this->template_admin;
    }

    private function icon(){
        return array(
            'main'          => 'glyphicon glyphicon-home',
            'contentcms'    => 'glyphicon glyphicon-file',
            'mainmenu'      => 'glyphicon glyphicon-th-list',
            'user'          => 'glyphicon glyphicon-user',
            'template'      => 'glyphicon glyphicon-list-alt',
            'extension'     => 'glyphicon glyphicon-th',
        );
    }
    
    private function  menu() {
        return array(
            array(  __('menu_panel')                    => 'main'),
            array(
                    __('menu_content')                  => 'contentcms',
                    __('menu_content_articles')         => 'articles',
                    __('menu_content_pages')            => 'pages',
                    __('menu_content_news')             => 'news',
            ),
            array(
                    __('menu_main')                     => 'mainmenu',
                    __('menu_main_categories')          => 'categories',
                    __('menu_main_menu')                => 'menu',
            ),
            array(
                    __('menu_user')                     => 'user',
                    __('menu_user_users')               => 'users',
                    __('menu_user_roles')               => 'roles',
                    __('menu_user_comments')            => 'comments',
                    __('menu_user_subscribe')           => 'subscribes', 
            ),
            array(
                    __('menu_template')                 => 'template', 
                    __('menu_template_adverts')         => 'adverts', 
                    __('menu_template_languages')       => 'languages', 
                    __('menu_template_layouts')         => 'layouts', 
            ),
            array(
                    __('menu_extension')                => 'extension',
                    __('menu_extension_widgets')        => 'widgets',   
                    __('menu_extension_feeds')          => 'feeds',
            ),
        );
     }
}
