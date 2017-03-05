<?php

/**
 * This is the model class for table "{{scrollpicture}}".
 *
 * The followings are the available columns in table '{{scrollpicture}}':
 * @property integer $sp_id
 * @property string $sp_title
 * @property string $sp_picture
 * @property string $sp_link
 * @property integer $sp_order
 */
class Scrollpicture extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Scrollpicture the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	public static $sp_type = array(
        1 => '首页',
        2 => '待定',
    );
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{scrollpicture}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('sp_title, sp_type', 'required'),
                array('sp_order, sp_type', 'numerical', 'integerOnly'=>true),
                array('sp_title, sp_link', 'length', 'max'=>90),
                // The following rule is used by search().
                array('sp_picture',
                        'file',
                        'types'=>'jpg,jpeg',
                        "allowEmpty"=>true,
                        'maxSize'=>1024 * 1024 * 2, //2M max size
                        'tooLarge'=>'上传文件必须小于2M',),
                array("sp_link",
                        "url",
                        "allowEmpty"=>true,
                ),
                // Please remove those attributes that should not be searched.
				array('sp_id, sp_title, sp_picture, sp_link, sp_order, sp_type', 'safe', 'on'=>'search'),
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
                'sp_id' => 'ID',
                'sp_title' => '标题',
                'sp_picture' => '图片地址',
                'sp_link' => '链接地址',
                'sp_order' => '显示顺序',
				'sp_type' => '类型',
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

        $criteria->compare('sp_id',$this->sp_id);

        $criteria->compare('sp_title',$this->sp_title,true);

        $criteria->compare('sp_picture',$this->sp_picture,true);

        $criteria->compare('sp_link',$this->sp_link,true);

        $criteria->compare('sp_order',$this->sp_order);

		$criteria->compare('sp_type',$this->sp_type);
		
        $criteria->order = "sp_order";
        return new CActiveDataProvider(get_class($this), array(
                        'criteria'=>$criteria,
        ));
    }
}