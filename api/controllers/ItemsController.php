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
    if (!isset($req["name"]) || !strlen($req["name"])) {
      return createResponse($url, 0, "Error: name required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE id = $req[user_id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: user not found.", 0);
    }
    $req["token"] = date("HisYmd") . $req["user_id"];
    if (isset($req["available"])) {
      $req["status"] = $req["available"] ? 1 : 2;
    }
    printArray($req);
    $item = new Item();
    $item->add($req);
    $query = "SELECT id FROM items WHERE token = '$req[token]'";
    $id = dbQuery($db, $query)->fetchColumn(0);
    return createResponse($url, 1, "Success: item created.", $id);
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
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM items WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: item not found.", 0);
    }
    if (isset($req["pic_url"]) && strlen($req["pic_url"]) > 0 && !isImg($req["pic_url"])) {
      return createResponse($url, 0, "Error: invalid image format.", 0);
    }
    if (isset($req["available"])) {
      $req["status"] = $req["available"] ? 1 : 2;
    }
    $item = new Item();
    $item->edit($req);
    return createResponse($url, 1, "Success: item updated.", $req["id"]);
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
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM items WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: item not found.", 0);
    }
    $item = new Item();
    $item->delete($req["id"]);
    return createResponse($url, 1, "Success: item deleted.", $req["id"]);
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
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $url = "http://localhost/embryon/api/actions/item/getItem?id=$req[id]";
    logRequest($url, $req, "GET");
    $db = dbConnect();
    $query = "SELECT * FROM items WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
      return createGetUserResponse($url, 0, "Error: item not found.", null);
    }
    return createGetItemResponse($url, 1, "Success.", $res);
  }

  /*
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
    */
    public function getAll() {
      $url = "http://localhost/embryon/api/actions/item/getAll";
      logRequest($url, [], "GET");
      $db = dbConnect();
      $query = "SELECT * FROM items";
      $res = dbQuery($db, $query);
      $items = [];
      while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row;
      }
      return createGetAllItemsResponse($url, 1, "Success.", $items);
    }
  }

?>
