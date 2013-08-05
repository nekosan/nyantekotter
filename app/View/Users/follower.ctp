
<div class="main_content">
<h3><?php print(h($user[0]['User']['name']));?>さんは<?php print($follower_num); ?>人にフォローされています。</h3>

<?php foreach($follower as $t): ?>
    <div class="user">
        <div class="user_header">
            <a href="<?php echo Router::url('/users/profile/', false); echo $t['User']['username']?>">@<?php print(h($t['User']['username'])); ?></a>
            <b><?php print(h($t['User']['name'])); ?></b>
            <?php
            $flag = 0;
            foreach($auth_follow_id as $id){
                if($id == $t['User']['id']){
                    $flag = 1;
                }
            }
            if(!$flag):
            ?>
            <a href="<?php echo Router::url('/users/act_follow/', false);?>follower/<?php echo $user[0]['User']['username'] ?>/<?php echo $t['User']['id'] ?>">フォロー</a>
            <?php
            else :
            ?>
            <a href="<?php echo Router::url('/users/act_remove/', false); ?>follower/<?php echo $user[0]['User']['username'] ?>/<?php echo $t['User']['id'] ?>">リムーブ</a>
            <?php
            endif;
            ?>
        </div>
        <div class="user_content">
            <?php
            if(isset($later_tweet[$t['User']['id']]['Post']['content'])):
                print(h($later_tweet[$t['User']['id']]['Post']['content']));
            else:
                print(h(""));
            endif;
            ?>
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
</div>
