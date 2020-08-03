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

    $("#formRapport").submit( function(eventObj) {

    //Aller chercher les flux
    //Aller chercher les dechets
    //Aller chercher les dates
    //Aller chercher les donnees
      $("<input />").attr("type", "hidden")
          .attr("name", "something")
          .attr("value", "something")
          .appendTo("#formRapport");
      return true;
  });

</script>


