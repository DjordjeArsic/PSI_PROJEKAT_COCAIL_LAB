<?php
    echo "<div>";
    echo "<h1>{$koktel->naziv}</h1>";
    echo "<p>{$koktel->opis}<p>";
    echo '<table><tr><td>';
    if($koktel->slika!=NULL){
        echo '<img  width="400" src="data:image/jpeg;base64,'.base64_encode( $koktel->slika ).'"/>';
    }
    else{
        echo '<img  width="400" src="'.base_url('images/glass.jpg').'"/>';
    }
    echo '</td>';
    if($koktel->video!=NULL){
        echo '<td><iframe width="700" height="400" src='.$koktel->video.'></iframe></td>';
    }
    echo '</tr></table>';
    echo '<p style="color:red"><b>'.$poruka.'</b></p>';
?>
<form method='post' action="<?= site_url("Korisnik/reportovanjeTudjegRecepta/{$koktel->idKoktela}/{$registrovani->idRegistrovanog}")?>" method='post';>
<?php
    foreach($razlozi as $razlog){
        echo '<input type="checkbox" name="r['.$razlog->opisRazloga.']"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
        if($razlog->idRazloga==3) echo " Original: <input type='text' name='original'><br/>";
        else echo "<br/>";
    }
?>
    <input value="Reportuj recept" type="submit">
</form>
<?php

?>
