<div class="view">
    <div class="right-tip">
        <div class="font-20" style="float:left;">Id&nbsp;</div>
        <div class="right-id-tip deepskyblue">
            <?php echo CHtml::link(CHtml::encode($data->stkd_id), array('update', 'id'=>$data->stkd_id)); ?>
        </div>
    </div>

	<b><?php echo CHtml::encode("ID"); ?>:</b>
	<?php echo CHtml::encode($data->stkd_id); ?>
	<br />
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('stkd_id')); ?>:</b>
	<?php echo CHtml::encode(Seotkd::model()->getPosition($data->stkd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stkd_title')); ?>:</b>
	<?php echo CHtml::encode($data->stkd_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stkd_keyword')); ?>:</b>
	<?php echo CHtml::encode($data->stkd_keyword); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stkd_dec')); ?>:</b>
	<?php echo CHtml::encode($data->stkd_dec); ?>
	<br />
</div>