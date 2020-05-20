<script>
  document.getElementById("reportovaniRecepti").parentElement.classList.add("active");
</script>

<?php

echo "<br><br>";
foreach($prijave as $prijava)
{
    if($prijava->obrisanaPrijava == 0)
    {
        echo "Id prijavljenog koktela: $prijava->idKoktela"; echo"<br>"; 
        echo "Id korisnika: $prijava->idRegistrovanog"; echo"<br>"; 
        echo "Datum podnete prijave: $prijava->datum";  echo"<br>"; 
        
        echo "Razlozi: ";
        foreach($prijava->razlozi as $razlog)
        {
            echo "<br>";
            echo "&nbsp;&nbsp;&nbsp;$razlog->idRazloga. ";  $opis = $razlozi[$razlog->idRazloga];
            echo "$opis";
            
            if($razlog->duplikat)
            {
                echo " Link duplikata: $razlog->duplikat";
            }
        }
        
        echo "<br>";echo "<br>";
        echo anchor("Pretraga/koktel/" . $prijava->idKoktela, "Link ka receptu");
        echo "<br>";
        
       echo "
        <form action='". site_url("Admin/brisanjePrijave/$prijava->idKoktela/$prijava->idRegistrovanog")."' method='post'>
        <input value='Ukloni prijavu' type='submit'>
        </form>";
       
                
        echo "<br>";echo "<br>";
    }
}
?>