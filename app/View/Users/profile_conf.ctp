<?php echo $this -> Session->flash(); ?>

<?php 
print(
    $this -> Form -> create('User') .
    $this -> Form -> input('username', array('type' => 'text', 'label' => 'ユーザーID', 'value' => $auth_user['username'])) .
    $this -> Form -> input('password', array('label' => 'パスワード(確認用)', 'value' => '')) .
    $this -> Form -> input('name', array('type' => 'text', 'label' => '名前', 'value' => $auth_user['name'])) .
    $this -> Form -> input('address', array('type' => 'text', 'label' => 'メールアドレス', 'value' => $auth_user['address'])) .
    $this -> Form -> end('更新')
);
?>
<?php
    echo $this->Form->create('User', array('type' => 'file'));
    echo $this->Form->input('Image.0.attachment', array('type' => 'file', 'label' => 'Image'));
    echo $this->Form->input('Image.0.model', array('type' => 'hidden', 'value' => 'User'));
    echo $this->Form->end(__('Add'));
    echo $this -> Session -> flash();
?>

