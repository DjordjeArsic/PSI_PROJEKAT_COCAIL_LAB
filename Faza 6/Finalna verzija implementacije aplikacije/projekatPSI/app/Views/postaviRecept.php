
<script>
  document.getElementById("postaviRecept").parentElement.classList.add("active");
  
  function toggleVis(checkbox) {
      var red = document.getElementById(checkbox.value);
      if (red.style.display === "none") {
        red.style.display = "flex";
      }
      else {
        red.style.display = "none";
        
        red.getElementsByTagName("input")[0].value = "";
        red.getElementsByTagName("input")[1].checked = false;
      }
      return;
  }
</script>

<form  class="m-2" name="postavljanjeforma" action="<?= site_url("Korisnik/receptSubmit") ?>" method="post" enctype="multipart/form-data">
<div class="container">
    <div class="row p-2">
        <div class="col-xs-5 col-md-2"> Naziv:* </div>
        <div class="col-xs-10 col-md-7"> <input type="text" name="naziv" value="<?php echo $naziv ?>"/> </div>
    </div>
    <div class="row p-2">
        <div class="col-xs-5 col-md-2"> Opis:* </div>
        <div class="col-xs-10 col-md-7"> <textarea class="rounded w-100" name="opis" rows="5"><?php echo $opis ?></textarea> </div>
    </div>
    <div class="row p-2">
        <div class="col-xs-5 col-md-2"> Odaberi sastojke:* </div>
        <div class="col-xs-10 col-md-7">
            <?php
                foreach($sastojci as $value) {  
                    echo "<span class='ml-2'><label><input type='checkbox' value='$value' onclick='toggleVis(this)'>";
                    echo " $value</label></span>";
                }
            ?>
        </div>
    </div>
         
    <?php
        foreach($sastojci as $value) {
            echo "<div class='row p-2' id='$value' style='display:none'>";
            echo "<div class='col-xs-5 col-md-2'>".$value.":</div>";
            echo "<div class='col-xs-12 col-md-5'><input type='text' name='kolicine[".$value."]' placeholder='(Npr. 100ml ili 1 kasicica)'/></div>";
            echo "<div class='col-xs-12 col-md-3'><label><input type='checkbox' name='neobavezni[]' value='$value'> Neobavezan sastojak<label></div>";
            echo "</div>";
        }
    ?>

    <div class="row p-2">
        <div class="ol-xs-5 col-md-2"> Okači fotografiju: </div>
        <div class="col-xs-10 col-md-7"> <input class="w-100 bg-white" type="file" accept="image/*" name="fotografija"/> </div>
    </div>
    
    <div class="row p-2">
        <div class="ol-xs-5 col-md-2"> Okači video: </div>
        <div class="col-xs-10 col-md-7"> <input class="w-100 bg-white" type="file" accept="video/*" name="video"/> </div>
    </div>
    
    <div class="row p-2">
        <div class="col-7 text-danger" id="porukaDiv"> <?php if(isset($poruka)) echo $poruka ?> </div>
    </div>

    <div class="row p-4">
        <div class="col-12"> <input class="w-100" type="submit" value="Postavi recept"/> </div>
    </div>
         
</div>
</form>

<script>
$("form").submit(function(event) {
    
    var flag = false;
    var opis = document.getElementsByName('opis')[0];
    var inputs = document.getElementsByTagName('input');
    
    for(var i = 0; i < inputs.length; i++) {
        if(inputs[i].type.toLowerCase() === 'text') {
            if (inputs[i].getAttribute("name") !== "naziv" && inputs[i].value !== "") {
                flag = true;
                break;
            }
        }
    }
    
    if($("input[name='naziv']").val()==="" || opis.value==="" || !flag) {
        $("#porukaDiv").empty();
        if($("input[name='naziv']").val()==="") {
            $("#porukaDiv").append("Niste uneli naziv recepta.<br>");       
        }
        if(opis.value==="") {
            $("#porukaDiv").append("Niste uneli opis recepta.<br>");       
        }
        if(!flag) {
            $("#porukaDiv").append("Niste uneli nijedan obavezan sastojak.<br>");       
        }
        event.preventDefault();
    }
});
</script>