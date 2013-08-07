<?php echo $this -> Html -> script( 'jquery-1.10.2.min', array( 'inline' => false ) ); ?>
<?php echo $this -> Html -> script( 'test', array( 'inline' => false ) ); ?>
<?php echo $this -> Js -> writeBuffer(array('inline' => 'true')); ?>

<div id="return"></div>
<script>
<?php
echo $this -> Js -> get('#element') => event(
    'click',
    $this -> Js -> request(
        array('action' => 'ajax_return', 'param1'),
        array('async' => true, 'update' => '#return');
    ),
    array('buffer' => false)
);
?>
</script>
