<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Меню сайта"
 */
class Controller_Index_Widgets_Menu extends Controller_Index {

    public $template;
    
    public function action_index()
    {
        $rss = $this->cache->get('rss'); //извлекаем rss из кэша
        $menu = $this->cache->get('menu'); //извлекаем меню из кэша
       
        //если кэша нет, то
        if($menu == NULL)
        {
            $menu = array();
            //извлекаем страницы
            $menu_arr = DB::select('menu.url','menu.sort_order','menudescriptions.title','menu.page_id','pages.alias')
                ->from('menu')   
                ->where('menudescriptions.language_id', '=', $this->language_id)
                ->and_where('menu.status', '=', 1)
                ->join('menudescriptions')->on('menu.id', '=', 'menudescriptions.menu_id')
                ->join('pages','left')->on('menu.page_id', '=', 'pages.id')
                ->order_by('menu.sort_order', 'asc')
                ->order_by('menudescriptions.title', 'asc')
                ->execute()->as_array();

            foreach($menu_arr as $item){
                if($item['page_id']){
                    $menu[] = array(
                        'url'   => $item['alias'].'.html',
                        'title' => $item['title'],
                    );
                }
                else{
                    $menu[] = array(
                        'url'   => $item['url'],
                        'title' => $item['title'],
                    );
                }
            }

            $this->cache->set('menu', $menu); //сохраняем данные в кэш
        }
        if($rss == NULL){
            $frss = DB::select('value')->from('extensions')->where("key" ,"=", "frss")->execute()->as_array();
            if(isset($frss[0])) $rss = 1;
            else $rss = 0;
            
            $this->cache->set('rss', $rss); //сохраняем данные в кэш
        }

        $this->template = View::factory($this->template_index.'widgets/menu')
            ->bind('menu',          $menu)
            ->bind('rss',           $rss);

    }

}