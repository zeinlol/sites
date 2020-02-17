<form method="post" action="noname1.php">
    <input type="text" name="x">Nachalo<br>
    <input type="text" name="y">Conec<br>
    <input type="text" name="z">Stepen<br>
    <input type="text" name="c">Mnogytel<br>
    <button type="submit">Poschitat</button>
</form> 
<?php
    $x = $_POST['x'];
    $y = $_POST['y'];
    $b = $_POST['z'];
    $c = $_POST['c'];
    for ($q = $x;$q <= $y; $q++) {
        if ($x%2 == 0){
            $x = $x**$b;
            echo ('Ctepen'.$x);
            $x = $x+1;
        }
        else {
           $x = $x*$c;
           echo ('Dobytok'.$x);
           $x = $x+1;
        }    
    }  
?>

