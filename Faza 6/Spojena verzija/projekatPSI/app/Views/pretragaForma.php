<script>
  document.getElementById('pretraga').classList.add("active");
</script>

<div class="container text-center align-items-center" style="height: 400px;">
    <h2>Unesite sastojke koje imate kod sebe</h2>

    <!--Make sure the form has the autocomplete function switched off:-->
    <form name="pretragaRecepata" action="<?= site_url("Pretraga/pretragaSubmit") ?>" method="post" autocomplete="off">
        <?php   
        // ako postoji neka poruka tj. greska ispisujemo je ovde
        if($poruka!=null) {
            //var_dump($poruka);
            echo "<font color='red'>".$poruka."</font><br>";
        }
        ?>
      <div class="autocomplete" style="width:300px;">
        <input id="myInput" type="text" name="sastojak" placeholder="">
      </div>
      <div id="unos"></div>
      <div id="unetiSastojci" class="mt-2"></div>
      <input type="submit" class="mt-3 btn btn-primary" value="Pretraga">
      <?php
        // ispis rezultata
        if($recepti!=null) { 
            foreach($recepti as $rezultat) {
                echo "<div><a href='".site_url('Pretraga/koktel/'.$rezultat->idKoktela)."'>".$rezultat->naziv."</a></div>";
            }
        }
      ?>     
    </form>   
</div>

<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].naziv.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].naziv.substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].naziv.substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' id='"+ arr[i].idSastojka +"' value='" + arr[i].naziv + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              // inp.value = this.getElementsByTagName("input")[0].value;
              var sastojak = this.getElementsByTagName("input")[0].value; 
              
              var button = document.getElementById("id"+this.getElementsByTagName("input")[0].id);
              if(button) {           
                  inp.value="";
                  
                  button.setAttribute("style", "border: 3px solid red;");
                  setTimeout(function() {
                      button.removeAttribute("style");
                  }, 700);
                  
                  return;
              }
              /* ispisi uneti sastojak i izbrisi input */
              var noviSastojak = document.createElement("button");
              noviSastojak.setAttribute("id", "id"+this.getElementsByTagName("input")[0].id);
              noviSastojak.setAttribute("class", "btn btn-outline-primary btn-sm mr-2");
              //noviSastojak.setAttribute("onClick", ukloniSastojak());
              noviSastojak.addEventListener("click", function() {
                document.getElementsByClassName("class"+this.id)[0].remove();
                this.remove();
              });
              var nazivSastojka = document.createTextNode(sastojak+" x");
              noviSastojak.appendChild(nazivSastojka);

              var element = document.getElementById("unetiSastojci");
              element.appendChild(noviSastojak);
              
              inp.value="";
              var divUnos = document.getElementById("unos");
              var inputHidden = document.createElement("input");
              inputHidden.type = "hidden";
              inputHidden.name = "sastojci[]";
              inputHidden.value = this.getElementsByTagName("input")[0].id;
              inputHidden.setAttribute("class", "classid"+inputHidden.value);
              divUnos.appendChild(inputHidden);
              
              
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
  
  
}

// dohvati sastojke iz baze i prosledi kao niz za sugestije
<?php
    $sastojciZaPretragu=[];
    foreach($sastojci as $value) {
        $sastojciZaPretragu[]=$value;
    }
?>
var sastojci = <?php echo json_encode($sastojciZaPretragu); ?>;

autocomplete(document.getElementById("myInput"), sastojci);

</script>


<!--<form name="pretragaRecepata" action="<?= site_url("Pretraga/pretragaSubmit") ?>" method="post">   
    <?php   
        // ako postoji neka poruka tj. greska ispisujemo je ovde
        if($poruka!=null) {
            //var_dump($poruka);
            echo "<font color='red'>".$poruka."</font><br>";
        }
        // dohvati i ispisi sastojke iz baze
        foreach($sastojci as $value) {
            echo "<input type='checkbox' name='sastojci[]' value='$value->idSastojka'>".$value->naziv;
        }
    ?>
    <br><br>
    <input type="submit" value="Pretraga">
    <?php
        // ispis rezultata
        if($recepti!=null) { 
            foreach($recepti as $rezultat) {
                echo "<div><a href='".site_url('Pretraga/koktel/'.$rezultat->idKoktela)."'>".$rezultat->naziv."</a></div>";
            }
        }
    ?>
</form>
-->