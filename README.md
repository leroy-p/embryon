# embryon

## API

### user

    http://localhost/embryon/api/actions/user/login
    POST
    request :
    {
      "email": required,
      "password": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/add
    POST
    request :
    {
      "email": required,
      "password": required,
      "confirmation": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/edit
    PUT
    request :
    {
      "id": required,
      "firstname": optional,
      "lastname": optional,
      "pic_url": optional,
      "phone": optional,
      "building": optional,
      "floor": optional,
      "location": optional
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/delete
    DELETE
    request :
    {
      "id": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/confirmEmail
    POST
    request :
    {
      "token": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/setPassword
    PUT
    request :
    {
      "token": required,
      "password": required,
      "confirmation": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/user/getUser?id=$id
    GET
    response :
    {
      "status",
      "message",
      "user": {
                "id",
                "email",
                "password",
                "firstname",
                "lastname",
                "pic_url",
                "phone",
                "building",
                "floor",
                "location",
                "date_creation",
                "date_modification",
                "admin",
                "active"
              }
    }

    http://localhost/embryon/api/actions/user/getAll
    GET
    response :
    {
      "status",
      "message",
      "users": [      
                {
                  "id",
                  "email",
                  "password",
                  "firstname",
                  "lastname",
                  "pic_url",
                  "phone",
                  "building",
                  "floor",
                  "location",
                  "date_creation",
                  "date_modification",
                  "admin",
                  "active"
                },
                {
                  "id",
                  "email",
                  "password",
                  "firstname",
                  "lastname",
                  "pic_url",
                  "phone",
                  "building",
                  "floor",
                  "location",
                  "date_creation",
                  "date_modification",
                  "admin",
                  "active"
                },
                ...
              ]
    }

### item

    http://localhost/embryon/api/actions/item/add
    POST
    request :
    {
      "user_id": required,
      "type_id": required,
      "name": required,
      "description": optional,
      "available": optional
      "pic_url": optional,
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/item/edit
    PUT
    request :
    {
      "id: required,
      "type_id": optional,
      "name": required,
      "description": optional,
      "pic_url": optional,
      "available": optional
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/item/delete
    DELETE
    request :
    {
      "id: required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/item/getItem?id=$id
    GET
    response :
    {
      "status",
      "message",
      "item": {
                "user_id",
                "type_id",
                "name",
                "description",
                "pic_url",
                "available",
                "date_creation",
                "date_modification",
                "active"
              }
    }

    http://localhost/embryon/api/actions/item/getItems?user_id=$user_id
    GET
    response :
    {
      "status",
      "message",
      "items": [      
                {
                  "user_id",
                  "type_id",
                  "name",
                  "description",
                  "pic_url",
                  "available",
                  "date_creation",
                  "date_modification",
                  "active"
                },
                {
                  "user_id",
                  "type_id",
                  "name",
                  "description",
                  "pic_url",
                  "available",
                  "date_creation",
                  "date_modification",
                  "active"
                },
                ...
              ]
    }

    http://localhost/embryon/api/actions/item/getAll
    GET
    response :
    {
      "status",
      "message",
      "items": [      
                {
                  "user_id",
                  "type_id",
                  "name",
                  "description",
                  "pic_url",
                  "available",
                  "date_creation",
                  "date_modification",
                  "active"
                },
                {
                  "user_id",
                  "type_id",
                  "name",
                  "description",
                  "pic_url",
                  "available",
                  "date_creation",
                  "date_modification",
                  "active"
                },
                ...
              ]
    }

### trade

    http://localhost/embryon/api/actions/trade/add
    POST
    request :
    {
      "user_id": required,
      "item_id": required,
      "date_start": required,
      "date_end": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/trade/reply
    PUT
    request :
    {
      "id": required,
      "accept": required
    }
    response :
    {
      "status"
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/trade/start
    PUT
    request :
    {
      "id": required
    }
    response :
    {
      "status"
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/trade/start
    PUT
    request :
    {
      "id": required
    }
    response :
    {
      "status"
      "message",
      "id"
    }

    http://localhost/embryon/api/actions/trade/getTrade?id=$id
    GET
    response :
    {
      "status",
      "message",
      "trade": {
                "id",
                "user_id",
                "item_id",
                "token",
                "date_creation",
                "date_modification",
                "expected_date_start",
                "expected_date_end",
                "date_start",
                "date_end",
                "status"
              }
    }

    http://localhost/embryon/api/actions/trade/getTrades?user_id=$user_id&item_id=$item_id
    GET
    response :
    {
      "status",
      "message",
      "trades": [      
                {
                  "id",
                  "user_id",
                  "item_id",
                  "token",
                  "date_creation",
                  "date_modification",
                  "expected_date_start",
                  "expected_date_end",
                  "date_start",
                  "date_end",
                  "status"
                },
                {
                  "id",
                  "user_id",
                  "item_id",
                  "token",
                  "date_creation",
                  "date_modification",
                  "expected_date_start",
                  "expected_date_end",
                  "date_start",
                  "date_end",
                  "status"
                },
                ...
              ]
    }

    http://localhost/embryon/api/actions/trade/getAll
    GET
    response :
    {
      "status",
      "message",
      "trades": [      
                {
                  "id",
                  "user_id",
                  "item_id",
                  "token",
                  "date_creation",
                  "date_modification",
                  "expected_date_start",
                  "expected_date_end",
                  "date_start",
                  "date_end",
                  "status"
                },
                {
                  "id",
                  "user_id",
                  "item_id",
                  "token",
                  "date_creation",
                  "date_modification",
                  "expected_date_start",
                  "expected_date_end",
                  "date_start",
                  "date_end",
                  "status"
                },
                ...
              ]
    }
