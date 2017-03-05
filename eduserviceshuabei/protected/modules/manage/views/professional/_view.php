<?php
/* @var $this ProfessionalController */
/* @var $data Professional */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->p_id), array('view', 'id'=>$data->p_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_code')); ?>:</b>
	<?php echo CHtml::encode($data->p_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_name')); ?>:</b>
	<?php echo CHtml::encode($data->p_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_pid')); ?>:</b>
	<?php echo CHtml::encode($data->p_pid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->p_isdel); ?>
	<br />


</div>