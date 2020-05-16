<form name="pretragaRecepata" action="<?= site_url("Pretraga/pretragaSubmit") ?>" method="post">   
    <?php   
        // ako postoji neka poruka tj. greska ispisujemo je ovde
        if($poruka!=null) {
            //var_dump($poruka);
            echo "<font color='red'>".$poruka."</font><br>";
        }
        // dohvati i ispisi sastojke iz baze
        foreach($sastojci as $value) {
            echo "<input type='checkbox' name='sastojci[]' value='$value->idSastojka'>".$value->naziv;
        }
    ?>
    <br><br>
    <input type="submit" value="Pretraga">
    <?php
        // ispis rezultata
        if($recepti!=null) { 
            foreach($recepti as $rezultat) {
                echo "<div><a href='".site_url('Pretraga/koktel/'.$rezultat->idKoktela)."'>".$rezultat->naziv."</a></div>";
            }
        }
    ?>
</form>