define({ "api": [
  {
    "type": "post",
    "url": "/getOrderList",
    "title": "Request 申请请求是否添加成功",
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
            "field": "content",
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
    "type": "get",
    "url": "/getOrderList/:page",
    "title": "Request 订单列表",
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
    "type": "get",
    "url": "/getThumbupList/:id",
    "title": "显示用户的点赞记录",
    "name": "getThumbupList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>用户ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "返回个人点赞记录",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 200,\n\"msg\": \"success\",\n\"result\": {\n\n          },\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/User/ThumbupController.php",
    "groupTitle": "User"
  }
] });
