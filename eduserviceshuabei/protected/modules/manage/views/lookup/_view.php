<?php
/* @var $this LookupController */
/* @var $data Lookup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lu_id), array('view', 'id'=>$data->lu_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_key')); ?>:</b>
	<?php echo CHtml::encode($data->lu_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_value')); ?>:</b>
	<?php echo CHtml::encode($data->lu_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_class')); ?>:</b>
	<?php echo CHtml::encode($data->lu_class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_info')); ?>:</b>
	<?php echo CHtml::encode($data->lu_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lu_code')); ?>:</b>
	<?php echo CHtml::encode($data->lu_code); ?>
	<br />


</div>