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
                margin-left:200px;
                font-weight: bold;
                font-size: 40px;
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
            
            <aside id="aside">
                <div >
                    <div class="logo_val" style="float:right; position: absolute;">
                        <img src="images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="120" height="120" style="padding:10px;">
                    </div>
                    <div class="logo_afnor" style=" position: absolute; bottom:0%; right:0">
                        <img src="images/niv2.png" alt="Niveau deux de certification AFNOR" width="40" height="40">
                    </div>
                </div>
            </aside>

            <div style=" position:relative;">
                <div class="flex-center position-ref" >
                <h1 id=title>Rapport d'exploitation</h1>
                    <div>
                    
                    <div>
                        <h3>Flux pris en compte</h3>
                        @foreach($fluxx as $flux)
                            {{ \App\Flux::find($flux)->first()->type.' ('.\App\Flux::find($flux)->first()->societe.') ' }}
                        @endforeach
                    </div>

                    <div>
                        <h3>Déchetterie prises en compte</h3>
                        @foreach($dechetteries as $dechetterie)
                            {{ \App\Dechetterie::find($dechetterie)->first()->nom }}
                        @endforeach
                    </div>


                    @if($graphique)
                    <h1> Statistiques</h1>
                    <div ><img src="{{$graphe }}" width="600" height="300" style="background-color:white;" /></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
                    </div>
                    @endif

                    @if($tonnage && $graphique)
                        <div > <strong>Tonnage estimé : {{$tonnes}} tonnes</strong></div>
                    @endif
                    @if((($nc) || ($ncagglo)) && $graphique)
                        <div > <strong>Commandes avec des non-conformités : {{$pourcentage_nc}} %</strong></div>
                    @endif
                    @if ($enlevement && $graphique)
                        <div > <strong>Commandes enlevées en retard : {{ $pourcentage_enlevement_dans_les_delais }} %</strong></div>
                    @endif


                    @if($logs)
<p>

                    <div >
                        <h1> Logs</h1>
                        <ul>
                        @foreach($enregistrements as $enregistrement)
                        @if($enregistrement != '') 
                            <li style="margin-left:60px;margin-right:0;">{{$enregistrement}}</li>
                        @endif
                        @endforeach
                        </ul>
                    </div>
                    </p>
                    @endif

                </div>
            </div>
</div>

<footer >
<div style="position:relative;">
<div class="logo_val" style="float:left; margin-right:20px; ">
                        <img src="images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="50" height="50">
                    </div>
                    <div class="logo_afnor" style="padding-left:210px; padding-top:20px;">
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