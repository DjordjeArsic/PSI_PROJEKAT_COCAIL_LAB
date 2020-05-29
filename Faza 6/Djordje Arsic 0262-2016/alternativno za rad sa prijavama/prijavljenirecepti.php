<script>
  document.getElementById("reportovaniRecepti").parentElement.classList.add("active");
</script>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>Lista prijavljenih recepata:</h2><br>

                
                <?php
                $ImaPrijava = 0;
                $BrPrijave = 1;
                foreach($prijave as $prijava)
                {
                    if($prijava->obrisanaPrijava == 0)
                    {
                        echo "<div class='bg-light mb-3 p-3 border-radius'>";
                        echo "<h4>Prijava broj $BrPrijave</h4>"; $BrPrijave = $BrPrijave + 1;
                        
                        echo "-Id prijavljenog koktela: $prijava->idKoktela"; echo"<br>"; 
                        echo "-Id korisnika: $prijava->idRegistrovanog"; echo"<br>"; 
                        echo "-Datum podnete prijave: $prijava->datum";  echo"<br><br>"; 

                        $BrRazloga = 1; $ImaPrijava = 1;
                        echo "-Razlozi: ";
                        foreach($prijava->razlozi as $razlog)
                        {
                            echo "<br>";
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;$BrRazloga. ";  $opis = $razlozi[$razlog->idRazloga];
                            echo "$opis";

                            $BrRazloga = $BrRazloga + 1;
                            
                            if($razlog->duplikat)
                            {
                                echo "<a href='$razlog->duplikat'> Link ka duplikatu </a>";
                            }
                        }


                        echo "<br><br>";
                        echo anchor("Pretraga/koktel/" . $prijava->idKoktela, "Link ka prijavljenom receptu");
                        echo "<br><br>";
                       echo '<form method="post" action="'.site_url("Admin/brisanjePrijave/$prijava->idKoktela/". "$prijava->idRegistrovanog/$prijava->datum").'">';
                       echo '<input type="hidden"  value="'.$prijava->datum.'" name="datum2">';
                       echo "<input value='Obrišite prijavu' type='submit'>";
                       echo "</form>";
                       echo "</div>";
                    }
                }
                
                if($ImaPrijava == 0)
                {
                    echo '<h4><span style="color:red">-Nema prijavljenih recepata!</span></h4>';
                }
                ?>
           </div>
        </div> 
    </div>
</body>