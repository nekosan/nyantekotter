<pre>
<?php
    //print_r(h($tweets));
?>
</pre>
<?php
    print(
        $this -> Form -> create('Post') .
        $this -> Form -> input('content') .
        $this -> Form -> end('Post')
    );
    ?>
<br />

<div class="main_content">

<?php foreach($tweets as $t): ?>
    <div class="tweet">
        <div class="tweet_header">
            <a href="">@<?php print(h($t['UserPost']['username'])); ?></a>
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
