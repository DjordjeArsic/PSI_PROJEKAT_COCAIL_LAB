<script>
  document.getElementById("login").parentElement.classList.add("active");
</script>

<main>
    <img class="wave" src="<?php echo base_url('/img/wave.png'); ?>" alt="wave">
    <div class="container">
        <div class="img">
            <img src="<?php echo base_url('/img/bg.svg'); ?>" alt="background">
        </div>
        <div class="login-content">
            <form name="loginform" action="<?= site_url("Nalog/loginSubmit") ?>" method="post" autocomplete="off">
                <img src="<?php echo base_url('/img/avatar.svg'); ?>" alt="avatar">
                <h2 class="title font-weight-bold">Prijavite se</h2>
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
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Lozinka</h5>
                        <input type="password" name="lozinka" class="input">
                    </div>
                </div>
                <?php echo "<a href='".site_url("Nalog/register")."'>Nemate nalog?</a>"; ?>
                <input type="submit" class="btn" value="Prijavite se">
            </form>
        </div>
    </div>
</main>

<script src="<?php echo base_url('/js/main2.js'); ?>"></script>
<script>
$("form").submit(function(event) {
    if($("input[name='korime']").val()==="" || $("input[name='lozinka']").val()==="") {
        $("#porukaDiv").empty();
        if($("input[name='korime']").val()==="") {
            $("#porukaDiv").append("<span class='text-danger'>Unesite korisničko ime!</span><br>");       
        }
        if($("input[name='lozinka']").val()==="") {
            $("#porukaDiv").append("<span class='text-danger'>Unesite lozinku!</span><br>");       
        }
        event.preventDefault();
    }
});
</script>