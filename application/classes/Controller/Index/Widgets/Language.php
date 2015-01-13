<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Language extends Controller_Index {
    public $template;
    public function action_index() {
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/index');

        if ($this->request->post('language_code')) {
            
            $this->session->set('language', $this->request->post('language_code'));
            $this->cache->delete_all();
            if ($this->request->post('redirect')) {
                HTTP::redirect($this->request->post('redirect'));
            } else {
                HTTP::redirect('/');
            }
    	}	
        $params = Kohana_Widget::$params;

        $this->template = View::factory($this->template_index.'widgets/language')
            ->bind('redirect',          $params['uri'])
            ->bind('languages',         $this->languages);
    }
}
