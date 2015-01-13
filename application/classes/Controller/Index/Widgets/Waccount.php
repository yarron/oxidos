<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Waccount extends Controller_Index {
   
    public $template;
    
    public function action_index() {

        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/widgets/waccount');
        
        $text = array(
            'heading_title'           => __('heading_title'),
            'text_register'           => __('text_register'),
            'text_login'              => __('text_login'),
            'text_logout'             => __('text_logout'),
            'text_forgotten'          => __('text_forgotten'),
            'text_account'            => __('text_account'),
            'text_edit'               => __('text_edit'),
            'text_password'           => __('text_password'),
            'text_download'           => __('text_download'),
            'text_newsletter'         => __('text_newsletter'),
        );

        $links = array(
            'register'           => 'account/register',
            'login'             => 'account/login',
            'logout'             => 'account/logout',
            'forgotten'          => 'admin/forgotten',
            'account'            => 'account/account',
            'edit'               => 'account/edit',
            'password'           => 'account/password',
            'download'           => 'account/download',
            'newsletter'         => 'account/newsletter',
        );
        if($this->auth->logged_in()) 
            $logged = 1;
        else 
            $logged = 0;

        $this->template = View::factory($this->template_index.'widgets/w_account')
            ->bind('links',          $links)
            ->bind('text',          $text)
            ->bind('logged',        $logged);

    }
}
