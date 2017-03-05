<?php

/**
 * This is the model class for table "{{application}}".
 *
 * The followings are the available columns in table '{{application}}':
 * @property string $sa_id
 * @property integer $sa_sid
 * @property string $sa_remarks
 * @property integer $sa_sqtime
 * @property string $sa_fileurl
 * @property integer $sa_status
 * @property string $sa_statusremarks
 * @property integer $sa_shtime
 * @property integer $sa_shauditorid
 * @property integer $sa_type
 * @property integer $sa_shedittime
 * @property integer $sa_euserid
 * @property integer $sa_proposerid
 * @property integer $sa_isdel
 */
class Application extends CActiveRecord
{
	public static $type=array(
        "1" => "补考申请",
        "2" => "退学申请",
        "3" => "变更申请",
        "4" => "删除申请",
        "5" => "恢复申请"
    );
    public  static $astatus=array(
        "1" => "申请中",
        "2" => "通过",
        "3" => "驳回",
    );
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Application the static model class
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
		return '{{application}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sa_sid, sa_sqtime, sa_status, sa_shtime, sa_shauditorid, sa_type, sa_shedittime, sa_euserid, sa_proposerid', 'numerical', 'integerOnly'=>true),
			array('sa_remarks, sa_statusremarks', 'length', 'max'=>600),
            array('sa_fileurl',
                        'file',
                        'types'=>'rar,zip',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
            array('sa_fileurl', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sa_id, sa_sid, sa_remarks, sa_sqtime, sa_fileurl, sa_status, sa_statusremarks, sa_shtime, sa_shauditorid, sa_type, sa_shedittime, sa_euserid, sa_proposerid, sa_isdel', 'safe', 'on'=>'search'),
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
          'studentinfo' => array(self::BELONGS_TO, 'Students', '', 'on' => 't.sa_sid=studentinfo.s_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sa_id' => 'ID',
			'sa_sid' => '学员ID',
			'sa_remarks' => '申请备注',
			'sa_sqtime' => '申请时间',
			'sa_fileurl' => '附件上传',
			'sa_status' => '申核状态',
			'sa_statusremarks' => '审核备注',
			'sa_shtime' => '审核时间',
            'sa_shauditorid' => '审核人ID',
			'sa_type' => '申请类型',
			'sa_shedittime' => '最后修改时间',
			'sa_euserid' => '最后修改人ID',
			'sa_proposerid' => '申请操作人ID',
            'sa_isdel' => '回收站',
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

		$criteria->compare('sa_id',$this->sa_id,true);
		$criteria->compare('sa_sid',$this->sa_sid);
		$criteria->compare('sa_remarks',$this->sa_remarks,true);
		$criteria->compare('sa_sqtime',$this->sa_sqtime);
		$criteria->compare('sa_fileurl',$this->sa_fileurl,true);
		$criteria->compare('sa_status',$this->sa_status);
		$criteria->compare('sa_statusremarks',$this->sa_statusremarks,true);
		$criteria->compare('sa_shtime',$this->sa_shtime);
        $criteria->compare('sa_shauditorid',$this->sa_shauditorid);
		$criteria->compare('sa_type',$this->sa_type);
		$criteria->compare('sa_shedittime',$this->sa_shedittime);
		$criteria->compare('sa_euserid',$this->sa_euserid);
		$criteria->compare('sa_proposerid',$this->sa_proposerid);
        $criteria->compare('sa_isdel',$this->sa_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}