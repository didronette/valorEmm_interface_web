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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles : TODO mais garder aside -->
        <style> 
            #aside {
                float: left;
                width: 100px;
                height: 100%;
                position: absolute;
                
            }


            body {
                color : #000000;
            }
            

            table {
                max-width: 100%;
            }

            h1 {
                margin-top:0;
                padding-top: 20px;
                text-align: center;
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



<div  style="background-color: #ffffff;">
            <h1>La souris, le cochon, le rat-porc</h1>
            <aside id="aside">
                <div >
                    <div class="logo_val" style="float:right; position: absolute;">
                        <img src="images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="80" height="80" style="padding:10px;">
                    </div>
                    <div class="logo_afnor" style=" position: absolute; bottom:0%; right:0">
                        <img src="images/niv2.png" alt="Niveau deux de certification AFNOR" width="40" height="40">
                    </div>
                </div>
            </aside>
            <div style=" position:relative;">
                <div class="flex-center position-ref" >
                    <div>
                    
                    <div>
                        <h3>Flux pris en compte</h3>
                        @foreach($fluxx as $flux)
                            {{ \App\Flux::find($flux)->first()->type.' ('.\App\Flux::find($flux)->first()->societe.') ' }}
                        @endforeach
                    </div>

                    <div>
                        <h3>Déchetterie prise en compte</h3>
                        @foreach($dechetteries as $dechetterie)
                            {{ \App\Dechetterie::find($dechetterie)->first()->nom }}
                        @endforeach
                    </div>


                    @if($graphique)
                    <div ><img src="{{$graphe }}" width="600" height="300" style="background-color:white;" /></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
                    </div>

                    @if($tonnage)
                        <div > <strong>Tonnage estimé : {{$tonnes}} tonnes</strong></div>
                    @endif
                    @if(($nc) || ($ncagglo))
                        <div > <strong>Commandes avec des non-conformités : {{$pourcentage_nc}} %</strong></div>
                    @endif
                    @if ($enlevement)
                        <div "> <strong>Commandes enlevées en retard : {{ $pourcentage_enlevement_dans_les_delais }} %</strong></div>
                    @endif
                    @endif

                    @if($logs)
                    <div >
                        <h1> Logs</h1>
                        <ul>
                        @foreach($enregistrements as $enregistrement)
                            <li>{{$enregistrement}}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
</div>




</body>
</html>