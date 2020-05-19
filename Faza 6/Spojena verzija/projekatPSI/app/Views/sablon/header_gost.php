<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo '<br>header_gost ';
//echo '<a href='.site_url("Pretraga/index").' id="pretraga">Home</a> ';
//echo '<a href='.site_url("Nalog/login").' id="login">Log in</a> ';
//echo ' <a href='.site_url("Nalog/register").' id="register">Registracija</a> ';
//echo '<br><br>';
?>
<!DOCTYPE html>
<html lang="sr-RS">
<head>
  <title>Gost-Cocktail Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- linkovi za bootstrap 4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<style>
    * { box-sizing: border-box; }
body a {
  font: 16px Tahoma;
  font-weight: bold;
}
footer {
    font: 16px Tahoma;
    font-weight: bold;
}
h2 {
    font: 24px Tahoma;
    font-weight: 500;
}

.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
<body>
<!-- pocetak header-a -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom pt-3 pb-3">
      <?php echo "<a class='navbar-brand' href='".site_url("Pretraga/index")."'>COCKTAIL LAB</a>"; ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Pretraga/index")."' id='pretraga'>Početna</a>"; ?>
          </li>
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Nalog/login")."' id='login'>Ulogujte se</a>"; ?>            
          </li>
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Nalog/register")."' id='register'>Registrujte se</a>"; ?>            
          </li>
        </ul>
      </div>
    </nav>
</header>
<!-- kraj header-a -->