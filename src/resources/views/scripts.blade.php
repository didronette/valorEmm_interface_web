<script type="text/javascript">
   
   


   function HideorShow() {
       var x = document.getElementById("insertinputs");
       if (x.style.display === "none") {
           x.style.display = "block";
       } else {
           x.style.display = "none";
       }
   } 

    function Cocher(classe) {
        
        var elementsACocher = document.getElementsByClassName(classe);
        for(elem of elementsACocher) {
            elem.checked = true;
        } 
    }

    function Decocher(classe) {
        console.log(classe);
        var elementsACocher = document.getElementsByClassName(classe);
        for(elem of elementsACocher) {
            elem.checked = false;
        }  
    }

    function submitFormRapport(form){
        var fluxx = document.getElementsByClassName('flux');

        for(flux of fluxx) {
            if (flux.checked == true) {
                form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="'+flux.name+'" value="true">';

            }
        }

        var dechets = document.getElementsByClassName('dechetterie');

        for(dechet of dechets) {
            if (dechet.checked == true) {
                form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="'+dechet.name+'" value="true">';
            }
        }

        var date_debut = document.getElementsByName('date_debut')[0];
        form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="date_debut" value="'+date_debut.value+'">';
        var date_fin = document.getElementsByName('date_fin')[0];
        form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="date_fin" value="'+date_fin.value+'">';
        
        var enlevement = document.getElementsByName('enlevement')[0];
        if (enlevement.checked == true) {
            form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="enlevement" value="'+enlevement.checked+'">';
            }
        var tonnage = document.getElementsByName('tonnage')[0];
        if (tonnage.checked == true) {
            form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="tonnage" value="'+tonnage.checked+'">';
            }
        var nc = document.getElementsByName('nc')[0];
        if (nc.checked == true) {
            form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="nc" value="'+nc.checked+'">';
            }
        var ncagglo = document.getElementsByName('ncagglo')[0];
        if (ncagglo.checked == true) {
            form.innerHTML = form.innerHTML+'<input type=\'hidden\' name="ncagglo" value="'+ncagglo.checked+'">';
            }

      return true;
  };







</script>


