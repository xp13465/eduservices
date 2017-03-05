<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'登录',
);
?>

<h1>后台用户登录</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
)); ?>
    <table width="100%">
        <tr>
            <td width="7%"><?php echo $form->labelEx($model,'username'); ?></td>
            <td>
                <?php echo $form->textField($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model,'password'); ?></td>
            <td>
                <?php echo $form->passwordField($model,'password'); ?>
                <?php echo $form->error($model,'password'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $form->checkBox($model,'rememberMe');?>
                <?php echo $form->label($model,'rememberMe'); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"><?php echo CHtml::submitButton('登录'); ?></td>
        </tr>
    </table>

<?php $this->endWidget(); ?>
</div><!-- form -->
