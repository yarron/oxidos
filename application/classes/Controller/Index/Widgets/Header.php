<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Header extends Controller_Index {
    public $template;
    public function action_index() {
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/index');

        $data = array(
            'logo'              => HTTP_IMAGE.$this->config->get('logo'),
            'home'              => "",
            'name'              => $this->config->get('site_name'),
            'logged'            => $this->auth->logged_in(),
        );

        $text = array(
            'text_search'       => __('text_search'),
            'button_login'      => __('button_login'),
            'button_register'   => __('button_register'),
            'button_logout'     => __('button_logout'),
            'button_account'    => __('button_account'),
            'heading_title'     => $this->config->get('site_name'),
        );

        if($this->auth->logged_in()){
            $text['text_logged']    =sprintf(__('text_logged'),  $this->user->username);
            $text['text_ip']        =sprintf(__('text_ip'),  $this->user->ip);
            $text['text_date']      =sprintf(__('text_date'),  $this->user->last_login);
        }

        $params = Kohana_Widget::$params;

        if (isset($params['filter_name'])) {
            $data['filter_name'] = $params['filter_name'];
        } else {
            $data['filter_name'] ='';
        }

        $category = Kohana_Widget::load('category', $params);
        $language = Kohana_Widget::load('language', $params);
        $menu = Kohana_Widget::load('menu', $params);

        $this->template = View::factory($this->template_index.'widgets/header')
            ->bind('data',          $data)
            ->bind('text',          $text)
            ->bind('template',      $this->template_index)
            ->bind('category',      $category)
            ->bind('language',      $language)
            ->bind('menu',          $menu);
    }
}
