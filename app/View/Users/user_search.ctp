<div class="main_content">
<?php if(isset($result)): ?>
<?php foreach($result as $t): ?>
    <div class="user">
        <div class="user_header">
            <?php echo $this -> Html -> link(h('@'.$t['User']['username']), array(
               'controller' => 'Users',
               'action' => 'profile',
               $t['User']['username']
            )); ?>
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
    <?php endif; ?>
    <?php
        echo $this -> Paginator -> prev('Prev', $options = array(), $disabledTitle = null, $disabledoptions = array());
    ?>
    <?php
        echo $this -> Paginator -> next('Next', $options = array(), $disabledTitle = null, $disabledoptions = array());
    ?>
</div>
<div class="side_content">
       <div class="post">
    <?php
        print(
            $this -> Form -> create('User') .
            $this -> Form -> input('key', array('label' => '')) .
            $this -> Form -> end('Search')
        );
    ?>
    </div>
</div>
