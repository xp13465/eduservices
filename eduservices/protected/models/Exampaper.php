<?php

/**
 * This is the model class for table "{{exampaper}}".
 *
 * The followings are the available columns in table '{{exampaper}}':
 * @property integer $e_id
 * @property string $e_name
 * @property string $e_cat
 * @property integer $e_display
 * @property integer $e_maxenum
 * @property integer $e_btime
 * @property integer $e_etime
 * @property string $e_timecat
 * @property string $e_treap
 * @property string $e_tsecurity
 * @property string $e_esecurity
 * @property string $e_edescription
 * @property integer $e_snum
 * @property integer $e_scat
 * @property string $e_rpeople
 * @property string $e_scoreset
 * @property string $e_pstrategy
 * @property string $e_totals
 * @property string $e_passs
 * @property integer $e_use
 * @property integer $e_isdel
 */
class Exampaper extends CActiveRecord
{
    public $t_qid;
    // public $t_qid;
    // public $t_qid;
    
    public static $display=array(
        "1"=>"一屏显示所有题目",
        "2"=>"一屏显示一道题目",
        "3"=>"一屏显示一种题目",
    );
    
    public static $use=array(
        "1"=>"启用",
        "2"=>"停用",
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Exampaper the static model class
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
		return '{{exampaper}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('e_display, e_maxenum, e_btime, e_etime, e_snum, e_scat, e_use, e_isdel, e_cc, e_ktype,e_totals,e_passs', 'numerical', 'integerOnly'=>true),
            array('e_name,e_display,e_btime, e_etime, e_maxenum,e_timecat,e_totals,e_passs', 'required','message'=>'{attribute} 是必填项'),
			array('e_name', 'length', 'max'=>300),
			array('e_cat, e_esecurity, e_totals, e_passs', 'length', 'max'=>100),
			array('e_timecat', 'length', 'max'=>50),
			array('e_treap, e_tsecurity, e_edescription', 'length', 'max'=>1000),
            array('e_note', 'length', 'max'=>3000),
			array('e_rpeople', 'length', 'max'=>200),
			array('e_scoreset, e_pstrategy', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('e_id, e_name, e_cat, e_display, e_maxenum, e_btime, e_etime, e_timecat, e_treap, e_tsecurity, e_esecurity, e_edescription, e_snum, e_scat, e_rpeople, e_scoreset, e_pstrategy, e_totals, e_passs', 'safe', 'on'=>'search'),
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
			'e_id' => 'ID',
			'e_name' => '试卷名称',
			'e_cat' => '试卷类型',
			'e_display' => '显示方式',
			'e_maxenum' => '最多考试次数',
			'e_btime' => '开始有效时间',
			'e_etime' => '结束有效时间',
			'e_timecat' => '考试计时选项',
			'e_treap' => '防舞弊',
			'e_tsecurity' => '考试安全',
			'e_esecurity' => '试卷安全',
			'e_edescription' => '试卷说明',
			'e_snum' => '顺序号',
			'e_scat' => '考生',
			'e_rpeople' => '评卷人',
			'e_scoreset' => '题型与分数设置',
			'e_pstrategy' => '试卷策略',
			'e_totals' => '总分',
			'e_passs' => '及格分',
            'e_use' => '是否启用',
            'e_isdel' => '是否删除',
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

		$criteria->compare('e_id',$this->e_id);
		$criteria->compare('e_name',$this->e_name,true);
		$criteria->compare('e_cat',$this->e_cat,true);
		$criteria->compare('e_display',$this->e_display);
		$criteria->compare('e_maxenum',$this->e_maxenum);
		$criteria->compare('e_btime',$this->e_btime);
		$criteria->compare('e_etime',$this->e_etime);
		$criteria->compare('e_timecat',$this->e_timecat,true);
		$criteria->compare('e_treap',$this->e_treap,true);
		$criteria->compare('e_tsecurity',$this->e_tsecurity,true);
		$criteria->compare('e_esecurity',$this->e_esecurity,true);
		$criteria->compare('e_edescription',$this->e_edescription,true);
		$criteria->compare('e_snum',$this->e_snum);
		$criteria->compare('e_scat',$this->e_scat);
		$criteria->compare('e_rpeople',$this->e_rpeople,true);
		$criteria->compare('e_scoreset',$this->e_scoreset,true);
		$criteria->compare('e_pstrategy',$this->e_pstrategy,true);
		$criteria->compare('e_totals',$this->e_totals,true);
		$criteria->compare('e_passs',$this->e_passs,true);
        $criteria->compare('e_use',$this->e_use);
        $criteria->compare('e_use',$this->e_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    
    /**
     * 通过ID获取相应的数据值
     * @param integer $eid 试卷ID
     * @param string $field 字段名称
     * @return string or object字段数据或数据记录一条
     */
    public function getExamName($eid='',$field='e_name'){
        $return='';
        $cacheTime=Yii::app()->params->cacheTime;
        if($eid){
            $return=@Yii::app()->cache->get("exampaper_{$field}_{$eid}");
            if($return==false){
                $criteria=new CDbCriteria;
                if($field)$criteria->select=$field;
                $criteria->addCondition("e_id ='{$eid}'");
                $umodel = $this->find($criteria);
                $return=$umodel?$field?$umodel->$field:$umodel:"";
                Yii::app()->cache->set("exampaper_{$field}_{$eid}",$return,$cacheTime);
            }
        }
        return $return;
    }
    public function getAllExam(){
        $criteria = new CDbCriteria;
        $criteria->addCondition("e_btime<=".time());        
        $criteria->addCondition("e_etime>=".time());  
        $criteria->addCondition("e_use = 1 and e_isdel = 1");            
        $criteria->select = "e_id,e_name";
        $models = $this->findAll($criteria);
        $array=array();
        foreach($models as $key=>$val){
            $array[$val->e_id]=$val->e_name;
        }
        return $array;
    }  
    
}