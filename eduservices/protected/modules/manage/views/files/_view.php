<?php
/* @var $this FilesController */
/* @var $data Files */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->f_id), array('view', 'id'=>$data->f_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_uid')); ?>:</b>
	<?php echo CHtml::encode($data->f_uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_url')); ?>:</b>
	<?php echo CHtml::encode($data->f_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_type')); ?>:</b>
	<?php echo CHtml::encode($data->f_type); ?>
	<br />


</div>