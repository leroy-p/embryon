<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/models/Item.php";
require_once "$root/embryon/api/functions/jsonFunctions.php";
require_once "$root/embryon/api/functions/formatFunctions.php";

class ItemsController {
  /*
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
  */
  public function add($req) {
    $url = "http://localhost/embryon/api/actions/item/add";
    logRequest($url, $req, "POST");
    if (!isset($req["name"])) {
      return createResponse($url, 0, "Name required.", -1);
    }
    if (!$req["name"]) {
      return createResponse($url, 0, "Name required.", -1);
    }
    $db = dbConnect();
    $query = "SELECT active FROM users WHERE id = $req[user_id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res || $res == 1) {
      return createResponse($url, 0, "User not found.", 0);
    }
    $req["token"] = date("HisYmd") . $req["user_id"];
    if (isset($req["available"])) {
      $req["status"] = $req["available"] ? 1 : 2;
    }
    $item = new Item();
    $item->add($req);
    $query = "SELECT id FROM items WHERE token = '$req[token]'";
    $id = dbQuery($db, $query)->fetchColumn(0);
    return createResponse($url, 1, "Item created.", $id);
  }

  /*
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
  */
  public function edit($req) {
    $url = "http://localhost/embryon/api/actions/item/edit";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, 0, "Id required.", -1);
    }
    if (!$req["id"]) {
      return createResponse($url, 0, "Id required.", -1);
    }
    $db = dbConnect();
    $query = "SELECT id FROM items WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Item not found.", 0);
    }
    if (isset($req["pic_url"]) && strlen($req["pic_url"]) > 0 && !isImg($req["pic_url"])) {
      return createResponse($url, 0, "Invalid image format.", 0);
    }
    if (isset($req["available"])) {
      $req["status"] = $req["available"] ? 1 : 2;
    }
    $item = new Item();
    $item->edit($req);
    return createResponse($url, 1, "Item updated.", $req["id"]);
  }

  /*
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
  */
  public function delete($req) {
    $url = "http://localhost/embryon/api/actions/item/delete";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, 0, "Id required.", -1);
    }
    if (!$req["id"]) {
      return createResponse($url, 0, "Id required.", -1);
    }
    $db = dbConnect();
    $query = "SELECT id FROM items WHERE active = 1 AND id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Item not found.", 0);
    }
    $item = new Item();
    $item->delete($req["id"]);
    return createResponse($url, 1, "Item deleted.", $req["id"]);
  }

  /*
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
  */
  public function getItem($req) {
    if (!isset($req["id"])) {
      $url = "http://localhost/embryon/api/actions/item/getItem?id=";
      logRequest($url, $req, "GET");
      return createResponse($url, 0, "Id required.", -1);
    }
    if (!$req["id"]) {
      return createResponse($url, 0, "Id required.", -1);
    }
    $url = "http://localhost/embryon/api/actions/item/getItem?id=$req[id]";
    logRequest($url, $req, "GET");
    $db = dbConnect();
    $query = "SELECT * FROM items WHERE id = $req[id] AND active = 1";
    $res = dbQuery($db, $query)->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
      return createGetItemResponse($url, 0, "Item not found.", null);
    }
    return createGetItemResponse($url, 1, "Success.", $res);
  }

  /*
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
  */
  public function getItems($data) {
    $url_user = "";
    $query_user = "";
    if (isset($data["user_id"])) {
      $url_user = "?user_id=$data[user_id]";
      $query_user = " AND user_id = $data[user_id]";
    }
    $url = "http://localhost/embryon/api/actions/item/getItems$url_user";
    logRequest($url, $data, "GET");
    $db = dbConnect();
    $query = "SELECT * FROM items WHERE active = 1$query_user";
    $res = dbQuery($db, $query);
    $items = [];
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $items[] = $row;
    }
    if (!isset($items)) {
      return createGetAllItemsResponse($url, 0, "Items not found.", null);
    }
    return createGetAllItemsResponse($url, 1, "Success.", $items);
  }

  /*
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
    */
    public function getAll() {
      $url = "http://localhost/embryon/api/actions/item/getAll";
      logRequest($url, [], "GET");
      $db = dbConnect();
      $query = "SELECT * FROM items WHERE active = 1";
      $res = dbQuery($db, $query);
      $items = [];
      while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row;
      }
      return createGetAllItemsResponse($url, 1, "Success.", $items);
    }
  }
?>
