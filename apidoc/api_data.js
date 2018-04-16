define({ "api": [
  {
    "type": "post",
    "url": "/news/lists",
    "title": "新闻信息列表",
    "version": "1.0.0",
    "name": "lists",
    "group": "User",
    "permission": [
      {
        "name": "登录用户"
      }
    ],
    "description": "<p>用户登录后进入该页面，将显示新闻信息列表</p>",
    "sampleRequest": [
      {
        "url": "http://www.test.com:8080/test"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>客户姓名</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "user_head_img",
            "description": "<p>客户头像</p>"
          },
          {
            "group": "返回值",
            "type": "integer",
            "optional": false,
            "field": "sex",
            "description": "<p>性别:0-未设置,1-男,2-女</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "demand",
            "description": "<p>客户需求</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\"code\": 1,\"msg\": \"\",\"data\": {\"id\": \"57b3cdb46b787\",\"name\": \"余浩苗\",\"user_head_img\": \"userHead/2016-08-18/1034587522576.jpg\",\"sex\": \"1\",\"demand\": \"本人想买保险，请速联系！\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "(json) 错误示例:",
          "content": "{\"code\":-1,\"msg\":\"密码错误\",\"data\":{}}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/IndexController.php",
    "groupTitle": "User"
  }
] });
