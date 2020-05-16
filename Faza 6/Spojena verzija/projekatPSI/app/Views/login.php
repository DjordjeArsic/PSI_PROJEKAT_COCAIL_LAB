<?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>

<script>
  document.getElementById("login").innerHTML = "";
</script>


<form name="loginform" action="<?= site_url("Nalog/loginSubmit") ?>" method="post">
<table>
    <tr>
        <td>Korisnicko ime:</td>
        <td><input type="text" name="korime" value=""/></td>
    </tr>
    <tr>
        <td>Lozinka:</td>
        <td><input type="password" name="lozinka"/></td>
    </tr>
    <tr>
        <td><input type="submit" value="Log in"/></td>
    </tr>
</table>
</form>