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
        //echo '<img  width="400" src="data:image/jpeg;base64,'.base64_encode( $koktelInfo->koktel->slika ).'"/>';
        echo '<img  width="400" src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->slika).'"/>';
    }
    else{
        echo '<img  width="400" src="'.base_url('img/glass.jpg').'"/>';
    }
    echo '</td>';
    if($koktelInfo->koktel->video!=NULL){
        echo '<video controls width="320" height="240">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/mp4">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/ogg">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/webm">
                Vaš pretraživač ne podržava video klipove. Ažurirajte verziju Vašeg pretraživača.
              </video>';
    }
    echo '</tr></table>';
   
    // gost
    if ($korisnik == null) {
        echo '</div>';
        return;
    }
    
    // admin
    if ($korisnik->isAdmin) {       
        echo '<form action="'.site_url("Admin/brisanjeRecepta/".$koktelInfo->koktel->idKoktela).'" method="post">';
        echo '<input value="Ukloni recept" type="submit"></form>';

        echo '<form action="'.site_url("Admin/brisanjeKorisnika/".$koktelInfo->koktel->idKorisnika).'" method="post">';
        echo '<input value="Ukloni korisnika" type="submit"></form>';
    }
    else {   
        // korisnik
        if ($korisnik->idKorisnika==$koktelInfo->koktel->idKorisnika) {
            //echo "(ovde ide dugme za brisanje sopstvenog koktela)";
            echo "<form action='".site_url("Korisnik/brisanjeMogRecepta")."' method ='POST'>";
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            echo "<input value='Obrisi recept' type='submit'>";
            echo "</form>";
        } 
        else {
            echo '<form method="post" action="'.site_url("Korisnik/reportovanjeTudjegRecepta").'" method="post";>';
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            foreach($razlozi as $razlog){
                echo '<input type="checkbox" name="r['.$razlog->opisRazloga.']"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
                if($razlog->idRazloga==3) echo " Original: <input type='text' name='original'><br/>";
                else echo "<br/>";
            }
            echo '<input value="Reportuj recept" type="submit">';
            echo '</form>';
        }   
    }
    echo '</div>';
?>