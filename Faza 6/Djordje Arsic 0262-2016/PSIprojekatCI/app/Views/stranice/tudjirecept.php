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
            poruka.innerHTML="<b><font color='red'>Morate uneti razlog prijave recepta!</font></b>"
            return false;
        }
        if(razlogDuplikat==true && datOriginal==false){
            poruka = document.getElementById("poruka");
            poruka.innerHTML="<b><font color='red'>Morate navesti originalni recept ako tvrdite da je ovaj recept duplikat!</font></b>"
            return false;
        }
        return true;
    }
    function prikaziPoljeZaOriginal(){
        if(document.getElementById("razlog3").checked==true){
           var vidljiv = document.getElementById('unosOriginala');
           vidljiv.innerHTML=" Original: <input  type='text' name='original' id='original'>";
        }
    }
</script>
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
?>
<span id="poruka"></span>
<form  name='FormaZaReportovanjeRecepta' method='post' action="<?= site_url("Korisnik/reportovanjeTudjegRecepta")?>" method='post' onsubmit="return validanUnos()">
<?php
    echo '<input type="hidden" name="idKoktela" value="'.$koktel->idKoktela.'">';
    echo '<input type="hidden" name="idRegistrovanog" value="'.$registrovani->idRegistrovanog.'">';
    $ind = 1;
    foreach($razlozi as $razlog){
        echo '<input type="checkbox" onclick="prikaziPoljeZaOriginal();" id="'.'razlog'.$ind.'" name="r['.$razlog->opisRazloga.']"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
        if($razlog->idRazloga==3) echo "<span id='unosOriginala'></span><br/>";
        else echo "<br/>";
        $ind++;
    }
?>
    <input value="Reportuj recept" type="submit">
</form>
<?php

?>
