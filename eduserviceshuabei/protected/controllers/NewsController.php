<?php

class NewsController extends Controller
{
    public $layout='main';
	public function actionIndex($id=1)
	{   
        $criteria=new CDbCriteria;
        // $criteria->addCondition("i_class = '{$id}'");
        $id=in_array($id,array(1,2,3,4))?$id:$id="1";
        $criteria->addCondition("i_class = '{$id}'");
        
        $dataProvider =  new CActiveDataProvider("Information", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>15
						),
		));
		$this->render('index',array(
                'id'=>$id,
                'dataProvider'=>$dataProvider,
        ));
	}
    public function actionDetail($id)
	{
        $model=$this->loadModel($id);
        // print_r($model->i_class);    
        // if($model->i_class==5)throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        $model->i_click=$model->i_click?$model->i_click+1:1;
        $model->update();
		$this->render('detail',array(
            'model'=>$model,
        
        ));
	}
    public function loadModel($id)
	{
        // $model=Yii::app()->cache->get("news_modeldata_{$id}");     
        // if($model==false){  
            $model=Information::model()->findByPk($id);
            // Yii::app()->cache->set("news_modeldata_{$id}",$model,600);
        // }
		// echo $model->s_addid;
        if($model===null || $model->i_class=='5')
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    
}