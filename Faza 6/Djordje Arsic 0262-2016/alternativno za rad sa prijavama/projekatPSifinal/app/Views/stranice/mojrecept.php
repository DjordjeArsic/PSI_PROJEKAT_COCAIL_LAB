<?php
    echo "<div>";
    echo "<h1>{$koktel->naziv}</h1>";
    echo "<p>{$koktel->opis}<p>";
    echo '<b>Obavezni sastojci:&nbsp;</b>';
    for($i=0; $i<count($obaveznisastojci);$i++){
        if($i>0) echo ',&nbsp;';
        echo $obaveznisastojci[$i].' '."($obaveznisastojci_kolicina[$i])";
    }
    if(!empty($neobaveznisastojci)){
        echo '<br/><b>Nebavezni sastojci: </b>';
        for($i=0; $i<count($neobaveznisastojci);$i++){
            if($i>0) echo ',&nbsp;';
            echo $neobaveznisastojci[$i].' '."($neobaveznisastojci_kolicina[$i])";
        }
    }
    echo '<br/>';
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

?>
<form action="<?= site_url("Korisnik/brisanjeMogRecepta/{$koktel->idKoktela}")?>");>
    <input value="Obrisi recept" type="submit">
</form>