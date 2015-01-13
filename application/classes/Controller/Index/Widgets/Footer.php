<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Footer extends Controller_Index {
    public $template;
    public function action_index() {
        i18n::lang('index/'.$this->language_folder.'/index');
        $text['copyright'] = __('text_copyright');

        $this->template = View::factory($this->template_index.'widgets/footer')
            ->bind('text',          $text);
    }
}
