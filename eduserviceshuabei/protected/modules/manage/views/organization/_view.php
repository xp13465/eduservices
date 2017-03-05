<?php
/* @var $this OrganizationController */
/* @var $data Organization */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->o_id), array('view', 'id'=>$data->o_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_name')); ?>:</b>
	<?php echo CHtml::encode($data->o_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_contacts')); ?>:</b>
	<?php echo CHtml::encode($data->o_contacts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_tel')); ?>:</b>
	<?php echo CHtml::encode($data->o_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_web')); ?>:</b>
	<?php echo CHtml::encode($data->o_web); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_address')); ?>:</b>
	<?php echo CHtml::encode($data->o_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_code')); ?>:</b>
	<?php echo CHtml::encode($data->o_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('o_pid')); ?>:</b>
	<?php echo CHtml::encode($data->o_pid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('o_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->o_isdel); ?>
	<br />

	*/ ?>

</div>