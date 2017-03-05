<?php

/**
 * This is the model class for table "{{schoolabout}}".
 *
 * The followings are the available columns in table '{{schoolabout}}':
 * @property integer $sa_id
 * @property string $sa_label
 * @property string $sa_title
 * @property string $sa_pic
 * @property string $sa_con
 * @property integer $sa_click
 * @property integer $sa_bool
 * @property integer $sa_submitdate
 * @property integer $sa_updatetime
 */
class Schoolabout extends CActiveRecord
{
    public static $isbool=array(
        "0"=>"否",
        "1"=>"是",
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Schoolabout the static model class
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
		return '{{schoolabout}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sa_title, sa_con', 'required'),
			array('sa_click, sa_bool, sa_submitdate, sa_updatetime', 'numerical', 'integerOnly'=>true),
			array('sa_label', 'length', 'max'=>100),
            array('sa_pic',
                        'file',
                        'types'=>'jpg,jpeg,png,gif',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
			array('sa_title', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sa_id, sa_label, sa_title, sa_pic, sa_con, sa_click, sa_bool, sa_submitdate, sa_updatetime', 'safe', 'on'=>'search'),
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
			'sa_id' => 'Sa',
			'sa_label' => 'Sa Label',
			'sa_title' => 'Sa Title',
			'sa_pic' => 'Sa Pic',
			'sa_con' => 'Sa Con',
			'sa_click' => 'Sa Click',
			'sa_bool' => 'Sa Bool',
			'sa_submitdate' => 'Sa Submitdate',
			'sa_updatetime' => 'Sa Updatetime',
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

		$criteria->compare('sa_id',$this->sa_id);
		$criteria->compare('sa_label',$this->sa_label,true);
		$criteria->compare('sa_title',$this->sa_title,true);
		$criteria->compare('sa_pic',$this->sa_pic,true);
		$criteria->compare('sa_con',$this->sa_con,true);
		$criteria->compare('sa_click',$this->sa_click);
		$criteria->compare('sa_bool',$this->sa_bool);
		$criteria->compare('sa_submitdate',$this->sa_submitdate);
		$criteria->compare('sa_updatetime',$this->sa_updatetime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}