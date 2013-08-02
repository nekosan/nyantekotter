<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public $components = array('Session', 'Auth');
    public $paginate = array(
        'limit' => 10,
        'order' => array('time' => 'desc')
    );

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this -> Auth -> deny('index', 'logout');
    }

    //TL
    public function index($argu)
    {
        if(!isset($argu)){
            $this -> redirect('timeline');
        }
    }

    //Time Line
    public function timeline(){
        $this -> loadModel('Post');
        $this -> loadModel('UserUser');
        $user = $this -> User -> getUser($this -> Auth -> user()['username']);

        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));

        if($this -> request -> is('post')){
            if($this -> Post -> postTweet($this -> request, $this -> Auth -> user()['id'])){
                $this -> Session -> setFlash('登録に失敗しました。');
            }
        }

        $follow = $UserUser -> getFollowId($login_id);
        array_push($follow, $login_id);
        $tweet = $this -> paginate('Post', array('Post.user_id' => $follow));
        $this -> set('tweets', $posts);
        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
    }

    //Profile
    public function profile($username){
        $this -> loadModel('Post');
        $this -> loadModel('UserUser');
        $user = $this -> User -> getUser($username);
        $follow_num = count($this -> UserUser -> getFollowId($user[0]['User']['id']));
        $follower_num = count($this -> UserUser -> getFollowerId($user[0]['User']['id']));
        
        $tweet = $this -> paginate('Post', array('Post.user_id' => $user[0]['User']['id']));
        
        $this -> set('user', $user);
        $this -> set('follow_num', $follow_num);
        $this -> set('follower_num', $follower_num);
        $this -> set('tweet',$tweet);
    }

    public function follower($username)
    {
        $this -> loadModel('UserUser');
        $this -> loadModel('Post');
        $user = $this -> User -> getUser($username);
        $follower_id = $this -> UserUser -> getFollowerId($user[0]['User']['id']);

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
}
