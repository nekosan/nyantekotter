
<div class="main_content">

<?php foreach($tweets as $t): ?>
    <div class="tweet">
        <div class="tweet_header">
            <?php echo $this -> Html -> link(h('@'.$t['UserPost']['username']), array(
               'controller' => 'Users',
               'action' => 'profile',
               $t['UserPost']['username']
            )); ?>
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
            <td class="name">名前 : 
                <?php echo $this -> Html -> link((h($user[0]['User']['name'])), array(
                    'controller' => 'Users',
                    'action' => 'profile',
                    $user[0]['User']['username'],
                )); ?>
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
                <?php echo $this -> Html -> link((h('フォローしている')), array(
                    'controller' => 'Users',
                    'action' => 'follow',
                    $user[0]['User']['username'],
                )); ?>
            </td>
            <td class="text">
                <?php echo $this -> Html -> link((h('フォローされている')), array(
                    'controller' => 'Users',
                    'action' => 'follower',
                    $user[0]['User']['username']
                ));?>
            </td>
        </tr>
    </table>
    <?php
    $flag = 0;
    if($auth_user[0]['User']['id'] != $user[0]['User']['id']){
        foreach($auth_follow_id as $id){
            if($id == $user[0]['User']['id']){
                $flag = 1;
                break;
            }
        }
        if(!$flag):
        ?>
        <?php echo $this -> Html -> link((h('フォロー')), array(
            'controller' => 'Users',
            'action' => 'act_follow',
            'follow',
            $user[0]['User']['username'],
            $user[0]['User']['id']
        )); ?>
        <?php
        else :
        ?>
        <?php echo $this -> Html -> link((h('フォロー解除')), array(
            'controller' => 'Users',
            'action' => 'act_remove',
            'follow',
            $user[0]['User']['username'],
            $user[0]['User']['id']
        )); ?>
        <?php
        endif;
    }
    ?>
</div>

