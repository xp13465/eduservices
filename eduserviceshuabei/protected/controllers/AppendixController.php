<?php

class AppendixController extends Controller
{
	public $layout='main';
	public function actionIndex()
	{
        $criteria=new CDbCriteria;
        $criteria->addCondition("status = 1 ");
        $criteria->order='createtime desc';
        $dataProvider =  new CActiveDataProvider("Appendix", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>15
						),
		));
		$this->render('index',array(
                'dataProvider'=>$dataProvider,
        ));
	}
    public function actionDetail($id)
	{
        
		$model=Appendix::model()->findByPk($id);     
        if($model==null)throw new CHttpException(400,'��Ч�������벻Ҫ��������Ҫ��');
        $this->render('detail',array(
            "model"=>$model
        ));
	}
}