<?php
class FormModel extends CFormModel
{
    public function existNickname(){
        $model=User::model()->find('LOWER(u_nickname)=?',array(strtolower($this->nickname)) );
        if($model && $model->u_id != Yii::app()->user->id){
            $this->addError('nickname', '该昵称已经已经被注册！');
        }
    }

    public function existEmail(){
        $model=User::model()->find('LOWER(u_email)=?',array(strtolower($this->email)) );
        if($model && $model->u_id != Yii::app()->user->id){
            $this->addError('email', '该邮箱已经被注册！');
        }
    }
    public function existTelephone(){
        $model=Member::model()->findByAttributes(array('mem_telephone'=>$this->telephone));
        if($model && $model->mem_userid != Yii::app()->user->id){
            $this->addError('telephone', '该电话号码已经被注册！');
        }
    }
    public function myError($attribute,$htmlOptions=array()){
        $error=$this->getError($attribute);
		if($error!='')
			return CHtml::tag('p',$htmlOptions,$error);
		else
			return '';
    }
}
