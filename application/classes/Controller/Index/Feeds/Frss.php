<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 
 */
class Controller_Index_Feeds_Frss extends Controller {
     public function action_index() {
        $access = DB::select('value')->from('extensions')->where("key" ,"=", "frss")->execute()->as_array();
        if(!isset($access[0])){
            HTTP::redirect(); //переадресация
        } 
        else{
            $config = kohana::$config->load('config');
            i18n::lang('index/'.$config->get('index_language_folder').'/feeds/frss');

            //Устанавливаем заголовок RSS канала
            $info = array(
                'title' => $config->get('site_name'),
                'language' => $config->get('index_language_folder'),
                'description' => sprintf(__('rss_description'),$config->get('site_name') ),
                'link' => 'http://'.$_SERVER['HTTP_HOST']
            );

            //ищем статьи
            $articles_obj = DB::select(
                    'articles.author','articles.date_modified','articles.alias',
                    'articlesdescriptions.title','articlesdescriptions.description','articlesdescriptions.article_id',
                    'articles_categories.category_id', array('categories.alias','alias_c'))
                    ->from('articles') 
                    ->where('articles.status', '=', 1)
                    ->and_where('articlesdescriptions.language_id', '=',$config->get('index_language_id'))
                    ->join('articlesdescriptions')->on('articlesdescriptions.article_id', '=', 'articles.id')
                    ->join('articles_categories')->on('articles_categories.article_id', '=', 'articles.id')
                    ->join('categories')->on('articles_categories.category_id', '=', 'categories.id')
                    ->order_by('articles.date_modified','DESC')
                    ->limit(10)
                    ->as_object()    
                    ->execute(); 

            $items = array();
            foreach($articles_obj as $article){
                $items[] = array(
                        'title' => $article->title,
                        'description' => htmlspecialchars($article->description, ENT_QUOTES, 'UTF-8') ,
                        'link' => URL::site('c/'.$article->alias_c.'/'.$article->alias.'.html'),
                        'pubDate' => gmdate('D, d M Y H:i:s O', strtotime($article->date_modified))
                    );
            }


            // Генерируем xml
            $response = urldecode(Feed::create($info, $items));

            header("Content-Type: application/xml");
            echo $response; die(); 
        }    
         
     }
}