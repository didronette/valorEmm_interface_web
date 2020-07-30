
@extends('layouts.app')
@section('content')

        

<div class="full-height">
            <aside id="aside">
                <div >
                    <div class="logo_val" style="float:right; position: absolute;">
                        <img src="/images/logoValorEmm.jpg" alt="Logo de Valor'Emm" width="190" height="190" style="padding:10px;">
                    </div>
                    <div class="logo_afnor" style=" position: absolute; bottom:0%; left:120px">
                        <img src="/images/niv2.png" alt="Niveau deux de certification AFNOR" width="80" height="80">
                    </div>
                </div>
            </aside>
            <div style=" position:relative;">
                <h1 class="flex-center title">@yield('titre') </h1>
                <div class="flex-center position-ref full-height" id="blue">
                    <div>
                    
                        @yield('contenu')
                    </div>
                </div>
            </div>
        </div>
        
        


@endsection
