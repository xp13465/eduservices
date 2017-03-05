<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $user_id
 * @property string $user_name
 * @property string $user_nkname
 * @property string $user_headimg
 * @property string $user_email
 * @property string $user_webset
 * @property string $user_tel
 * @property string $user_tel2
 * @property string $user_phone
 * @property string $user_msn
 * @property string $user_adderss
 * @property string $user_qq
 * @property string $user_pwd
 * @property integer $user_role
 * @property integer $user_regtime
 * @property integer $user_loginnum
 * @property integer $user_lasttime
 * @property string $user_lastip
 * @property integer $user_online
 * @property integer $user_status
 * @property integer $user_organization
 */
class User extends CActiveRecord
{
	private $id = null;
	private $role = null;
		
	public static	$RoleName = array(
		'1'=>"机构",
		'2'=>"报名点",
		'3'=>"学习中心",
		'4'=>"监管中心",
        '5'=>"免考中心",
        '9999'=>"学员",
	);
	public static $Status = array(
		'0'=>"禁用",
		'1'=>"启用",
	);
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_role, user_regtime, user_loginnum, user_lasttime, user_online, user_status, user_organization', 'numerical', 'integerOnly'=>true),
			// array('user_name', 'unique', 'message'=>'该帐号已存在'),
			array('user_name, user_email', 'length', 'max'=>30),
            array('user_rolebz, user_sfqz, user_bddm', 'length', 'max'=>100),
			array('user_nkname, user_headimg, user_webset, user_msn, user_adderss', 'length', 'max'=>100),
			array('user_tel, user_tel2, user_phone, user_qq, user_pwd, user_lastip', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, user_nkname, user_headimg, user_email, user_webset, user_tel, user_tel2, user_phone, user_msn, user_adderss, user_qq, user_pwd, user_role, user_regtime, user_loginnum, user_lasttime, user_lastip, user_online, user_status, user_organization', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'user_name' => '用户名',
			'user_nkname' => '负责人',
			'user_headimg' => '头像',
			'user_email' => '邮箱',
			'user_webset' => '网址',
			'user_tel' => '电话',
			'user_tel2' => 'User Tel211',
			'user_phone' => 'User Phone',
			'user_msn' => 'User Msn',
			'user_adderss' => 'User Adderss',
			'user_qq' => 'User Qq',
			'user_pwd' => 'User Pwd',
			'user_role' => 'User Role',
			'user_regtime' => 'User Regtime',
			'user_loginnum' => 'User Loginnum',
			'user_lasttime' => 'User Lasttime',
			'user_lastip' => 'User Lastip',
			'user_online' => 'User Online',
			'user_status' => 'User Status',
			'user_organization' => 'User Organization',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_nkname',$this->user_nkname,true);
		$criteria->compare('user_headimg',$this->user_headimg,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_webset',$this->user_webset,true);
		$criteria->compare('user_tel',$this->user_tel,true);
		$criteria->compare('user_tel2',$this->user_tel2,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_msn',$this->user_msn,true);
		$criteria->compare('user_adderss',$this->user_adderss,true);
		$criteria->compare('user_qq',$this->user_qq,true);
		$criteria->compare('user_pwd',$this->user_pwd,true);
		$criteria->compare('user_role',$this->user_role);
		$criteria->compare('user_regtime',$this->user_regtime);
		$criteria->compare('user_loginnum',$this->user_loginnum);
		$criteria->compare('user_lasttime',$this->user_lasttime);
		$criteria->compare('user_lastip',$this->user_lastip,true);
		$criteria->compare('user_online',$this->user_online);
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('user_organization',$this->user_organization);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 获取用户ID
     * @return integer 用户ID
     */
	public function getId() {
        if(!Yii::app()->user->isGuest) {
            $this->id = Yii::app()->user->id;
        }
        return $this->id;
    }
    
    /**
     * 获取用户权限
     * @return integer 权限ID
     */
    public function getRole() {
        if(!Yii::app()->user->isGuest) {
            $this->role = Yii::app()->user->role;
        }
        return $this->role;
    }
    
    /**
     * 通过用户ID获得数据
     * @param integer $uid  用户ID
     * @param string $field  字段名称
     * @return string or object 用户表字段数据 或者 用户表结果集对象
     */
	public function getUserInfoById($uid,$field='') {
        $return=Yii::app()->cache->get("user_{$field}_{$uid}");
        if($return==false){
            $criteria=new CDbCriteria;
            if($field)$criteria->select="{$field}";
            $criteria->addCondition("user_id ='{$uid}'");
            $umodel=$this->find($criteria);
            // print_r($umodel);exit;
            $return=$field?$umodel->$field:$umodel;
            Yii::app()->cache->set("user_{$field}_{$uid}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
    }
    
    /**
     * 通过用户ID获得用户昵称
     * @param integer $uid  用户ID
     * @param boolean $type  是否显示ID
     * @return string 用户昵称
     */
	public function getUserName($uid,$type=true) {
        if(is_array($uid)){
            $return ="";
            foreach($uid as $u){
                $umodel= $this->getUserInfoById($u);
                $return.= $return?",":"";
                $return.=$umodel?$type?$umodel->user_nkname."($u)":$umodel->user_nkname:"";
            }
            return $return;
        }else{
            $umodel= $this->getUserInfoById($uid);
            return $umodel?$umodel->user_nkname:"";
        }
    }
    
    /**
     * 通过用户ID获得对应的公司名称
     * @param integer $uid  用户ID
     * @return string 公司名称  
     */
	public function getCnameByUid($uid){
        $return=Yii::app()->cache->get("user_organization_name_{$uid}");/////
        if($return==false){
            $user_organization=$this->getUserInfoById($uid,'user_organization');
            $Oname='';
            if($user_organization){
                $Oname=Organization::model()->getNameByOid($user_organization);
            }
            $return=$Oname?$Oname:'';
            Yii::app()->cache->set("user_organization_name_{$uid}",$return,Yii::app()->params->cacheTime);
        }
        return $return ;
	}
    
    /**
     * 获得对应权限的帐号数组
     * @param integer $role  权限代码
     * @return array 帐号数组 attributes (key=>user_name)
     */
	public function getManage($role) {
		$manage=array("admin","sysadmin");
        $criteria=new CDbCriteria;
        $criteria->select="user_name";
        $criteria->addCondition("user_role ='{$role}' and user_status='1' and user_isdel='1'");
        $Manages=$this->findAll($criteria);
		foreach($Manages as $val)$manage[]=$val->user_name;
		
		return $manage;
    }
    
    /**
     * 通过公司ID数组获得对应帐号数组
     * @param array $idArr  公司ID数组
     * @return array 帐号数组 attributes (key=>user_id)
     */
	public function getAllByOid($idArr) {
		$manage=array();
		if($idArr){
            $criteria=new CDbCriteria;
            $criteria->select="user_id";
            $criteria->addCondition("user_status='1'");
            $criteria->addInCondition("user_organization",$idArr);
			$Manages=$this->findAll($criteria);
			foreach($Manages as $val)$manage[]=$val->user_id;
		}
		return $manage;
    }
}