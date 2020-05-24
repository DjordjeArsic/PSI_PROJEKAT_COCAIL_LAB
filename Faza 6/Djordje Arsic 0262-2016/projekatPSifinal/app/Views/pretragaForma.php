<script>
  document.getElementById("pretraga").parentElement.classList.add("active");
</script>

<div class="align-self-center container text-center align-items-center mt-5">
    <img class="fotografija-pocetna" src="http://localhost:8080/img/refreshing_beverage.svg" alt="Osvežavajuće piće">
    <h3 class="mt-3 mb-2">Unesite sastojke koje imate kod sebe:</h3>

    <!--Make sure the form has the autocomplete function switched off:-->
    <form name="pretragaRecepata" action="<?= site_url("Pretraga/pretragaSubmit") ?>" method="post" autocomplete="off">
      <div id="porukaDiv">
      <?php   
        // ako postoji neka poruka tj. greska ispisujemo je ovde
        if($poruka!=null) {
            //var_dump($poruka);
            echo "<span class='text-danger'>$poruka</span><br>";
        }
      ?>
      </div>
      <div class="autocomplete">
        <input id="myInput" type="text" name="sastojak" placeholder="" autofocus>
      </div>
      <div id="unos"></div>
      <div id="unetiSastojci" class="mt-2">
      </div>
      <input type="submit" class="mt-3 btn btn-primary btn-lg" id="submitButton" value="Pretraži">     
    </form>   
    <?php
        // ispis rezultata
        if($recepti!=NULL) { 
            foreach($recepti as $rezultat) {
                
                echo '<div class="row bg-light mt-3 border-radius">';
                echo '<div class="col-sm-12 col-md-4">';
                if($rezultat->koktel->slika==NULL) 
                    echo '<img src="http://localhost:8080/img/placeholder.svg" class="fotografija-koktela img-fluid" alt="Nema slike koktela">';
                else 
                    echo '<img src="'.base_url("/uploads/".$rezultat->koktel->idKoktela."/".$rezultat->koktel->slika).'"'
                        . ' alt="Fotografija koktela" class="fotografija-koktela img-fluid" />';                   
                echo '</div>';
                  
                echo '<div class="col-sm-12 col-md-8 text-md-left">';
                echo '<h2 class="mt-3 naslov-koktela">'
                .'<a href="'.site_url('Pretraga/koktel/'.$rezultat->koktel->idKoktela).'">'.$rezultat->koktel->naziv.'</a></h2>';
                echo '<p>Obavezni sastojci: ';
                
                $obavezni = $rezultat->obavezniSastojci;
                foreach($obavezni as $key=>$sastojak) {
                    if($key!=0) echo ', ';
                    echo $sastojak->naziv.' '.$sastojak->kolicina;
                }               
                
               $neobavezni = $rezultat->neobavezniSastojci;
                if($neobavezni!=null) {
                    echo '</p><p>Neobavezni sastojci: ';
                    foreach($neobavezni as $key=>$sastojak) {
                        if($key!=0) echo ', ';
                        echo $sastojak->naziv.' '.$sastojak->kolicina;
                    } 
                }
                
                echo '</p></div></div>';
            }
        }
       
      ?>
</div>

<script>
function dodajSastojakUListuIzabranih(sastojakNaziv, sastojakId) {
    // pravljenje dugmeta sa nazivom sastojk         
    var button = document.getElementById("id"+sastojakId);

    // ako sastojak vec postoji obavesti korsinika crvenim border-om
    if(button) {           
      button.setAttribute("style", "border: 2px solid red;");
      setTimeout(function() {
          button.removeAttribute("style");
      }, 700);

      return;
    }``
    /* ispisi uneti sastojak i izbrisi input */
    var noviSastojak = document.createElement("button");
    noviSastojak.setAttribute("id", "id"+sastojakId);
    noviSastojak.setAttribute("class", "btn btn-outline-primary btn-sm mr-2 mt-2");
    noviSastojak.addEventListener("click", function() {
        
        var sastojciSesija = JSON.parse(sessionStorage.getItem("upamceniSastojci"));       
        for(var i=0; i<sastojciSesija.length; ++i) {
            if(sastojciSesija[i].id==this.id.substr(2)) {
                sastojciSesija.splice(i, 1);
                break;
            }    
        }       
        sessionStorage.setItem("upamceniSastojci", JSON.stringify(sastojciSesija));
        
        document.getElementsByClassName("class"+this.id)[0].remove();
        this.remove();
    });
    var nazivSastojka = document.createTextNode(sastojakNaziv+" x");
    noviSastojak.appendChild(nazivSastojka);

    var element = document.getElementById("unetiSastojci");
    element.appendChild(noviSastojak);
    // dugme napravljeno

    // pravljenje hidden input-a
    var divUnos = document.getElementById("unos");
    var inputHidden = document.createElement("input");
    inputHidden.type = "hidden";
    inputHidden.name = "sastojci[]";
    inputHidden.value = sastojakId;
    inputHidden.setAttribute("class", "classid"+inputHidden.value);
    divUnos.appendChild(inputHidden);
    // hidden input napravljen
    
    return;
}
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
          // var sastojak cuva naziv sastojka, var sastojakId cuva id sastojka kao u BP
          b.addEventListener("click", function() {
              /*insert the value for the autocomplete text field:*/            
              sastojak=this.getElementsByTagName("input")[0].value;             
              sastojakId=this.getElementsByTagName("input")[0].id;
              var novi = {id: sastojakId, naziv: sastojak};

              var sastojciSesija = JSON.parse(sessionStorage.getItem("upamceniSastojci"));
              
              if(sastojciSesija===null) {
                sastojciSesija = [];
              }
              
              var flag = true;
              for(var i=0; i<sastojciSesija.length; ++i) {
                  if(sastojciSesija[i].id==sastojakId) {
                    flag = false;
                    break;
                  }
              }
              
              if(flag) sastojciSesija.push(novi);
              sessionStorage.setItem("upamceniSastojci", JSON.stringify(sastojciSesija));
              
              dodajSastojakUListuIzabranih(sastojak, sastojakId);
          
              inp.value="";

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
        if(inp.value !== "") {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
              /*and simulate a click on the "active" item:*/
              if (x) x[currentFocus].click();
            }
        }
        else {
            e.preventDefault();
            document.getElementById("submitButton").click();
        }
      }
     
  });
  
  document.getElementsByTagName("body")[0].addEventListener("keydown", function(e) {
      if (e.keyCode == 13 && document.activeElement !== inp) {
        document.getElementById("submitButton").click();
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

// ako korisnik klikne da posalje formu prvo proveri da li je uneo barem jedan sastojak
// ako jeste posalji formu, ako nije ispis poruku o gresci
$("form").submit(function( event ) {
    if($('#unos').children().length === 0) {
        $("#porukaDiv").empty();
        $("#porukaDiv").append("<span class='text-danger'>Niste uneli nijedan sastojak!</span><br>");
        event.preventDefault();
    }
});

// dohvati sastojke iz baze i prosledi kao niz za sugestije
<?php
    $sastojciZaPretragu=[];
    foreach($sastojci as $value) {
        $sastojciZaPretragu[]=$value;
    }
?>
// ovo ubacuje sastojke za autocomplete 
var sastojci = <?php echo json_encode($sastojciZaPretragu); ?>;
autocomplete(document.getElementById("myInput"), sastojci);

// citanje vec unetih sastojaka iz sesije
var sastojciIzSesije = JSON.parse(sessionStorage.getItem("upamceniSastojci"));

if(sastojciIzSesije!==null) {
    for (var i=0; i<sastojciIzSesije.length; i++) {
        dodajSastojakUListuIzabranih(sastojciIzSesije[i].naziv, sastojciIzSesije[i].id);
    }
}
</script>
