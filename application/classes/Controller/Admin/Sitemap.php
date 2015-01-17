<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sitemap extends Kohana_Sitemap
{
	public static function map($pr_page, $pr_news, $pr_category, $pr_article)
	{
        $sitemap = new Sitemap;
        $url = new Sitemap_URL;

        $news_obj = ORM::factory('Admin_New')->where('status', '=', 1)->order_by('date_modified','DESC')->find_all();
        $page_obj = ORM::factory('Admin_Page')->where('status', '=', 1)->order_by('date_modified','DESC')->find_all();
        $category_obj = ORM::factory('Admin_Category')->where('status', '=', 1)->order_by('date_modified','DESC')->find_all();

        $article_obj = DB::select('articles.date_modified','articles.alias',array('categories.alias','alias_c'))
            ->from('articles') ->where('articles.status', '=', 1)
            ->join('articles_categories')->on('articles_categories.article_id', '=', 'articles.id')
            ->join('categories')->on('articles_categories.category_id', '=', 'categories.id')
            ->order_by('articles.date_modified','DESC')->as_object()->execute();
        
        if( $pr_news != "" ){
            foreach ($news_obj as $news) 
            {
                    $url->set_loc('http://'.$_SERVER['HTTP_HOST'].'/news/'.$news->alias.'.html') 
                        ->set_last_mod($news->date_modified) 
                        ->set_priority($pr_news);
                    $sitemap->add($url); 
            }
        }
        
        if( $pr_page != "" ){
            foreach ($page_obj as $page) 
            {
                    $url->set_loc('http://'.$_SERVER['HTTP_HOST'].'/'.$page->alias.'.html') 
                        ->set_last_mod($page->date_modified) 
                        ->set_priority($pr_page);
                    $sitemap->add($url); 
            }
        }
        if( $pr_category != "" ){
            foreach ($category_obj as $category) 
            {
                    $url->set_loc('http://'.$_SERVER['HTTP_HOST'].'/c/'.$category->alias) 
                        ->set_last_mod($category->date_modified) 
                        ->set_priority($pr_category);
                    $sitemap->add($url); 
            }
        }
        if( $pr_article != "" ){
            foreach ($article_obj as $article) 
            {
                    $url->set_loc('http://'.$_SERVER['HTTP_HOST'].'/c/'.$article->alias_c.'/'.$article->alias.'.html') 
                        ->set_last_mod(strtotime($article->date_modified)) 
                        ->set_priority($pr_article);
                    $sitemap->add($url); 
            }
        }
		// Генерируем xml
		$response = $sitemap->render();

		//Записываем в файл sitemap.xml в корне сайта
		file_put_contents('sitemap.xml', $response);
	}   
        
        
}