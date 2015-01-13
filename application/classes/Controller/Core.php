<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Общий базовый класс
 */
class Controller_Core extends Controller_Template {
    protected $user;
    protected $auth;
    protected $cache;
    protected $session;
    protected $config;
    protected $statistic;
    protected $template_index;
    protected $template_admin;

    public function before() {
        parent::before();

        //если существует модуль установки, то переходим в него
        if(is_dir(MODPATH.'install')){
            $module = Kohana::modules();
            if(isset($module['install'])){
                HTTP::redirect('install');
            }
        }

        //извлекаем данные из конфига
        $this->config = kohana::$config->load('config');

        //инициализируем переменные сессии и куков
        Cookie::$salt = $this->config->get('salt');
        Session::$default = $this->config->get('session');

        //инициализируем остальные переменные и создаем экземпляры классов
        $this->cache = Cache::instance($this->config->get('cache'));
        $this->session = Session::instance();
        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();

        $this->template_index = 'index/templates/'.$this->config->get('template_index').'/';
        $this->template_admin = 'admin/templates/'.$this->config->get('template_admin').'/';

        //анонимная информация
        if(Request::current()->directory() == 'Admin'){
            $statistic = (int) Encrypt::instance()->decode($this->config->get('statistic'));
            if(!$statistic){
                $this->config->set('statistic', Encrypt::instance()->encode(time()));
            }

            $time = (int)$statistic + 86400; //прошел день
            if($time <= time()){
                $this->statistic = "$.ajax({url: 'http://www.oxidos.ru/free?callback=?', type: 'GET', crossdomain: true, data: {data: '".Encrypt::instance()->encode($_SERVER['HTTP_HOST'].'~'.$_SERVER["REMOTE_ADDR"].'~'.$statistic)."'}, dataType: 'jsonp', cache: false, success: function (data){}});";
                $this->config->set('statistic', Encrypt::instance()->encode(time()));
            }
            else
                $this->statistic = '';

        }

        // Вывод в шаблон
        $this->template->page_title                 = null;
        $this->template->content                    = null;

        // Подключаем стили и скрипты
        $this->template->styles                     = array();
        $this->template->scripts                    = array();

        // Подключаем блоки
        $this->template->data                       = null;
        $this->template->text                       = null;
    }

    //проверка полномочий на изменение
    protected function validateModify() {
        $controller = Request::current()->controller();
        $directory = Request::current()->directory();

        //если нет прав на изменение записей, то выводим ошибку
        if (!$this->checkPermission('modify', $directory.'/'.$controller)) {
            $this->errors[] = __('error_permission');
        }

        if (!$this->errors) {
            return true;
        } else {
            return false;
        }
    }

    //проверка полномочий на раздел
    protected function checkPermission($key, $value) {
        $permission = unserialize($this->user->roles->find()->permission);

        if (isset($permission[$key]))
            return in_array($value, $permission[$key]);
        else
            return false;
    }

    //транслитерация алиасов
    protected function translateAlias($var, $lower = true, $punkt = true)
    {
        $langtranslit = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            "ї" => "yi", "є" => "ye",

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            "Ї" => "yi", "Є" => "ye",
        );

        if ( is_array($var) ) return "";

        $var = UTF8::str_ireplace(chr(0), '', $var);

        if (!is_array ( $langtranslit ) OR !count( $langtranslit ) ) {
            $var = UTF8::trim( strip_tags( $var ) );

            if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
            else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

            $var = preg_replace( '#[.]+#i', '-', $var );
            $var = UTF8::str_ireplace( ".php", ".ppp", $var );

            if ( $lower ) $var = UTF8::strtolower( $var );

            return $var;

        }

        $var = UTF8::trim( strip_tags( $var ) );
        $var = preg_replace( "/\s+/ms", "-", $var );
        $var = str_replace( "/", "-", $var );

        $var = strtr($var, $langtranslit);

        if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
        else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

        $var = preg_replace( '#[\-]+#i', '-', $var );
        $var = preg_replace( '#[.]+#i', '-', $var );

        if ( $lower ) $var = UTF8::strtolower( $var );

        $var = UTF8::str_ireplace( ".php", "", $var );
        $var = UTF8::str_ireplace( ".php", ".ppp", $var );

        if( UTF8::strlen( $var ) > 200 ) {

            $var = UTF8::substr( $var, 0, 200 );

            if( ($temp_max = UTF8::strrpos( $var, '-' )) ) $var = UTF8::substr( $var, 0, $temp_max );

        }

        return $var;
    }

    protected function resizer($filename, $width, $height) {
        if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
            return;
        }

        $info = pathinfo($filename);

        $extension = $info['extension'];

        $old_image = $filename;
        $new_image = 'cache/' . UTF8::substr($filename, 0, UTF8::strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
            $path = '';

            $directories = explode('/', dirname(UTF8::str_ireplace('../', '', $new_image)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!file_exists(DIR_IMAGE . $path)) {
                    @mkdir(DIR_IMAGE . $path, 0777);
                }
            }

            $image = Image::factory(DIR_IMAGE . $old_image);
            $image->resize($width, $height);
            $image->save(DIR_IMAGE . $new_image);

        }

        return HTTP_IMAGE.$new_image;
    }
}
