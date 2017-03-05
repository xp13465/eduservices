<?php

/**
 * This is the model class for table "{{emapp}}".
 *
 * The followings are the available columns in table '{{emapp}}':
 * @property integer $mk_id
 * @property integer $mk_sid
 * @property integer $mk_cardtype
 * @property string $mk_cardnumber
 * @property string $mk_cardimg
 * @property string $mk_sname
 * @property integer $mk_sex
 * @property integer $mk_ethnic
 * @property string $mk_sdgx
 * @property string $mk_xh
 * @property integer $mk_specialty
 * @property string $mk_moblie
 * @property string $mk_tel
 * @property string $mk_subject
 * @property string $mk_reason
 * @property string $mk_ksadder
 * @property string $mk_file
 * @property integer $mk_addid
 * @property integer $mk_addtime
 * @property integer $mk_editid
 * @property integer $mk_editime
 * @property integer $mk_status
 * @property integer $mk_statustime
 * @property integer $mk_statusabout
 * @property integer $mk_isdel
 * @property integer $mk_deltime
 * @property string $mk_zkznum
 * @property string $mk_zjnum
 */
class Emapp extends CActiveRecord
{

    public static $subject=array(
		1=>"大学英语B",
		2=>"计算机应用基础",
	);
    public static $status=array(
		1=>"待审核",
		2=>"通过",
        3=>"驳回",
	);
	public static $credentialstype=array(
		"1"=>"身份证",
		"2"=>"军官证",
		"3"=>"护照",
		"4"=>"港、澳、台居民证件",
		"5"=>"其他",
	);
    
    public static $arrsex=array(1=>'男',0=>'女');
    public static $arrreason=array(
          1=>"已具有国民教育系列本科以上学历（含本科）",
          2=>"非计算机类专业,获得全国计算机等级考试一级B或以上级别证书",
          3=>"非英语专业,获得大学英语等级考试CET四级或以上级别证书",
          4=>"非英语专业,获得全国公共英语等级考试PETS三级或以上级别证书",
          5=>"非英语专业,省级教育行政部门组织的成人教育学位英语考试合格证书",
          6=>"非英语专业,入学注册时年龄满40周岁",
          7=>"非英语专业,户籍(以身份证的为准)在少数民族聚居地区的少数民族学生"
    );
    public static $textarr=array(
            "非英语专业,获得全国公共英语等级考试PETS三级或以上级别证书",
            "非英语专业,省级教育行政部门组织的成人教育学位英语考试合格证书",
            "非英语专业,入学注册时年龄满40周岁",
            "非英语专业,户籍(以身份证的为准)在少数民族聚居地区的少数民族学生",
            "日语专业,获得日本语能力测试(JLPT)三级或以上级别证书",
            "日语专业,获得日语专业四级或八级证书",
            "公共外语为日语,获得日本语能力测试(JLPT)四级或以上级别证书",
            "公共外语为日语,获得大学日语四级证书",
            "公共外语为俄语,获得大学俄语四级证书",
            "已参加统考，且成绩通过"
        );
    //计算机的证书报考年分数组
    public static $arrjsjksnf=array(
            "2862"=>"2013年9月",
            "2622"=>"2013年3月",
            "2402"=>"2012年9月",
            "2240"=>"2012年3月",
            "2080"=>"2011年9月",
            "1821"=>"2011年3月",
            "1680"=>"2010年9月",
            "1480"=>"2010年3月",
            "1202"=>"2009年9月",
            "1020"=>"2009年3月",
            "620"=>"2008年9月",
            "520"=>"2008年4月",
            "480"=>"2007年9月",
            "560"=>"2007年4月",
            "660"=>"2006年9月",
            "1342"=>"2006年4月",
            "1341"=>"2005年9月",
            "1340"=>"2005年4月",
            "1360"=>"2004年9月",
            "1361"=>"2004年4月",
            "1362"=>"2003年9月",
            "1363"=>"2003年4月",
            "1520"=>"2002年9月",
            "1521"=>"2002年4月",
            "1522"=>"2001年9月",
            "1523"=>"2001年4月",
            "1545"=>"2000年9月",
            "1544"=>"2000年4月",
            "1524"=>"1999年9月",
            "1525"=>"1999年4月",
            "1526"=>"1998年9月",
            "1527"=>"1998年4月",
            "1528"=>"1997年9月",
            "1529"=>"1997年4月",
            "1530"=>"1996年9月",
            "1531"=>"1996年4月",
            "1532"=>"1995年",
            "1533"=>"1994年" 
          
    );
    
    
    //英证免考试证书的报考年分数组
     public static $arrengksnf=array(
            "2842"=>"2013年9月",
            "2602"=>"2013年3月",
            "2382"=>"2012年9月",
            "2220"=>"2012年3月",
            "2060"=>"2011年9月",
            "1820"=>"2011年3月",
            "1660"=>"2010年9月",
            "1420"=>"2010年3月",
            "1200"=>"2009年9月",
            "640"=>"2009年3月",
            "600"=>"2008年9月",
            "583"=>"2008年3月",
            "340"=>"2007年9月",
            "582"=>"2007年3月",
            "400"=>"2006年9月",
            "581"=>"2006年3月",
            "446"=>"2005年9月",
            "580"=>"2005年3月",
            "445"=>"2004年9月",
            "444"=>"2004年3月",
            "443"=>"2003年9月",
            "442"=>"2003年3月",
            "441"=>"2002年9月",
            "440"=>"2002年3月",
            "421"=>"2001年9月",
            "420"=>"2001年3月"
     );
    
    
    
    //免考试证书的报考省分
     public static $arrmkadder=array(
            "11"=>"11-北京",
            "12"=>"12-天津",
            "13"=>"13-河北",
            "14"=>"14-山西",
            "15"=>"15-内蒙古",
            "21"=>"21-辽宁",
            "22"=>"22-吉林",
            "23"=>"23-黑龙江",
            "31"=>"31-上海",
            "32"=>"32-江苏",
            "33"=>"33-浙江",
            "34"=>"34-安徽",
            "35"=>"35-福建",
            "36"=>"36-江西",
            "37"=>"37-山东",
            "41"=>"41-河南",
            "42"=>"42-湖北",
            "43"=>"43-湖南",
            "44"=>"44-广东",
            "45"=>"45-广西",
            "46"=>"46-海南",
            "50"=>"50-重庆",
            "51"=>"51-四川",
            "52"=>"52-贵州",
            "53"=>"53-云南",
            "54"=>"54-西藏",
            "61"=>"61-陕西",
            "62"=>"62-甘肃",
            "63"=>"63-青海",
            "64"=>"64-宁夏",
            "65"=>"65-新疆",
            "81"=>"81-总参",
            "82"=>"82-北京军区",
            "83"=>"83-兰州军区"
     );
     //免考试证书的报考省分
    public static $arrzstype=array(
        "1"=>"1-一级B(英语)",
        "2"=>"2-一级(英语)",
        "3"=>"3-二级(英语)",
        "4"=>"4-三级(英语)",
        "5"=>"5-四级(英语)",
        "13"=>"13-一级B(计算机)",
        "14"=>"14-一级WPS Office",
        "15"=>"15-一级Microsoft Office",
        "20"=>"20-二级(仅在1994年)",
        "21"=>"21-二级QBASIC(1995-2005上)",
        "22"=>"22-二级FORTRAN(1995-2003下)",
        "23"=>"23-二级PASCAL(1995-2002上)",
        "24"=>"24-二级C",
        "25"=>"25-二级FOXBASE+(1995-2005上)",
        "26"=>"26-二级Visual Basic",
        "27"=>"27-二级Visual FoxPro",
        "28"=>"28-二级JAVA",
        "29"=>"29-二级ACCESS",
        "61"=>"61-二级C++",
        "62"=>"62-二级Delphi",
        "30"=>"30-三级(仅在1994年)",
        "31"=>"31-三级A(1995-2002上)",
        "32"=>"32-三级B(1995-2002上)",
        "33"=>"33-三级PC技术",
        "34"=>"34-三级信息管理技术",
        "35"=>"35-三级网络技术",
        "36"=>"36-三级数据库技术",
        "40"=>"40-四级(1995-2008下)",
        "41"=>"41-四级网络工程师",
        "42"=>"42-四级数据库工程师",
        "43"=>"43-四级软件测试工程师",
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Emapp the static model class
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
		return '{{emapp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mk_cardtype,mk_cardnumber,mk_xh,mk_sname,mk_sex,mk_ethnic, mk_sdgx, mk_specialty,mk_moblie, mk_subject,mk_file', 'required'),
			array('mk_sid, mk_cardtype, mk_sex, mk_ethnic, mk_specialty, mk_addid, mk_addtime, mk_editid, mk_editime, mk_status, mk_statustime,  mk_isdel, mk_deltime, mk_zstype', 'numerical', 'integerOnly'=>true),
			array('mk_cardnumber, mk_moblie, mk_tel', 'length', 'max'=>20),
			array('mk_cardimg, mk_subject, mk_ksadder', 'length', 'max'=>100),
			array('mk_sname', 'length', 'max'=>30),
			array('mk_sdgx', 'length', 'max'=>60),
			array('mk_xh', 'length', 'max'=>12),
			array('mk_reason, mk_file', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mk_id, mk_sid, mk_cardtype, mk_cardnumber, mk_cardimg, mk_sname, mk_sex, mk_ethnic, mk_sdgx, mk_xh, mk_specialty, mk_moblie, mk_tel, mk_subject, mk_reason, mk_ksadder, mk_file, mk_addid, mk_addtime, mk_editid, mk_editime, mk_status, mk_statustime, mk_statusabout, mk_isdel, mk_deltime, mk_ksnf,mk_zkznum, mk_zjnum', 'safe', 'on'=>'search'),
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
			'mk_id' => 'Mk',
			'mk_sid' => '关联学员ID',
			'mk_cardtype' => '证件类型',
			'mk_cardnumber' => '证件号',
			'mk_cardimg' => '证件图',
			'mk_sname' => '姓名',
			'mk_sex' => '性别',
			'mk_ethnic' => '民族',
			'mk_sdgx' => '试点高校',
			'mk_xh' => '学号',
			'mk_specialty' => '免考专业',
			'mk_moblie' => '手机',
			'mk_tel' => '电话',
			'mk_subject' => '免考科目',
			'mk_reason' => '免考原因',
			'mk_ksadder' => '免考证的考试地点',
			'mk_file' => '附件',
			'mk_addid' => '添加人帐号',
			'mk_addtime' => '添加时间',
			'mk_editid' => '修改人帐号',
			'mk_editime' => '修改时间',
			'mk_status' => '审核状态',
			'mk_statustime' => '审核时间',
			'mk_statusabout' => '审核备注',
			'mk_isdel' => '删除状态',
			'mk_deltime' => '删除时间',
            'mk_ksnf'=>'免考证考试时间',
            'mk_zkznum' => '免考准考证号',
            'mk_zjnum' => '免考证件号',
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

		$criteria->compare('mk_id',$this->mk_id);
		$criteria->compare('mk_sid',$this->mk_sid);
		$criteria->compare('mk_cardtype',$this->mk_cardtype);
		$criteria->compare('mk_cardnumber',$this->mk_cardnumber,true);
		$criteria->compare('mk_cardimg',$this->mk_cardimg,true);
		$criteria->compare('mk_sname',$this->mk_sname,true);
		$criteria->compare('mk_sex',$this->mk_sex);
		$criteria->compare('mk_ethnic',$this->mk_ethnic);
		$criteria->compare('mk_sdgx',$this->mk_sdgx,true);
		$criteria->compare('mk_xh',$this->mk_xh,true);
		$criteria->compare('mk_specialty',$this->mk_specialty);
		$criteria->compare('mk_moblie',$this->mk_moblie,true);
		$criteria->compare('mk_tel',$this->mk_tel,true);
		$criteria->compare('mk_subject',$this->mk_subject,true);
		$criteria->compare('mk_reason',$this->mk_reason,true);
		$criteria->compare('mk_ksadder',$this->mk_ksadder,true);
		$criteria->compare('mk_file',$this->mk_file,true);
		$criteria->compare('mk_addid',$this->mk_addid);
		$criteria->compare('mk_addtime',$this->mk_addtime);
		$criteria->compare('mk_editid',$this->mk_editid);
		$criteria->compare('mk_editime',$this->mk_editime);
		$criteria->compare('mk_status',$this->mk_status);
		$criteria->compare('mk_statustime',$this->mk_statustime);
		$criteria->compare('mk_statusabout',$this->mk_statusabout);
		$criteria->compare('mk_isdel',$this->mk_isdel);
		$criteria->compare('mk_deltime',$this->mk_deltime);        
        $criteria->compare('mk_ksnf',$this->mk_ksnf,true);
		$criteria->compare('mk_zkznum',$this->mk_zkznum,true);
		$criteria->compare('mk_zjnum',$this->mk_zjnum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
  

}