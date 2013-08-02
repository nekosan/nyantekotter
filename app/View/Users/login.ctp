
<?php
print(
    $this -> Form -> create('User') .
    $this -> Form -> input('username', array('type' => 'text', 'label' => 'ユーザーID')) .
    $this -> Form -> input('password', array('label' => 'パスワード')) .
    $this -> Form -> end('ログイン')
);
