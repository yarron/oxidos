<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Errors extends Controller_Admin {
    private $params = array();
    private $code;
    private $text;
    public function action_index() {

        $this->params = explode('/',$this->request->param('message'));

        if($this->request->param('message')){
            $this->text = $this->params[0];
            $this->code = $this->params[1];
        }
        else{
            $this->text = null;
            $this->code = 403;
        }
        $this->error();
    }

    private function error() {
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/errors');

        // Вывод в шаблон
        $this->template->page_title = __('heading_'.$this->code);
        $this->template->page_url[]= HTML::anchor('admin/errors', $this->template->page_title);

        $message = urldecode($this->text);
        $text = __('message_'.$this->code);

        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'errors/v_errors')
            ->bind('box_title',$this->template->page_title)
            ->bind('text', $text)
            ->bind('message', $message);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    

}
