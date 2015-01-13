<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Комментарии
 */
class Controller_Index_Comments extends Controller_Index {
    public function  before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/articles');
    } 
    
    
    public function action_edit() {
        //если редактируется коммент
        if($this->request->is_ajax() && $this->auth->logged_in()){
            $json = array();
            
            //извлекаем данные
            $data = Arr::extract($_POST, array('comment','comment_id'));
            $date = date("Y-m-d H:i:s");

            //добавляем коммент в базу
            $edit = ORM::factory('Index_Comment', $data['comment_id']);
            $edit->text = $data['comment'];
            $edit->author = $this->user->username;
            $edit->email = $this->user->email;
            $edit->ip = $this->user->ip;
            $edit->date_modified = $date;
            //если модерация включена
            if($this->config['comment_moderation'])
                $edit->status = 0;
            else
                $edit->status = 1;

            //формируем ответ в виде json
            try {
                $edit->update();
                
                //формируем ответ в виде json
                $json = array(
                    'date'          => date("d F Y H:i",strtotime($date)),
                    'text'          => $this->config['comment_moderation'] ? __('moderation') :  $data['comment'],
                );
            }
            catch(ORM_Validation_Exception $e)
            {
                $json['errors'] = $e->errors('index/'.$this->language_folder);
            }
            
            echo json_encode($json); die();
        }
    }
    
    //добавление комментария
    public function action_add() {
        //если добавляется коммент
        if($this->request->is_ajax()){
            $json = array();

            //извлекаем данные
            $data = Arr::extract($_POST, array('comment','article_id', 'rating','author','email','captcha','user_id'));
            $date = date("Y-m-d H:i:s");

            //добавляем коммент в базу
            if(!$data['user_id'] && !Captcha::valid($data['captcha']))
                $json['errors']['captcha'] = __('error_captcha');
            else{
                $add = ORM::factory('Index_Comment');
                $add->article_id = $data['article_id'];
                $add->text = $data['comment'];
                //если это гость
                if(!$this->auth->logged_in()){
                    $add->user_id = (int)$data['user_id'];
                    $add->author = $data['author'];
                    $add->email = $data['email'];
                    $add->ip = $_SERVER['REMOTE_ADDR'];
                    $add->is_reg = 0;
                    $ava = "no_ava.jpg";
                }
                else { //если пользователь
                    $add->user_id = (int)$this->user->id;
                    $add->author = $this->user->username;
                    $add->email = $this->user->email;
                    $add->ip = $this->user->ip;
                    $add->is_reg = 1;
                    $ava = $this->user->ava;
                }

                $add->date_modified = $date;

                //если есть модерация
                if($this->config['comment_moderation']) $add->status = 0;
                else $add->status = 1;

                $add->rating = $data['rating'];

                try {
                    $add->save(); //пытаемся сохранить комментарий
                    if($data['rating'] > 0){
                        $article = ORM::factory('Index_Article', $data['article_id']);
                        $article->rating  =  (int)($article->rating + $data['rating'])/2;
                        $article->update();
                    }

                    //если авы нет, то сохраняем по-умолчанию
                    if($this->auth->logged_in() && !$this->user->ava)
                        $ava = "no_ava.jpg";

                    //формируем ответ
                    if(!$this->auth->logged_in()){
                        $json = array(
                            'id'            => $add->pk(),
                            'user_id'       => (int)$data['user_id'],
                            'ava'           => HTTP_IMAGE.$ava,
                            'author'        => $data['author'],
                            'date'          => date("d F Y H:i",strtotime($date)),
                            'text'          => $this->config['comment_moderation'] ? __('moderation') : $data['comment'],
                            'offset'        => $this->config['count_comment']*30
                        );
                    }
                    else {
                        $json = array(
                            'id'            => $add->pk(),
                            'user_id'       => $this->user->id,
                            'ava'           => HTTP_IMAGE.$ava,
                            'author'        => $this->user->username,
                            'date'          => date("d F Y H:i",strtotime($date)),
                            'text'          => $this->config['comment_moderation'] ? __('moderation') : $data['comment'],
                            'offset'        => $this->config['count_comment']*30
                        );
                    }


                }
                catch(ORM_Validation_Exception $e)
                {
                    $json['errors'] = $e->errors('index/'.$this->language_folder);
                }
            }

            echo json_encode($json); die();
        }
    }
    
    //удаление комментария
    public function action_remove() {
        if($this->request->is_ajax() && $this->auth->logged_in()){
            $json = array();
            
            //извлекаем данные
            $id = Arr::get($_POST, 'comment_id');
            
            //если данные существуют, то формируем отправку
            if (isset($id)) {
                if($id != 0){ 
    		     DB::delete('comments')->where('id', '=', $id)->execute();
                     $json = array(
                        'id'  => $id,
                     );
    		}
            }
            echo json_encode($json); die();
        }
    }
}