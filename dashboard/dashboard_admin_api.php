<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['admin']))
{
  header('location: ./dashboard_interconnector.php');
}

echo'<div class="row">';

if (isset($_GET['err']))
{
  $error = $_GET['err'];
  echo "<div class=\"col-12 p-0\"><h2 class=\"h4 p-1 ml-2 alert-danger rounded m-1 border shadow-sm\">$error</h2></div>";
}
else if (isset($_GET['succ']))
{
  $success = $_GET['succ'];
  echo "<div class=\"col-12 p-0\"><h2 class=\"h4 p-1 ml-2 alert-success rounded m-1 border shadow-sm\">$success</h2></div>";
}

function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^*';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

echo generateRandomString(15);

?>

<div class="col-12 p-0">
  <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Api Settings</h2>
</div>
<div class="col-4">
  <p>Genereer jou api-key(sleutel) hier, de key wordt automaties opgeslagen.</p>
  <form action="../includes/controller.php" method="post">
    <input type="hidden" name="type" value="apikey">
    <button type="submit" class="btn btn-info">Genereer Api-key</button>
  </form>
</div>


<?php
require 'dashboard_footer.php';
