<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Пользователи
 */
class Controller_Admin_Users extends Controller_Admin {
    
    public function before() {
        parent::before();
        $this->template->styles[] = 'styles/admin/bower_components/jquery-ui/themes/south-street/jquery-ui.min.css';

        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/core.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/datepicker.min.js';
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/users');
        
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/users', $this->template->page_title);
    }

    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_logins'         => __('column_logins'),
            'column_last_login'     => __('column_last_login'),
            'column_username'       => __('column_username'),
            'column_name'           => __('column_name'),
            'column_ip'             => __('column_ip'),
            'button_change'         => __('button_change'),
            'message_no'            => __('message_no'),
            'confim_delete'         => __('confim_delete'),

            'button_change'         => __('button_change'),
            'button_filter'         => __('button_filter'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),
        );

        //инициализация переменных для фильтра
        $filter_username = (string) $this->request->param('username');
        $filter_name = (string) $this->request->param('name');
        $filter_date = (string) $this->request->param('date');
        $filter_ip = (string) $this->request->param('ip');
        $filter_status =  $this->request->param('fstatus');

        //извлечение параметров запроса
        $page = $this->request->param('page');
        $status = $this->request->param('status');
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');
        
        //установка значений для выборки из базы по-умолчанию
        if($page == "") $page = 1;
        if($status == "") $status = -1;
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";

        if($filter_username != "") $f1='LIKE';
        else $f1='!=';

        if($filter_name != "") $f2='LIKE';
        else  $f2='!=';

        if($filter_date != "") $f3='LIKE';
        else $f3='!=';

        if($filter_ip != "") $f4='LIKE';
        else $f4='!=';

        if($filter_status != "") $f5='=';
        else $f5='!=';

        //извлекаем количество пользователей
        $count = ORM::factory('Admin_User')
            ->where('username', $f1, '%'.$filter_username.'%')
            ->and_where('name', $f2, '%'.$filter_name.'%')
            ->and_where('last_login', $f3, '%'.$filter_date.'%')
            ->and_where('ip', $f4, '%'.$filter_ip.'%')
            ->and_where('status', $f5, $filter_status)
            ->count_all();

        i18n::lang('admin/'.$this->language_folder.'/common');
        //высчитываем пагинацию
        $pagination = Pagination::factory(array( 
            'total_items' => $count,
            'view'=>'pagination/admin'
        ))
            ->route_params( array(
            'controller' => Request::current()->controller(),
            'action' => Request::current()->action(),
        ));
        
        //извлекаем пользователей
        $users = ORM::factory('Admin_User')
            ->where('username', $f1, '%'.$filter_username.'%')
            ->and_where('name', $f2, '%'.$filter_name.'%')
            ->and_where('last_login', $f3, '%'.$filter_date.'%')
            ->and_where('ip', $f4, '%'.$filter_ip.'%')
            ->and_where('status', $f5, $filter_status)
            ->limit($pagination->items_per_page)->offset($pagination->offset)
            ->order_by($sort, $type)->find_all();
    
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'users/v_users_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('errors', $this->errors)
            ->bind('pagination', $pagination) 
            ->bind('users', $users)
            ->bind('sort', $sort)
            ->bind('type', $type)
            ->bind('page', $page)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    //Удаление пользователей
    public function action_delete() {
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                //перебираем все языки и удаляем
                foreach($selected as $id){
                    if($id != 0){ 
                        $user = ORM::factory('Admin_User')->where('id', '=', $id)->find(); //извлекаем пользователя
                        $user->remove('roles'); //удаляем его роли
                        $user->delete();        //удаляем пользователя из базы  
                    }
                }
                $this->session->set('message', __('message_delete'));
            }
        }
        HTTP::redirect('admin/users');
    }

    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name','username', 'email', 'phone', 'password', 'action', 'confirm','status','group', 'skype', 'icq', 'info','newsletter', 'ip'));

            //загрузка модели
            $user = ORM::factory('Admin_User', $this->data['id']);
            $user->values($this->data);
            $this->data['last_login'] = $user->last_login;
            $this->data['ava'] = $user->ava ? $user->ava : "no_ava.jpg";
            
            //проверка на валидацию
            try {
                $user->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                //инициализируем новую модель,т.к. вдруг пароли отсутствуют, а проверить то их надо было в модели
                $user = ORM::factory('Admin_User', $this->data['id']);
                $user->name         = $this->data['name'];
                $user->username     = $this->data['username'];
                $user->email        = $this->data['email'];
                $user->phone        = $this->data['phone'];
                $user->skype        = $this->data['skype'];
                $user->icq          = $this->data['icq'];
                $user->info         = $this->data['info'];
                $user->newsletter   = $this->data['newsletter'];
                $user->status       = $this->data['status'];
                
                //если пароли существуют и равны, то сохраняем и его
                if($this->data['password']!="" && $this->data['confirm']!="" && $this->data['password']===$this->data['confirm']){
                    $user->password = $this->auth->hash_password($this->data['password']);
                }
                
                $user->save();   //обновляем параметры 
                $user->remove('roles'); //удаляем роли этого пользователя
                
                if(isset($this->data['group']))
                    $user->add('roles', $this->data['group']); //добавляем новые роли если есть
                $this->session->set('message', __('message_edit'));
                HTTP::redirect('admin/users'); 
            }  
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }

    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        { 
            
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name','username', 'email', 'phone', 'password', 'action', 'confirm','status','group', 'skype', 'icq', 'info','newsletter', 'ip'));

            //загрузка модели
            $user = ORM::factory('Admin_User');
            $user->values($this->data);
            $this->data['ava'] = "no_ava.jpg";
            
            //проверка на валидацию
            try {
                $user->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                //инициализируем новую модель,т.к. вдруг пароли отсутствуют, а проверить то их надо было в модели
                $user = ORM::factory('Admin_User');
                $user->name         = $this->data['name'];
                $user->username     = $this->data['username'];
                $user->email        = $this->data['email'];
                $user->phone        = $this->data['phone'];
                $user->skype        = $this->data['skype'];
                $user->icq          = $this->data['icq'];
                $user->info         = $this->data['info'];
                $user->newsletter   = $this->data['newsletter'];
                $user->status       = $this->data['status'];
                
                //если пароли существуют и равны, то сохраняем и его
                if($this->data['password']!="" && $this->data['confirm']!="" && $this->data['password']===$this->data['confirm']){
                    $user->password = $this->auth->hash_password($this->data['password']);
                }
                
                $user->save();   //обновляем параметры 
                
                if(isset($this->data['group']))
                    $user->add('roles', $this->data['group']); //добавляем новые роли если есть
                $this->session->set('message', __('message_add'));
                HTTP::redirect('admin/users'); 
            }  
        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }

    public function action_statusupdate(){
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $user = ORM::factory('Admin_User', $id);
                
                if( ! $user->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $user->status = $status;
                $user->save();
                $this->session->set('message', __('message_status'));
            }
        }
        HTTP::redirect('admin/users');
    }
    
     //функция формирования данных для шаблона
    private function getContent(){

        $id = (int) $this->request->param('id');

        $roles = ORM::factory('Admin_Role')->find_all();
        
        //формирование массива категорий
        $roles_arr = array();
        foreach ($roles as $role){
                $roles_arr[$role->id] = $role->description;
        }

        $text = array(
            'text_ip'            	=> __('text_ip'),
            'text_icq'            	=> __('text_icq'),
            'text_ava'            	=> __('text_ava'),
            'text_noava'            => __('text_noava'),
            'text_info'            	=> __('text_info'),
            'text_date'            	=> __('text_date'),
            'text_name'             => __('text_name'),
            'text_username'         => __('text_username'),
            'text_email'            => __('text_email'),
            'text_phone'            => __('text_phone'),
            'text_skype'            => __('text_skype'),
            'text_group'            => __('text_group'),
            'text_password'         => __('text_password'),
            'text_confirm'          => __('text_confirm'),
            'text_newsletter'       => __('text_newsletter'),
            'text_status'           => __('text_status'),
            'text_select_all'       => __('text_select_all'),
            'text_select_remove'    => __('text_select_remove'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        //извлекаем все роли
        $roles = ORM::factory('Admin_Role')->find_all();

        //формирование массива категорий
        $roles_arr = array();
        foreach ($roles as $role){
            $roles_arr[$role->id] = $role->description;
        }

        if($id){
            //извлечение пользователя
            $user = ORM::factory('Admin_User', $id);

            if( ! $user->loaded())
            {
                throw new HTTP_Exception_404('user not found');
            }

            //извлекаем роли конкретного пользователя
            $roles_user = $user->roles->find_all();

            //формируем массив выделенных ролей
            foreach ($roles_user as $role)
                $user_roles = $role->id;

        }

        //если post пустой и существует id
        if(empty($this->data) && $id)
        {
            //формирование массива настроек пользователя
            $this->data = Array(
                "id"            => $user->id,
                "name"          => $user->name,
                "username"      => $user->username,
                "email"         => $user->email,
                "phone"         => $user->phone,
                "skype"         => $user->skype,
                "icq"         	=> $user->icq,
                "ip"         	=> $user->ip,
                "ava"         	=> $user->ava ? $user->ava : "no_ava.jpg",
                "info"         	=> $user->info,
                "last_login"    => $user->last_login,
                "newsletter"    => $user->newsletter,
                "password"      => "",
                "confirm"       => "",
                "status"        => $user->status,
                "action"        => 'edit',
                "group"         => $user_roles,
            );
        }

        //если post пустой, и не существует id
        if(empty($this->data) && !$id){
            $ip = $_SERVER['REMOTE_ADDR'];

            $this->data = array(
                "action" 		=> "add",
                "id" 			=> 0,
                "username" 		=> "",
                "name" 			=> "",
                "email" 	    => "",
                "phone" 		=> "",
                "skype"         => "",
                "icq"         	=> "",
                "ava"         	=> "no_ava.jpg",
                "ip"         	=> $ip,
                "info"         	=> "",
                "last_login"    => "",
                "newsletter"    => "",
                "password" 		=> "",
                "confirm" 		=> "",
                "group" 		=> 0,
                "status" 		=> 0,

            );
        }

        //формируем весь контент
        $content = View::factory($this->template_admin.'users/v_users_form')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) //ошибки
            ->bind('user', $user) //массив пользователя
            ->bind('text', $text) //массив текста для полей
            ->bind('roles', $roles_arr) //массив ролей
            ->bind('data', $this->data);    //передаваемые данные

        return $content;
    }    
    
    
}