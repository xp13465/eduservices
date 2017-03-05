<?php
/* @var $this SchoolController */
/* @var $data School */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->s_id), array('view', 'id'=>$data->s_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_code')); ?>:</b>
	<?php echo CHtml::encode($data->s_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_name')); ?>:</b>
	<?php echo CHtml::encode($data->s_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_province')); ?>:</b>
	<?php echo CHtml::encode($data->s_province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_history')); ?>:</b>
	<?php echo CHtml::encode($data->s_history); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_pinyinsuoxie')); ?>:</b>
	<?php echo CHtml::encode($data->s_pinyinsuoxie); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_pinyinlongname')); ?>:</b>
	<?php echo CHtml::encode($data->s_pinyinlongname); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('s_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->s_isdel); ?>
	<br />

	*/ ?>

</div>