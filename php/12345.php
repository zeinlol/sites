<form method="post" action="noname1.php">
    <input type="text" name="x">Chislo 1<br>
    <input type="text" name="y">Chislo 2<br>
    <input type="text" name="w">Chislo 3<br>
    <input type="text" name="z">Chislo 4<br>
    <button type="submit">Poschitat</button>
</form> 
<?php
    $x = $_POST['x'];
    $y = $_POST['y'];
    $a = $_POST['w'];
    $b = $_POST['z'];
    for ($x = 1;$x <= $y; $x++) {
        if ($a%2== 0){
            $a = $a^2^$b;
            echo ('Ctepen'.$a);
            $a = $_POST['w'];
        }
        else {
           $a = $a*$b;
           echo ('Dobytok'.$a); 
           $a = $_POST['w'];
        }    
    }
     
?>


