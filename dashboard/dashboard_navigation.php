<style>
  nav.bootstrapnavigation {
    top: 0;
    left: 0;
  }
</style>

<nav class="vh-100 position-fixed pt-5 col-md-2 bootstrapnavigation d-none d-md-block bg-light sidebar">
  <div class="sidebar-fixed">
    <ul class="nav flex-column"
    >
      <li class="nav-item">
        <a class="nav-link" href="./dashboard_interconnector.php?navderection=2sH65u7^lj">Dashboard</a>
      </li>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Teams</h6>
      
      <li class="nav-item">
        <a class="nav-link" href="./dashboard_interconnector.php?navderection=6L$6IQo2$c">Alle teams</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./dashboard_interconnector.php?navderection=7hHIh1Lz$1">Toegetreden teams</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./dashboard_interconnector.php?navderection=50cKcixZ*o">Eigen teams</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./dashboard_interconnector.php?navderection=BJbaVM@U41">Competitie</a>
      </li>
    </ul>
    

    <?php
      // if isset session id than show this admin menu!
      if (isset($_SESSION['admin']))
      {
        echo "<h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">Admin</h6>

              <ul class=\"nav flex-column mb-2\">
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"./dashboard_interconnector.php?navderection=yUOnR0A0l\">Instellingen</a>
                </li>
          
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"./dashboard_interconnector.php?navderection=4t1J62oOs\">Gebruikers Config</a>
                </li>
          
              </ul>";
      }
    ?>
  </div>
</nav>