<?php

/**
 * This is the model class for table "{{province}}".
 *
 * The followings are the available columns in table '{{province}}':
 * @property integer $pid
 * @property string $pname
 */
class Province extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Province the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{province}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, pname', 'required'),
			array('pid', 'numerical', 'integerOnly'=>true),
			array('pname', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pid, pname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pid' => 'Pid',
			'pname' => 'Pname',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pid',$this->pid);
		$criteria->compare('pname',$this->pname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 获取省分列表
     * @return array 返回身份列表数组 attributes ( pid=>pname )
     */
	public function getAllP() {
       $return=Yii::app()->cache->get("province_getallp");
       if($return==false){
            $criteria=new CDbCriteria;
            $criteria->select='pid,pname';
            $Pmodel=$this->findAll($criteria);
            $PidArr=array();
            foreach($Pmodel as $val)$PidArr[$val->pid]=$val->pname;
            $return=$PidArr;
           Yii::app()->cache->set("province_getallp",$return,Yii::app()->params->cacheTime);
       }
       return $return;
    }
    /**
     * 通过ID获取省份名称
     * @param integer $id  省份表的KEY
     * @return string 省份名称
     */
	public function getNameById($id){
        $return=Yii::app()->cache->get("province_name_{$id}");
        if($return==false){
            $model=$this->findByPk($id);
            $return=$model?$model->pname:'';
            Yii::app()->cache->set("province_name_{$id}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
	}
    
}