<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php echo $title_for_layout ?></title>
    <?php echo $this -> Html -> css('main'); ?>
</head>

<body>
    <div id="container">
        <div id="header">
            <div id="header_logo">
                <?php echo $this -> Html -> link($this -> Html -> image('top_logo.png', array('width' => '296', 'height' => '66')), array('controller' => 'Users', 'action' => 'index'), array('escape' => false)); ?>
            </div>
            <div id="header_menu">
                <?php if(isset($user)): ?>
                        <span><?php echo $this -> Html -> link('ログアウト', '/users/logout'); ?></span>
                    <?php else: ?>
                        <span><?php echo $this -> Html -> link('ログイン', '/users/login'); ?></span> | 
                        <span><?php echo $this -> Html -> link('新規登録', '/users/register'); ?></span>
                    <?php endif; ?>
            </div>
        </div>
        <div id="content">
            <?php echo $this -> fetch('content'); ?>
        </div>
    </div>
</body>

</html>

