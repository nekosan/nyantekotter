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
                    $this -> Session -> setFlash('登録に失敗しました。');
                    echo 'failed';
                }
                else{
                    echo 'Success';
                }
                echo 'Woo';
            }
        }
    }

    //Time Line
    public function timeline(){
        Configure::write('debug', 0);

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

        
        if($this -> RequestHandler -> isAjax()){
            $this -> autoRender = false;
            $options = array(
                'conditions' => array(
                    'Post.user_id' => $follow,
                    'Post.f_delete' => 0,
                    'Post.id >' => $auth_user[0]['User']['latest_post_id'],
                ),
                'order' => array('Post.time DESC')
            );
            $tweets = $this -> Post -> find('all', $options);
            if(!empty($tweets)){
                $this -> User -> save(array('User' => array('id' => $auth_user[0]['User']['id'], 'latest_post_id' => $tweets[0]['Post']['id'])), false, array('latest_post_id'));
            }

            $output['user'] = $user;
            $output['auth_user'] = $auth_user;
            $output['follow_num'] = $follow_num;
            $output['follower_num'] = $follower_num;
            $output['auth_follow_id'] = $auth_follow_id;
            $output['tweets'] = $tweets;

            echo $_GET['callback'] . '(' . json_encode($output) . ')';
        }
        else{
            $options = array(
                'conditions' => array(
                    'Post.user_id' => $follow,
                    'Post.f_delete' => 0,
                ),
                'limit' => 10,
                'order' => array('Post.time DESC')
            );
            $tweets = $this -> Post -> find('all', $options);
            $this -> User -> save(array('User' => array('id' => $auth_user[0]['User']['id'], 'latest_post_id' => $tweets[0]['Post']['id'])), false, array('latest_post_id'));

            if($this -> request -> is('post')){
                if($this -> Post -> postTweet($this -> request, $this -> Auth -> user('id'))){
                    $this -> Session -> setFlash('登録に失敗しました。');
                }
            }
            $this -> set('tweets', $tweets);
            $this -> set('user', $user);
            $this -> set('follow_num', $follow_num);
            $this -> set('follower_num', $follower_num);
            $this -> set('auth_user', $auth_user);
            $this -> set('auth_follow_id', $auth_follow_id);
        }
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

        $tweet = $this -> paginate('Post', array('Post.user_id' => $user[0]['User']['id']));
        
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
            if($this -> User -> save($this -> request -> data)){
                $this -> redirect('register_completed');
            }
            else{
                $this -> Session -> setFlash('登録に失敗しました。');
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
                $this -> Session -> setFlash('ログイン失敗');
            }
        }
    }

    //Log out
    public function logout()
    {
        $this -> Auth -> logout();
        $this -> redirect('login');
    }

    //Follow Action
    public function act_follow($redirect, $param, $follow_id)
    {
        if($this -> UserUser -> followUser($this -> Auth -> user('id'), $follow_id)){
                $this -> Session -> setFlash('フォローに失敗しました。');
        }
        $this -> redirect(array('action' => $redirect, $param));
    }

    //Remove Action
    public function act_remove($redirect, $param, $remove_id)
    {
        if($this -> UserUser -> removeUser($this -> Auth -> user('id'), $remove_id)){
            $this -> Session -> setFlash('フォローに失敗しました。');
        }
        $this -> redirect(array('action' => $redirect, $param));
    }

    public function undefined()
    {
        
    }
}
