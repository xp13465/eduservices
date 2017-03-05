<?php
/* @var $this TopicController */
/* @var $data Topic */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->t_id), array('view', 'id'=>$data->t_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_qid')); ?>:</b>
	<?php echo CHtml::encode($data->t_qid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_know')); ?>:</b>
	<?php echo CHtml::encode($data->t_know); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_level')); ?>:</b>
	<?php echo CHtml::encode($data->t_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_score')); ?>:</b>
	<?php echo CHtml::encode($data->t_score); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_type')); ?>:</b>
	<?php echo CHtml::encode($data->t_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_validity')); ?>:</b>
	<?php echo CHtml::encode($data->t_validity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('t_con')); ?>:</b>
	<?php echo CHtml::encode($data->t_con); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_daxx')); ?>:</b>
	<?php echo CHtml::encode($data->t_daxx); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_answer')); ?>:</b>
	<?php echo CHtml::encode($data->t_answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_leaflet')); ?>:</b>
	<?php echo CHtml::encode($data->t_leaflet); ?>
	<br />

	*/ ?>

</div>