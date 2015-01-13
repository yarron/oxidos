<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Личный кабинет
 */
class Controller_Index_Account extends Controller_Index {
    private $header;
    private $slider;
    private $content_top;  
    private $content_bottom;
    private $column_left;
    private $column_right;
    private $footer;
    private $message;
    private $page_url;
    
    public function before() {
        
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        
        if(!$this->auth->logged_in() && Request::current()->action()!= 'login' && Request::current()->action()!= 'register' && Request::current()->action()!= 'forgotten' && Request::current()->action()!= 'reset') {
            HTTP::redirect('account/login');
        }
        
        
        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri());    //инициализация контроллера

        //инициализация шаблонов
        $this->header                     = Kohana_Widget::load('header', $route); 
        $this->slider                     = Kohana_Widget::load('slider', $route);
        $this->content_top                = Kohana_Widget::load('contenttop', $route);
        $this->content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $this->column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $this->column_right               = Kohana_Widget::load('columnright', $route);
        $this->footer                     = Kohana_Widget::load('footer');
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home')). " &raquo; ";
        
        i18n::lang('index/'.$this->language_folder.'/account');
    }
    
    public function action_index() {
        HTTP::redirect('account/login');
    }
    
    //авторизация
    public function action_login() {
        $message = $this->session->get("message");
        $this->session->delete('message');
        
        $enters = 0;
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/login', __('auth_title'));
        
        //инициализируем капчу
        $captcha = Captcha::instance();
        
        if(isset($_POST['submit'])){

            //извлекаем данные с массива
            $data = Arr::extract($_POST, array('username', 'password', 'remember', 'captcha', 'enters'));
            $enters = $data['enters'];
            
            //если это не первый вход и капча не валидна, то ошибка, иначе проверяем далее
            if($data['enters']!=1 && !Captcha::valid($data['captcha'])){
                $errors['captcha'] = __('error_captcha');
            }
            else{
                //проверяем статус залогинивания
                $status = $this->auth->login($data['username'], $data['password'], (bool) $data['remember']);

                if($status){
                    $check = ORM::factory('user')->where('username', '=',$data['username'])->find();
                    //если авторизация успешна
                    if ($check->status){
                        //иначе просто на главную
                        if($this->auth->logged_in())
                        {
                            HTTP::redirect('account/account'); 
                        }
                    }
                    else {
                        $this->auth->logout();
                        $errors['status'] =__('error_status');
                    }
                }
                else{
                    $errors['no_user'] = __('error_no_user');
                }
                
            }
            
        }
        
        //если уже залогинены то переадресуемся на главную
        if($this->auth->logged_in()) {
            HTTP::redirect('account/account');
        }
        
        $text = array(
            'auth_title'        => __('auth_title'),
            'auth_new_heading'  => __('auth_new_heading'),
            'auth_reg_heading'  => __('auth_reg_heading'),
            
            'reg_title'         => __('reg_title'),
            'text_reg_account'  => __('text_reg_account'),
            'button_register'   => __('button_register'),
            'text_username'     => __('text_username'),
            'text_password'     => __('text_password'),
            'text_remember'     => __('text_remember'),
            'text_captcha'      => __('text_captcha'),
            'text_forgotten'    => __('text_forgotten'),
            'text_enter'        => __('text_enter'),
            'error_username'    => __('error_username'),
            'error_password'    => __('error_password'),
            
        );
        $uri = "http://".$_SERVER['HTTP_HOST']."/".$this->request->uri();
        $content = View::factory($this->template_index.'account/v_account_login')
            ->bind('template',      $this->template_index)
            ->bind('page_url',      $this->page_url)
            ->bind('uri',           $uri)
            ->bind('enters',        $enters)
            ->bind('data',          $data)
            ->bind('text',          $text)
            ->bind('errors',        $errors)
            ->bind('message',       $message)
            ->bind('captcha',       $captcha)
            ->bind('header',        $this->header)
            ->bind('slider',        $this->slider)    
            ->bind('content_top',   $this->content_top)    
            ->bind('content_bottom',$this->content_bottom)
            ->bind('column_left',   $this->column_left)
            ->bind('column_right',  $this->column_right)
            ->bind('footer',        $this->footer);

       
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('auth_title');
        $this->template->description                = __('auth_title');
        $this->template->keywords                   = __('auth_title');
    }
    
    //выход из аккаунта
    public function action_logout() {
        if($this->auth->logout()) {
            HTTP::redirect();
        }
    }
    
    //регистрация аккаунта
    public function action_register() {
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/register', __('reg_title'));
        
        if($this->auth->logged_in()) {
            HTTP::redirect('account/account');
        }
        $errors = array();
        $captcha = Captcha::instance();
        if($this->config->get('newsletter') !=0){
            $page = DB::select()
                ->from('pages')   
                ->join('pagesdescriptions')
                ->on('pages.id', '=', 'pagesdescriptions.page_id')
                ->where('pages.id', '=', $this->config->get('newsletter'))
                ->and_where('pagesdescriptions.language_id', '=', $this->language_id)
                ->and_where('pages.status', '=', 1)
                ->limit(1)->execute()->as_array();
        }
        
        if($this->request->post()){
            //Извлечение данных
            $data = Arr::extract($_POST, array('name','username', 'email', 'phone', 'password', 'password_confirm','captcha','newsletter'));
            $data['status'] = 1;
            
            //загрузка модели
            $user = ORM::factory('Index_Userpassword');
            $user->values($data);

            //проверка на валидацию
            try {
                $user->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('index/'.$this->language_folder);
            }
            
            if(!$data['newsletter'] && $this->config->get('newsletter')!=0)
                $errors['newsletter'] = sprintf(__('error_newsletter'), $page[0]['title']);
            
            if(!Captcha::valid($data['captcha']))
                $errors['captcha'] = __('error_captcha');
            
            //если все ок, то сохраняем
            if(empty($errors)){ 
                $user = ORM::factory('Index_User');
                $user->create_user($data, array(
                    'username',
                    'name',
                    'password',
                    'email',
                    'phone',
                    'newsletter',
                    'status'
                ));
                $user->add('roles', $this->config->get('user_role')); //добавляем роль пользователя
                
                $this->sendEmail($data);    //отправляем письмо о регистрации
                
                Auth::instance()->login($data['username'], $data['password'], 0);   //авторизуемся
                
                //загрузка языкового файла
                i18n::lang('index/'.$this->language_folder.'/account');
                $this->session->set('message', __('message_register'));
                HTTP::redirect('account/account'); 
            }  
            
        }

        $text = array(
            'text_your_details'             => __('text_your_details'),
            'text_your_password'            => __('text_your_password'),
            'text_code'                     => __('text_code'),
            'text_name'                     => __('text_name'),
            'text_username'                 => __('text_username'),
            'text_email'                    => __('text_email'),
            'text_phone'                    => __('text_phone'),
            'text_password'                 => __('text_password'),
            'text_confirm'                  => __('text_confirm'),
            'text_captcha'                  => __('text_captcha'),
            'text_captcha_enter'            => __('text_captcha_enter'),
            'button_save'                   => __('button_save'),
            'button_check'                  => __('button_check'),
            'reg_title'                     => __('reg_title'),
        );
        
        if($this->config->get('newsletter')!=0)
            $text['text_newsletter'] = sprintf(__('text_newsletter'), HTML::anchor('info/'.$page[0]['alias'].'.html', '<b>'.$page[0]['title'].'</b>', array('class' => 'colorbox', 'alt' => $page[0]['title']))); 
        
        $uri = "http://".$_SERVER['HTTP_HOST']."/".$this->request->controller()."/check";
        $content = View::factory($this->template_index.'account/v_account_register')
            ->bind('template',      $this->template_index)
            ->bind('page_url',      $this->page_url)
            ->bind('uri',           $uri   )
            ->bind('data',          $data)
            ->bind('text',          $text)
            ->bind('errors',        $errors)
            ->bind('captcha',       $captcha)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)
            ->bind('category',              $this->category)    
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);

       
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('reg_title');
        $this->template->description                = __('reg_title');
        $this->template->keywords                   = __('reg_title');
        
        
    }

    //отправка писем о регистрации
    private function sendEmail($data){
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/email');

        //формируем текст для отправки письма пользователю
        $theme = sprintf(__('reg_subject'), $this->config->get('company_name'));
        $text =  sprintf(__('reg_welcome'), $this->config->get('company_name'));
        $text .= sprintf(__('reg_login'),   $data['username'], $data['password']);
        $text .= __('reg_services');
        $text .= sprintf(__('reg_thanks'), $this->config->get('company_name'));

        //отправляем письмо пользователю
        $user = Email::factory($theme, $text)
            ->message($text, 'text/html')
            ->to($data['email'], $data['name'])
            ->from($this->config->get('company_email'), $this->config->get('company_name'))
            ->send(); 

        if($this->config->get('mail_registration')){
            //формируем текст для отправки письма админу
            $admtheme = sprintf(__('adm_reg_subject'), $this->config->get('company_name'));
            $message =  sprintf(__('adm_reg_head'), $this->config->get('company_name'));
            $message .= sprintf(__('adm_reg_data'),   $data['name'], $data['username'], $data['email'], $data['phone']);
            
            //отправляем письмо пользователю
            $adm = Email::factory($admtheme, $message)
                ->message($message, 'text/html')
                ->to($this->config->get('company_email'), $this->config->get('company_name'))
                ->from($this->config->get('company_email'), $this->config->get('company_name'))
                ->send();
            
            // Отправление писем на дополнительные почтовые ящики
            $emails = explode(',', $this->config->get('optional_address'));

            foreach ($emails as $email) {
                if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
                    //отправляем письмо пользователю
                    $opt = Email::factory($admtheme, $message)
                        ->message($message, 'text/html')
                        ->to($email)
                        ->from($this->config->get('company_email'), $this->config->get('company_name'))
                        ->send();
                }
            }
        } 
    }

    //вход в аккаунт
    public function action_account(){
        $this->page_url .= HTML::anchor('account', __('account_title'));
            $this->message = $this->session->get("message");
            $this->session->set('message', 0);
            
            $text = array(
                'account_title'                 => __('account_title'),
                'text_my_account'               => __('text_my_account'),
                'text_edit_title'               => __('text_edit_title'),
                'text_edit_description'         => __('text_edit_description'),
                'text_password_title'           => __('text_password_title'),
                'text_password_description'     => __('text_password_description'),
                
                'text_my_settings'              => __('text_my_settings'),
                'text_newsletter_title'         => __('text_newsletter_title'),
                'text_newsletter_description'   => __('text_newsletter_description'),
            );

            //формируем весь контент
            $content = View::factory($this->template_index.'account/v_account_account')
                ->bind('template',      $this->template_index)
                ->bind('page_url',      $this->page_url)
                ->bind('message',               $this->message)    
                ->bind('text',                  $text)
                ->bind('header',                $this->header)
                ->bind('slider',                $this->slider)
                ->bind('category',              $this->category)    
                ->bind('content_top',           $this->content_top)    
                ->bind('content_bottom',        $this->content_bottom)
                ->bind('column_left',           $this->column_left)
                ->bind('column_right',          $this->column_right)
                ->bind('footer',                $this->footer);

            //инициализация переменных шаблона
            $this->template->title                      = __('account_title');
            $this->template->description                = __('account_title');
            $this->template->keywords                   = __('account_title');
            $this->template->content = $content;
        
        
    }
    
    //редактирование данных акканта
    public function action_edit(){
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/edit', __('edit_title'));
        $errors = array();
        $text = array(
            'edit_title'                => __('edit_title'),
            'text_edit_account'         => __('text_edit_account'),
            'text_edit_username'        => __('text_edit_username'),
            'text_edit_name'            => __('text_edit_name'),
            'text_edit_email'           => __('text_edit_email'),
            'text_edit_phone'           => __('text_edit_phone'),
            
            'text_edit_skype'           => __('text_edit_skype'),
            'text_edit_icq'             => __('text_edit_icq'),
            'text_edit_info'            => __('text_edit_info'),
            'text_edit_ava'             => __('text_edit_ava'),
            'text_edit_noava'           => __('text_edit_noava'),
            
            'button_save'               => __('button_save'),
            'button_abort'              => __('button_abort'),
        );
        
        $data = array(
            'username'  => $this->user->username,
            'name'      => $this->user->name,
            'email'     => $this->user->email,
            'phone'     => $this->user->phone,
            'id'        => $this->user->id,
            'skype'     => $this->user->skype,
            'icq'       => $this->user->icq,
            'info'      => $this->user->info,
            'ava'       => $this->user->ava,
        );
        
        //если нажата кнопка сохранить
        if (isset($_POST['save'])){
            //Извлечение данных
            $data = Arr::extract($_POST, array('id','username', 'name', 'email', 'phone','skype', 'icq', 'info', 'noava'));
            $data['ava'] = $this->user->ava;
            //загрузка модели
            $user = ORM::factory('Index_Useredit', $data['id']);

            $user->values($data);
            //а есть ли загружаемая аватарка
            if (!empty($_FILES['ava']['name']))
            {
                //проверяем загружаемый файл
                $file = Validation::factory($_FILES);
                $file->rule('ava', 'Upload::type', array(':value', array('jpg', 'png', 'gif')))
                     ->rule('ava', 'Upload::size', array(':value', '5M'));

                //если проверка пройдена, то сохраняем файл на сервере и в базе
                if($file->check()) {

                    $ava = Image::factory($_FILES['ava']['tmp_name']);

                    if($ava->width > 110)
                    {
                        $ava->resize(110, 110, Image::NONE);
                    }

                    $ava->save(DIR_IMAGE.'data/ava/'.$data['username'].'.jpg');
                    $user->ava = 'data/ava/'.$data['username'].'.jpg';

                }
                else
                {
                    $errors = Arr::merge($errors, $file -> errors('index/'.$this->language_folder.'/index_useredit'));
                }
            }   
            

            //проверка на валидацию данных
            try {
                $user->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = Arr::merge($errors, $e->errors('index/'.$this->language_folder));
            }

            //если все ок, то сохраняем
            if(empty($errors)){ 
                //если надо удалить аватар, то удаляем
                if($data['noava']) {
                    $user->ava = "";
                    @unlink(DIR_IMAGE.'data/ava/'.$data['username'].'.jpg'); //удаляем файл с сервера
                }
                $user->save();
                $this->session->set('message', __('message_edit'));
                HTTP::redirect('account/account'); 
            }
            
        }
        
        //формируем весь контент
        $content = View::factory($this->template_index.'account/v_account_edit')
            ->bind('page_url',              $this->page_url)
            ->bind('errors',                $errors)
            ->bind('text',                  $text)
            ->bind('data',                  $data)    
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)
            ->bind('category',              $this->category)    
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);

        //инициализация переменных шаблона
        $this->template->title                      = __('edit_title');
        $this->template->description                = __('edit_title');
        $this->template->keywords                   = __('edit_title');
        $this->template->content = $content;
    }
    
    //смена пароля в аккаунте
    public function action_password(){
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/password', __('password_title'));
        
        $errors = array();
        $data = null;
        
        $text = array(
            'password_title'            => __('password_title'),
            'text_password_title'       => __('text_password_title'),
            'text_password_old'         => __('text_password_old'),
            'text_password_password'    => __('text_password_password'),
            'text_password_confirm'     => __('text_password_confirm'),
            'button_save'               => __('button_save'),
            'button_abort'              => __('button_abort'),
        );
        
        //если нажата кнопка сохранить
        if (isset($_POST['save'])){
            //Извлечение данных
            $data = Arr::extract($_POST, array('password', 'password_old', 'password_confirm', 'action'));
            $old_enter = $this->auth->hash_password($data['password_old']);
            $old_base = $this->user->password;
            
            if($old_enter == $old_base ){
                
                //загрузка модели
                $user = ORM::factory('Index_Useredit', $this->user->id);
                $user->values($data);

                //проверка на валидацию
                try {
                    $user->check();
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('index/'.$this->language_folder);
                }
                
                //если все ок, то сохраняем
                if(empty($errors)){ 
                    $user->save();
                    $this->session->set('message', __('message_password'));
                    HTTP::redirect('account/account'); 
                }
            }
            else $errors['password_old'] = __('error_password_old');
            
        }
        
        //формируем весь контент
        $content = View::factory($this->template_index.'account/v_account_password')
            ->bind('page_url',      $this->page_url)
            ->bind('errors',                $errors)
            ->bind('text',                  $text)
            ->bind('data',                  $data)    
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)
            ->bind('category',              $this->category)    
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);

        //инициализация переменных шаблона
        $this->template->title                      = __('password_title');
        $this->template->description                = __('password_title');
        $this->template->keywords                   = __('password_title');
        $this->template->content = $content;
    }
    
    //редактирование подписки на новости
    public function action_newsletter(){
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/newsletter', __('newsletter_title'));
        
        $errors = array();
        $data = null;
        
        $text = array(
            'newsletter_title'              => __('newsletter_title'),
            'text_newsletter_newsletter'    => __('text_newsletter_newsletter'),
            'text_newsletter_yes'           => __('text_newsletter_yes'),
            'text_newsletter_no'            => __('text_newsletter_no'),
            'button_save'                   => __('button_save'),
            'button_abort'                  => __('button_abort'),
        );
        
        $data = array(
            'newsletter' => $this->user->newsletter,
        );
        
        //если нажата кнопка сохранить
        if (isset($_POST['save'])){
           
            //Извлечение данных
            $data = Arr::extract($_POST, array('newsletter', 'action'));
            
            //загрузка модели
            DB::update('users')->set(array('newsletter' => (int)$data['newsletter']))->where('id', '=', $this->user->id)->execute();
            
            $this->session->set('message', __('message_newsletter'));
            HTTP::redirect('account/account'); 
        }
        
        //формируем весь контент
        $content = View::factory($this->template_index.'account/v_account_newsletter')
            ->bind('page_url',      $this->page_url)
            ->bind('errors',                $errors)
            ->bind('text',                  $text)
            ->bind('data',                  $data)    
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)
            ->bind('category',              $this->category)    
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);

        //инициализация переменных шаблона
        $this->template->title                      = __('newsletter_title');
        $this->template->description                = __('newsletter_title');
        $this->template->keywords                   = __('newsletter_title');
        $this->template->content = $content;
    }
    
    
    
    
    
    //забыли пароль
    public function action_forgotten(){
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/forgotten', __('forgotten_title'));
        
        if($this->auth->logged_in()) {
                HTTP::redirect('account/account');
        }
        
        //если отправляем данные
        if (isset($_POST['email'])){
            
            //извлекаем email для восстановления пароля
            $email = Arr::get($_POST, 'email');
            
            //ищем в базе этого пользователя
            $usertemp = ORM::factory('Index_Useredit', array('email' => $email));
            
            //если не нашли, выводим ошибку
            if(!$usertemp->loaded())
            {
                $errors[] = __('error_email');    
            }
            else{
                $random = sha1(rand(1000000, 9999999)); //формируем рандомное число и кодируем его
                $usertemp->code = $random;
                $usertemp->save();  //сохраняем в базу код восстановления

                //загрузка языкового файла
                i18n::lang('index/'.$this->language_folder.'/account');
                
                $link =  "http://".$_SERVER['HTTP_HOST']."/account/reset/".$random; //формируем ссылку для восстановления
                
                //формируем текст для отправки письма
                $theme = $this->config->get('company_name')." - ".__('email_theme');
                
                $text = "<strong>".__('email_text').$this->config->get('company_name') .".</strong><br />";
                $text .= __('email_link');
                $text .= "<a href='$link'>$link</a><br />";
                $text .= __('email_ip');
                
                //отправляем письмо пользователю
                $send = Email::factory($theme, $text)
                    ->message($text, 'text/html')
                    ->to($email, $usertemp->name)
                    ->from($this->config->get('company_email'), $this->config->get('company_name'))
                    ->send(); 

                $this->session->set('message', __('message_success'));                           
                HTTP::redirect('account/login');
            }

        }
        
        $text = array(
            'text_forgotten'       => __('text_forgotten'),
            'text_description'     => __('text_description'),
            'text_email'           => __('text_email'),
            'button_reset'         => __('button_reset'),
            'button_abort'         => __('button_abort'),
        );
        
        
        $content = View::factory($this->template_index.'account/v_account_forgotten')
            ->bind('page_url',      $this->page_url)
            ->bind('text',          $text)
            ->bind('errors',        $errors)
            ->bind('header',        $this->header)
            ->bind('slider',        $this->slider)    
            ->bind('content_top',   $this->content_top)    
            ->bind('content_bottom',$this->content_bottom)
            ->bind('column_left',   $this->column_left)
            ->bind('column_right',  $this->column_right)
            ->bind('footer',        $this->footer);

       
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('forgotten_title');
        $this->template->description                = __('forgotten_title');
        $this->template->keywords                   = __('forgotten_title');
    }
    
    //сброс пароля
    public function action_reset() {
        $this->page_url .= HTML::anchor('account', __('account_title')). " &raquo; ".  HTML::anchor('account/reset', __('reset_title'));

        if($this->auth->logged_in()) {
                HTTP::redirect('account/account');
        }
        
        if (isset($_POST['action']) && $_POST['action'] == "reset"){
            
            //Извлечение данных
            $data = Arr::extract($_POST, array('password', 'action', 'password_confirm', 'key'));
            
            $user = ORM::factory('Index_Useredit', array("code" => $data['key']));
            $user->values($data);

            //проверка на валидацию
            try {
                $user->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('index/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($errors)){ 
                $user->code = null;
                $user->save();   //обновляем параметры 
                
                //загрузка языкового файла
                i18n::lang('index/'.$this->language_folder.'/account');
                
                $this->session->set('message', __('message_update'));
                HTTP::redirect('account/login'); 
            }  
        }
        else{
            //если отправляем данные
            $key = $this->request->param('id');
            
            $user = ORM::factory('Index_Useredit', array("code" => $key));
            
            if(!$user->loaded())
            {
                HTTP::redirect('account/login');  
            }
        }
        
        //если post пустой, и существует id
        if(empty($data) && $key){ 
           $data = array(
               "key" => $key,
               "password" => "",
               "password_confirm" => "",
           ); 
        }
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/account');
        
        $text = array(
            'reset_title'               => __('reset_title'),
            'text_reset_description'    => __('text_reset_description'),
            'text_reset_password'       => __('text_reset_password'),
            'text_reset_confirm'        => __('text_reset_confirm'),
            'button_save'               => __('button_save'),
            'button_abort'              => __('button_abort'),
        );

        $content = View::factory($this->template_index.'account/v_account_reset')
                    ->bind('errors',        $errors)
                    ->bind('data',          $data)
                    ->bind('text',          $text)
                    ->bind('header',        $this->header)
                    ->bind('slider',        $this->slider)    
                    ->bind('content_top',   $this->content_top)    
                    ->bind('content_bottom',$this->content_bottom)
                    ->bind('column_left',   $this->column_left)
                    ->bind('column_right',  $this->column_right)
                    ->bind('footer',        $this->footer);
 
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('reset_title');
        $this->template->description                = __('reset_title');
        $this->template->keywords                   = __('reset_title');
    }
       
    
}