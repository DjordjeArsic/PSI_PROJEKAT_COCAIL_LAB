<?php 
    if ($koktelInfo->koktel == null) {
        echo "<p class='text-center'>Izabrali ste nepostojeći koktel!</p>";
        return;
    }

    if ($koktelInfo->koktel->obrisan) {
        echo "<p class='text-center'>Ovaj koktel je obrisan!</p>";
        return;
    }

    echo "<div class='m-4'>";
    echo "<h1>{$koktelInfo->koktel->naziv}</h1>";
    echo "<p>Datum: {$koktelInfo->koktel->datum}</p>";
    echo "<p>{$koktelInfo->koktel->opis}</p>";
    echo '<p class="mb-3">Obavezni sastojci: ';
    for($i=0; $i<count($koktelInfo->obavezniSastojci);$i++){
        if($i>0) { echo ', '; }
        echo $koktelInfo->obavezniSastojci[$i]->naziv.' '.$koktelInfo->obavezniSastojci[$i]->kolicina;
    }
    if(!empty($koktelInfo->neobavezniSastojci)){
        echo '<br/>Nebavezni sastojci: ';
        for($i=0; $i<count($koktelInfo->neobavezniSastojci);$i++){
            if($i>0) { echo ', '; }
            echo $koktelInfo->neobavezniSastojci[$i]->naziv.' '.$koktelInfo->neobavezniSastojci[$i]->kolicina;
        }
    }
    echo '</p>';
    if($koktelInfo->koktel->slika!=NULL){        
        echo '<img src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->slika).'" '
                . 'alt="Fotografija koktela" class="responsive-max-500 mb-2"><br>';
    }
    
    if($koktelInfo->koktel->video!=NULL){
        echo '<video controls class="responsive-max-500">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/mp4">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/ogg">
                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/webm">
                Vaš pretraživač ne podržava video klipove. Ažurirajte verziju Vašeg pretraživača.
              </video><br>';
    }
   
    // gost
    if ($korisnik == null) {
        echo '</div>';
        return;
    }
    
    // admin
    if ($korisnik->isAdmin) {       
        echo '<form class="mt-2" action="'.site_url("Admin/brisanjeRecepta/".$koktelInfo->koktel->idKoktela).'" method="post" onsubmit="return potvrdiBrisanje()">';
        echo '<input value="Obrišite recept" type="submit"></form>';
        
        if($koktelInfo->koktel->idKorisnika!==$korisnik->idKorisnika) {
            echo '<form class="mt-2" action="'.site_url("Admin/brisanjeKorisnika/".$koktelInfo->koktel->idKorisnika).'" method="post" onsubmit="return potvrdiBrisanjeKorisnika()">';
            echo '<input value="Obrišite korisnika" type="submit"></form>';
        }
    }
    else {   
        // korisnik
        if ($korisnik->idKorisnika==$koktelInfo->koktel->idKorisnika) {
            //echo "(ovde ide dugme za brisanje sopstvenog koktela)";
            echo "<form class='mt-2' action='".site_url("Korisnik/brisanjeMogRecepta")."' method ='POST' onsubmit='return potvrdiBrisanje()'>";
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            echo "<input value='Obrišite recept' type='submit'>";
            echo "</form>";
        } 
        else {
            echo '<input type="button" onclick="prikaziFormuZaPrijavu()" class="btn btn-primary" style="margin-bottom: 10px;" value="Prijavite recept"><br/>';
            echo '<div id="sakrivena_forma">';
            echo '<form class="mt-2" action="'.site_url("Korisnik/reportovanjeTudjegRecepta").'" method="post" onsubmit="return validanUnos()">';
            echo '<span id="poruka"></span>';
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            $ind = 1;
            foreach($razlozi as $razlog){
                echo '<label><input type="checkbox" id="'.'razlog'.$ind.'" onclick="prikaziPoljeZaOriginal()" name="r['.$razlog->opisRazloga.']"'." value={$razlog->idRazloga}".'> '.$razlog->opisRazloga.'</label><br>';
                if($razlog->idRazloga==3) { echo "<span id='unosOriginala'></span><br/>"; }
                $ind++;
            }
            echo '<input value="Prijavite recept" type="submit">';
            echo '</form>';
            echo '</div>';
        }   
    }
    echo "</div>";
?>

<script>
    var vec_prikazano = 0;
    
    function validanUnos(){
        var datRazlog = false;
        var razlogDuplikat = false;
        var datOriginal = false;
        var original;
        var poruka;
        var ind = 1;
        while(document.getElementById("razlog"+ind)!=null){
            if (document.getElementById("razlog"+ind).checked == true){
                datRazlog = true;
                if(ind==3){
                    razlogDuplikat=true;
                    original = document.getElementById("original").value;
                    if((original!="")&&(original!=null)){
                        datOriginal= true;
                    }
                }
            }
            ind++;
        }
        if( datRazlog == false){
            poruka = document.getElementById("poruka");
            poruka.innerHTML="<span class='text-danger'>Morate uneti razlog prijave recepta!</span><br/>"
            return false;
        }
        if(razlogDuplikat==true && datOriginal==false){
            poruka = document.getElementById("poruka");
            poruka.innerHTML="<span class='text-danger'>Morate navesti originalni recept ako tvrdite da je ovaj recept duplikat!</span><br/>"
            return false;
        }
        var potvrda = confirm("Da li ste sigurni da želite da prijavite ovaj recept?");
        if(potvrda == true){
            return true;
        }
        else{
            sakrijFormuZaPrijavu();
            return false;
        }
    }
    function prikaziPoljeZaOriginal(){
        if(document.getElementById("razlog3").checked==true){
           if(vec_prikazano == 0){    
            var vidljiv = document.getElementById('unosOriginala');
            vidljiv.innerHTML="<input  type='text' name='original' id='original' class='mt-2 mb-3' placeholder='Original'>";
            vec_prikazano = 1;
            }
        }
        else{
           var vidljiv = document.getElementById('unosOriginala');
           vidljiv.innerHTML="";
           vec_prikazano = 0;
        }   
    }
    function prikaziFormuZaPrijavu(){
        var objekat = document.getElementById("sakrivena_forma");
        if (objekat.style.display=='flex'){
            objekat.style.display='none'
        }
        else{
            objekat.style.display='flex'
        }
    }
    function sakrijFormuZaPrijavu(){
        document.getElementById("sakrivena_forma").style.display='none';
    }
    function potvrdiBrisanje(){
        var potvrda = confirm("Da li želite da obrišete ovaj recept?");
        if(potvrda==true){
            return true;
        }
        else{
            return false;
        }
    }
    
    function potvrdiBrisanjeKorisnika() { 
        var potvrda = confirm("Da li želite da obrišete ovog korisnika?");
        if(potvrda==true){
            return true;
        }
        else{
            return false;
        }
    }
</script>
