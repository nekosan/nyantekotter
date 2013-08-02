<?php
App::uses('AppModel', 'Model');

class UserUser extends AppModel {
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'follow_id'
        )
    );

    public function getFollowerId($login_id){
        if(!isset($login_id)){
            return null;//Error
        }
        $follower = $this -> find('all', array('fields' => array('user_id'),'conditions' => array('follow_id' => $login_id)));

        $follower_id = array();
        foreach ($follower as $f):
            array_push($follower_id, $f['UserUser']['user_id']);
        endforeach;
        
        return $follower_id;
    }

    public function getFollowId($login_id){
        if(!isset($login_id)){
            return null;//Error
        }
        $follow = $this -> find('all', array('fields' => array('follow_id'),'conditions' => array('user_id' => $login_id)));

        $follow_id = array();
        foreach ($follow as $f):
            array_push($follow_id, $f['UserUser']['follow_id']);
        endforeach;
        
        return $follow_id;
    }

    public function followUser($login_id, $follow_id)
    {
        $options = $this -> find('all', array('conditions' => array('UserUser.user_id' => $login_id, 'UserUser.follow_id' => $follow_id)));
        if(!empty($options)){
            return 1;
        }
        $datas = array(
            'UserUser' => array(
                'user_id' => $login_id,
                'follow_id' => $follow_id
            )
        );
        if($this -> save($datas)){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function removeUser($login_id, $remove_id)
    {
        if($this -> deleteAll(array('UserUser.user_id' => $login_id, 'UserUser.follow_id' => $remove_id), false)){
            return 0;
        }
        else {
            return 1;
        }
    }

    public function test(){
        return 0;
    }
}

?>
