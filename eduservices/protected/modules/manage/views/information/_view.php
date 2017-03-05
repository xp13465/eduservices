<?php
/* @var $this InformationController */
/* @var $data Information */
?>

<div class="view">
     <div class="right-tip">
        <div class="font-20" style="float:left;">Id&nbsp;</div>
        <div class="right-id-tip deepskyblue">
            <?php echo CHtml::link(CHtml::encode($data->i_id), array('view', 'id'=>$data->i_id)); ?>
        </div>
        <?php echo CHtml::encode($data->getAttributeLabel('i_pic')); ?>:
        <img src='<?php echo CHtml::encode($data->i_pic); ?>' style='width:200px;height:120px;<?=$data->i_pic?"":"display:none"?>'>
    </div>
    

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_class')); ?>:</b>
	<?php echo CHtml::encode(Information::$class[$data->i_class]); ?>

    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_label')); ?>:</b>
	<?php echo CHtml::encode($data->i_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_title')); ?>:</b>
	<?php echo CHtml::encode($data->i_title); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('i_bool')); ?>:</b>
	<?php echo CHtml::encode(Information::$isbool[$data->i_bool]); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_click')); ?>:</b>
	<?php echo CHtml::encode($data->i_click); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('i_submitdate')); ?>:</b>
	<?php echo CHtml::encode($data->i_submitdate?date("Y-m-d H:i:s",$data->i_submitdate):""); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_updatetime')); ?>:</b>
	<?php echo CHtml::encode($data->i_submitdate?date("Y-m-d H:i:s",$data->i_updatetime):""); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_form')); ?>:</b>
	<?php echo CHtml::encode($data->i_form); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('i_author')); ?>:</b>
	<?php echo CHtml::encode($data->i_author); ?>
	<br />



</div>