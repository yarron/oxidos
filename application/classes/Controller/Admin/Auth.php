<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Авторизация
 */

class Controller_Admin_Auth extends Controller_Admin {

    public function action_index() {
        $this->action_login();
    }
    
    public function action_login() {

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/login');
        $enters = 0;

        $this->message = $this->session->get("message");
        $this->session->set('message', null);

        
        //если уже залогинены то переадресуемся на главную
        if($this->auth->logged_in()) {
                HTTP::redirect('admin');
        }
        
        $text = array(
            'heading_title'     => __('heading_title'),
            'text_username'     => __('text_username'),
            'text_password'     => __('text_password'),
            'text_captcha'      => __('text_captcha'),
            'text_remember'     => __('text_remember'),
            'text_forgotten'    => __('text_forgotten'),
            'text_enter'        => __('text_enter'),
            'text_loading'      => __('text_loading'),
        );
        //если отправляем данные
        if (isset($_POST['action'])){

            //инициализируем капчу
            $this->captcha = Captcha::instance();
            
            //извлекаем данные с массива
            $data = Arr::extract($_POST, array('username', 'password', 'remember', 'captcha', 'enters'));
            
            //если это не первый вход и капча не валидна, то ошибка, иначе проверяем далее
            if($data['enters']!=1 && !Captcha::valid($data['captcha']))
                $this->errors = __('error_captcha');
            else{
                
                //проверяем статус залогинивания
                $status = $this->auth->login($data['username'], $data['password'], (bool) $data['remember']);

                if($status){
                    $check = ORM::factory('user')->where('username', '=',$data['username'])->find();
                    //если авторизация успешна
                    if ($check->status){
                        //получаем переменную из сессии
                        $reffer = $this->session->get('reffer');

                        //если существует reffer, то переадресуемся на него
                        if($reffer && $this->auth->logged_in())
                            HTTP::redirect($reffer);

                        //иначе просто на главную
                        if($this->auth->logged_in())
                            HTTP::redirect('admin');
                    }
                    else {
                        $this->auth->logout();
                        $this->errors = __('error_status');
                    }
                }
                else $this->errors = __('error_no_user');
            }
            
            $enters = $data['enters'];
        }

        if(BROWSER == 'UPDATE' || BROWSER == 'ie') $this->errors = __('error_browser');
        $content = View::factory($this->template_admin.'auth/v_auth')
                    ->bind('template',$this->template_admin)
                    ->bind('captcha', $this->captcha)
                    ->bind('errors', $this->errors)
                    ->bind('data', $data)
                    ->bind('text', $text)
                    ->bind('enters', $enters)
                    ->bind('message', $this->message);

        // Выводим в шаблон
        $this->template->title = __('heading_title');
        $this->template->page_title = __('heading_page_title');
        $this->template->block_center = array($content);
    }
    
    public function action_logout() {
        if($this->auth->logout()) {
            HTTP::redirect('admin/login');
        }
    }

 }
