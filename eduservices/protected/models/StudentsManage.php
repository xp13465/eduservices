<?php

/**
 * This is the model class for table "{{students_manage}}".
 *
 * The followings are the available columns in table '{{students_manage}}':
 * @property integer $sm_id
 * @property integer $sm_sid
 * @property string $sm_bmorder
 * @property string $sm_zknumber
 * @property integer $sm_status
 * @property string $sm_statusabout
 */
class StudentsManage extends CActiveRecord
{
    public static $status=array(
		"1"=>"待确认",
		"2"=>"录取",
		"3"=>"不录取",
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StudentsManage the static model class
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
		return '{{students_manage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sm_bmorder, sm_zknumber', 'required'),
			array('sm_sid, sm_status', 'numerical', 'integerOnly'=>true),
			array('sm_bmorder, sm_zknumber, sm_statusabout', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sm_id, sm_sid, sm_bmorder, sm_zknumber, sm_status, sm_statusabout', 'safe', 'on'=>'search'),
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
             'studentinfo' => array(self::BELONGS_TO, 'Students', '', 'on' => 't.sm_sid=studentinfo.s_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sm_id' => 'Sm',
			'sm_sid' => 'Sm Sid',
			'sm_bmorder' => 'Sm Bmorder',
			'sm_zknumber' => 'Sm Zknumber',
			'sm_status' => 'Sm Status',
			'sm_statusabout' => 'Sm Statusabout',
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

		$criteria->compare('sm_id',$this->sm_id);
		$criteria->compare('sm_sid',$this->sm_sid);
		$criteria->compare('sm_bmorder',$this->sm_bmorder,true);
		$criteria->compare('sm_zknumber',$this->sm_zknumber,true);
		$criteria->compare('sm_status',$this->sm_status);
		$criteria->compare('sm_statusabout',$this->sm_statusabout,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}