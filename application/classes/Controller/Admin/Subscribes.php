<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Subscribes extends Controller_Admin {
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
        i18n::lang('admin/'.$this->language_folder.'/subscribes');

        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/subscribes', $this->template->page_title);
    }

    //показ всех статей
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);

        if($this->request->post() && $this->validateModify()){
            $post = Arr::extract($_POST, array('whom', 'subject', 'message', 'to_name', 'to_email'));
            
            if(UTF8::strlen($post['subject']) < 3)  $this->errors['subject'] = __('error_subject');
            if(UTF8::strlen($post['message']) < 10) $this->errors['message'] = __('error_message');
            if($this->errors) $this->action_index('admin/subscribes');
            else
            {
                $emails = array();
                switch ($post['whom']) {
                    case 'newsletter':
    					$results = ORM::factory('Admin_User')->where("newsletter","=", 1)->and_where("status","=", 1)->find_all();
    					foreach ($results as $result) 
    						$emails[] = $result->email;
                        break;

                    case 'user':
    					$results = ORM::factory('Admin_User')->where("status","=", 1)->find_all();   
    					foreach ($results as $result) 
    						$emails[] = $result->email;
                        break;    
                }
                
                if ($emails) {
                    foreach ($emails as $email) {
                        if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
                            //отправляем письмо пользователю
                            $opt = Email::factory($post['subject'], $post['message'])
                                ->message($post['message'], 'text/html')
                                ->to($email)
                                ->from($post['to_email'], $post['to_name'])
                                ->send();
                        }
                    }
                    $post = null;
                    $this->session->set('message', __('message_post'));
                    HTTP::redirect('admin/subscribes');
                }
            }
        }
        $text = Array(
            'entry_from'         => __('entry_from'),
            'entry_whom'         => __('entry_whom'),
            'entry_subject'      => __('entry_subject'),
            'entry_message'      => __('entry_message'),
            'button_save'   	    => __('button_post'),
            'button_abort'          => __('button_abort'),
        );

        //массив опций рассылки
        $whom = array(
            'newsletter'        =>   __('opt_newsletter'),
            'user'              =>   __('opt_user'),
        );
        
        $from = array(
            'name'  => $this->config->get('company_name'),
            'email' => $this->config->get('company_email'),
        );


        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'subscribes/v_subscribes_form')
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
	        ->bind('errors',  $this->errors)
            ->bind('post',  $post)
            ->bind('locale', $this->language_folder)
            ->bind('whom', $whom)
            ->bind('from', $from)
            ->bind('text', $text);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

}
