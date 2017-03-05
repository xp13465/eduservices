<?php
/* @var $this SchoolaboutController */
/* @var $data Schoolabout */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sa_id), array('view', 'id'=>$data->sa_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_label')); ?>:</b>
	<?php echo CHtml::encode($data->sa_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_title')); ?>:</b>
	<?php echo CHtml::encode($data->sa_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_pic')); ?>:</b>
	<?php echo CHtml::encode($data->sa_pic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_con')); ?>:</b>
	<?php echo CHtml::encode($data->sa_con); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_click')); ?>:</b>
	<?php echo CHtml::encode($data->sa_click); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_bool')); ?>:</b>
	<?php echo CHtml::encode($data->sa_bool); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_submitdate')); ?>:</b>
	<?php echo CHtml::encode($data->sa_submitdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sa_updatetime')); ?>:</b>
	<?php echo CHtml::encode($data->sa_updatetime); ?>
	<br />

	*/ ?>

</div>