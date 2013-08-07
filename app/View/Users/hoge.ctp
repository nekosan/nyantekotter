<?php print $this -> Html -> script( 'jquery-1.10.2.min', array( 'inline' => false ) ); ?>
<?php print $this -> Html -> script( 'test', array( 'inline' => false ) ); ?>

    <?php
        print(
            $this -> Form -> create('Post', array('class' => 'postform', 'default' => false)) .
            $this -> Form -> input('content', array('class' => 'postfield', 'cols' => '29', 'rows' => '4', 'label' => '', 'value' => '')) .
            $this -> Form -> submit('Post', array('class' => 'postbutton', 'url' => 'user/timeline')) .
            $this -> Form -> end()
        );
    ?>
<span class="textnum">140</span>
