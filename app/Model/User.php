<?php
App::uses('AppModel', 'Model');

class User extends AppModel {
    public $hasMany = array(
        'Image' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_key',
            'conditions' => array(
                'Image.model' => 'User',
            ),
        ),
    );

    public $validate = array(
        'username' => array(
            array(
                'rule' => 'isUnique',
                'message' => '既に使用されている名前です。'
            ),
            array(
                'rule' => array('custom', '/^[0-9a-zA-Z\_]+$/'),
                'message' => '名前は半角英数字とアンダーバーにしてください。'
            ),
            array(
                'rule' => array('between', 1, 64),
                'message' => '名前は６４文字以内にしてください。'
            ),
        ),
        'password' => array(
            array(
                'rule' => array('custom', '/^[0-9a-zA-Z\_]+$/'),
                'message' => 'パスワードは半角英数字とアンダーバーにしてください。'
            ),
            array(
                'rule' => array('between', 8, 64),
                'message' => 'パスワードは8文字以上64文字以内にしてください。'
            ),
        ),
        'name' => array(
            array(
                'rule' => array('between', 0, 32),
                'message' => '名前は32文字以下にしてください。'
            ),
        ),
        'address' => array(
            array(
                'rule' => 'isUnique',
                'message' => '既に登録されているメールアドレスです。',
            ),
        ),
    );

    /*public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'user_user',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'follow_id',
            'unique' => 'true',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );*/

    public function getUser($username){
        $result = $this -> find('all', array('conditions' => array('User.username' => $username)));
        return $result;
    }

    public function beforeSave($option = array()){
        return true;
    }


    public function createWithAttachments($data) {
        if (!empty($data['Image'][0])) {
            if (isset($data['foreign_key'])) {
                unset($data['foreign_key']);
            }
        }

        $this->create();
        if ($this -> saveAll($data) && $data['Image'][0]['attachment']['error'] == 0) {
            return true;
        }

        throw new Exception(__("This post could not be saved. Please try again"));
    }
}

?>
