<?php

/**
 * This is the model class for table "{{students}}".
 *
 * The followings are the available columns in table '{{students}}':
 * @property string $s_id
 * @property integer $s_status
 * @property integer $s_statustime
 * @property integer $s_userid
 * @property string $s_name
 * @property integer $s_sex
 * @property string $s_headerimg
 * @property integer $s_credentialstype
 * @property string $s_credentialsnumber
 * @property string $s_credentialsimg1
 * @property string $s_credentialsimg2
 * @property integer $s_birthdate
 * @property string $s_birthaddress
 * @property integer $s_nationality
 * @property integer $s_politicalstatus
 * @property integer $s_highesteducation
 * @property string $s_phone
 * @property string $s_email
 * @property integer $s_baokaocengci
 * @property integer $s_baokaozhuanye
 * @property integer $s_zhiyezhuangkuang
 * @property integer $s_hunyinzhuangkuang
 * @property string $s_familyaddress
 * @property string $s_gongzuodanwei
 * @property string $s_youbian
 * @property string $s_contactaddress
 * @property string $s_tel
 * @property string $s_sfromaddress
 * @property integer $s_sfromtype
 * @property integer $s_cjgztime
 * @property string $s_oldschool
 * @property string $s_oldschoolcode
 * @property string $s_oldzhuanye
 * @property integer $s_oldtime
 * @property string $s_oldimg
 * @property string $s_oldimgnumber
 * @property string $s_file
 * @property string $s_beizhu
 * @property integer $s_enrollment
 * @property integer $s_study
 * @property integer $s_addid
 * @property integer $s_addtime
 * @property integer $s_editid
 * @property integer $s_edittime
 * @property integer $s_sleavetype
 */
class Students extends CActiveRecord
{
	public static $sex=array(
		"1"=>"男",
		"0"=>"女",
	);
	public static $credentialstype=array(
		"1"=>"身份证",
		"2"=>"军官证",
		"3"=>"护照",
		"4"=>"港、澳、台居民证件",
		"5"=>"其他",
	);
	public static $highesteducation=array(
		"1"=>"高中（职高、中专、技校等同等学历）",
		"2"=>"专科",
		"3"=>"本科",
		"4"=>"研究生",
		"5"=>"其他",
	);
	public static $profession=array(
		"1"=>"在职、就业",
		"2"=>"失业、待业",
	);
	public static $marital=array(
		"1"=>"已婚",
		"2"=>"未婚",
	
	);
	public static $enrollment=array(
		"1"=>"测试",
		"2"=>"免试",
	);
	public static $study=array(
		"1"=>"正式生",
		// "2"=>"进修生",
	
	);
	public static $status=array(
		"1"=>"待审核",
		"2"=>"已审核",
		"3"=>"驳回",
	);
    public static $bdtype = array(
		'1'=>"录入未分配",
		'2'=>"异地",
        '3'=>"本地",
	);
    public static $stype=array(
		"1"=>"本站",
		"2"=>"北航",
	
	);
    public static $zjtype=array(
        "0"=>"",
		"1"=>"居住证",
		"2"=>"房产证",
		"3"=>"社保证明",
		"4"=>"本省身份证",
	);
    public static $txtype = array( //s_sleavetype
        "1"=>"不退学",
        "2"=>"退学",
    );
    public static $smtype = array( //s_sleavetype
        "1"=>"所有",
        "2"=>"录入",
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Students the static model class
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
		return '{{students}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('s_zsbzm, s_oldimg, s_headerimg, s_name, s_credentialstype, s_credentialsnumber, s_credentialsimg1, s_credentialsimg2, s_birthdate, s_birthaddress, s_nationality, s_politicalstatus, s_highesteducation, s_phone, s_email, s_baokaocengci, s_baokaozhuanye, s_zhiyezhuangkuang, s_contactaddress', 'required',"message"=>"{attribute} 是必填项"),
			array('s_idbd, s_zjtype, s_stype, s_status, s_statustime, s_userid, s_sex, s_credentialstype, s_birthdate, s_nationality, s_politicalstatus, s_highesteducation, s_baokaocengci, s_baokaozhuanye, s_zhiyezhuangkuang, s_hunyinzhuangkuang, s_sfromtype, s_cjgztime, s_oldtime, s_enrollment, s_study, s_addid, s_addtime, s_editid, s_edittime , s_sleavetype', 'numerical', 'integerOnly'=>true),
			array('s_pc,s_rpc, s_phone, s_tel, s_oldimgnumber', 'length', 'max'=>50),
			array('s_statusabout, s_headerimg, s_credentialsimg1, s_credentialsimg2, s_birthaddress, s_oldschool, s_zsbzm, s_oldimg, s_file', 'length', 'max'=>200),
			array('s_name, s_credentialsnumber, s_sfromaddress, s_oldzhuanye', 'length', 'max'=>100),
			array('s_email', 'length', 'max'=>80),
            array('s_phone', 'existTelephone'),
            array('s_credentialsnumber', 'existCredentialsnumber'),
			array('s_familyaddress, s_gongzuodanwei, s_contactaddress', 'length', 'max'=>300),
			array('s_youbian, s_oldschoolcode', 'length', 'max'=>20),
			array('s_beizhu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('s_id, s_pc,s_zjtype, s_status, s_statustime, s_statusabout, s_userid, s_name, s_sex, s_headerimg, s_credentialstype, s_credentialsnumber, s_credentialsimg1, s_credentialsimg2, s_birthdate, s_birthaddress, s_nationality, s_politicalstatus, s_highesteducation, s_phone, s_email, s_baokaocengci, s_baokaozhuanye, s_zhiyezhuangkuang, s_hunyinzhuangkuang, s_familyaddress, s_gongzuodanwei, s_youbian, s_contactaddress, s_tel, s_sfromaddress, s_sfromtype, s_cjgztime, s_oldschool, s_oldschoolcode, s_oldzhuanye, s_oldtime, s_zsbzm, s_oldimg, s_oldimgnumber, s_file, s_beizhu, s_enrollment, s_study, s_addid, s_addtime, s_editid, s_edittime, s_sleavetype', 'safe', 'on'=>'search'),
		);
	}
    public function existTelephone(){
    
        $str=isset($this->s_id)&&$this->s_id?" and s_id !='{$this->s_id}'":'';
		$model=Students::model()->find("LOWER(s_phone)=? and s_isdel=1 and s_stype=1 and (s_status =2 or s_status =1) {$str}",array(strtolower(trim($this->s_phone))) );
        if($model ){
            $this->addError('s_phone', '该电话号码已存在！');
        }
    }
    public function existCredentialsnumber(){
        $str=isset($this->s_id)&&$this->s_id?" and s_id !='{$this->s_id}'":'';
        $model=Students::model()->find("LOWER(s_credentialsnumber)=? and s_stype=1 and s_isdel=1 and (s_status =2 or s_status =1) {$str}",array(strtolower(trim($this->s_credentialsnumber))));
        $id=Yii::app()->user->id;
        $user=User::model()->findByPk($id);
        $checkArr=$user->user_sfqz?explode(",",$user->user_sfqz):array();
        $sfcode=substr(strtolower(trim($this->s_credentialsnumber)),0,2);
        $valid=true;
        if(Yii::app()->user->role!="4"&&$checkArr&&!in_array($sfcode,$checkArr)){
            $valid = false;
            break;
        }
        if($model)
        $valid = false;if(!$valid ){
            $this->addError('s_credentialsnumber', '该身份证号已存在！');
        }
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        return array(
         'manageinfo' => array(self::BELONGS_TO, 'StudentsManage', '', 'on' => 't.s_id=manageinfo.sm_sid'),
        );
	}

    /*
    @s_rpc入学批次优化执行缓存方法
    */
    public function getSrpc(){    
        $return=Yii::app()->cache->get("srpc_title");
        if($return==false){
        $criteria = new CDbCriteria;
        $criteria->select='s_rpc';
        $criteria->group='s_rpc';
        $model=$this->findAll($criteria);
        $return=array();
        foreach($model as $val)$return[$val->s_rpc?$val->s_rpc:"999"]=$val->s_rpc?$val->s_rpc:"无批次";
        Yii::app()->cache->set("srpc_title",$return,Yii::app()->params->cacheTime);
        }
        return $return;
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			's_id' => 'ID',
			's_pc' => '批次',
			's_status' => '审核状态',
			's_statustime' => '审核时间',
			's_statusabout' => '审核备注',
			's_userid' => '用户ID',
			's_name' => '姓名',
			's_sex' => '性别',
			's_headerimg' => '照片',
			's_credentialstype' => '证件类型',
			's_credentialsnumber' => '证件号码',
			's_credentialsimg1' => '证件照（正面）',
			's_credentialsimg2' => '证件照（反面）',
			's_birthdate' => '出生日期',
			's_birthaddress' => '出生地',
			's_nationality' => '民族',
			's_politicalstatus' => '政治面貌',
			's_highesteducation' => '最高学历',
			's_phone' => '手机',
			's_email' => '邮箱',
			's_baokaocengci' => '报考层次',
			's_baokaozhuanye' => '报考专业',
			's_zhiyezhuangkuang' => '职业状况',
			's_hunyinzhuangkuang' => '婚姻状况',
			's_familyaddress' => '家庭地址',
			's_gongzuodanwei' => '工作单位',
			's_youbian' => '邮编',
			's_contactaddress' => '通讯地址',
			's_tel' => '联系电话',
			's_sfromaddress' => '生源地',
			's_sfromtype' => '生源类型',
			's_cjgztime' => '参加工作时间',
			's_oldschool' => '原毕业学校',
			's_oldschoolcode' => '原毕业学校代码',
			's_oldzhuanye' => '原毕业专业',
			's_oldtime' => '原毕业时间',
			's_zsbzm' => '专升本证明',
			's_oldimg' => '毕业证书',
			's_oldimgnumber' => '院毕业证书编号',
			's_file' => '附件',
			's_beizhu' => '备注',
			's_enrollment' => '入学方式',
			's_study' => '学习类型',
			's_addid' => '添加用户',
			's_addtime' => '添加时间',
			's_editid' => '最后修改',
			's_edittime' => '修改时间',
            's_sleavetype' => '退学'
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

		$criteria->compare('s_id',$this->s_id,true);
		$criteria->compare('s_pc',$this->s_pc,true);
		$criteria->compare('s_status',$this->s_status);
		$criteria->compare('s_statustime',$this->s_statustime);
		$criteria->compare('s_statusabout',$this->s_statusabout,true);
		$criteria->compare('s_userid',$this->s_userid);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('s_sex',$this->s_sex);
		$criteria->compare('s_headerimg',$this->s_headerimg,true);
		$criteria->compare('s_credentialstype',$this->s_credentialstype);
		$criteria->compare('s_credentialsnumber',$this->s_credentialsnumber,true);
		$criteria->compare('s_credentialsimg1',$this->s_credentialsimg1,true);
		$criteria->compare('s_credentialsimg2',$this->s_credentialsimg2,true);
		$criteria->compare('s_birthdate',$this->s_birthdate);
		$criteria->compare('s_birthaddress',$this->s_birthaddress,true);
		$criteria->compare('s_nationality',$this->s_nationality);
		$criteria->compare('s_politicalstatus',$this->s_politicalstatus);
		$criteria->compare('s_highesteducation',$this->s_highesteducation);
		$criteria->compare('s_phone',$this->s_phone,true);
		$criteria->compare('s_email',$this->s_email,true);
		$criteria->compare('s_baokaocengci',$this->s_baokaocengci);
		$criteria->compare('s_baokaozhuanye',$this->s_baokaozhuanye);
		$criteria->compare('s_zhiyezhuangkuang',$this->s_zhiyezhuangkuang);
		$criteria->compare('s_hunyinzhuangkuang',$this->s_hunyinzhuangkuang);
		$criteria->compare('s_familyaddress',$this->s_familyaddress,true);
		$criteria->compare('s_gongzuodanwei',$this->s_gongzuodanwei,true);
		$criteria->compare('s_youbian',$this->s_youbian,true);
		$criteria->compare('s_contactaddress',$this->s_contactaddress,true);
		$criteria->compare('s_tel',$this->s_tel,true);
		$criteria->compare('s_sfromaddress',$this->s_sfromaddress,true);
		$criteria->compare('s_sfromtype',$this->s_sfromtype);
		$criteria->compare('s_cjgztime',$this->s_cjgztime);
		$criteria->compare('s_oldschool',$this->s_oldschool,true);
		$criteria->compare('s_oldschoolcode',$this->s_oldschoolcode,true);
		$criteria->compare('s_oldzhuanye',$this->s_oldzhuanye,true);
		$criteria->compare('s_oldtime',$this->s_oldtime);
		$criteria->compare('s_zsbzm',$this->s_zsbzm,true);
		$criteria->compare('s_oldimg',$this->s_oldimg,true);
		$criteria->compare('s_oldimgnumber',$this->s_oldimgnumber,true);
		$criteria->compare('s_file',$this->s_file,true);
		$criteria->compare('s_beizhu',$this->s_beizhu,true);
		$criteria->compare('s_enrollment',$this->s_enrollment);
		$criteria->compare('s_study',$this->s_study);
		$criteria->compare('s_addid',$this->s_addid);
		$criteria->compare('s_addtime',$this->s_addtime);
		$criteria->compare('s_editid',$this->s_editid);
		$criteria->compare('s_edittime',$this->s_edittime);
        $criteria->compare('s_sleavetype',$this->s_sleavetype);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 通过身份证号获取相应的出生年月
     * @param integer $IDCard  身份证号
     * @return string or object 字段数据或数据记录一条
     */
	function getIDCardInfo($IDCard){
		if(strlen($IDCard)==18){
		   $tyear=(substr($IDCard,6,4));
		   $tmonth=(substr($IDCard,10,2));
		   $tday=(substr($IDCard,12,2));
		   $tdate=$tyear."".$tmonth."".$tday."";
		}elseif(strlen($IDCard)==15){
		   $tyear=("19".substr($IDCard,6,2));
		   $tmonth=(substr($IDCard,8,2));
		   $tday=(substr($IDCard,10,2));
		   $tdate=$tyear."".$tmonth."".$tday."";
		}else{
            $tdate='';
        }
		 
		 return $tdate;
	}
    /**
     * 通过ID获取相应的数据值
     * @param integer $id 学员ID
     * @param string $field 字段名称
     * @return string or object字段数据或数据记录一条
     */
    function getNameById($id,$field='s_name'){
        $return='';
        $cacheTime=Yii::app()->params->cacheTime;
        if($id){
            $return=@Yii::app()->cache->get("student_{$field}_{$id}");
            if($return==false){
                $criteria=new CDbCriteria;
                if($field)$criteria->select=$field;
                $criteria->addCondition("s_id = '{$id}'");
                $umodel = $this->find($criteria);
                $return=$umodel?$field?$umodel->$field:$umodel:"";
                Yii::app()->cache->set("student_{$field}_{$id}",$return,$cacheTime);
            }
        }
        return $return;
    } 
    /**
     * 用身份证号码经过网络验证得到对应数组
     * @param integer $cardNumber 身份证号码
     * @return array 身份证数据数组
     */
    function getCardInfoByWeb($cardNumber){
        $sfjsoncode=Yii::app()->cache->get("sfcode_{$cardNumber}");
        if($sfjsoncode==false){
            $sfcode=@simplexml_load_file("http://www.youdao.com/smartresult-xml/search.s?type=id&q={$cardNumber}");
            $array=array();
            if($sfcode){
                foreach($sfcode as $tmp){
                    $array['birthday']=$tmp->birthday;
                    $array['location']=$tmp->location;
                    $array['code']=$tmp->code;
                    $array['sex']=$tmp->gender=='m'?1:0;
                }
            }
            Yii::app()->cache->set("sfcode_{$cardNumber}",json_encode($array),Yii::app()->params->cacheTime);
        }else{
            $array=json_decode($sfjsoncode);
        }
        return $array;
    }
    /**
     * 统计人数
     * @param array $Uarr 录入员ID
     * @return smtype 类型  1录入  2管理
     * @return status 状态  1，2，3
     * @return integer $returnNum 人数
     */
    function getNum($Uarr,$smtype=1,$status=1,$pici=""){
        if(!$Uarr)return 0;
        $criteria=new CDbCriteria;
        $criteria->addInCondition('s_addid', $Uarr);
        if($pici)$criteria->addCondition("s_rpc  = '{$pici}' ");
        $criteria->addCondition("s_isdel  = '1' ");
        $criteria->join=" left join es_students_manage on s_id=sm_sid ";
        if($smtype==2){
            $criteria->addCondition("s_status ='{$status}'");
            $criteria->addCondition("sm_id is NULL");
            
        }elseif($smtype==1){
            $criteria->addCondition("sm_status ='{$status}'");
            $criteria->addCondition("sm_id is not NULL");
        }
        $returnNum=Students::model()->count($criteria);
        return $returnNum;
    }
}