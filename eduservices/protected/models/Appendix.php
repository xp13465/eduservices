<?php

/**
 * This is the model class for table "{{appendix}}".
 *
 * The followings are the available columns in table '{{appendix}}':
 * @property string $id
 * @property integer $status
 * @property integer $ishome
 * @property integer $createtime
 * @property string $name
 * @property string $pic
 * @property string $fileurl
 * @property integer $typeid
 * @property string $siteinfo
 */
class Appendix extends CActiveRecord
{   
    public static $Status = array(
		'0'=>"禁用",
		'1'=>"启用",
	);
    public static $type = array(
        1 => '统一类',
    );
    public static $ishome = array(
        0 => '否',
        1 => '是',
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Appendix the static model class
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
		return '{{appendix}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, ishome, createtime, typeid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
            array('pic',
                        'file',
                        'types'=>'jpg,jpeg,png,gif',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
            array('fileurl',
                        'file',
                        'types'=>'rar,zip,doc,docx,xls,xlsx',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
			array('fileurl', 'length', 'max'=>150),
			array('siteinfo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, ishome, createtime, name, pic, fileurl, typeid, siteinfo', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'status' => '状态',
			'ishome' => '首页显示',
			'createtime' => '添加时间',
			'name' => '标题',
			'pic' => '缩略图',
			'fileurl' => '附件',
			'typeid' => '分类',
			'siteinfo' => '描述',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ishome',$this->ishome);
		$criteria->compare('createtime',$this->createtime);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('fileurl',$this->fileurl,true);
		$criteria->compare('typeid',$this->typeid);
		$criteria->compare('siteinfo',$this->siteinfo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}