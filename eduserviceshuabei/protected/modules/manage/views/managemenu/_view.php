<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->m_id), array('view', 'id'=>$data->m_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_name')); ?>:</b>
	<?php echo CHtml::encode($data->m_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_link')); ?>:</b>
	<?php echo CHtml::encode($data->m_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_parentid')); ?>:</b>
	<?php echo CHtml::encode($data->m_parentid); ?>
	<br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('m_role')); ?>:</b>
	<?php echo CHtml::encode(User::model()->getUserName(explode(",",$data->m_role))); ?>
	<br />


</div>