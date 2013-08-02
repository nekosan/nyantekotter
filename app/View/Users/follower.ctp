
<div class="main_content">
<h3><?php print(h($user[0]['User']['name']));?>さんは<?php print($follower_num); ?>人にフォローされています。</h3>

<?php foreach($follower as $t): ?>
    <div class="user">
        <div class="user_header">
            <a href="">@<?php print(h($t['User']['username'])); ?></a>
            <b><?php print(h($t['User']['name'])); ?></b>
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
            <td class="name">名前 : <a href=""><?php print(h($user[0]['User']['name'])); ?></a></td>
        </tr>
    </table>
    <table class="user_info">
        <tr>
            <td class="number"><?php print(h($follow_num)); ?></td>
            <td class="number"><?php print(h($follower_num)); ?></td>
        </tr>
        <tr>
            <td class="text"><a href="">フォローしている</a></td>
            <td class="text"><a href="">フォローされている</a></td>
        </tr>
    </table>
</div>
