<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_nkname')); ?>:</b>
	<?php echo CHtml::encode($data->user_nkname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_headimg')); ?>:</b>
	<?php echo CHtml::encode($data->user_headimg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_webset')); ?>:</b>
	<?php echo CHtml::encode($data->user_webset); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_tel')); ?>:</b>
	<?php echo CHtml::encode($data->user_tel); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_tel2')); ?>:</b>
	<?php echo CHtml::encode($data->user_tel2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_phone')); ?>:</b>
	<?php echo CHtml::encode($data->user_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_msn')); ?>:</b>
	<?php echo CHtml::encode($data->user_msn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_adderss')); ?>:</b>
	<?php echo CHtml::encode($data->user_adderss); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_qq')); ?>:</b>
	<?php echo CHtml::encode($data->user_qq); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->user_pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_role')); ?>:</b>
	<?php echo CHtml::encode($data->user_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_regtime')); ?>:</b>
	<?php echo CHtml::encode($data->user_regtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_loginnum')); ?>:</b>
	<?php echo CHtml::encode($data->user_loginnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_lasttime')); ?>:</b>
	<?php echo CHtml::encode($data->user_lasttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_lastip')); ?>:</b>
	<?php echo CHtml::encode($data->user_lastip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_online')); ?>:</b>
	<?php echo CHtml::encode($data->user_online); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_organization')); ?>:</b>
	<?php echo CHtml::encode($data->user_organization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->user_isdel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_authorize')); ?>:</b>
	<?php echo CHtml::encode($data->user_authorize); ?>
	<br />

	*/ ?>

</div>