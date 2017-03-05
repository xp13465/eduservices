<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require(dirname(__FILE__).'/define.php');//加载定义的全局变量

return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'北京航空航天大学现代远程教育',
        'language'=>'zh_cn',
		// 'preload'=>array('log'),
        // autoloading model and component classes
        'import'=>array(
                'application.models.*',
                'application.components.*',
                'application.common.*',
				// 'application.vendors.*',
        ),

        'defaultController'=>'site',

        // application components
        'components'=>array(
                'ip' => array(
                    'class' => 'IpLocation',
                ),
                'user'=>array(
                        'allowAutoLogin'=>true,
                        'loginUrl' => array('/site/index'),
                        'identityCookie'=>array('domain' => '.onlinebeihang.com','path' => '/'),//配置用户cookie作用域
                        'stateKeyPrefix'=>'hd',//你的前缀，必须指定为一样的
                        'loginUrl'=>array('/user/login'),
                ),
                'session' => array(
                    // 'cookieParams' => array('domain' => '.onlinebeihang.com', 'lifetime' => 0),//配置会话ID作用域 生命期和超时
                    'timeout' => 9800,
                    'class' => 'system.web.CDbHttpSession',//create table yiisession
                    'connectionID' => 'db',
                ),
                 // 'statePersister'=>array(
                    // 'class'=>'system.base.CStatePersister',
                    // 'stateFile'=>'../protected/runtime/state.bin',
                // ),
                'authManager'=>array(
                //enable auth user by roles
                        'class'=>'CDbAuthManager',
                        'itemTable' => 'es_authitem',//认证项表名称
                        'itemChildTable'=> 'es_authitemchild',//认证项父子关系
                        'assignmentTable' =>'es_authassignment',//认证项赋权关系
                ),
                'db'=>array(
                        'class'=>'system.db.CDbConnection',
                        'connectionString' => 'mysql:host=localhost;dbname=eduservices',
                        'emulatePrepare' => true,
                        'username' => 'eduservices',
                        'password' => '123456#edu',
                        'charset' => 'utf8',
                        'tablePrefix' => 'es_',
                        'schemaCachingDuration'=>3600,
                        // 'enableProfiling'=>true,
                ),
                'errorHandler'=>array(
                // use 'site/error' action to display errors
                        'errorAction'=>'/site/error',
                ), /*
                'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                       
								array(
								'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
								'ipFilters'=>array("220.248.89.202"),
								),
                               

                        ),
                ),*/
				'cache' => array (

					'class' => 'system.caching.CFileCache',

					 'directoryLevel' => 2,

				),
                'urlManager'=>array(
                        'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'matchValue'=>true,
						'urlSuffix' => '.html',//后缀  
                        'rules'=>array(
							 '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
							'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            
                            'studentchecklist'=>'admin/students/check',
                            'studentlist'=>'admin/students/index',
                            'studentmanage'=>'admin/students/manage',
                            'studentview<id:\d+>'=>'admin/students/view/',
                            'studentcheck<id:\d+>'=>'admin/students/checku',
                            'studentenrollprint<id:\d+>'=>'admin/students/print',
                            'studentinfoprint<id:\d+>'=>'admin/students/allprint',
                            'studentenroll'=>'admin/students/add',
                            'studentedit<id:\d+>'=>'admin/students/edit',
                            
                            'applicationlist'=>'admin/application/applicationlist',
                            
                            'myinfo'=>'admin/user/view',
                            
                            'schoollist'=>'admin/school/index',
                            'schooledit<id:\d+>'=>'admin/school/edit',
                            
                            'professionallist'=>'admin/professional/index',
                            'professionaledit<id:\d+>'=>'admin/professional/edit',
                            
                            'batchlist'=>'admin/pici/index',
                            
                            'learningcenterlist'=>'admin/organization/index',
                            'registrationpriontlist'=>'admin/organization/index/type/baomingdian',
                            'institutionlist'=>'admin/organization/index/type/jigou',
                            'organizationedit<id:\d+>'=>'admin/organization/edit',
                            
                            'examsetlist'=>'admin/examset/index',
                            'examlist'=>'admin/examset/index/type/second',
                            'examinfoedit<id:\d+>'=>'admin/examset/edit',
                            
                            'questionsmanage'=>'admin/questions/index',
                            'questionsview<id:\d+>'=>'admin/questions/view',
                            'questionsedit<id:\d+>'=>'admin/questions/edit',
                            'questionsadd'=>'admin/questions/add',
                            
                            'papermmanage'=>'admin/paperm/index',
                            'papermview<id:\d+>'=>'admin/paperm/view',
                            'papermedit<id:\d+>'=>'admin/paperm/edit',
                            'papermadd'=>'admin/paperm/add',
                            
                            'examinationmanage'=>'admin/exam/index',
                            'scorelist'=>'admin/exam/equery', 
                            'examinationadd'=>'admin/exam/add',
                            
                            'accountlist'=>'admin/account/index',
                            'accountview<id:\d+>'=>'admin/account/view',
                            'accountedit<id:\d+>'=>'admin/account/edit',
                            'accountadd'=>'admin/account/add',
                            
                            'examarrangementlist'=>'admin/examarrangement/index',
                            
                            'applicationmanagelist'=>'admin/application/index', 
                            'applicationchecklist'=>'admin/application/check',
                            'applicationaudit<id:\d+>'=>'admin/application/audit',
                            'applicationview<id:\d+>'=>'admin/application/view',
                            'applicationadd'=>'admin/application/add',
                            'applicationedit<id:\d+>'=>'admin/application/edit',
                            
                            'informationmanagelist'=>'admin/information/index',
                            'informationview<id:\d+>'=>'admin/information/view',
                            'informationadd'=>'admin/information/add',
                            'informationedit<id:\d+>'=>'admin/information/edit',
                            
                            'emappadd'=>'admin/emapp/add',
                            'emappindex'=>'admin/emapp/index',
                            'emappauditck'=>'admin/emapp/auditck',
                            'emappview<id:\d+>'=>'admin/emapp/view',
                            'emappedit<id:\d+>'=>'admin/emapp/edit',
                            'emappshedit<id:\d+>'=>'admin/emapp/shedit',
                        ),
                ),
        ),
        'modules'=>array(
                "api",
                "admin",
                "student",
                "manage",
                'gii'=>array(
                        'class'=>'system.gii.GiiModule',
                        'password'=>'qd',
                )
        ),
        'params'=>require(dirname(__FILE__).'/params.php'),
);