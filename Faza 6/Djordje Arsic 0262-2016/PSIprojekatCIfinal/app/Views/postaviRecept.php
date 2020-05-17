<?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>

<script>
  document.getElementById("postaviRecept").innerHTML = "";
</script>


<form name="postavljanjeforma" action="<?= site_url("Korisnik/receptSubmit") ?>" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <td>Naziv:*</td>
        <td><input type="text" name="naziv" value="<?php echo $naziv ?>" /></td>
    </tr>
    <tr>
        <td>Opis:*</td>
        <td><textarea name="opis" rows="5" cols="60"><?php echo $opis ?></textarea></td>
    </tr>
    <tr>
        <td colspan="2">Odaberi sastojke:</td>
    </tr>
        <?php
            foreach($sastojci as $value) {
                echo "<tr>";
                echo "<td>".$value.":</td>";
                echo "<td><input type='text' name='kolicine[".$value."]' placeholder='Npr. 100ml ili 1 kasicica'/>";
                echo "<input type='checkbox' name='neobavezni[]' value='$value'>Neobavezan sastojak</input></td>";
                echo "</tr>";
            }
        ?>
   
    <tr>
        <td colspan="2"><br>Okači fotografiju: <input type="file" accept="image/*" name="fotografija"></td>
    </tr>
    <tr><td colspan="2"><br>Okači video: <input type="file" accept="video/*" name="video"></td>
    </tr>
    
    <tr>
        <td><br><input type="submit" value="Postavi recept"/></td>
    </tr>

</table>
</form>