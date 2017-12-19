<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/models/Trade.php";
require_once "$root/embryon/api/functions/jsonFunctions.php";
require_once "$root/embryon/api/functions/formatFunctions.php";

class TradesController {
  /*
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
  */
  public function add($req) {
    $url = "http://localhost/embryon/api/actions/trade/add";
    logRequest($url, $req, "POST");
    $requiredColumns = ["user_id", "item_id", "date_start", "date_end"];
    foreach ($requiredColumns as $value) {
      if (!isset($req[$value])) {
        return createResponse($url, 0, "Error: $value required.", 0);
      }
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE id = $req[user_id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: user not found.", 0);
    }
    $query = "SELECT available FROM items WHERE id = $req[item_id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: item not found or available.", 0);
    }
    $req["token"] = date("HisYmd") . $req["user_id"] . $req["item_id"];
    $trade = new Trade();
    $trade->add($req);
    $query = "SELECT id FROM trades WHERE token = '$req[token]'";
    $id = dbQuery($db, $query)->fetchColumn(0);
    return createResponse($url, 1, "Success: trade created.", $id);
  }

  /*
    http://localhost/embryon/api/actions/trade/reply
    POST
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
  */
  public function reply($req) {
    $url = "http://localhost/embryon/api/actions/trade/reply";
    logRequest($url, $req, "POST");
    $requiredColumns = ["id", "accept"];
    foreach ($requiredColumns as $value) {
      if (!isset($req[$value])) {
        return createResponse($url, 0, "Error: $value required.", 0);
      }
    }
    $db = dbConnect();
    $query = "SELECT item_id FROM trades WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: trade not found.", 0);
    }
    $req["item_id"] = $res;
    $req["status"] = $req["accept"] ? 2 : 3;
    $trade = new Trade();
    $trade->editStatus($req);
    $message = $req["accept"] ? "accepted" : "refused";
    return createResponse($url, 1, "Success: trade $message.", $req["id"]);
  }

  /*
    http://localhost/embryon/api/actions/trade/start
    POST
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
  */
  public function start($req) {
    $url = "http://localhost/embryon/api/actions/trade/start";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT item_id FROM trades WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: trade not found.", 0);
    }
    $req["item_id"] = $res;
    $req["date_start"] = date("Y-m-d H:i:s");
    $req["status"] = 4;
    $trade = new Trade();
    $trade->editDate($req, "date_start");
    return createResponse($url, 1, "Success: trade started.", $req["id"]);
  }

  /*
    http://localhost/embryon/api/actions/trade/start
    POST
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
  */
  public function end($req) {
    $url = "http://localhost/embryon/api/actions/trade/end";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT item_id FROM trades WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: trade not found.", 0);
    }
    $req["item_id"] = $res;
    $req["date_end"] = date("Y-m-d H:i:s");
    $req["status"] = 5;
    $trade = new Trade();
    $trade->editDate($req, "date_end");
    return createResponse($url, 1, "Success: trade ended.", $req["id"]);
  }

  /*
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
  */
  public function getTrade($req) {
    if (!isset($req["id"])) {
      $url = "http://localhost/embryon/api/actions/item/getTrade?id=";
      logRequest($url, $req, "GET");
      return createResponse($url, 0, "Error: id required.", 0);
    }
    $url = "http://localhost/embryon/api/actions/item/getTrade?id=$req[id]";
    logRequest($url, $req, "GET");
    $db = dbConnect();
    $query = "SELECT * FROM trades WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
      return createGetTradeResponse($url, 0, "Error: trade not found.", null);
    }
    return createGetTradeResponse($url, 1, "Success.", $res);
  }

  /*
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
  */
  public function getTrades($data) {
    $url_user = "";
    $query_user = "";
    $url_item = "";
    $query_item = "";
    if (isset($data["user_id"])) {
      $url_user = "?user_id=$data[user_id]";
      $query_user = " WHERE user_id = $data[user_id]";
    }
    if (!isset($data["user_id"]) && isset($data["item_id"])) {
      $url_item = "?item_id=$data[item_id]";
      $query_item = " WHERE item_id = $data[item_id]";
    }
    if (isset($data["user_id"]) && isset($data["item_id"])) {
      $url_item = "&item_id=$data[item_id]";
      $query_item = " AND item_id = $data[item_id]";
    }
    $url = "http://localhost/embryon/api/actions/item/getTrades$url_user$url_item";
    logRequest($url, $data, "GET");
    $db = dbConnect();
    $query = "SELECT * FROM trades$query_user$query_item";
    $res = dbQuery($db, $query);
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $trades[] = $row;
    }
    if (!isset($trades)) {
      return createGetAllTradesResponse($url, 0, "Error: trades not found.", null);
    }
    return createGetAllTradesResponse($url, 1, "Success.", $trades);
  }

  /*
    http://localhost/embryon/api/actions/item/getAll
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
  */
  public function getAll() {
    $url = "http://localhost/embryon/api/actions/trade/getAll";
    logRequest($url, [], "GET");
    $db = dbConnect();
    $query = "SELECT * FROM trades";
    $res = dbQuery($db, $query);
    $trades = [];
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $trades[] = $row;
    }
    return createGetAllTradesResponse($url, 1, "Success.", $trades);
  }
}

?>
