<!--<script>
  document.getElementById("register").parentElement.classList.add("active");
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

-->
<script>
document.getElementById("register").parentElement.classList.add("active");
  // Create new link element
const link = document.createElement('link');
link.setAttribute('rel', 'stylesheet');
link.setAttribute('href', 'http://localhost:8080/css/style2.css');

// Append to the `head` element
document.head.appendChild(link);
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