<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Базовый класс главной страницы
 */
class Controller_Index extends Controller_Core {

    public $template;        // Базовый шаблон
    protected $language_id;
    protected $language_folder;
    protected $languages;
    protected $extensions;
    protected $layouts; 
    protected $super = false;
    protected $lang;

    public static $styles = array();
    public static $scripts = array();
     
    public function  before() {
        parent::before();

        $languages = $this->cache->get('languages'); //извлекаем языки из кэша
        
        //если кэша нет, то
        if($languages == NULL)
        {
            $languages = array();
            $query_rows = DB::select()->from('languages')->where('status', '=', 1)->execute()->as_array(); //извлекаем все включеные языки
            foreach ($query_rows as $result) 
                $languages[$result['code']] = $result;
            $this->cache->set('languages', $languages); //сохраняем данные в кэш
        }
        
        $extensions = $this->cache->get('extensions'); //извлекаем расширения из кэша
        
        //если кэша нет, то
        if($extensions == NULL)
        {
            $extensions = DB::select()->from('extensions')->where('group','=','widget')->execute()->as_array();
            $this->cache->set('extensions', $extensions); //сохраняем данные в кэш
        }
       
        $layouts = $this->cache->get('layouts'); //извлекаем схемы из кэша
         
        //если кэша нет, то
        if($layouts == NULL)
        {
            $layouts = DB::select()->from('layouts')->execute()->as_array();
            $this->cache->set('layouts', $layouts); //сохраняем данные в кэш
        }
        
        $detect = '';
        
        //если есть заголовки с языком, то извлекаем из них язык
        if (Request::accept_lang()) { 
            $browser_languages = Request::accept_lang();

            foreach ($browser_languages as $loc=>$browser_language) {
                foreach ($languages as $key => $value) {
                    if ($value['status']) {
                        $locale = explode(',', $value['locale']);
                        if (in_array($loc, $locale))  $detect = $key; 
                    }
                }
            }
        }
        
        //если есть сессии, куки или заголовки с кодом языка, то извлекаем его, иначе берем по-умолчанию
        if ($this->session->get('language') && array_key_exists($this->session->get('language'), $languages) && $languages[$this->session->get('language')]['status']) {
                $code = $this->session->get('language');
        } elseif (Cookie::get('language') && array_key_exists(Cookie::get('language'), $languages) && $languages[Cookie::get('language')]['status']) {
                $code = Cookie::get('language');
        } elseif ($detect) {
                $code = $detect;
        } else {
                $code = $this->config->get('index_language_folder');
        }
       
        //если сессии с кодом языка нет, то создаем сессию
        if (!$this->session->get('language') || $this->session->get('language') != $code) {
                $this->session->set('language',$code);
        }
         //если куки с кодом языка нет, то создаем куку
        if (!Cookie::get('language') || Cookie::get('language') != $code) {	  
                Cookie::set('language', $code);
        }
         
        I18n::lang($code); // устанавливаем язык 
        
        $this->language_folder                      = $languages[$code]['code']; //ставим код языка
        $this->language_id                          = $languages[$code]['id']; //ставим id языка
        $this->languages                            = $languages;  //храним массив языков
        $this->extensions                           = $extensions;
        $this->layouts                              = $layouts;
        $this->lang = $code;
        $data = array(
            'base'              => 'http://'.$_SERVER['HTTP_HOST'].'/',
            'icon'              => HTTP_IMAGE.$this->config->get('icon'),
            'google_analytics'  => $this->config->get('google'),
            'lang'              =>  $code,
            'browser'           => BROWSER,
        );

        //если включен режим обслуживания, смотрим, какая роль у пользователя. Пускаем на сайт только супер админа
        if($this->config->get('maintenance') && $this->auth->logged_in()){
            if($this->user->roles->find()->id == $this->config->get('admin_role'))
                $this->super = true;
        }

        $this->template = View::factory($this->template_index.'v_index')
            ->bind('styles',        $this->template->styles)
            ->bind('scripts',       $this->template->scripts)
            ->bind('data',          $data);

        $this->template->title = $this->config->get('title');
        $this->template->description = $this->config->get('meta_description');
        $this->template->keywords = $this->config->get('meta_keywords');
    }
}
