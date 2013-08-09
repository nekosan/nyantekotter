<?php
    echo $this->Form->create('User', array('type' => 'file'));
    echo $this->Form->input('Image.0.attachment', array('type' => 'file', 'label' => 'Image'));
    echo $this->Form->input('Image.0.model', array('type' => 'hidden', 'value' => 'User'));
    echo $this->Form->end(__('Add'));
    echo $this -> Session -> flash();
?>
<?php echo $this->Html->image('/files/image/attachment/'.$user[0]['Image']['0']['dir'].'/'.$user[0]['Image']['0']['attachment'], array('alt' => 'icon')); ?>
<pre>
<?php print_r($user); ?>
</pre>

