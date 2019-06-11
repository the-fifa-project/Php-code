<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['admin']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$sql = "SELECT * from `users`";
$query = $db->query($sql);
$users = $query->fetchAll(2);


echo'<div class="row p-1">';

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
  
?>

<div class="col-12 p-0">
  <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Users</h2>
</div>

<div class="col-12 p-1 border rounded shadow-sm">
  <table class="table table-hover table-borderless">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Voornaam</th>
        <th scope="col">Achternaam</th>
        <th scope="col">E-mail</th>
        <th scope="col">Rol</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $count = 1;
        foreach ($users as $user)
        {
          echo '<tr>';
          echo "<td scope=\"row\">$count</td>";
          echo "<td>{$user['firstname']}</td>";
          echo "<td>{$user['middlename']} {$user['lastname']}</td>";
          echo "<td>{$user['email']}</td>";
          if ($user['dev_admin'] !== null)
          {
            echo "<td class='text-success'>Developer</td>";
          }
          else if ($user['administrator'] !== null)
          {
            echo "<td class='text-danger'>Administrator</td>";
          }
          else 
          {
            echo "<td class='text-muted'>Gebruiker</td>";
          }

          echo "<td> 
                <div class='dropdown login'>
                  <p class='h6 text-dark m-0 p-1 dropdown-toggle' data-toggle='dropdown' style='cursor: pointer;'>Opties</p>     
                    <div class='dropdown-menu dropdown-menu-right py-0'>
                      <button class='dropdown-item'>Rol veranderen</button>
                      <div class='dropdown-divider my-0'></div>
                      <h6 class='dropdown-header'>Gebruiker aanpassen</h6>
                        <button class='dropdown-item'>Gegevens</button>
                        <button class='dropdown-item'>Wachtwoord veranderen</button>
                    </div> 
                  </div>
                </td>"; 
          
          echo '</tr>';
          $count++;
        }
      ?>
    </tbody>
  </table>
</div>






<?php
require 'dashboard_footer.php';
