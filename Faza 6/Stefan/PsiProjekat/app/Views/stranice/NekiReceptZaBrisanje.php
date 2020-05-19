<?php
    echo 'Neki recept<br><br>';
?>

<form action="<?= site_url("Admin/brisanjeRecepta/2")?>" method="post">
    <input value="Ukloni recept" type="submit">
</form>

<form action="<?= site_url("Admin/brisanjeKorisnika/2")?>" method="post">
    <input value="Ukloni korisnika" type="submit">
</form>