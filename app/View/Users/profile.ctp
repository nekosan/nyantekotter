
<div class="main_content">

<?php foreach($tweets as $t): ?>
    <div class="tweet">
        <div class="tweet_header">
            <a href="<?php echo Router::url('/users/profile/', false); echo $user[0]['User']['username']?>">@<?php print(h($t['UserPost']['username'])); ?></a>
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
    <?php
        echo $this -> Paginator -> prev('Prev', $options = array(), $disabledTitle = null, $disabledoptions = array());
    ?>
    <?php
        echo $this -> Paginator -> next('Next', $options = array(), $disabledTitle = null, $disabledoptions = array());
    ?>
</div>
<div class="side_content">
    <table class="user_info">
        <tr>
            <td class="name">名前 : <a href="<?php echo Router::url('/users/profile/', false); echo $user[0]['User']['username']?>"><?php print(h($user[0]['User']['name'])); ?></a></td>
        </tr>
    </table>
    <table class="user_info">
        <tr>
            <td class="number"><?php print(h($follow_num)); ?></td>
            <td class="number"><?php print(h($follower_num)); ?></td>
        </tr>
        <tr>
            <td class="text"><a href="<?php echo Router::url('/users/follow/', false); echo $user[0]['User']['username']?>">フォローしている</a></td>
            <td class="text"><a href="<?php echo Router::url('/users/follower/', false); echo $user[0]['User']['username']?>">フォローされている</a></td>
        </tr>
    </table>
    <?php
    $flag = 0;
    foreach($auth_follow_id as $id){
        if($id == $user[0]['User']['id']){
            $flag = 1;
        }
    }
    ?>
    <?php
    if(!$flag):
    ?>
    <a href="<?php echo Router::url('/users/act_follow/', false); ?>profile/<?php echo $user[0]['User']['username'] ?>/<?php echo $user[0]['User']['id'] ?>">フォロー</a>
    <?php
    else :
    ?>
    <a href="<?php echo Router::url('/users/act_remove/', false); ?>profile/<?php echo $user[0]['User']['username'] ?>/<?php echo $user[0]['User']['id'] ?>">リムーブ</a>
    <?php
    endif;
    ?>
    
</div>

