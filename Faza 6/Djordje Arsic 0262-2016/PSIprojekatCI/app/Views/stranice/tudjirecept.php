<?php
    echo "<div>";
    echo "<h1>{$koktel->naziv}</h1>";
    echo "<p>{$koktel->opis}<p>";
?>
<form action="<?= site_url("Usercontroller/reportovanjeTudjegRecepta/{$koktel->idKoktela}/{$registrovani->idRegistrovanog}")?>";>
<?php
    foreach($razlozi as $razlog){
        echo '<input type="checkbox" name="r[]"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga."<br/>";
    }
?>
    <input value="Reportuj recept" type="submit">
</form>
<?php
    if($registrovani !=null){
        echo '<h1>Postoji korisnik</h1>';
    }
