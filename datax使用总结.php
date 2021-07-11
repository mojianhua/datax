-1、datax下载
	https://github.com/alibaba/DataX
0、进入py2虚拟环境
	activate py2
1、测试运行datax
	python datax.py D:\datax\job\job.json
2、创建datax,stram文件
	python datax.py -r streamreader -w streamwriter
3、datax，mysqlreader参数解析
	"reader": {
			  "name": "streamreader",                        //name:reader名
			  "parameter": {
				"sliceRecordCount": 10,			             //sliceRecordCount:执行次数
				"column": [									 //column:需要同步数据的列名集合，使用json数组描述自带信息，*表示所有列
					  {
						"type": "long",
						"value": "10"
					  },
				  ]
				  "connection":[
					{
						"jdbcUrl":[],						//jdbcUrl：对数据库的JDBC连接信息，使用JSON数组描述，支持多个连接池地址
						"table":[],                         //table:需要同步的表，支持多个
						[
							"querySql":[]					//querySql:自定义SQL，配置它后，mysqlreader直接忽略table，column,where
						]
					}
				  ],                                        //password：mysql密码
				  "password":"",
				  "username":"",					        //username：mysql账号
				  [
					"where":""								//where：筛选条件
				  ],
				  [
					"splitPk":""							//splitPk：数据分片字段，一般是主键
				  ]
				]
			  }
			},
4、datax，mysqlwriter参数解析
	"writer": {
			  "name": "mysqlwriter",                        //name:reader名
			  "parameter": {
				"sliceRecordCount": 10,			             //sliceRecordCount:执行次数
				"column": [									 //column:需要写入字段名
					  {
						"id",
						"name"
					  },
				  ]
				  "connection":[
					{
						"jdbcUrl":"",						//jdbcUrl：对数据库的JDBC连接信息，只能是单链接
						"table":[],                         //table:需要同步的表，支持多个
						[
							"querySql":[]					//querySql:自定义SQL，配置它后，mysqlreader直接忽略table，column,where
						]
					}
				  ],                                        //password：mysql密码
				  "password":"",
				  "username":"",					        //username：mysql账号
				  "writeMode":"",					        //writeMode："insert"写入
				]
			  }
			},

5、mysql写入mysql例子
	{
    "job": {
        "setting": {
            "speed": {
				"channel":1
            }
        },
        "content": [
            {
                "reader": {
                    "name": "mysqlreader",
                    "parameter": {
                        "column": [														//column:需要同步数据的列名集合，使用json数组描述自带信息，*表示所有列
							"id",
							"name"
                        ],
                       "connection":[
							{
								"jdbcUrl":[
									"jdbc:mysql://127.0.0.1:3306/datax"
								],
								"table":[
									"student1"
								]
							}
					   ],
					   "username":"root",
					   "password":"root"
                    }
                },
                "writer": {
                    "name": "mysqlwriter",
                    "parameter": {
                        "column": [
							"id",
							"name"
                        ],
                       "connection":[
							{
								"jdbcUrl":"jdbc:mysql://127.0.0.1:3306/datax",
								"table":[
									"student2"
								]
							}
					   ],
					   "username":"root",
					   "password":"root",
					   "writeMode": "insert"
                    }
                }
            }
        ]
    }
}
6、datax,从mysql数据导入mangodb
	{
    "job": {
        "setting": {
            "speed": {
				"channel":1
            }
        },
        "content": [
            {
                "reader": {
                    "name": "mysqlreader",
                    "parameter": {
                        "column": [
							"name"
                        ],
                       "connection":[
							{
								"jdbcUrl":[
									"jdbc:mysql://127.0.0.1:3306/datax"
								],
								"table":[
									"student1"
								]
							}
					   ],
					   "username":"root",
					   "password":"root"
                    }
                },
                "writer": {
                    "name": "mongodbwriter",								//name:写入mongod
                    "parameter": {
                        "column": [										    //column:需要同步数据的列名集合，使用json数组描述自带信息
							{
							  "name": "name",
							  "type": "string"
							}
                        ],
						"address": ["127.0.0.1:27017"],						//address:mongod 地址支持集群
						"dbName": "lanseeStatistics",						//dbName: mongod数据库名
						"collectionName": "test",							//collectionName:mongod collectionName名
						"userName":"jim",									//userName:mongod 用户名
						"userPassword":"123",								//userName:mongod 密码
						"writeMode": {										//writeMode写入方式，
							"isReplace": "false",
							"replaceKey": "_id"
						}
                    }
                }
            }
        ]
    }
}


