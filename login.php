<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:45
 */

require 'header.php';
if(isset($_SESSION['id']))
{
    header('location: index.php');
    exit;
}
?>

<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-md-8 col-lg-6">
        <?php
        if (isset($_GET['action']) && $_GET['action'] === "register") {
          echo "
          <nav class=\"border shadow-lg my-4 px-4 pb-3\">
            <ul class=\"nav nav-fill\" id=\"rogin-register-tab\">
              <li class=\"nav-item\">
                <a href=\"#login\" class=\"nav-link\" id=\"login-tab\" data-toggle=\"tab\" aria-controls=\"login\" aria-selected=\"false\">
                  <h2 class=\"h4\">Inloggen</h2>
                </a>
              </li>
              <li class=\"nav-item\">
                <a href=\"#register\" class=\"nav-link  active\" id=\"register-tab\" data-toggle=\"tab\" aria-controls=\"register\" aria-selected=\"true\">
                  <h2 class=\"h4\">Registreren</h2>
                </a>
              </li>
            </ul>
            <!-- tabs where he goes switch -->
            <div class=\"tab-content\" id=\"login-register-tabcontent\">
              <!-- login form -->
              <div class=\"tab-pane fade\" id=\"login\" role=\"tabpanel\" aria-labelledby=\"login-tab\">
                <form action=\"includes/controller.php\" method=\"post\">";
                  if (isset($_GET['loginmsg']))
                  {
                    echo "<div class=\"form-group shadow-sm px-2 py-1 rounded my-2 alert alert-danger\" role=\"alert\">
                            <p class=\"m-0\">{$_GET['loginmsg']}</p>
                          </div>";
                  }
                  echo "<div class=\"form-group\">
                          <input type='hidden' name='type' value='login'>
                          <label for=\"email-login\">E-mail:</label>
                          <input type=\"email\" name='email' class=\"form-control shadow-sm\" id=\"email-login\">
                        </div>
                
                  <div class=\"form-group\">
                    <label for=\"pwdlogin\">Wachtwoord:</label>
                    <input type=\"password\" name='password' class=\"form-control shadow-sm\" id=\"pwdlogin\">
                  </div>
                
                  <button type=\"submit\" class=\"btn btn-primary\">Inloggen</button>
                </form>
              </div>

              <!-- registreren form -->
              <div class=\"tab-pane fade  show active\" id=\"register\" role=\"tabpanel\" aria-labelledby=\"register-tab\">
                <form action=\"includes/controller.php\" method=\"post\">
                  <input type='hidden' name='type' value='register'>";
                  if (isset($_GET['registermsg']))
                  {
                    echo "<div class=\"form-group shadow-sm px-2 py-1 rounded my-2 alert alert-danger\" role=\"alert\">
                            <p class=\"m-0\">{$_GET['registermsg']}</p>
                          </div>";
                  }

                  echo "<div class=\"form-group\">
                    <label for=\"firstname\">Voornaam: <span class='text-muted'>(Verplicht)</span></label>
                    <input type=\"text\" name='firstname' class=\"form-control shadow-sm\" id=\"firstname\" require>
                  </div>
                
                  <div class=\"form-group\">
                    <label for=\"middlename\">Tussenvoegsel:</label>
                    <input type=\"text\" name='middlename' class=\"form-control shadow-sm\" id=\"middlename\">
                  </div>
                
                  <div class=\"form-group\">
                    <label for=\"lastname\">Achternaam: <span class='text-muted'>(Verplicht)</span></label>
                    <input type=\"text\" name='lastname' class=\"form-control shadow-sm\" id=\"lastname\" require>
                  </div>
                
                  <div class=\"form-group\">
                    <label for=\"email-register\">E-mail: <span class='text-muted'>(Verplicht)</span></label>
                    <input type=\"email\" name='email' class=\"form-control shadow-sm\" id=\"email-register\" require>
                  </div>
                
                  <div class=\"form-group\">
                    <label for=\"pwdregister\">Wachtwoord: <span class='text-muted'>(Verplicht)</span></label>
                    <input type=\"password\" name='password' class=\"form-control shadow-sm\" id=\"pwdregister\" require>
                  </div>
                  
                  <div class=\"form-group\">
                    <label for=\"pwdConfirm\">Wachtwoord bevestigen: <span class='text-muted'>(Verplicht)</span></label>
                    <input type=\"password\" name='passwordconfirm' class=\"form-control shadow-sm\" id=\"pwdConfirm\" require>
                  </div>
                
                  <button type=\"submit\" class=\"btn btn-primary\">Registreren</button>
                </form>
              </div>
            </div>
          </nav>";
          }
          else 
          {
          echo "<!-- nav -->
                <nav class=\"border shadow-lg my-4 px-4 pb-3\">
                  <ul class=\"nav nav-fill\" id=\"rogin-register-tab\">
                    <li class=\"nav-item\">
                      <a href=\"#login\" class=\"nav-link active\" id=\"login-tab\" data-toggle=\"tab\" aria-controls=\"login\" aria-selected=\"true\">
                        <h2 class=\"h4\">Inloggen</h2>
                      </a>
                    </li>
                    <li class=\"nav-item\">
                      <a href=\"#register\" class=\"nav-link\" id=\"register-tab\" data-toggle=\"tab\" aria-controls=\"register\" aria-selected=\"false\">
                        <h2 class=\"h4\">Registreren</h2>
                      </a>
                    </li>
                  </ul>
                  <!-- tabs where he goes switch -->
                  <div class=\"tab-content\" id=\"login-register-tabcontent\">
                    <!-- login form -->
                    <div class=\"tab-pane fade show active\" id=\"login\" role=\"tabpanel\" aria-labelledby=\"login-tab\">
                      <form action=\"includes/controller.php\" method=\"post\">
                        <input type='hidden' name='type' value='login'>";
                        if (isset($_GET['loginmsg']))
                        {
                          echo "<div class=\"form-group shadow-sm px-2 py-1 rounded my-2 alert alert-danger\" role=\"alert\">
                                  <p class=\"m-0\">{$_GET['loginmsg']}</p>
                                </div>";
                        }
                        echo "
                          <div class=\"form-group\">
                            <label for=\"email-login\">E-mail:</label>
                            <input type=\"email\" name='email' class=\"form-control shadow-sm\" id=\"email-login\">
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"pwdlogin\">Wachtwoord:</label>
                            <input type=\"password\" name='password' class=\"form-control shadow-sm\" id=\"pwdlogin\">
                          </div>
                
                          <button type=\"submit\" class=\"btn btn-primary\">Inloggen</button>
                        </form>
                      </div>

                      <!-- registreren form -->
                      <div class=\"tab-pane fade\" id=\"register\" role=\"tabpanel\" aria-labelledby=\"register-tab\">
                        <form action=\"includes/controller.php\" method=\"post\">
                          <input type='hidden' name='type' value='register'>";
                          if (isset($_GET['registermsg']))
                          {
                            echo "<div class=\"form-group shadow-sm px-2 py-1 rounded my-2 alert alert-danger\" role=\"alert\">
                                    <p class=\"m-0\">{$_GET['registermsg']}</p>
                                  </div>";
                          }
                          echo "
                          <div class=\"form-group\">
                            <label for=\"firstname\">Voornaam: <span class='text-muted'>(Verplicht)</span></label>
                            <input type=\"text\" name='firstname' class=\"form-control shadow-sm\" id=\"firstname\" require>
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"middlename\">Tussenvoegsel:</label>
                            <input type=\"text\" name='middlename' class=\"form-control shadow-sm\" id=\"middlename\">
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"lastname\">Achternaam: <span class='text-muted'>(Verplicht)</span></label>
                            <input type=\"text\" name='lastname' class=\"form-control shadow-sm\" id=\"lastname\" require>
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"email-register\">E-mail: <span class='text-muted'>(Verplicht)</span></label>
                            <input type=\"email\" name='email' class=\"form-control shadow-sm\" id=\"email-register\" require>
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"pwdregister\">Wachtwoord: <span class='text-muted'>(Verplicht)</span></label>
                            <input type=\"password\" name='password' class=\"form-control shadow-sm\" id=\"pwdregister\" require>
                          </div>
                          
                          <div class=\"form-group\">
                            <label for=\"pwdConfirm\">Wachtwoord bevestigen: <span class='text-muted'>(Verplicht)</span></label>
                            <input type=\"password\" name='passwordconfirm' class=\"form-control shadow-sm\" id=\"pwdConfirm\" require>
                          </div>
                          
                          <button type=\"submit\" class=\"btn btn-primary\">Registreren</button>
                        </form>
                      </div>
                    </div>
                  </nav>
          ";
        }

        ?>
        

      </div>
    </div>
  </div>
</main>

<?php
require 'footer.php';
?>

<!-- href="#home"  aria-controls="home" aria-selected="true">Home</a> -->