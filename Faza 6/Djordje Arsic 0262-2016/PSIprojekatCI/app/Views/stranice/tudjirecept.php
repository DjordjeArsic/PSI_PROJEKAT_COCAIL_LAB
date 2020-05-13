<?php
    echo "<div>";
    echo "<h1>{$koktel->naziv}</h1>";
    echo "<p>{$koktel->opis}<p>";
    echo '<img  width="200" src="data:image/jpeg;base64,'.base64_encode( $koktel->slika ).'"/>';
?>
<form action="<?= site_url("Korisnik/reportovanjeTudjegRecepta/{$koktel->idKoktela}/{$registrovani->idRegistrovanog}")?>";>
<?php
    foreach($razlozi as $razlog){
        echo '<input type="checkbox" name="r[]"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
        if($razlog->idRazloga==3) echo " Original: <input type='text' name='original'><br/>";
        else echo "<br/>";
    }
?>
    <input value="Reportuj recept" type="submit">
</form>
<?php
    if($registrovani !=null){
        echo '<h1>Postoji korisnik</h1>';
    }
