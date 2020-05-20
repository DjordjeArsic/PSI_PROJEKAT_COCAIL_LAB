<!DOCTYPE html>
<html lang="sr-RS">
<head>
  <title>Admin-Cocktail Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- linkovi za bootstrap 4 -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost:8080/fonts/icomoon/style.css">
    <link rel="stylesheet" href="http://localhost:8080/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://localhost:8080/css/nouislider.min.css">
    <link rel="stylesheet" href="http://localhost:8080/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="http://localhost:8080/css/style.css">
    <link rel="stylesheet" href="http://localhost:8080/css/nasCSS.css">
    
    <link rel="stylesheet" type="text/css" href="http://localhost:8080/css/style2.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">  
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
<!-- pocetak header-a -->
    <header>
      <nav class=" px-4 navbar navbar-expand-lg navbar-dark bg-primary mb-4">
          <?php echo "<a class='navbar-brand' href='".site_url("Pretraga/index")."'>COCKTAIL LAB</a>"; ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown4" aria-controls="navbarNavDropdown4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown4">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Admin/index")."' id='pretraga'>";?>
                <i class="fas fa-home fa-lg"></i> <span>Početna</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Admin/reportovaniRecepti")."' id='reportovaniRecepti'>";?>
                <i class="fas fa-bug fa-lg"></i> <span>Prijavljeni recepti</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Korisnik/postaviRecept")."' id='postaviRecept'>";?>            
                <i class="fas fa-upload fa-lg"></i> <span>Objavite recept</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Admin/mojiKokteli")."' id='mojiRecepti'>";?>          
                <i class="fas fa-laugh-beam fa-lg"></i> <span>Moji recepti</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Nalog/logOut")."'>";?>           
                <i class="fas fa-sign-out-alt fa-lg"></i> <span>Odjavite se</span></a>
              </li>
            </ul>
          </div>
        </nav> 
    </header>
<!-- kraj header-a -->


