<?php
/**
 * This is the model class for table "{{seotkd}}".
 *
 * The followings are the available columns in table '{{seotkd}}':
 * @property integer $stkd_id
 * @property integer $stkd_position
 * @property string $stkd_title
 * @property string $stkd_keyword
 * @property string $stkd_dec
 */
class Seotkd extends CActiveRecord
{
    public static $position = array(
        1=>'网站首页 ---------',
        2=>'列表页 --------- ',
        3=>'详细页 --------- ',
    );
    /**
     * Returns the static model of the specified AR class.
     * @return Seotkd the static model class
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
        return '{{seotkd}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stkd_id, stkd_title, stkd_keyword, stkd_dec', 'required'),
            array('stkd_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('stkd_id,stkd_title, stkd_keyword, stkd_dec', 'safe', 'on'=>'search'),
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
            'stkd_id' => 'ID',
            'stkd_title' => '标题',
            'stkd_keyword' => '关键字',
            'stkd_dec' => '描述',
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

        $criteria->compare('stkd_id',$this->stkd_id);

        $criteria->compare('stkd_title',$this->stkd_title,true);

        $criteria->compare('stkd_keyword',$this->stkd_keyword,true);

        $criteria->compare('stkd_dec',$this->stkd_dec,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * 循环获取帐户所属机构
     * @param integer $intPosition 分类ID
     * @return string 分类名称
     */
    public function getPosition($intPosition) {
        $positionName = "";
        if(key_exists($intPosition, self::$position)){
            $positionName = self::$position[$intPosition];
        }
        return $positionName;
    }
} 
?>
