
<h2><?php print(h($user[0]['User']['name']));?>さんは<?php print($follow_num); ?>人をフォローしています。</h2>
<h2><?php print(h($user[0]['User']['name']));?>さんは<?php print($follower_num); ?>人からフォローされています。</h2>

<?php foreach($tweet as $t): ?>
<div class="tweet">
    <div class="tweet_header">
        <a href="">@<?php print(h($t['UserPost']['username'])); ?></a>
        <b><?php print(h($t['UserPost']['name'])); ?></b>
    </div>
    <div><?php print(h($t['Post']['content'])); ?></div>
</div>
<?php endforeach; ?>
<?php
    echo $this -> Paginator -> prev('Prev', $options = array(), $disabledTitle = null, $disabledoptions = array());
?>
<?php
    echo $this -> Paginator -> next('Next', $options = array(), $disabledTitle = null, $disabledoptions = array());
?>
    
