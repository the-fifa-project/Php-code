<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:45
 */
//if (!isset($_SESSION['admin']))
//{
//    header('location: index.php');
//    exit;
//}


require 'header.php';

?>

<!-- search for nabvar for dashboard bootstrap 4 -->

<main>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-3 col-lg-2  p-0 m-1">

                <div class="shadow-sm border  p-1 w-100">

                    <h2 class="h4 border-bottom pb-1">Settings</h2>
                    <div class="time">
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-duration">Tijdsduur aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-break">Pauze tijd aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-half">match rust aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#fields">Velden aanpassen</button>
                        <button class="btn btn-warning text-white w-100 my-1" data-toggle="modal" data-target="#match-generate">Match Genereren</button>
                        <button class="btn btn-danger text-white w-100 my-1" data-toggle="modal" data-target="#match-delete">Match verwijderen</button>
                    </div>
                </div>

            </div>
            <div class="col m-1 p-0">

                <div class="shadow-sm border  p-1 w-100">
                    <h2 class="h4 border-bottom pb-1">Matches</h2>
                    <table class="table table-hover table-sm text-center">
                        <caption>List of competitions</caption>
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Match</th>
                            <th scope="col">Teams 1</th>
                            <th scope="col">Team 2</th>
                            <th scope="col">Time</th>
                            <th scope="col">Veld</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < $arrLength; $i++) {
                            for ($j = 0; $j < count($teamsArray); $j++) {
                                if ($teamsArray[0] !== $teamsArray[$j]) {
                                    echo "<tr>
                                                <th scope=\"row\">$count</th>
                                                    <td>$teamsArray[0]</td>
                                                    <td>$teamsArray[$j]</td>
                                                    <td>" . date('H:i', $endTime) . "</td>
                                                    <td>$fieldCounter</td>
                                                </tr>";
                                    if ($fieldCounter < $fields)
                                    {
                                        $fieldCounter++;
                                    }
                                    else
                                    {
                                        $fieldCounter = 1;
                                    }
                                    $count++;
                                    $timeS = date('H:i', $endTime);
                                    $endTime = strtotime("+$timeT minutes", strtotime($timeS));
                                }
                            }
                            array_shift($teamsArray);
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
<!--            <div class="col border shadow-sm m-1">-->
<!--                dsa-->
<!--            </div>-->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-duration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Speel tijd aanpassen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de tijd van een wedstrijd instellen <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" name="matchTime" id="matchTime" min="0">
                        <label for="matchTime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-break" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Speel tijd aanpassen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de tijd van een wedstrijd instellen <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" name="matchTime" id="matchTime" min="0">
                        <label for="matchTime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-half" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Speel tijd aanpassen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de tijd van een wedstrijd instellen <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" name="matchTime" id="matchTime" min="0">
                        <label for="matchTime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fields" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Velden instellen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hoeveel velden worden er gebruikt??</p>
                    </div>

                    <div class="formgroup">
                        <input type="number" name="matchTime" id="matchTime" min="0">
                        <label for="matchTime">Velden</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="match-generate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <input type="hidden" name="type" value="generate">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Compititie generator</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Weet u zeker dat u een compititie wilt laten genereren? als u dit doet wordt de vorige compititie <span class="text-danger">verwijdert!</span></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Genereren!</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="match-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Compititie generator</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Weet u zeker dat u de compititie wilt <span class="text-danger">verwijderen?</span></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ja dat wil ik</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
require 'footer.php';
?>