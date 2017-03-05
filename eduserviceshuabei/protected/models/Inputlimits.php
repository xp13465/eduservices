<?php

/**
 * This is the model class for table "{{inputlimits}}".
 *
 * The followings are the available columns in table '{{inputlimits}}':
 * @property integer $il_id
 * @property integer $il_pc
 * @property integer $il_uid
 * @property integer $il_limit
 * @property integer $il_addid
 * @property integer $il_editid
 * @property integer $il_addtime
 * @property integer $il_edittime
 */
class Inputlimits extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inputlimits the static model class
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
		return '{{inputlimits}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('il_pc, il_uid, il_limit, il_addid, il_editid, il_addtime, il_edittime', 'required'),
			array('il_pc, il_uid, il_limit, il_addid, il_editid, il_addtime, il_edittime', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('il_id, il_pc, il_uid, il_limit, il_addid, il_editid, il_addtime, il_edittime', 'safe', 'on'=>'search'),
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
			'il_id' => 'ID',
			'il_pc' => '限制批次',
			'il_uid' => '限制帐号',
			'il_limit' => '限制数量',
			'il_addid' => '添加用户',
			'il_editid' => '修改用户',
			'il_addtime' => '添加时间',
			'il_edittime' => '修改时间',
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

		$criteria->compare('il_id',$this->il_id);
		$criteria->compare('il_pc',$this->il_pc);
		$criteria->compare('il_uid',$this->il_uid);
		$criteria->compare('il_limit',$this->il_limit);
		$criteria->compare('il_addid',$this->il_addid);
		$criteria->compare('il_editid',$this->il_editid);
		$criteria->compare('il_addtime',$this->il_addtime);
		$criteria->compare('il_edittime',$this->il_edittime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getPiCi($uid='',$thispc=''){
        
        $Array=array();
        if($thispc)$Array[]=$thispc;
        for($i=-1;$i<2;$i++){
            $str=$i<0?" {$i} year":"+ {$i} year";
            $date1=date("y",strtotime($str))."03";
            $date2=date("y",strtotime($str))."09";
            if($uid&&$usermodel=User::model()->getUserInfoById($uid)){
                $num1=$this->count("il_pc ='{$date1}' and il_uid='{$uid}' ");
                if($num1==0)$Array[$date1]=$date1;
            }else{ 
                $Array[$date1]=$date1;
            }
            if($uid&&$usermodel=User::model()->getUserInfoById($uid)){
                $num2=$this->count("il_pc ='{$date2}' and il_uid='{$uid}' ");
                if($num2==0)$Array[$date2]=$date2;
            }else{ 
                $Array[$date2]=$date2;
            }
        }
        return $Array;
    }
}