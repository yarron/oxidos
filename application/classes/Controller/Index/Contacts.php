<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Страница контактов
 */
class Controller_Index_Contacts extends Controller_Index {
    private $page_url;
    public function  before() {
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home')). " &raquo; ";
     
    }
    
    // Контакты
    public function action_index() {
        $message = $this->session->get("feedback");
        $this->session->set('feedback', null);
        $errors = array();
        $data = array();
        
        $captcha = Captcha::instance();
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/contacts');
        
        if (isset($_POST['send'])) 
        {
            //извлекаем данные из массива POST
            $data = Arr::extract($_POST, array('name','email','enquiry','captcha'));
            if(!Captcha::valid($data['captcha']))
                $errors['captcha'] = __('error_captcha');
            else{
                $post = Validation::factory($data);
            
                $post->rule('name',  'not_empty')->rule('name', 'min_length', array(':value', '3'))->label('name' ,__('label_name'))    
                    ->rule('email', 'not_empty')->rule('email', 'email')->label('email' ,__('label_email'))
                    ->rule('enquiry',  'not_empty')->rule('enquiry', 'min_length', array(':value', '10'))->label('enquiry' ,__('label_enquiry'));   
                
                if ($post->check())
                {
                    
                    //формируем текст для отправки письма 
                    $theme = sprintf(__('email_theme'), $data['name']);
                    $text =  $data['enquiry'];
                    
                    //отправляем письмо 
                    $email = Email::factory($theme, $text)
                        ->message($text, 'text/html')
                        ->to($this->config->get('company_email'), $this->config->get('company_name'))
                        ->from($data['email'], $data['name'])
                        ->send();
                    $this->session->set('feedback', __('message_post'));
                    HTTP::redirect('contacts.html');
                }
                else{
                    $errors = $post->errors('index/'.$this->language_folder.'/contacts');
                    
                }
            }    
            
        }

        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri());
    
        $header                     = Kohana_Widget::load('header', $route); 
        $slider                     = Kohana_Widget::load('slider', $route);
        $content_top                = Kohana_Widget::load('contenttop', $route);
        $content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $column_right               = Kohana_Widget::load('columnright', $route);
        $footer                     = Kohana_Widget::load('footer');
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/contacts');
        
        $this->page_url .= HTML::anchor('contacts.html', __('heading_title'));
        
        $text = array(
            'title'             => __('heading_title'),
            'description'       => $this->config->get('company_description'),
            'address'           => $this->config->get('company_address'),
            'phone'             => $this->config->get('company_phone'),
            'fax'               => $this->config->get('company_fax'),
            'company'           => $this->config->get('company_name'),
            'code'              => $this->config->get('company_code'),
            
            'entry_address'     => __('entry_address'),
            'entry_company'     => __('entry_company'),
            'entry_feedback'    => __('entry_feedback'),
            'entry_code'        => __('entry_code'),
            
            'text_address'      => __('text_address'),
            'text_phone'        => __('text_phone'),
            'text_fax'          => __('text_fax'),
            
            'label_name'        => __('label_name'),
            'label_email'       => __('label_email'),
            'label_enquiry'     => __('label_enquiry'),
            'label_captcha'     => __('label_captcha'),
            'button_post'       => __('button_post'),
        );
        
        $content = View::factory($this->template_index.'contacts/v_contacts')
            ->bind('template',      $this->template_index)
            ->bind('page_url',      $this->page_url)
            ->bind('captcha',       $captcha)
            ->bind('errors',        $errors)
            ->bind('message',       $message)
            ->bind('text',          $text)
            ->bind('data',          $data)
            ->bind('header',        $header)
            ->bind('slider',        $slider)  
            ->bind('content_top',   $content_top)    
            ->bind('content_bottom',$content_bottom)
            ->bind('column_left',   $column_left)
            ->bind('column_right',  $column_right)
            ->bind('footer',        $footer);

        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_title');
        $this->template->description                = __('heading_title');
        $this->template->keywords                   = __('heading_title');      

    }
    
    
}
