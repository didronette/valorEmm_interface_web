<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, target-densitydpi=device-dpi, initial-scale=0.6, maximum-scale=5.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rapport</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <!-- Styles : TODO mais garder aside -->
        <style> 
            #aside {
                padding-left:40px;
                float: left;
                width: 100px;
                height: 100%;
                position: absolute;
                
            }

            footer .pagenum:before {
      content: counter(page);
}

@page { margin: 100px 25px; }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; background-color: lightblue; height: 50px; padding:0 10px;}
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }

            body {
                color : #000000;
                
                
            }
            

            table {
                max-width: 100%;
            }

            #title {
                margin-top:0;
                margin-left:50px;
                font-weight: bold;
                font-size: 60px;
                }

            h1,h3 {
                font-weight: bold;
            }


            .acceptable-width {
                width: 50%;
            }
            
            .logo_val {
                float: top;
            }

            .logo_afnor {
                float: bottom;
            }

            .full-height {
                height: 85vh;
                
            }

            .flex-center {
                align-items: center;
                
                justify-content: center;
            }



            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 58px;
                display: flex;
                margin-left: 200px;
                
            }

            

            

            #blue {
                color : #1212CD;
            }

            #yellow {
                background-color: #fffd9e;
                border: 4px solid;
                border-color: #3097d1;
            }


        </style>


    
</head>



<body style="background-color: #ffffff;">



<div  style="background-color: #ffffff; ">

            <div style=" position:relative;">
                <div class="flex-center position-ref" >
                <div div style=" margin-top:300px;">
                    <h1 id=title>Rapport des incidents</h1>
                    <img src="images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="300" height="300" style="margin:30px; margin-left:200px;">
                </div>
                    <div>
                    



                    <div >
                        
                        @foreach($enregistrements as $incident)
                        <p>

                            <div style="padding:30px;">
                                Incident reporté pour la déchetterie de {!! $incident->getDechetterie()->nom !!} par {!! $incident->getAgent()->name !!}. <br>
                                Incident survenu le {!! $incident->date_heure !!}. <br>

                                Détails :
                                <ul>
                                <li>Catégorie de l'incident : {!! $incident->categorie !!}</li>
                                @if(isset($incident->type_vehicule)) 
                                <li>Type du véhicule : {!! $incident->type_vehicule !!}</li>
                                <li>Marque du véhicule : {!! $incident->marque_vehicule !!}</li>
                                <li>Couleur du véhicule : {!! $incident->couleur_vehicule !!}</li>
                                <li>Immatriculation du véhicule : {!! $incident->immatriculation !!}</li>
                                <li>Numéro Sidem Pass : {!! $incident->numero_sidem_pass !!}</li>
                                @endif
                                <li>Description de l'incident : {!! $incident->description !!}</li>
                                <li>Réponse apportée : {!! $incident->reponse_apportee !!}</li>

                                

                                </ul>
                                <div>Photos de l'incident :</div>
                                @foreach($incident->getPhotos() as $photo)
                                <div style="margin-top:20px;margin-left:30px;">
                                    <div><img src="{!! substr($photo->url, 1) !!}" alt="{!! $photo->nom !!}" height="350" ></div>
                                    <div>{!! $photo->nom !!}</div>
                                </div>
                                @endforeach

                                
                            </div>
                            </p>
                        @endforeach
                        
                    </div>
                    
               

                </div>
            </div>
</div>

<footer >
<div style="position:relative;">
<div class="logo_val" style="float:left; margin-right:20px; ">
                        <img src="images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="50" height="50">
                    </div>
                    <div class="logo_afnor" style="padding-left:210px; padding-top:21px;">
                        <img src="images/niv2.png" alt="Niveau deux de certification AFNOR" width="30" height="30">
                    </div>
                    <div style="padding-left:300px; display: inline;">
                        Source : Valor'Emm {{\Carbon::now()->format('Y')}}
                    </div>
            <div class="pagenum-container" style="float:right">Page <span class="pagenum"></span></div>
</div>

</footer>



</body>
</html>