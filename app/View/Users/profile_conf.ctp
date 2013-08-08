<?php echo $this -> session->flash() ?>

<?php 
print(
    $this -> Form -> create('User') .
    $this -> Form -> input('username', array('type' => 'text', 'label' => 'ユーザーID', 'value' => $auth_user['username'])) .
    $this -> Form -> input('password', array('label' => 'パスワード', 'value' => '')) .
    $this -> Form -> input('name', array('type' => 'text', 'label' => '名前', 'value' => $auth_user['name'])) .
    $this -> Form -> input('address', array('type' => 'text', 'label' => 'メールアドレス', 'value' => $auth_user['address'])) .
    $this -> Form -> end('更新')
);
?>

