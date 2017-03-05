<?php

/**
 * This is the model class for table "{{link}}".
 *
 * The followings are the available columns in table '{{link}}':
 * @property string $id
 * @property integer $status
 * @property integer $listorder
 * @property integer $createtime
 * @property string $name
 * @property string $logo
 * @property string $siteurl
 * @property integer $typeid
 * @property integer $linktype
 * @property string $siteinfo
 */
class Link extends CActiveRecord
{
    public static $Status = array(
		'0'=>"禁用",
		'1'=>"启用",
	);
    public static $type = array(
        1 => '友情链接',
        2 => '招生服务',
        3 => '合作办学',
        4 => '非学历培训',
        5 => '资源下载',
    );
    public static $linktype = array(
        1 => '新窗口打开',
        2 => '本窗口打开',
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Link the static model class
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
		return '{{link}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, listorder, createtime, typeid, linktype', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
            array('logo',
                        'file',
                        'types'=>'jpg,jpeg,png,gif',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
			array('siteurl', 'length', 'max'=>150),
			array('siteinfo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, listorder, createtime, name, logo, siteurl, typeid, linktype, siteinfo', 'safe', 'on'=>'search'),
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
			'listorder' => '排序',
			'createtime' => '添加时间',
			'name' => '标题',
			'logo' => '标题图',
			'siteurl' => '链接',
			'typeid' => '分类',
			'linktype' => '链接分类',
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
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('createtime',$this->createtime);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('siteurl',$this->siteurl,true);
		$criteria->compare('typeid',$this->typeid);
		$criteria->compare('linktype',$this->linktype);
		$criteria->compare('siteinfo',$this->siteinfo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}