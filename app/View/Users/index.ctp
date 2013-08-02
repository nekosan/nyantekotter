
<?php
    print(h($user['name']));
    print(
        $this -> Form -> create('Post') .
        $this -> Form -> input('content') .
        $this -> Form -> end('Post')
    );
    ?>
<br />
<pre>
<?php print_r($posts); ?>
</pre>
