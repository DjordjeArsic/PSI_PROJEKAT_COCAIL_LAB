<script>
  document.getElementById("mojiRecepti").parentElement.classList.add("active");
  
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
<?php

    if (count($kokteli)==0) {
        echo '<div style="text-align: center;">';
        echo "Nemate ni jedan koktel.";
        echo '</div>';
    }
    echo "<div class='container'>";
    foreach($kokteli as $koktel) {
        echo '<div class="row bg-light mt-3 border-radius">';
        echo '<div class="col-sm-12 col-md-4">';
        if($koktel->slika==NULL) 
            echo '<img src="http://localhost:8080/img/placeholder.svg" class="fotografija-koktela img-fluid" alt="Nema slike koktela">';
        else 
            echo '<img src="'.base_url("/uploads/".$koktel->idKoktela."/".$koktel->slika).'"'
            . ' alt="Fotografija koktela" class="fotografija-koktela img-fluid" />';                   
        echo '</div>';
        echo '<div class="col-sm-12 col-md-8 text-md-left">';
        echo '<h2 class="mt-3 naslov-koktela">'
        .'<a href="'.site_url('Pretraga/koktel/'.$koktel->idKoktela).'">'.$koktel->naziv.'</a></h2>';
        echo '<p>Obavezni sastojci: ';
        $obavezni = $obavezni_sastojci_mojih_koktela[$koktel->idKoktela];
        $br = 0;
        foreach($obavezni as $obavezan) {
            if($br!=0) echo ', ';
            $br=1;
            echo $obavezan;
        }               
        $neobavezni = $neobavezni_sastojci_mojih_koktela[$koktel->idKoktela];
        if($neobavezni!=null) {
            echo '</p><p>Neobavezni sastojci: ';
            $br=0;
            foreach($neobavezni as $neobavezan) {
                if($br!=0) echo ', ';
                $br=1;
                echo $neobavezan;
            } 
        }
        echo "<form action='".site_url("Korisnik/brisanjeMogRecepta")."' method ='POST' onsubmit='return potvrdiBrisanje()'>";
        echo '<input type="hidden" name="idKoktela" value="'.$koktel->idKoktela.'">';
        echo "<input value='Obrišite recept' type='submit'>";
        echo "</form>";
        echo '</p></div></div>';
    }
    echo "</div>";
