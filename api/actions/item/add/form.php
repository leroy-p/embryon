<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Embryon</title>
  </head>
  <body>
    <h2>Add item</h2>
    <form action="index.php" method="post">
      <p>
        <input type="number" name="user_id" id="user_id" />user_id<br />
        <input type="number" name="type_id" id="type_id" />type_id<br />
        <input type="text" name="name" id="name" />Name<br />
        <input type="text" name="description" id="description" />Description<br />
        <input type="file" name="pic_url" id="pic_url" placeholder="" />Image<br />
        <input type="submit" value="Create" />
      </p>
    </form>
  </body>
</html>
