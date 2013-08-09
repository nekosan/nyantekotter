<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    var $name = 'Users';
    var $helpers = array('Js');
    public $components = array('Session', 'Auth', 'RequestHandler');
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this -> loadModel('Post');
        $this -> loadModel('UserUser');
    }

    public function _update_session_auth_user() {
        $user = $this -> User -> find('first', array('conditions' => array('id' => $this->Auth->user('id')), 'recursive' => -1));
        unset($user['User']['password']);
        $this -> Session -> write('Auth', $user);
    }

    public function add(){
        if ($this->request->is('post')) {
            try {
                $this -> request -> data['User']['id'] = 5;
                $this -> User -> createWithAttachments($this -> request -> data);
                $this -> Session -> setFlash(__('The message has been saved'));
            } catch (Exception $e) {
                $this -> Session -> setFlash($e -> getMessage());
            }
        }

        $this -> set('user', $this -> User -> getUser('neko3'));
    }

    //TL
    public function index($argu)
    {
        if(!isset($argu)){
            $this -> redirect('timeline');
        }
    }

    public function foo(){

    }

    public function hoge() {
        $this -> set('title_for_layout', 'test');

        if($this -> RequestHandler -> isAjax()){
            Configure::write('debug', 0);
            $this -> autoRender = false;
            $output = array('label' => 'data');
            echo $_GET['callback'] . '(' . json_encode($output) . ')';
        }
    }

    public function tweetpost(){
        if($this -> RequestHandler -> isAjax()){
            if(!empty($this -> params['data']['content'])){
                $datas = array_merge(array('content' => $this -> params['data']['content']), array('user_id' => $this -> Auth -> user('id')));
                if(!$this -> Post -> save($datas)){
                    $this -> Session -> setFlash('$BEPO?$K<:GT$7$^$7$?!#(B');
                    echo 'failed';
                }
                else{
                    echo 'Success';
                }
                echo 'Woo';
            }
        }
    }

    public function get_latest_tl($latest_post_id){
        if($this -> RequestHandler -> isAjax()){
            Configure::write('debug', 0);
            $this -> autoRender = false;

            $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));

            $follow = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);
            array_push($follow, $this -> Auth -> user('id'));
            $options = array(
                'conditions' => array(
                    'Post.user_id' => $follow,
                    'Post.f_delete' => 0,
                    'Post.id >' => $latest_post_id,
                ),
                'order' => array('Post.time DESC')
            );
            $tweets = $this -> Post -> find('all', $options);

            $t_user = array();
            
            foreach($tweets as $t){
            $buf = $this -> User -> getUser($t['UserPost']['username']);
            if(isset($buf[0]['Image'][0])){
                $t_user[$t['UserPost']['id']] = $buf[0]['Image'][count($buf[0]['Image']) - 1];
            }
            else{
                $t_user[$t['UserPost']['id']]['dir'] = 'default';
                $t_user[$t['UserPost']['id']]['attachment'] = 'default.png';
            }
            }


            $output['auth_user'] = $auth_user;
            $output['tweets'] = $tweets;
            $output['t_user'] = $t_user;

            echo $_GET['callback'] . '(' . json_encode($output) . ')';
        }
    }

    public function get_old_tl($old_post_id){
        if($this -> RequestHandler -> isAjax()){
            Configure::write('debug', 0);
            $this -> autoRender = false;

            $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));

            $follow = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);
            array_push($follow, $this -> Auth -> user('id'));
            $options = array(
                'conditions' => array(
                    'Post.user_id' => $follow,
                    'Post.f_delete' => 0,
                    'Post.id <' => $old_post_id,
                ),
                'order' => array('Post.time DESC'),
                'limit' => 10,
            );
            $tweets = $this -> Post -> find('all', $options);

            foreach($tweets as $t){
            $buf = $this -> User -> getUser($t['UserPost']['username']);
            if(isset($buf[0]['Image'][0])){
                $t_user[$t['UserPost']['id']] = $buf[0]['Image'][count($buf[0]['Image']) - 1];
            }
            else{
                $t_user[$t['UserPost']['id']]['dir'] = 'default';
                $t_user[$t['UserPost']['id']]['attachment'] = 'default.png';
            }
            }

            $output['auth_user'] = $auth_user;
            $output['tweets'] = $tweets;
            $output['t_user'] = $t_user;

            echo $_GET['callback'] . '(' . json_encode($output) . ')';
        }
    }

    //Time Line
    public function timeline(){

        $user = $this -> User -> getUser($this -> Auth -> user('username'));
        $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));

        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));
        $auth_follow_id = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);

        $follow = $this -> UserUser -> getFollowId($this -> Auth -> user('id'));
        array_push($follow, $this -> Auth -> user('id'));

        $this -> paginate = array(
            'conditions' => array(
                'Post.user_id' => $follow,
                'Post.f_delete' => 0
            ),
            'limit' => 10
        );

        $options = array(
            'conditions' => array(
                'Post.user_id' => $follow,
                'Post.f_delete' => 0,
            ),
            'limit' => 10,
            'order' => array('Post.time DESC')
        );
        $tweets = $this -> Post -> find('all', $options);
        $t_user = array();
        foreach($tweets as $t){
            $buf = $this -> User -> getUser($t['UserPost']['username']);
            if(isset($buf[0]['Image'][0])){
                $t_user[$t['UserPost']['id']] = $buf[0]['Image'][count($buf[0]['Image']) - 1];
            }
        }

        if($this -> request -> is('post')){
            if($this -> Post -> postTweet($this -> request, $this -> Auth -> user('id'))){
                $this -> Session -> setFlash('$BEPO?$K<:GT$7$^$7$?!#(B');
            }
        }

        $this -> set('tweets', $tweets);
        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
        $this -> set('auth_user', $auth_user);
        $this -> set('auth_follow_id', $auth_follow_id);
        $this -> set('t_user', $t_user);
    }

    //Profile
    public function profile($username){
        if(empty($username)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $user = $this -> User -> getUser($username);
        if(empty($user)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));
        $auth_follow_id = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);
        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));
        $follow_id = $this -> UserUser -> getFollowId($user[0]['User']['id']);

        $this -> paginate = array(
            'conditions' => array(
                'Post.user_id' => $user[0]['User']['id']
            ),
            'order' => 'Post.time DESC',
            'limit' => 10,
        );
        $tweet = $this -> paginate('Post');
        
        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
        $this -> set('tweets',$tweet);
        $this -> set('follow_id', $follow_id);
        $this -> set('auth_user', $auth_user);
        $this -> set('auth_follow_id', $auth_follow_id);
    }

    public function follow($username){
        if(empty($username)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $user = $this -> User -> getUser($username);
        if(empty($user)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));
        $follow_id = $this -> UserUser -> getFollowId($user[0]['User']['id']);
        $auth_follow_id = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);

        $this -> paginate = array(
            'conditions' => array('User.id' => $follow_id),
            'limit' => 10
        );
        $follow = $this -> paginate('User');

        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));
        
        $later_tweet = array();
        foreach ($follow_id as $id){
            $later_tweet[$id] = $this -> Post -> getLaterTweet($id);
        }

        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
        $this -> set('follow', $follow);
        $this -> set('later_tweet', $later_tweet);
        $this -> set('follow_id', $follow_id);
        $this -> set('auth_user', $auth_user);
        $this -> set('auth_follow_id', $auth_follow_id);
    }

    public function follower($username)
    {
        if(empty($username)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $user = $this -> User -> getUser($username);
        if(empty($user)){
            $this -> redirect(array('action' => 'undefined'));
        }
        $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));

        $follow_id = $this -> UserUser -> getFollowId($user[0]['User']['id']);
        $follower_id = $this -> UserUser -> getFollowerId($user[0]['User']['id']);

        $auth_follow_id = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);

        $this -> paginate = array(
            'conditions' => array('User.id' => $follower_id),
            'limit' => 10
        );
        $follower = $this -> paginate('User');
        
        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));
        
        $later_tweet = array();
        foreach ($follower_id as $id){
            $later_tweet[$id] = $this -> Post -> getLaterTweet($id);
        }

        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
        $this -> set('follower', $follower);
        $this -> set('later_tweet', $later_tweet);
        $this -> set('follow_id', $follow_id);
        $this -> set('auth_user', $auth_user);
        $this -> set('auth_follow_id', $auth_follow_id);
    }

    //Register
    public function register()
    {
        if($this -> request ->is('post')){
            $this -> request -> data['User']['password'] = AuthComponent::password($this -> request -> data['User']['password']);
            if($this -> User -> save($this -> request -> data)){
                $this -> redirect('register_completed');
            }
            else{
                $this -> Session -> setFlash('$BEPO?$K<:GT$7$^$7$?!#(B');
            }
        }
    }

    //User Search
    public function user_search()
    {
        $auth_user = $this -> User -> getUser($this -> Auth -> user('username'));
        $auth_follow_id = $this -> UserUser -> getFollowId($auth_user[0]['User']['id']);
        
        $search_key = '';
        if($this -> request -> is('post')){
            $search_key = $this -> request['data']['User']['key'];
        }
        
        if($search_key != ''){
            $this -> paginate = array(
                'conditions' => array('User.username LIKE' => '%'.$search_key.'%'),
                'limit' => 10
            );
            $result = $this -> paginate('User');
            $this -> set('result', $result);
        }

        $later_tweet = array();
        foreach ($auth_follow_id as $id){
            $later_tweet[$id] = $this -> Post -> getLaterTweet($id);
        }
        
        $this -> set('auth_user', $auth_user);
        $this -> set('auth_follow_id', $auth_follow_id);
        $this -> set('later_tweet', $later_tweet);
    }

    //Register Completed
    public function register_completed()
    {

    }

    //Log in
    public function login()
    {
        if($this -> request -> is('post')){
            if($this -> Auth -> login()){
                return $this -> redirect('index');
            }
            else{
                $this -> Session -> setFlash('ログインに失敗しました。');
            }
        }
    }

    //Log out
    public function logout()
    {
        $this -> Auth -> logout();
        $this -> redirect('login');
    }

    public function profile_conf(){
        $this -> Session -> setFlash('');

        if($this -> request ->is('post') && !isset($this -> request -> data['Image'])){
            $pass = $user = $this -> User -> find('first', array('conditions' => array('id' => $this->Auth->user('id')), 'recursive' => -1));
            $this -> request -> data['User']['password'] = AuthComponent::password($this -> request -> data['User']['password']);

            if($this -> request -> data['User']['password'] == $pass['User']['password']){
                $data = array('User' => array(
                    'id' => $this -> Auth -> user('id'),
                    'username' => $this -> request -> data['User']['username'],
                    'name' => $this -> request -> data['User']['name'],
                    'address' => $this -> request -> data['User']['address'],
                ));
                if($this -> User -> save($data, true, array('username', 'name', 'address'))){
                    $user = $this -> User -> find('first', array('conditions' => array('id' => $this->Auth->user('id')), 'recursive' => -1));
                    unset($user['User']['password']);
                    $this -> Session -> write('Auth', $user);
                    $this -> Session -> setFlash('プロフィールを更新しました');
                }
                else{
                    $this -> Session -> setFlash('プロフィールを更新できませんでした');
                }
            }
            else {
                $this -> Session -> setFlash('パスワードが違います');
            }
        }

        if ($this->request->is('post') && isset($this -> request -> data['Image'])) {
            try {
                $this -> request -> data['User']['id'] = $this -> Auth -> user('id');
                $this -> User -> createWithAttachments($this -> request -> data);
                $this -> Session -> setFlash(__('アイコンを変更しました'));
            } catch (Exception $e) {
                $this -> Session -> setFlash($e -> getMessage());
            }
        }

        $this -> set('auth_user', $this -> Auth -> user());
        $this -> set('user', $this -> User -> getUser($this -> Auth -> user('username')));
    }

    //Follow Action
    public function act_follow($redirect, $param, $follow_id)
    {
        if($this -> UserUser -> followUser($this -> Auth -> user('id'), $follow_id)){
                $this -> Session -> setFlash('フォローできませんでした');
        }
        $this -> redirect(array('action' => $redirect, $param));
    }

    //Remove Action
    public function act_remove($redirect, $param, $remove_id)
    {
        if($this -> UserUser -> removeUser($this -> Auth -> user('id'), $remove_id)){
            $this -> Session -> setFlash('フォロー解除できませんでした');
        }
        $this -> redirect(array('action' => $redirect, $param));
    }

    public function undefined()
    {
        
    }
}
