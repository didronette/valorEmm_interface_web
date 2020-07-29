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

</script>


