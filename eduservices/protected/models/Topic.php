<?php

/**
 * This is the model class for table "{{topic}}".
 *
 * The followings are the available columns in table '{{topic}}':
 * @property integer $t_id
 * @property integer $t_qid
 * @property string $t_know
 * @property integer $t_level
 * @property integer $t_score
 * @property integer $t_type
 * @property integer $t_validity
 * @property string $t_con
 * @property string $t_daxx
 * @property integer $t_answer
 * @property string $t_leaflet
 */
class Topic extends CActiveRecord
{
     public $questionsid;
     public $zhselect;
     public static $type=array(
        1=>"单选题",
        2=>"多选题",
        3=>"判断题",
        // 4=>"问答题",
     );     
     public static $level=array(
        1=>"1",
        2=>"2",
        3=>"3",
        4=>"4",
        5=>"5",
     );
     public static $hselect=array(
        2=>"2",
        3=>"3",
        4=>"4",
        5=>"5",
        6=>"6",
     );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Topic the static model class
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
		return '{{topic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('questionsid,t_qid, t_level, t_score, t_type', 'numerical', 'integerOnly'=>true),
            array('t_qid,t_type,t_validity,t_con','required',"message"=>"{attribute} 是必填项"),
            // array('t_score','required',"message"=>"{attribute} 不能为空"),
			array('t_know, t_answer', 'length', 'max'=>100),
			array('t_leaflet', 'length', 'max'=>1000),
			array('t_con, t_daxx', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('t_id, t_qid, t_know, t_level, t_score, t_type, t_validity, t_con, t_daxx, t_answer, t_leaflet', 'safe', 'on'=>'search'),
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
			't_id' => 'ID',
			't_qid' => '题目所属[题库表]',
			't_know' => '知识点',
			't_level' => '难度',
			't_score' => '默认分数',
			't_type' => '题目类型',
			't_validity' => '有效期',
			't_con' => '题目内容',
			't_daxx' => '题目答案选项组',
			't_answer' => '题目答案',
			't_leaflet' => '题目说明',
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

		$criteria->compare('t_id',$this->t_id);
		$criteria->compare('t_qid',$this->t_qid);
		$criteria->compare('t_know',$this->t_know,true);
		$criteria->compare('t_level',$this->t_level);
		$criteria->compare('t_score',$this->t_score);
		$criteria->compare('t_type',$this->t_type);
		$criteria->compare('t_validity',$this->t_validity);
		$criteria->compare('t_con',$this->t_con,true);
		$criteria->compare('t_daxx',$this->t_daxx,true);
		$criteria->compare('t_answer',$this->t_answer);
		$criteria->compare('t_leaflet',$this->t_leaflet,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 获取专业名称
     * @param integer $mid 题目所属类别ID
     * @retuen array 知识点列表  attributes(t_know=>t_know)
     */
    public function getAllZS($mid){
        $criteria=new CDbCriteria;
		$criteria->addCondition("t_qid ='{$mid}'");
        $criteria->group='t_know';
		$models=$this->findAll($criteria);
		return $this->toArray($models);
    
    }
    
    /**
     * 把结果集数组化
     * @param object $models  题目表结果集对象
     * @return array 知识点数组 attributes(t_know=>t_know)
     */
    public function toArray($models){
        $return =array();
        foreach($models as $val){
            $return[$val->t_know]=$val->t_know;        
        }
        return $return;
    
    }
}