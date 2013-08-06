
<div class="main_content">
<h3><?php print(h($user[0]['User']['name']));?>さんは<?php print($follower_num); ?>人にフォローされています。</h3>

<?php foreach($follower as $t): ?>
    <div class="user">
        <div class="user_header">
            <?php echo $this -> Html -> link(h('@'.$t['User']['username']), array(
               'controller' => 'Users',
               'action' => 'profile',
               $t['User']['username']
            )); ?>
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
            <?php echo $this -> Html -> link((h('フォロー')), array(
                'controller' => 'Users',
                'action' => 'act_follow',
                'follower',
                $user[0]['User']['username'],
                $t['User']['id']
            )); ?>
            <?php
            else :
            ?>
            <?php echo $this -> Html -> link((h('フォロー解除')), array(
                'controller' => 'Users',
                'action' => 'act_remove',
                'follower',
                $user[0]['User']['username'],
                $t['User']['id']
            )); ?>
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
</div>
