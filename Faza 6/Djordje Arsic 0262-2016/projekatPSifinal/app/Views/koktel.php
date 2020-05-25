<?php 
//    if ($koktelInfo->koktel == null) {
//        echo "Izabrali ste nepostojeći koktel.";
//        return;
//    }
//
//    if ($koktelInfo->koktel->obrisan) {
//        echo "Ovaj koktel je obrisan.";
//        return;
//    }
//
//    echo "<div>";
//    echo "<h1>{$koktelInfo->koktel->naziv}</h1>";
//    echo "<p>{$koktelInfo->koktel->opis}<p>";
//    echo '<b>Obavezni sastojci:&nbsp;</b>';
//    for($i=0; $i<count($koktelInfo->obavezniSastojci);$i++){
//        if($i>0) echo ',&nbsp;';
//        echo $koktelInfo->obavezniSastojci[$i]->naziv.' '.$koktelInfo->obavezniSastojci[$i]->kolicina;
//    }
//    if(!empty($koktelInfo->neobavezniSastojci)){
//        echo '<br/><b>Nebavezni sastojci: </b>';
//        for($i=0; $i<count($koktelInfo->neobavezniSastojci);$i++){
//            if($i>0) echo ',&nbsp;';
//            echo $koktelInfo->neobavezniSastojci[$i]->naziv.' '.$koktelInfo->neobavezniSastojci[$i]->kolicina;
//        }
//    }
//    echo '<br/>';
//    echo '<table><tr><td>';
//    if($koktelInfo->koktel->slika!=NULL){
//        //echo '<img  width="400" src="data:image/jpeg;base64,'.base64_encode( $koktelInfo->koktel->slika ).'"/>';
//        echo '<img  width="400" src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->slika).'"/>';
//    }
//    else{
//        echo '<img  width="400" src="'.base_url('img/glass.jpg').'"/>';
//    }
//    echo '</td>';
//    if($koktelInfo->koktel->video!=NULL){
//        echo '<video controls width="320" height="240">
//                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/mp4">
//                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/ogg">
//                <source src="'.base_url("/uploads/".$koktelInfo->koktel->idKoktela."/".$koktelInfo->koktel->video).'" type="video/webm">
//                Vaš pretraživač ne podržava video klipove. Ažurirajte verziju Vašeg pretraživača.
//              </video>';
//    }
//    echo '</tr></table>';
//   
//    // gost
//    if ($korisnik == null) {
//        echo '</div>';
//        return;
//    }
//    
//    // admin
//    if ($korisnik->isAdmin) {       
//        echo '<form action="'.site_url("Admin/brisanjeRecepta/".$koktelInfo->koktel->idKoktela).'" method="post">';
//        echo '<input value="Ukloni recept" type="submit"></form>';
//
//        echo '<form action="'.site_url("Admin/brisanjeKorisnika/".$koktelInfo->koktel->idKorisnika).'" method="post">';
//        echo '<input value="Ukloni korisnika" type="submit"></form>';
//    }
//    else {   
//        // korisnik
//        if ($korisnik->idKorisnika==$koktelInfo->koktel->idKorisnika) {
//            //echo "(ovde ide dugme za brisanje sopstvenog koktela)";
//            echo "<form action='".site_url("Korisnik/brisanjeMogRecepta")."' method ='POST'>";
//            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
//            echo "<input value='Obrisi recept' type='submit'>";
//            echo "</form>";
//        } 
//        else {
//            echo '<form method="post" action="'.site_url("Korisnik/reportovanjeTudjegRecepta").'" method="post";>';
//            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
//            foreach($razlozi as $razlog){
//                echo '<input type="checkbox" name="r['.$razlog->opisRazloga.']"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
//                if($razlog->idRazloga==3) echo " Original: <input type='text' name='original'><br/>";
//                else echo "<br/>";
//            }
//            echo '<input value="Reportuj recept" type="submit">';
//            echo '</form>';
//        }   
//    }
//    echo '</div>';

    if ($koktelInfo->koktel == null) {
        echo "Izabrali ste nepostojeći koktel.";
        return;
    }

    if ($koktelInfo->koktel->obrisan) {
        echo "Ovaj koktel je obrisan.";
        return;
    }

    echo "<div class='ml-4'>"; 
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
        echo '<img  width="400" src="'.base_url('uploads/'.$koktelInfo->koktel->idKoktela.'/'.$koktelInfo->koktel->slika).'"/>';
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
        echo '</div>';
        return;
    }
    
    // admin
    if ($korisnik->isAdmin) {       
        echo '<form action="'.site_url("Admin/brisanjeRecepta/".$koktelInfo->koktel->idKoktela).'" method="post" onsubmit="return potvrdiBrisanje()">';
        echo '<input value="Uklonite recept" type="submit"></form>';
        echo "</div>";
    }
    else {   
        // korisnik
        if ($korisnik->idKorisnika==$koktelInfo->koktel->idKorisnika) {
            //echo "(ovde ide dugme za brisanje sopstvenog koktela)";
            echo "<form action='".site_url("Korisnik/brisanjeMogRecepta")."' method ='POST' onsubmit='return potvrdiBrisanje()'>";
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            echo "<input value='Obrišite recept' type='submit'>";
            echo "</form>";
            echo "</div>";
        } 
        else {
            echo '<form>';
            echo '<input type="button" onclick="prikaziFormuZaPrijavu()" class="btn btn-primary" style="margin-bottom: 10px;" value="Prijavite recept"><br/>';
            echo '</form>';
            echo '<div id="sakrivena_forma">';
            echo '<form action="'.site_url("Korisnik/reportovanjeTudjegRecepta").'" method="post" onsubmit="return validanUnos()">';
            echo '<span id="poruka"></span>';
            echo '<input type="hidden" name="idKoktela" value="'.$koktelInfo->koktel->idKoktela.'">';
            $ind = 1;
            foreach($razlozi as $razlog){
               echo '<input type="checkbox" id="'.'razlog'.$ind.'" onclick="prikaziPoljeZaOriginal()" name="r['.$razlog->opisRazloga.']"'." value={$razlog->idRazloga}".'> '.$razlog->opisRazloga.'<br>';
               if($razlog->idRazloga==3) echo "<span id='unosOriginala'></span><br/>";
               $ind++;
            }
            echo '<input value="Prijavite recept" type="submit">';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        } 
    }

?>
<style>
    #sakrivena_forma{
        display:none;
		text-align: center;
        justify-content: center;
    }
</style>
<script type="text/javascript">
    function validanUnos($imeForme){
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
            poruka.innerHTML="<b><font color='red'>Morate uneti razlog prijave recepta!</font></b><br/>"
            return false;
        }
        if(razlogDuplikat==true && datOriginal==false){
            poruka = document.getElementById("poruka");
            poruka.innerHTML="<b><font color='red'>Morate navesti originalni recept ako tvrdite da je ovaj recept duplikat!</font></b><br/>"
            return false;
        }
        var potvrda = confirm("Da li ste sigurni da želite da reportujete ovaj recept?");
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
           var vidljiv = document.getElementById('unosOriginala');
           vidljiv.innerHTML="<input  type='text' name='original' id='original' class='mt-2 mb-3' placeholder='Original'>";
        }
        else{
           var vidljiv = document.getElementById('unosOriginala');
           vidljiv.innerHTML="";
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
</script>