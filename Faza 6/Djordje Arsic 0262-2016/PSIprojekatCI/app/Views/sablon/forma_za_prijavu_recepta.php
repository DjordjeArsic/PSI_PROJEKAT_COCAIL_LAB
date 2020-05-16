<form method='post' action="<?= site_url("Korisnik/reportovanjeTudjegRecepta/{$koktel->idKoktela}/{$registrovani->idRegistrovanog}")?>" method='post';>
<?php
    foreach($razlozi as $razlog){
        echo '<input type="checkbox" name="r['.$razlog->opisRazloga.']"'."value={$razlog->idRazloga}".'>'.$razlog->opisRazloga;
        if($razlog->idRazloga==3) echo " Original: <input type='text' name='original'><br/>";
        else echo "<br/>";
    }
?>
    <input value="Reportuj recept" type="submit">
</form>