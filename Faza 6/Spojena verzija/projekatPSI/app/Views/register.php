<script>
document.getElementById("register").parentElement.classList.add("active");
</script>

<main>
    <img class="wave" src="http://localhost:8080/img/wave.png" alt="wave">
    <div class="container">
        <div class="img">
            <img src="http://localhost:8080/img/bg.svg" alt="background">
        </div>
        <div class="login-content">
            <form name="registrationform" action="<?= site_url("Nalog/registerSubmit") ?>" method="post" autocomplete="off">
                <img src="http://localhost:8080/img/avatar.svg" alt="avatar">
                <h2 class="title font-weight-bold">Registrujte se</h2>
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
                <div class="input-div one">
                   <div class="i">
                        <i class="fas fa-envelope"></i>
                   </div>
                   <div class="div">
                        <h5>E-mail</h5>
                        <input type="text" name="email" value="" class="input">
                   </div>
                </div>
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Lozinka</h5>
                        <input type="password" name="lozinka" class="input">
                    </div>
                </div>
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Ponovite lozinku</h5>
                        <input type="password" name="ponovljenaLozinka" class="input">
                    </div>
                </div>
                <input type="submit" class="btn" value="Registrujte se">
            </form>
        </div>
    </div>
</main>

<script src="http://localhost:8080/js/main2.js"></script>