<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Главная страница
 */

class Controller_Admin_Main extends Controller_Admin {

    public function action_index() {

        $this->template->page_title = __('heading_title');

        i18n::lang('admin/'.$this->language_folder.'/main');

        //массив записей статистики
        $overview = array();
        $overview['news'] = ORM::factory('Admin_New')->count_all();
	    $overview['articles'] = ORM::factory('Admin_Article')->count_all();
        $overview['categories'] = ORM::factory('Admin_Category')->count_all();
        $overview['users'] = ORM::factory('Admin_User')->count_all();
        $overview['pages'] = ORM::factory('Admin_Page')->count_all();
        $overview['comments'] = ORM::factory('Admin_Comment')->where('status', '=', 0)->count_all();
        $overview['all_comments'] = ORM::factory('Admin_Comment')->count_all();
        $overview['banned'] = ORM::factory('Admin_User')->where('status', '=', 0)->count_all();
         
        
        $text_s = array(
            'synopsis'                      => __('synopsis'),

            'overview_users'                => __('overview_users'),
            'overview_categories'           => __('overview_categories'),
            'overview_news'                 => __('overview_news'),
            'overview_articles'             => __('overview_articles'),
            'overview_pages'                => __('overview_pages'),
            'overview_comments'             => __('overview_comments'),
            'overview_all_comments'         => __('overview_all_comments'),
            'overview_banned'               => __('overview_banned'),

            'entry_range'                   => __('entry_range'),

            'text_week'                     => __('text_week'),
            'text_month'                    => __('text_month'),
            'text_halfyear'                 => __('text_halfyear'),
            'text_sync'                     => __('text_sync'),

            'button_update'                 => __('button_update'),
            'button_loading'                => __('button_loading'),

            'statistic'                     => __('statistic'),
            'error_stat'                    => __('error_stat'),
        );
        
        $statistic = View::factory($this->template_admin.'main/v_main_statistic', array(
            'overview'      => $overview,
            'text'          => $text_s,
            'box_title'     => __('heading_statistic'),
            'statistic'          => $this->statistic,
            'template'      => 'styles/'.$this->template_admin
        ));

        $this->template->block_center = array($statistic);

    }
    
    public function action_chart() {
        $data = array();
        $data['pageview'] = array();
		$data['visits'] = array();
		$data['xaxis'] = array();

        $range = $this->request->param('id');
        
		if (!isset($range)) {
			$range = 'week';
		}
		$metrics =  array('pageviews', 'visits');

        switch ($range) {
			
			case 'week':
                $week = $this->cache->get('analytics_week');
                if($week == NULL){
                    $date = date('Y-m-d', strtotime('6 day ago'));
                    $results = Kohanalytics::instance()->daily_visit_count($date, false, $metrics);	
                    $week = $this->builderDay($metrics, $results);
                    $this->cache->set('analytics_week', $week);
                }
                $data = $week;	
                break;
            case 'month':
                $month = $this->cache->get('analytics_month');
                if($month == NULL){
                    $d = date('d')-1;
				    $date = date('Y-m-d', strtotime('-'.$d." day"));
                    $results = Kohanalytics::instance()->daily_visit_count($date, false, $metrics);	
                    $month = $this->builderDay($metrics, $results);
                    $this->cache->set('analytics_month', $month);		
                }
                $data = $month;				
                break;
            case 'halfyear':
                $halfyear = $this->cache->get('analytics_halfyear');
                if($halfyear == NULL){
				    $start_date = date('Y-m-d', strtotime('6 month ago'));
                    $end_date = date('Y-m-d', strtotime('0 day ago'));
                    $results = Kohanalytics::instance()->monthly_visit_count($start_date, $end_date, $metrics);	
                    $halfyear = $this->builderYear($metrics, $results);
                    $this->cache->set('analytics_halfyear', $halfyear);		
                }
                $data = $halfyear;				
                break; 
            case 'sync':
                $this->cache->delete('analytics_month');
                $this->cache->delete('analytics_week');	
                $this->cache->delete('analytics_halfyear');	
                HTTP::redirect('admin/main/chart/');		
                break;
            case 'check':
                $date = date('Y-m-d', strtotime('0 day ago'));
                $results = Kohanalytics::instance()->daily_visit_count($date, false, $metrics, null, 1);	
                $data = array("status" => count($results));
                break;
		} 
		echo json_encode($data); die();
	}

    public function builderDay($metrics, $results) {
        $data = array();
        if(is_array($results)){
            i18n::lang('admin/'.$this->language_folder.'/main');
            
            
            foreach($metrics as $metric){
                if($metric == "pageviews") $label = __('text_pageviews');
                if($metric == "visits") $label = __('text_visits');
                
                $count = 0; 
                foreach ($results as $r){
                    $data[$metric]["label"] = $label;
                    $data[$metric]["data"][$count] =array(
                        0 => $count+1,
                        1 => $r->{'get'.ucwords($metric)}(),
                    );
                    $count++;
                }
            }
            
            $count = 0; 
            foreach ($results as $r){
                $date = $r->getDate();
                $day = substr($date, 6);
                $data["xaxis"][$count] =array(
                    0 => $count+1,
                    1 => $day,
                );
                $count++;
            }
            $data["datetime"] = time();
            $data["date"] = sprintf(__('text_update'), date("d.m.Y"));

            $data["date"] = sprintf(__('text_update'), date("d.m.Y"));
        } 
        else 
            $data['error'] = 1;
        
        return $data;		
     }
    
    public function builderYear($metrics, $results) {
        $data = array();
        if(is_array($results)){
            i18n::lang('admin/'.$this->language_folder.'/main');
            foreach($metrics as $metric){
                if($metric == "pageviews") $label = __('text_pageviews');
                if($metric == "visits") $label = __('text_visits');
                
                $count = 0; 
                foreach ($results as $r){
                    $data[$metric]["label"] = $label;
                    $data[$metric]["data"][$count] =array(
                        0 => $count+1,
                        1 => $r->{'get'.ucwords($metric)}(),
                    );
                    $count++;
                }
            }
            
            $count = 0; 
            $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
            
            foreach ($results as $r){
                $date = (int)$r->getMonth();
                
                $data["xaxis"][$count] =array(
                    0 => $count+1,
                    1 => $mons[$date],
                );
                $count++;
            }
            $data["datetime"] = time();
            $data["date"] = sprintf(__('text_update'), date("d.m.Y"));
        }
        else 
            $data['error'] = 1;
        return $data;		
     }
}