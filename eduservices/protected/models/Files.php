<?php

/**
 * This is the model class for table "{{files}}".
 *
 * The followings are the available columns in table '{{files}}':
 * @property integer $f_id
 * @property integer $f_uid
 * @property string $f_url
 * @property integer $f_type
 */
class Files extends CActiveRecord
{
	public static $type=array(
		"1"=>"头像照",
		"2"=>"身份证扫描件（正面）",
		"3"=>"身份证扫描件（反面）",
		"4"=>"毕业证书",
		"5"=>"专升本证明",
		"6"=>"附件",
		"7"=>"用户头像",
        "8"=>"免考证件",
	);
	public static $fileend=array(
		"1"=>"HD",
		"2"=>"SF1",
		"3"=>"SF2",
		"4"=>"BY",
		"5"=>"ZM",
		"6"=>"F",
		"7"=>"UH",
        "8"=>"MK",
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Files the static model class
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
		return '{{files}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('f_uid, f_url', 'required'),
			array('f_uid, f_type', 'numerical', 'integerOnly'=>true),
			array('f_url', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('f_uid, f_url, f_type', 'safe', 'on'=>'search'),
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
			'f_id' => 'F',
			'f_uid' => 'F Uid',
			'f_url' => 'F Url',
			'f_type' => 'F Type',
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

		$criteria->compare('f_id',$this->f_id);
		$criteria->compare('f_uid',$this->f_uid);
		$criteria->compare('f_url',$this->f_url,true);
		$criteria->compare('f_type',$this->f_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 获取新闻数据
     * @param string $file 文件名
     * @param string $newName 新文件名
     * @param integer $tid 附件类型ID
     * @param integer $uid 所属用户ID
     * @return string or false 成功返回新文件地址 或者假
     */
	public function SaveFile($file,$newName,$tid,$uid){
		if(!$file||!$newName||!Files::$fileend[$tid])return false;
        if(!file_exists(USER_PATH.Files::$fileend[$tid])){
            mkdir(USER_PATH.Files::$fileend[$tid]);
        }
		$extend =explode("." , $file);  
		$va=count($extend)-1;  
		$newfileName=USER_PATH.Files::$fileend[$tid]."/".$newName.".".$extend[$va];
		$newfileUrl=USER_URL.Files::$fileend[$tid]."/".$newName.".".$extend[$va];
        if(DOCUMENTROOT.$file==$newfileName){
            return $newfileUrl;
        }else{
            if(file_exists(DOCUMENTROOT.$file)&&rename(DOCUMENTROOT.$file,$newfileName)){
                
                if(Files::model()->count("f_uid='{$uid}' and f_type='{$tid}' and f_uid='{$uid}'")==1){
                    $model=Files::model()->find("f_uid='{$uid}' and f_type='{$tid}' and f_uid='{$uid}'");
                }else{
                    $model=new Files;
                }
                $model->f_uid=$uid;
                $model->f_url=$newfileUrl;
                $model->f_type=$tid;
                if($model->save()){
                    // if(file_exists($newfileName)&&$newfileName!=DOCUMENTROOT.$file)unlink(DOCUMENTROOT."/".$file);
                    // echo $newfileName."<br/>".DOCUMENTROOT."/".$file;exit;
                    
                    //
                    return $newfileUrl;
                }else{
                    return false;
                }
            
            }
        }
	}
}