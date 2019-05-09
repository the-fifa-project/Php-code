<?php
/**
 * Created by PhpStorm.
 * User: GekkeGlenn
 * Date: 16-4-2019
 * Time: 12:01
 */

require 'header.php';

if (isset($_SESSION['id']))
{
    echo "inlogged as {$_SESSION['username']}";
}
?>

    <main>
        <h2>home pagina</h2>
    </main>

<?php

require 'footer.php';