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
    $query = "SELECT id FROM items WHERE id = $req[item_id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Error: item not found.", 0);
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
}
?>
