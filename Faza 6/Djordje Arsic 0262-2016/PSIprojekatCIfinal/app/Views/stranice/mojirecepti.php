<script>
  document.getElementById("mojiRecepti").innerHTML = "";
</script>
<?php

    if (count($kokteli)==0) {
        echo "Nemate ni jedan koktel.";
    }

    foreach($kokteli as $koktel){
        if($koktel->slika!=NULL){
            echo '<img  width="200" src="data:image/jpeg;base64,'.base64_encode( $koktel->slika ).'"/>';
        }
        else{
           echo '<img  width="200" src="'.base_url('images/glass.jpg').'"/>'; 
        }
        echo "<div style='align:center; width:80%;' ><h2>". anchor("Korisnik/mojKoktel/{$koktel->idKoktela}", "$koktel->naziv", ['idKoktela'=>$koktel->idKoktela])."<h2></div>";
        echo '<form action="'.site_url("Korisnik/brisanjeMogRecepta/{$koktel->idKoktela}").'");>';
        echo '<input value="Obrisi recept" type="submit"><hr>';
        echo '</form>';
    }

