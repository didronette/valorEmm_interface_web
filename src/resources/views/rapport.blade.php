<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, target-densitydpi=device-dpi, initial-scale=0.6, maximum-scale=5.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La souris, le cochon, le rat-porc</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles : TODO mais garder aside -->
        <style> 
            #aside {
                float: left;
                width: 200px;
                height: 100%;
                position: absolute;
                
            }


            
            

            table {
                max-width: 100%;
            }

            h1 {
                color : #1212CD;
                margin-top:0;
                padding-top: 20px;
                text-align: center;
                }

            .grid-aspect {
                display: grid;
                grid-auto-flow: line;
                grid-row-gap: 20px;
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            

            .column {
                 float: left;
                width: 50%;
                padding-right: 50px;
                padding-left: 50px;
            }

            /* Clear floats after the columns */
            .row:after {
            content: "";
            display: table;
            clear: both;
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



<body>



<div  style="background-color: #ffffff;">
            <h1>La souris, le cochon, le rat-porc</h1>
            <aside id="aside">
                <div >
                    <div class="logo_val" style="float:right; position: absolute;">
                        <img src="/images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="180" height="180" style="padding:10px;">
                    </div>
                    <div class="logo_afnor" style=" position: absolute; bottom:0%; right:0">
                        <img src="/images/niv2.png" alt="Niveau deux de certification AFNOR" width="80" height="80">
                    </div>
                </div>
            </aside>
            <div style=" position:relative;">
                <h1 class="flex-center title">@yield('titre') </h1>
                <div class="flex-center position-ref"  id="blue">
                    <div>
                    
                    <p>My first paragraph.</p>


    
                    <div ><img src="{{$graphe }}" style="background-color:white;" /></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
                    </div>
                </div>
            </div>
</div>




</body>
</html>