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
                <div id="porukaDiv" class="mb-3">
                <?php if(isset($poruka)) echo "<span class='text-danger'>$poruka</span>"; ?>
                </div>
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

<script>
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}    

// lozinka mora biti 3-16 karaktera          
function validatePass(pass) {
  var re = /^(.){3,16}$/;
  return re.test(pass);
}
    
$("form").submit(function(event) {
    // pretpostavimo da nema greske
    var flag=0;
    
    var korime = $("input[name='korime']").val();
    var email = $("input[name='email']").val();
    var lozinka = $("input[name='lozinka']").val();
    var potvrdaLozinke = $("input[name='ponovljenaLozinka']").val();
    
    // nije uneto korisnicko ime
    if(korime === "") {
        $("#porukaDiv").empty();
        $("#porukaDiv").append("<span class='text-danger'>Unesite korisničko ime!</span><br>");
        flag=1;
    }
    
    // email nije u dobrom formatu
    if(!validateEmail(email)) {       
        if(flag === 0) $("#porukaDiv").empty();
        $("#porukaDiv").append("<span class='text-danger'>E-mail nije ispravan!</span><br>");
        flag = 1;
    }
    
    // provera da li je lozinka u ispravnom formatu
    if(!validatePass(lozinka)) {
        if(flag === 0) $("#porukaDiv").empty();
        $("#porukaDiv").append("<span class='text-danger'>Lozinka mora imati 3-16 karaktera!</span><br>");
        flag = 1;
    }   
    // ako jeste lozinka i potvrda lozinke moraju biti iste
    else if (lozinka !== potvrdaLozinke) {
        if(flag === 0) $("#porukaDiv").empty();
        $("#porukaDiv").append("<span class='text-danger'>Lozinka i potvrda lozinke se ne slažu!</span><br>");
        flag = 1;
    }
    
    if(flag === 1) event.preventDefault();
});
</script>