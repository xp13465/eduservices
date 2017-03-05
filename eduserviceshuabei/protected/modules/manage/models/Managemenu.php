<?php

/**
 * This is the model class for table "{{managemenu}}".
 *
 * The followings are the available columns in table '{{managemenu}}':
 * @property integer $m_id
 * @property string $m_name
 * @property string $m_link
 * @property integer $m_parentid
 */
class Managemenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Managemenu the static model class
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
		return '{{managemenu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('m_id, m_parentid', 'numerical', 'integerOnly'=>true),
			array('m_name', 'length', 'max'=>100),
			array('m_link', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('m_id, m_name, m_link, m_parentid,m_role', 'safe', 'on'=>'search'),
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
            'm_id' => '主键',
			'm_name' => '名称',
            'm_link' => '链接地址',
			'm_parentid' => '父类Id',
            'm_role' => '授权角色',
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

		$criteria->compare('m_id',$this->m_id);

		$criteria->compare('m_name',$this->m_name,true);

		$criteria->compare('m_link',$this->m_link,true);

		$criteria->compare('m_parentid',$this->m_parentid);
        $criteria->compare('m_role',$this->m_role);
        if($this->m_role)
        $criteria->addCondition("find_in_set({$this->m_role},m_role) ");
        
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}