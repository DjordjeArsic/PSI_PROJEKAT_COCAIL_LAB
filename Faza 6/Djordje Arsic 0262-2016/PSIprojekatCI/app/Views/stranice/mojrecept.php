<?php
    echo "<div>";
    echo "<h1>{$koktel->naziv}</h1>";
    echo "<p>{$koktel->opis}<p>";
    echo '<b>Obavezni sastojci:&nbsp;</b>';
    for($i=0; $i<count($obaveznisastojci);$i++){
        if($i>0) echo ',&nbsp;';
        echo $obaveznisastojci[$i].' '."($obaveznisastojci_kolicina[$i])";
    }
    echo '<br/><b>Nebavezni sastojci: </b>';
    for($i=0; $i<count($neobaveznisastojci);$i++){
       if($i>0) echo ',&nbsp;';
       echo $neobaveznisastojci[$i].' '."($neobaveznisastojci_kolicina[$i])";
    }
?>
<form action="<?= site_url("Usercontroller/brisanjeMogRecepta/{$koktel->idKoktela}")?>");>
    <input value="Obrisi recept" type="submit">
</form>