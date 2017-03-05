<?php
/* @var $this PiciController */
/* @var $data Pici */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->p_id), array('view', 'id'=>$data->p_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_value')); ?>:</b>
	<?php echo CHtml::encode($data->p_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_status')); ?>:</b>
	<?php echo CHtml::encode($data->p_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->p_isdel); ?>
	<br />


</div>