<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Embryon</title>
  </head>
  <body>
    <h2>Edit user</h2>
    <form action="index.php" method="post">
      <p>
        <input type="number" name="id" id="id" placeholder="" />id<br />
        <input type="text" name="firstname" id="firstname" placeholder="" />Prénom<br />
        <input type="text" name="lastname" id="lastname" placeholder="" />Nom<br />
        <input type="file" name="pic_url" id="pic_url" placeholder="" />Image<br />
        <input type="text" name="phone" id="phone" placeholder="" />Téléphone<br />
        <input type="text" name="building" id="building" placeholder="" />Batiment<br />
        <input type="number" name="floor" id="floor" placeholder="" />Etage<br />
        <input type="text" name="location" id="location" placeholder="" />Position<br />
        <input type="submit" value="Save" />
      </p>
    </form>
  </body>
</html>
