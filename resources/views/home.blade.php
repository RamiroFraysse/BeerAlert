@extends('layouts.app')
@section('content') 
        <!-- Botón de notificaciones -->
        <div class="container-fluid" style="text-align: center">
            <button class="oculto btn-noti-activadas" >Notificaciones Activadas</button>
            <button class="oculto btn-noti-desactivadas">Notificaciones Desactivadas</button>
            <br>
            <br>
            <br>
        </div>
        <!-- Fin de boton de notificaciones -->
        
        
        @if($temp_actual != -200)

        <div class="row justify-content-center">
        
                <div class="col-md-8">
                    <div id="container">    
                        <?php
                            require "../resources/views/temp_dia.php";
                        ?>
                    </div>
                </div>
        </div>

        @else
        <div class="container-fluid" style="text-align: center">                
                    <div class="row justify-content-center">
                        <img class = "img-fluid" src="../resources/assets/img/beer.png" alt="Responsive image">
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row justify-content-center">
                        <h3 style = "font-size: 3vw !important;"><i><b>Es hora de poner tu cerveza a enfriar!</b></i></h3>
                    </div>
        </div>
        @endif
        <br>
        <br>
       
        @if($temp_actual!=-200)
        <div class="row justify-content-center" )>
                <p style="color:white;">     
                    <span>El {{ $dato_ini }} encendió su dispositivo BeerAlert</span>
                </p>
        </div>
        <div class="row justify-content-center" >
            <div class="col col-lg-2">
                <!-- small box -->
                <div class="card small-box bg-danger text-center">
                    <div class="inner">
                        <h3>{{$temp_actual}} ℃</h3>
                        <p>Temperatura Actual</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-beer "></i>
                    </div>
                </div>
            </div>
            <div class="col col-lg-2">
                <!-- small box -->
                <div class="card small-box bg-success text-center">
                    <div class="inner">
                        <h3>3℃</h3>
                        <p>Temperatura Ideal</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-beer "></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
@endsection
