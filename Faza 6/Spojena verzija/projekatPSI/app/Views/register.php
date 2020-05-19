<?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>

<script>
  document.getElementById('register').classList.add("active");
</script>


<form name="registrationform" action="<?= site_url("Nalog/registerSubmit") ?>" method="post">
<table>
    <tr>
        <td>Korisnicko ime:*</td>
        <td><input type="text" name="korime" value=""/></td>
    </tr>
    <tr>
        <td>Email:*</td>
        <td><input type="text" name="email" value=""/></td>
    </tr>
    <tr>
        <td>Lozinka:*</td>
        <td><input type="password" name="lozinka"/></td>
    </tr>
    <tr>
        <td>Ponovljena lozinka:*</td>
        <td><input type="password" name="ponovljenaLozinka"/></td>
    </tr>
    <tr>
        <td><input type="submit" value="Registracija"/></td>
    </tr>
</table>
</form>