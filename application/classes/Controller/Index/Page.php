<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Страницы
 */
class Controller_Index_Page extends Controller_Index {
    private $page_url;
    public function  before() {
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home')). " &raquo; ";
    }  

    public function action_index() {
        $page_alias = $this->request->param('alias');
        
        $page = DB::select()
                ->from('pages')   
                ->join('pagesdescriptions')
                ->on('pages.id', '=', 'pagesdescriptions.page_id')
                ->where('pages.alias', '=', $page_alias)
                ->and_where('pagesdescriptions.language_id', '=', $this->language_id)
                ->and_where('pages.status', '=', 1)
                ->limit(1)->execute()->as_array();
        
        
        
        if(empty($page)) 
           throw new HTTP_Exception_404();
        else
            $this->page_url .= HTML::anchor('page/'.$page_alias.".html", $page[0]['title']);
        
        //обновляем количество просмотров
        DB::update('pages')->set(array('viewed' => DB::expr('viewed + 1')))->where('alias', '=', $page_alias)->execute();
        
        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri());
        
        $header                     = Kohana_Widget::load('header', $route); 
        $slider                     = Kohana_Widget::load('slider', $route);
        $content_top                = Kohana_Widget::load('contenttop', $route);
        $content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $column_right               = Kohana_Widget::load('columnright', $route);
        $footer                     = Kohana_Widget::load('footer');
        
        $content = View::factory($this->template_index.'page/v_page')
            ->bind('page_url',      $this->page_url)
            ->bind('page',          $page[0])
            ->bind('header',        $header)
            ->bind('slider',        $slider)  
            ->bind('content_top',   $content_top)    
            ->bind('content_bottom',$content_bottom)
            ->bind('column_left',   $column_left)
            ->bind('column_right',  $column_right)
            ->bind('footer',        $footer);

        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = $page[0]['seo_title'];
        $this->template->description                = $page[0]['meta_description'];
        $this->template->keywords                   = $page[0]['meta_keywords'];

        if (!headers_sent()) {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $page[0]['date_modified']));
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
    }

    public function action_info(){
        $page_alias = $this->request->param('alias');
        
        $page = DB::select()
                ->from('pages')   
                ->join('pagesdescriptions')
                ->on('pages.id', '=', 'pagesdescriptions.page_id')
                ->where('pages.alias', '=', $page_alias)
                ->and_where('pagesdescriptions.language_id', '=', $this->language_id)
                ->and_where('pages.status', '=', 1)
                ->limit(1)->execute()->as_array();
        
        

        if ($page) {
                DB::update('pages')->set(array('viewed' => DB::expr('viewed + 1')))->where('alias', '=', $page_alias)->execute();
                
                $output  = '<html dir="ltr" lang="'.$this->language_folder.'">' . "\n";
                $output .= '<head>' . "\n";
                $output .= '  <title>' . $page[0]['title'] . '</title>' . "\n";
                $output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                $output .= '  <meta name="robots" content="noindex">' . "\n";
                $output .= '</head>' . "\n";
                $output .= '<body>' . "\n";
                $output .= '  <h1>' . $page[0]['title'] . '</h1>' . "\n";
                $output .= html_entity_decode($page[0]['description'], ENT_QUOTES, 'UTF-8') . "\n";
                $output .= '  </body>' . "\n";
                $output .= '</html>' . "\n";			
                die($output);    
               
        }
    }
    
}