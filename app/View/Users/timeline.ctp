<?php echo $this -> Html -> script( 'jquery-1.10.2.min', array( 'inline' => false ) ); ?>
<?php echo $this -> Html -> script( 'test', array( 'inline' => false ) ); ?>
<?php echo $this -> Js -> writeBuffer(array('inline' => 'true')); ?>

<div class="main_content">

<div class="tweet_field">
<?php foreach($tweets as $t): ?>
    <div class="tweet">
        <div class="tweet_header">
            <?php echo $this -> Html -> link(
                '@' . $t['UserPost']['username'],
                array(
                    'controller' => 'users',
                    'action' => 'profile',
                    $t['UserPost']['username']
                )
            ); ?>
            <b><?php print(h($t['UserPost']['name'])); ?></b>
        </div>
        <div class="tweet_content">
            <?php print(h($t['Post']['content'])) ?>
        </div>
        <div class="tweet_time">
            <?php print(h($t['Post']['time'])); ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>
    <div class="get_old_post">
        過去のツイートを取得するにはここをクリック
    </div>
</div>
<div class="side_content">
    <table class="user_info">
        <tr>
            <td class="name">名前 : 
            <?php echo $this -> Html -> link(
                $auth_user[0]['User']['name'],
                array(
                    'controller' => 'users',
                    'action' => 'profile',
                    $auth_user[0]['User']['username']
                )
            ); ?>
            </td>
        </tr>
    </table>
    <table class="user_info">
        <tr>
            <td class="number"><?php print(h($follow_num)); ?></td>
            <td class="number"><?php print(h($follower_num)); ?></td>
        </tr>
        <tr>
            <td class="text">
            <?php echo $this -> Html -> link(
                'フォローしている',
                array(
                    'controller' => 'users',
                    'action' => 'follow',
                    $user[0]['User']['username']
                )
            ); ?>
            </td>
            <td class="text">
            <?php echo $this -> Html -> link(
                'フォローされている',
                array(
                    'controller' => 'users',
                    'action' => 'follower',
                    $user[0]['User']['username']
                )
            ); ?>
            </td>
            <td><span class="textnum">140</span></td>
        </tr>
    </table>
    <div class="post">
    <?php
        print(
            $this -> Form -> create('Post', array('class' => 'postform', 'default' => false)) .
            $this -> Form -> input('content', array('class' => 'postfield', 'cols' => '29', 'rows' => '4', 'label' => '', 'value' => '')) .
            $this -> Form -> submit('Post', array('class' => 'postbutton', 'url' => 'user/timeline')) .
            $this -> Form -> end()
        );
    ?>
    </div>
    <div id='messageArea'></div>
</div>


