<?php

/**
 * This is the model class for table "{{information}}".
 *
 * The followings are the available columns in table '{{information}}':
 * @property integer $i_id
 * @property integer $i_class
 * @property string $i_label
 * @property string $i_title
 * @property string $i_pic
 * @property string $i_con
 * @property integer $i_click
 * @property integer $i_bool
 * @property integer $i_submitdate
 * @property integer $i_updatetime
 * @property string $i_form
  * @property string $i_editform
 * @property string $i_author
 * @property string $i_isdel  
 */
class Information extends CActiveRecord
{
    public static $class=array(
        "1"=>"网院快讯",
        "2"=>"教学教务",
        "3"=>"讲座公告",
        "4"=>"招生服务",
        "5"=>"网站公告",
    );
    public static $isbool=array(
        "0"=>"否",
        "1"=>"是",
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Information the static model class
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
		return '{{information}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_class, i_title, i_con', 'required'),
			array('i_class, i_click, i_bool, i_submitdate, i_updatetime, i_isdel', 'numerical', 'integerOnly'=>true),
			array('i_label', 'length', 'max'=>100),
            array('i_pic',
                        'file',
                        'types'=>'jpg,jpeg,png,gif',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
			array('i_title, i_form, i_editform, i_author', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('i_id, i_class, i_label, i_title, i_pic, i_con, i_click, i_bool, i_submitdate, i_updatetime, i_editform, i_form, i_author, i_isdel', 'safe', 'on'=>'search'),
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
			'i_id' => 'ID',
			'i_class' => '分类',
			'i_label' => '标签',
			'i_title' => '标题',
			'i_pic' => '标题图',
			'i_con' => '详细',
			'i_click' => '点击量',
			'i_bool' => '是否推荐',
			'i_submitdate' => '提交时间',
			'i_updatetime' => '修改时间',
			'i_form' => '来源', 
            'i_editform' => '最后修改人',
			'i_author' => '作者',
            'i_isdel' => '回收站',
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

		$criteria->compare('i_id',$this->i_id);
		$criteria->compare('i_class',$this->i_class);
		$criteria->compare('i_label',$this->i_label,true);
		$criteria->compare('i_title',$this->i_title,true);
		$criteria->compare('i_pic',$this->i_pic,true);
		$criteria->compare('i_con',$this->i_con,true);
		$criteria->compare('i_click',$this->i_click);
		$criteria->compare('i_bool',$this->i_bool);
		$criteria->compare('i_submitdate',$this->i_submitdate);
		$criteria->compare('i_updatetime',$this->i_updatetime);
		$criteria->compare('i_form',$this->i_form,true);
        $criteria->compare('i_editform',$this->i_editform,true);
		$criteria->compare('i_author',$this->i_author,true);
        $criteria->compare('i_isdel',$this->i_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 获取新闻数据
     * @param integer $id    新闻类别ID
     * @param integer $limit 返回条数
     * @param string  $order 排序条件
     * @param boolean $ishot 是否热点
     * @param boolean $isdel 是否进入回收站
     * @return object新闻数据结果集对象
     */
    public function getAllById($id='',$limit='10',$order='i_submitdate desc',$ishot=false,$isdel='1')
	{
		$criteria=new CDbCriteria;
		if($id){
			$criteria->addCondition("i_class ='{$id}'");
		}
		if($ishot)$criteria->addCondition(" i_bool = 1 ");
        if($isdel)$criteria->addCondition(" i_isdel = 1 ");
		$criteria->limit=$limit;
		$criteria->order=$order;
		$News=$this->findAll($criteria);
		return $News;
	}
}