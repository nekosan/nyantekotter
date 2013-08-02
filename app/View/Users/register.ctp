
<?php 
print(
    $this -> Form -> create('User') .
    $this -> Form -> input('username', array('type' => 'text', 'label' => 'ユーザーID')) .
    $this -> Form -> input('password', array('label' => 'パスワード')) .
    $this -> Form -> input('name', array('type' => 'text', 'label' => '名前')) .
    $this -> Form -> input('address', array('type' => 'text', 'label' => 'メールアドレス')) .
    $this -> Form -> end('登録')
);
?>
