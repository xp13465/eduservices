<?php
/* @var $this StudentsController */
/* @var $data Students */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->s_id), array('view', 'id'=>$data->s_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_pc')); ?>:</b>
	<?php echo CHtml::encode($data->s_pc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_status')); ?>:</b>
	<?php echo CHtml::encode($data->s_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_statusid')); ?>:</b>
	<?php echo CHtml::encode($data->s_statusid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_statustime')); ?>:</b>
	<?php echo CHtml::encode($data->s_statustime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_statusabout')); ?>:</b>
	<?php echo CHtml::encode($data->s_statusabout); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_userid')); ?>:</b>
	<?php echo CHtml::encode($data->s_userid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('s_name')); ?>:</b>
	<?php echo CHtml::encode($data->s_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_sex')); ?>:</b>
	<?php echo CHtml::encode($data->s_sex); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_headerimg')); ?>:</b>
	<?php echo CHtml::encode($data->s_headerimg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_credentialstype')); ?>:</b>
	<?php echo CHtml::encode($data->s_credentialstype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_credentialsnumber')); ?>:</b>
	<?php echo CHtml::encode($data->s_credentialsnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_credentialsimg1')); ?>:</b>
	<?php echo CHtml::encode($data->s_credentialsimg1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_credentialsimg2')); ?>:</b>
	<?php echo CHtml::encode($data->s_credentialsimg2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_birthdate')); ?>:</b>
	<?php echo CHtml::encode($data->s_birthdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_birthaddress')); ?>:</b>
	<?php echo CHtml::encode($data->s_birthaddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_nationality')); ?>:</b>
	<?php echo CHtml::encode($data->s_nationality); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_politicalstatus')); ?>:</b>
	<?php echo CHtml::encode($data->s_politicalstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_highesteducation')); ?>:</b>
	<?php echo CHtml::encode($data->s_highesteducation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_phone')); ?>:</b>
	<?php echo CHtml::encode($data->s_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_email')); ?>:</b>
	<?php echo CHtml::encode($data->s_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_isdel')); ?>:</b>
	<?php echo CHtml::encode($data->s_isdel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_baokaocengci')); ?>:</b>
	<?php echo CHtml::encode($data->s_baokaocengci); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_baokaozhuanye')); ?>:</b>
	<?php echo CHtml::encode($data->s_baokaozhuanye); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_zhiyezhuangkuang')); ?>:</b>
	<?php echo CHtml::encode($data->s_zhiyezhuangkuang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_hunyinzhuangkuang')); ?>:</b>
	<?php echo CHtml::encode($data->s_hunyinzhuangkuang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_familyaddress')); ?>:</b>
	<?php echo CHtml::encode($data->s_familyaddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_gongzuodanwei')); ?>:</b>
	<?php echo CHtml::encode($data->s_gongzuodanwei); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_youbian')); ?>:</b>
	<?php echo CHtml::encode($data->s_youbian); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_contactaddress')); ?>:</b>
	<?php echo CHtml::encode($data->s_contactaddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_tel')); ?>:</b>
	<?php echo CHtml::encode($data->s_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_sfromaddress')); ?>:</b>
	<?php echo CHtml::encode($data->s_sfromaddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_sfromtype')); ?>:</b>
	<?php echo CHtml::encode($data->s_sfromtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_cjgztime')); ?>:</b>
	<?php echo CHtml::encode($data->s_cjgztime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldschool')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldschool); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldschoolcode')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldschoolcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldzhuanye')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldzhuanye); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldtime')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_zsbzm')); ?>:</b>
	<?php echo CHtml::encode($data->s_zsbzm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldimg')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldimg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_oldimgnumber')); ?>:</b>
	<?php echo CHtml::encode($data->s_oldimgnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_file')); ?>:</b>
	<?php echo CHtml::encode($data->s_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_beizhu')); ?>:</b>
	<?php echo CHtml::encode($data->s_beizhu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_enrollment')); ?>:</b>
	<?php echo CHtml::encode($data->s_enrollment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_study')); ?>:</b>
	<?php echo CHtml::encode($data->s_study); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_addid')); ?>:</b>
	<?php echo CHtml::encode($data->s_addid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_addtime')); ?>:</b>
	<?php echo CHtml::encode($data->s_addtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_editid')); ?>:</b>
	<?php echo CHtml::encode($data->s_editid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_edittime')); ?>:</b>
	<?php echo CHtml::encode($data->s_edittime); ?>
	<br />

	*/ ?>

</div>