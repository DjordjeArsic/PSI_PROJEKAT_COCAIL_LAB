<?php
    foreach($kokteli as $koktel){
        echo '<img  width="200" src="data:image/jpeg;base64,'.base64_encode( $koktel->slika ).'"/>';
        echo "<div style='align:center; width:80%;' ><h2>". anchor("Korisnik/mojKoktel/{$koktel->idKoktela}", "$koktel->naziv", ['idKoktela'=>$koktel->idKoktela])."<h2></div><hr>";
        
    }

