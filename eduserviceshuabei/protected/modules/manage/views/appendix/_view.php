<?php
/* @var $this AppendixController */
/* @var $data Appendix */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode(Appendix::$Status[$data->status]); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ishome')); ?>:</b>
	<?php echo CHtml::encode(Appendix::$ishome[$data->ishome]); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createtime')); ?>:</b>
	<?php echo CHtml::encode($data->createtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pic')); ?>:</b>
	<?php echo CHtml::encode(DOMAIN.$data->pic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fileurl')); ?>:</b>
	<?php echo CHtml::encode(DOMAIN.$data->fileurl); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('typeid')); ?>:</b>
	<?php echo CHtml::encode(Appendix::$type[$data->typeid]); ?>
	<br />
<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('siteinfo')); ?>:</b>
	<?php echo CHtml::encode($data->siteinfo); ?>
	<br />

	*/ ?>

</div>