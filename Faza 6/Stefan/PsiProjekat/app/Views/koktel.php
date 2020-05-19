<?php
    
    if ($koktelInfo->koktel == null) {
        echo "Izabrali ste nepostojeći koktel.";
        return;
    }

    if ($koktelInfo->koktel->obrisan) {
        echo "Ovaj koktel je obrisan.";
        return;
    }

    echo "<div>";
    echo "<h1>{$koktelInfo->koktel->naziv}</h1>";
    echo "<p>{$koktelInfo->koktel->opis}<p>";
    echo '<b>Obavezni sastojci:&nbsp;</b>';
    for($i=0; $i<count($koktelInfo->obavezniSastojci);$i++){
        if($i>0) echo ',&nbsp;';
        echo $koktelInfo->obavezniSastojci[$i]->naziv.' '.$koktelInfo->obavezniSastojci[$i]->kolicina;
    }
    if(!empty($koktelInfo->neobavezniSastojci)){
        echo '<br/><b>Nebavezni sastojci: </b>';
        for($i=0; $i<count($koktelInfo->neobavezniSastojci);$i++){
            if($i>0) echo ',&nbsp;';
            echo $koktelInfo->neobavezniSastojci[$i]->naziv.' '.$koktelInfo->neobavezniSastojci[$i]->kolicina;
        }
    }
    echo '<br/>';
    echo '<table><tr><td>';
    if($koktelInfo->koktel->slika!=NULL){
        echo '<img  width="400" src="data:image/jpeg;base64,'.base64_encode( $koktelInfo->koktel->slika ).'"/>';
    }
    else{
        echo '<img  width="400" src="'.base_url('images/glass.jpg').'"/>';
    }
    echo '</td>';
    if($koktelInfo->koktel->video!=NULL){
        echo '<td><iframe width="700" height="400" src='.$koktelInfo->koktel->video.'></iframe></td>';
    }
    echo '</tr></table>';
   
    // gost
    if ($korisnik == null) {
        return;
    }
    
    // admin
    if ($korisnik->isAdmin) {
        echo "(ovde ide dugme za brisanje koktela)<br>";
        echo "(ovde ide dugme za brisanje naloga)";
    }
    else {   
        // korisnik
        if ($korisnik->idKorisnika==$koktelInfo->koktel->idKorisnika) {
            //echo "(ovde ide dugme za brisanje sopstvenog koktela)";
            echo "<form action='".site_url("Korisnik/brisanjeMogRecepta/{$koktelInfo->koktel->idKoktela}")."'>";
            echo "<input value='Obrisi recept' type='submit'>";
            echo "</form>";
        } 
        else {
            echo "(ovde ide dugme za reportovanje tudjeg koktela)";
        }   
    }
?>