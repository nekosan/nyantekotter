<?php
App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $name = 'Post';
    public $validate = array(
        'content' => array(
            array(
                'rule' => array('between', 1, 140),
                'message' => '文字数が140文字を超えています。'
            )
        )
    );
    public $belongsTo = array(
        'UserPost' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    public function test(){
        return 0;
    }

    public function getTimeline($login_id)
    {
        App::import('Model', 'UserUser');
        $UserUser = new UserUser();
        $follow = $UserUser -> getFollowId($login_id);
        array_push($follow, $login_id);
        $posts = $this -> find('all', array('conditions' => array('Post.user_id' => $follow), 'order' => array('Post.time' => 'DESC')));

        return $posts;
    }

    public function getUserTweet($user_id)
    {
        $posts = $this -> find('all', array('conditions' => array('Post.user_id' => $user_id), 'order' => array('Post.time' => 'DESC')));

        return $posts;
    }

    public function getLaterTweet($user_id)
    {
        $options = array(
            'conditions' => array(
                'Post.user_id' => $user_id
            ),
            'order' => array(
                'Post.time' => 'DESC'
            )
        );
        $post = $this -> find('first', $options);
        return $post;
    }

    public function postTweet($request, $login_id){
        $datas = array_merge($request -> data['Post'], array('user_id' => $login_id));
        if($this -> save($datas)){
            return 0;
        }
        else{
            return 1;
        }
    }
}
?>
