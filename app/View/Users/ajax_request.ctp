<?php echo $this -> Html -> script( 'jquery-1.10.2.min', array( 'inline' => false ) ); ?>
<?php echo $this -> Html -> script( 'test', array( 'inline' => false ) ); ?>
<?php echo $this -> Js -> writeBuffer(array('inline' => 'true')); ?>

<a id="element">test</a>
<script>
<?php echo $this -> Js -> request(array('action' => 'ajax_return', 'param1'), array('async' => true, 'update' => '#element')); ?>
</script>
