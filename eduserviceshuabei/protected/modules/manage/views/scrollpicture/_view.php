<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sp_id), array('view', 'id'=>$data->sp_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sp_title')); ?>:</b>
	<?php echo CHtml::encode($data->sp_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sp_link')); ?>:</b>
	<?php echo CHtml::encode($data->sp_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sp_order')); ?>:</b>
	<?php echo CHtml::encode($data->sp_order); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('sp_type')); ?>:</b>
	<?php echo CHtml::encode(Scrollpicture::$sp_type[$data->sp_type]); ?>
	<br />

</div>