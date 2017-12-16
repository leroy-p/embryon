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
POST
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
POST
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
  "pic_url": optional,
  "available": optional
}
response :
{
  "status",
  "message",
  "id"
}

http://localhost/embryon/api/actions/item/edit
POST
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
POST
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

http://localhost/embryon/api/actions/item/getAll?user=$id
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
