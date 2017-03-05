<?php

/**
 * This is the model class for table "{{score}}".
 *
 * The followings are the available columns in table '{{score}}':
 * @property integer $sc_id
 * @property integer $sc_sid
 * @property integer $sc_sjid
 * @property string $sc_thanswer
 * @property integer $sc_kgmark
 * @property integer $sc_zgmark
 * @property integer $sc_status
 * @property integer $sc_readerid
 * @property string $sc_remark
 * @property string $sc_sdt
 * @property string $sc_ldt
 * @property string $sc_source
 * @property integer $sc_pkid
 */
class Score extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Score the static model class
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
		return '{{score}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sc_id, sc_sid, sc_sjid,sc_pkid,sc_kgmark, sc_zgmark, sc_status, sc_readerid', 'numerical', 'integerOnly'=>true),
			array('sc_source', 'length', 'max'=>50),
			array('sc_thanswer, sc_remark, sc_sdt, sc_ldt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sc_id, sc_sid, sc_sjid,sc_pkid,sc_thanswer, sc_kgmark, sc_zgmark, sc_status, sc_readerid, sc_remark, sc_sdt, sc_ldt, sc_source', 'safe', 'on'=>'search'),
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
			'sc_id' => 'Sc',
			'sc_sid' => 'Sc Sid',
			'sc_sjid' => 'Sc Sjid',
            'sc_pkid' => 'Sc Pkid',
			'sc_thanswer' => 'Sc Thanswer',
			'sc_kgmark' => 'Sc Kgmark',
			'sc_zgmark' => 'Sc Zgmark',
			'sc_status' => 'Sc Status',
			'sc_readerid' => 'Sc Readerid',
			'sc_remark' => 'Sc Remark',
			'sc_sdt' => 'Sc Sdt',
			'sc_ldt' => 'Sc Ldt',
			'sc_source' => 'Sc Source',
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

		$criteria->compare('sc_id',$this->sc_id);
		$criteria->compare('sc_sid',$this->sc_sid);
		$criteria->compare('sc_sjid',$this->sc_sjid);
        $criteria->compare('sc_pkid',$this->sc_pkid);
		$criteria->compare('sc_thanswer',$this->sc_thanswer,true);
		$criteria->compare('sc_kgmark',$this->sc_kgmark);
		$criteria->compare('sc_zgmark',$this->sc_zgmark);
		$criteria->compare('sc_status',$this->sc_status);
		$criteria->compare('sc_readerid',$this->sc_readerid);
		$criteria->compare('sc_remark',$this->sc_remark,true);
		$criteria->compare('sc_sdt',$this->sc_sdt,true);
		$criteria->compare('sc_ldt',$this->sc_ldt,true);
		$criteria->compare('sc_source',$this->sc_source,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    
        /**
     * 根据考生ID与试卷ID获取最后一次答卷的分数信息
     * @param integer $sid 考生ID integer $sjid 试卷表ID 
     * @return  array
     */
    public function getExamScore($sid,$sjid){
    
    //echo $sid.'---777888999---'.$sjid;
        $return='';
       // $cacheTime=Yii::app()->params->cacheTime;
       // if($eid){
          //  $return=@Yii::app()->cache->get("exampaper_name_{$eid}");
           // if($return==false){
                $criteria=new CDbCriteria;
                $criteria->select='*';
                $criteria->addCondition("sc_sid ='{$sid}'");
                $criteria->addCondition("sc_sjid ='{$sjid}'");
                $criteria->order = "sc_id desc";
                $return = $this->find($criteria);
                //$return=$umodel?$umodel->e_name:"";
                //Yii::app()->cache->set("exampaper_name_{$eid}",$return,$cacheTime);
           // }
        //}
        return $return;
    }
}