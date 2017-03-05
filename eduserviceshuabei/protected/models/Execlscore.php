<?php

/**
 * This is the model class for table "{{execlscore}}".
 *
 * The followings are the available columns in table '{{execlscore}}':
 * @property integer $es_id
 * @property string $es_stuid
 * @property string $es_name
 * @property string $es_pici
 * @property string $es_zy
 * @property string $es_cardnumber
 * @property string $es_qiandao
 * @property string $es_score
 * @property string $es_kaodian
 * @property string $es_kaochangbianhao
 * @property string $es_kemu
 */
class Execlscore extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Execlscore the static model class
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
		return '{{execlscore}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('es_stuid', 'length', 'max'=>12),
			array('es_name', 'length', 'max'=>30),
			array('es_pici, es_score', 'length', 'max'=>20),
			array('es_zy', 'length', 'max'=>100),
            array('es_execlname', 'length', 'max'=>200),
			array('es_cardnumber, es_qiandao, es_kaochangbianhao', 'length', 'max'=>20),
			array('es_kaodian, es_kemu', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('es_id, es_stuid, es_name, es_pici, es_zy, es_cardnumber, es_qiandao, es_score, es_kaodian, es_kaochangbianhao, es_kemu', 'safe', 'on'=>'search'),
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
			'es_id' => 'Es',
			'es_stuid' => 'Es Stuid',
			'es_name' => 'Es Name',
			'es_pici' => 'Es Pici',
			'es_zy' => 'Es Zy',
			'es_cardnumber' => 'Es Cardnumber',
			'es_qiandao' => 'Es Qiandao',
			'es_score' => 'Es Score',
			'es_kaodian' => 'Es Kaodian',
			'es_kaochangbianhao' => 'Es Kaochangbianhao',
			'es_kemu' => 'Es Kemu',
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

		$criteria->compare('es_id',$this->es_id);
		$criteria->compare('es_stuid',$this->es_stuid,true);
		$criteria->compare('es_name',$this->es_name,true);
		$criteria->compare('es_pici',$this->es_pici,true);
		$criteria->compare('es_zy',$this->es_zy,true);
		$criteria->compare('es_cardnumber',$this->es_cardnumber,true);
		$criteria->compare('es_qiandao',$this->es_qiandao,true);
		$criteria->compare('es_score',$this->es_score,true);
		$criteria->compare('es_kaodian',$this->es_kaodian,true);
		$criteria->compare('es_kaochangbianhao',$this->es_kaochangbianhao,true);
		$criteria->compare('es_kemu',$this->es_kemu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}