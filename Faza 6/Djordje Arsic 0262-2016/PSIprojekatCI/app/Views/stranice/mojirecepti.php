<?php
    foreach($kokteli as $koktel){
        echo "<div style='align:center; width:80%;'><h2>". anchor("Usercontroller/mojKoktel/{$koktel->idKoktela}", "$koktel->naziv", ['idKoktela'=>$koktel->idKoktela])."<h2></div><hr>";
    }

