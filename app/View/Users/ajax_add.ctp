<?php echo $this -> Html -> script( 'jquery-1.10.2.min', array( 'inline' => false ) ); ?>
<?php echo $this -> Html -> script( 'test', array( 'inline' => false ) ); ?>
<?php echo $this -> Js -> writeBuffer(array('inline' => 'true')); ?>

<?php
print(
    $this -> Form -> create(null, array('url' => '#', 'id' => 'addForm')).
    $this -> Form -> input('content', array('id' => 'addFormFiled')).
    $this -> Form -> submit('Post', array('id' => 'addformSubmit')).
    $this -> Form -> end()
);
?>

<ul id='lastUpdate'></ul>

<script>
function update(){
    $.getJSON("")
}

$(function(){
    $a('a.delete').click(function(e){
        if(confirm('Sure?')){
            $.post('users/delete/'+$(this).data('post-id'), {}, function(res){
                $('#post_'+res.id).fadeOut;
            }, "json");
        }
        return false;
    }
});
</script>
