<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Embryon</title>
  </head>
  <body>
    <h2>Edit item</h2>
    <form action="index.php" method="post">
      <p>
        <input type="number" name="id" id="id" />id<br />
        <input type="number" name="type_id" id="type_id" />type_id<br />
        <input type="text" name="name" id="name" />Name<br />
        <input type="text" name="description" id="description" />Description<br />
        <input type="file" name="pic_url" id="pic_url" placeholder="" />Image<br />
        <input type="submit" value="Save" />
      </p>
    </form>
  </body>
</html>
