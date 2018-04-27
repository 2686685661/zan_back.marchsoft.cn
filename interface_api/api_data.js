define({ "api": [
  {
    "type": "post",
    "url": "/addApply",
    "title": "申请点赞币",
    "name": "addApply",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "applyUserId",
            "description": "<p>申请人id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "applyUserName",
            "description": "<p>申请人姓名.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "applyContent",
            "description": "<p>申请点赞币具体内容，包括申请给哪些人，张数以及描述，要求为json数据.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "applyType",
            "description": "<p>点赞币申请类型的id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码 0正常</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/addTalk",
    "title": "添加匿名聊天",
    "name": "addTalk",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>内容</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码 0正常</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/countList",
    "title": "显示点赞币统计记录",
    "name": "countList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "0",
              "1",
              "2",
              "3"
            ],
            "optional": false,
            "field": "countGrade",
            "description": "<p>年级(0 =&gt; 全部，1 =&gt; 大一，2 =&gt; 大二， 3 =&gt; 大三)默认为 0</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "startDate",
            "description": "<p>开始日期 yy-mm-dd</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "endDate",
            "description": "<p>结束日期 yy-mm-dd</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "IndRank",
            "description": "<p>个人信息数组</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "countArr",
            "description": "<p>点赞排名数组</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：返回点赞币统计记录",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"success\",\n\"data\": {\n     IndRank:[\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"receive_count\":21,\"week_count\":8},\n      ],\n     countArr:[\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"receive_count\":28,\"week_count\":7},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"receive_count\":25,\"week_count\":2},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"receive_count\":20,\"week_count\":5},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"receive_count\":18,\"week_count\":1},\n      ],\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/RecordController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/getApplyType",
    "title": "返回类型列表",
    "name": "getApplyType",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>类型id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "type_name",
            "description": "<p>类型名称.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n  \"data\":{\n             id:,\n             type_name:\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/getBuyOrder",
    "title": "查询需要处理的订单列表",
    "name": "getBuyOrder",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>用户id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "groupId",
            "description": "<p>组别id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>类型id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>购买内容.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>用户名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>用户qq号</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "status",
            "description": "<p>订单状态 0未接受 1拒绝 2接受 3完成</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n  \"data\":{\n             id:,\n             content:,\n             name:,\n             code,\n             status:\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/getCoinList",
    "title": "得到自己未使用（空白的，未点出的）的点赞币",
    "name": "getCoinList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "userId",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 请求成功，其他数值 请求失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "coinList",
            "description": "<p>未使用（空白的，未点出的）的点赞币数组</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>点赞币id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "coin_id",
            "description": "<p>币种id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "coin_name",
            "description": "<p>币种name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "start_time",
            "description": "<p>点赞币开始生效时间（时间戳）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "over_time",
            "description": "<p>点赞币结束生效时间（时间戳）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：请求成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n      coinList:[\n         {\"id\":\"xxx\",\"coin_id\":\"xxxxxxxx\",\"coin_name\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888},\n         {\"id\":\"xxx\",\"coin_id\":\"xxxxxxxx\",\"coin_name\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888}\n      ]\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 请求失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"failed\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbsUpController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/getOrderList",
    "title": "订单列表",
    "name": "getOrderList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>页码.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>订单内容</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "created_time",
            "description": "<p>创建时间.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "status",
            "description": "<p>订单状态.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "resaon",
            "description": "<p>订单拒绝的理由.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n  \"data\":{\n             content:'test',\n             created_time:0,\n             status:1,\n             resaon:''\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/getOverdueCoinList",
    "title": "得到已过期的点赞币",
    "name": "getOverdueCoinList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "userId",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 请求成功，其他数值 请求失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "overdueCoinList",
            "description": "<p>未使用（空白的，未点出的）的已过期的点赞币数组</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>点赞币id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "coin_id",
            "description": "<p>币种id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "coin_name",
            "description": "<p>币种name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "start_time",
            "description": "<p>点赞币开始生效时间（时间戳）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "over_time",
            "description": "<p>点赞币结束生效时间（时间戳）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：请求成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n      overdueCoinList:[\n         {\"id\":\"xxx\",\"coin_id\":\"xxx\",\"coin_name\":\"xxx\",\"start_time\":\"xxx\",\"over_time\":\"xxx\"},\n         {\"id\":\"xxx\",\"coin_id\":\"xxx\",\"coin_name\":\"xxx\",\"start_time\":\"xxx\",\"over_time\":\"xxx\"}\n      ]\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 请求失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"failed\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbsUpController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/getRule",
    "title": "查看点赞币规则",
    "name": "getRule",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>点赞币规则.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n  \"data\":{\n             content:\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/getTalk",
    "title": "获取匿名聊天",
    "name": "getTalk",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>匿名内容</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "create_time",
            "description": "<p>上传时间</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n  \"data\":{\n             content:,\n             create_time:\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/getUsedCoinList",
    "title": "得到自己已使用的点赞币",
    "name": "getUsedCoinList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "userId",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 请求成功，其他数值 请求失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "usedCoinList",
            "description": "<p>已使用（已点出的）的点赞币数组</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>点赞币id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "coin_id",
            "description": "<p>币种id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "to_user_id",
            "description": "<p>点给某人&lt;某人的id&gt;</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "to_user_name",
            "description": "<p>点给某人&lt;某人的name&gt;</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>点赞原因</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "use_time",
            "description": "<p>点赞时间（时间戳）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：请求成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n      usedCoinList:[\n         {\"id\":\"xxx\",\"coin_id\":\"xxx\",\"to_user_id\":\"xxx\",\"to_user_name\":\"xxx\",\"reason\":\"xxx\",\"use_time\":\"xxx\"},\n         {\"id\":\"xxx\",\"coin_id\":\"xxx\",\"to_user_id\":\"xxx\",\"to_user_name\":\"xxx\",\"reason\":\"xxx\",\"use_time\":\"xxx\"}\n      ]\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 请求失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"failed\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbsUpController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/seeCon",
    "title": "获得点赞币消费记录",
    "name": "getUserConsumeCoin",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "userid",
            "description": "<p>查看人的id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>点赞币使用记录种类 $type == 0 未使用 $type == 1 已使用 $type == 2 已过期</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>点赞人的姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "qq_account",
            "description": "<p>点赞人的qq号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "img_url",
            "description": "<p>赞点人的头像网址.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>点赞原因.</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "over_time",
            "description": "<p>点赞币过期时间.</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "coin_id",
            "description": "<p>点赞币种类.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " \nHTTP/1.1 200 OK\n$type == 0 || 1:\n {\n   \"code\": \"0\",\n   \"msg\": \"success\",\n   \"data\":[\n              0=>[\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1},\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1}       \n              ],\n              1=>[\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2},\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2}\n              ],\n              2=>[\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3},\n                   {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3}\n              ]\n          ]\n }\n$type == 2:\n {\n   \"code\": \"0\",\n   \"msg\": \"success\",\n   \"data\":[\n              0=>{name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test'}\n              1=>{name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test'}        \n          ]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ConsumeController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/getUserList",
    "title": "得到用户列表",
    "name": "getUserList",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 请求成功，其他数值 请求失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "userList",
            "description": "<p>用户列表数组</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>用户name</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：请求成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n      userList:[\n         {\"id\":\"xxx\",\"name\":\"xxx\"},\n         {\"id\":\"xxx\",\"name\":\"xxx\"}\n      ]\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 请求失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"failed\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbsUpController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/insertCoinOrder",
    "title": "使用点赞币消费",
    "name": "insertUserConsume",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coin_useful",
            "description": "<p>点赞币用途id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "coin_id_arr",
            "description": "<p>点赞币id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "use_id",
            "description": "<p>使用人id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>点赞币用途.</p>"
          },
          {
            "group": "Parameter",
            "type": "NUmber",
            "optional": false,
            "field": "group_id",
            "description": "<p>组别id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"使用成功\",\n  \"data\":{\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ConsumeController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/login",
    "title": "登录",
    "name": "login",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>账号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "isManager",
            "description": "<p>是否是管理员：0 是，1 不是</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 登录成功，其他数值 登录失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：登录成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 登录失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"账号或密码错误\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/LoginController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "user/thumbsUp",
    "title": "点赞",
    "name": "thumbsUp",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id[]",
            "description": "<p>点赞币id数组</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "toUserId",
            "description": "<p>点给某人&lt;某人的id&gt;</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>点赞原因</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码：0 点赞成功，其他数值 点赞失败</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response：点赞成功",
          "content": "HTTP/1.1 200 OK\n{\n \"code\": 0,\n \"msg\": \"success\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response: 点赞失败",
          "content": "HTTP/1.1 200\n{\n \"code\": 1,\n \"msg\": \"failed\",\n \"data\": {\n\n   },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbsUpController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "user/thumbup",
    "title": "显示用户本周点赞记录",
    "name": "thumbup",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "thumbupedArr",
            "description": "<p>被点赞数组</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "thumbupArr",
            "description": "<p>点赞数组</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "countTotal",
            "description": "<p>总计获得点赞币数</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "totalWeek",
            "description": "<p>本周获得点赞币数</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rankWeek",
            "description": "<p>本周排名</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: 返回个人被点赞记录",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"success\",\n\"data\": {\n    thumbupedArr:[\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n                ],\n    thumbupArr:[\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n         {\"name\":\"xxx\",\"img_url\":\"xxxxxxxx\",\"reason\":\"xxxxxxxxxxxx\",\"start_time\":888888,\"over_time\":888888888,\"use_time\":88888888},\n                ],\n    countTotal: 28,\n    totalWeek: 2,\n    rankWeek: 20,\n     },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '无数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/RecordController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/updatePassword",
    "title": "修改密码",
    "name": "updatePassword",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Nubmer",
            "optional": false,
            "field": "id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "oldPassword",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "newPassword",
            "description": "<p>新密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "newPasswordAgain",
            "description": "<p>再次输入的新密码</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>状态码 0正常</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>响应信息.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/PersonalCenter.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/alipay/notify",
    "title": "支付异步回调接口",
    "name": "alipayNotify",
    "group": "alipay",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/Alipay/AlipayWapController.php",
    "groupTitle": "alipay"
  },
  {
    "type": "get",
    "url": "/alipay/return",
    "title": "支付同步回调接口",
    "name": "alipayReturn",
    "group": "alipay",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "out_trade_no",
            "description": "<p>唯一订单id(后端自动生成).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject",
            "description": "<p>订单介绍.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "total_amount",
            "description": "<p>支付金额.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "body",
            "description": "<p>订单主题介绍.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/Alipay/AlipayWapController.php",
    "groupTitle": "alipay"
  },
  {
    "type": "get",
    "url": "/alipay/wappay",
    "title": "购买点赞币支付宝手机网站支付接口",
    "name": "alipayWapPay",
    "group": "alipay",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "out_trade_no",
            "description": "<p>唯一订单id(后端自动生成).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject",
            "description": "<p>订单介绍.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "total_amount",
            "description": "<p>支付金额.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "body",
            "description": "<p>订单主题介绍.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n 回调return_url,页面重新加载",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/Alipay/AlipayWapController.php",
    "groupTitle": "alipay"
  }
] });
