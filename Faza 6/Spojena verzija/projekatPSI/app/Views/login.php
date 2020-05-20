<script>
  document.getElementById("login").parentElement.classList.add("active");
</script>


<!--<form name="loginform" action="<?= site_url("Nalog/loginSubmit") ?>" method="post">
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
</form>-->
<main style="min-height: 500px">
    <img class="wave" src="http://localhost:8080/img/wave.png">
    <div class="container">
        <div class="img">
            <img src="http://localhost:8080/img/bg.svg">
        </div>
        <div class="login-content">
            <form name="loginform" action="<?= site_url("Nalog/loginSubmit") ?>" method="post" autocomplete="off">
                <img src="http://localhost:8080/img/avatar.svg">
                <h2 class="title font-weight-bold">Prijavite se</h2>
                <?php if(isset($poruka)) echo "<span class='text-danger'>$poruka</span><br>"; ?>
                <div class="input-div one">
                   <div class="i">
                        <i class="fas fa-user"></i>
                   </div>
                   <div class="div">
                        <h5>Korisničko ime</h5>
                        <input type="text" name="korime" value="" class="input">
                   </div>
                </div>
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Lozinka</h5>
                        <td><input type="password" name="lozinka" class="input">
                    </div>
                </div>
                <?php echo "<a href='".site_url("Nalog/register")."'>Nemate nalog?</a>"; ?>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
</main>
        
<script type="text/javascript" src="http://localhost:8080/js/main2.js"></script>