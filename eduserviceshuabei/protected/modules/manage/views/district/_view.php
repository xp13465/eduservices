<?php
/* @var $this DistrictController */
/* @var $data District */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('did')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->did), array('view', 'id'=>$data->did)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dname')); ?>:</b>
	<?php echo CHtml::encode($data->dname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cid')); ?>:</b>
	<?php echo CHtml::encode($data->cid); ?>
	<br />


</div>