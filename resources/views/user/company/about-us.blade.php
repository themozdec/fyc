@extends('user.layouts.app', ['title' => 'Acerca de Nosotros'])

@section('css')
@endsection

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <x-alert></x-alert>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">{{env('APP_NAME')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('user.about_us')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('user.about_us')}}</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-0">
                    <div class="col-sm-4">

                    </div>
                    
                </div>
                <div class="row">


                   
                        <div class="col-md-12 mt-2">
                            <div class="border p-3 rounded mb-3 mb-md-0">
                                <span class="h5">¿Qué es Encuentra tu Código?<br><br>
Encuentra tu Código es una plataforma en la cual podrás encontrar recursos útiles para tu desarrollo profesional.<br><br>

Comunicación en Tiempo Real<br>
Nuestros desarrolladores de aplicaciones trabajan dentro de su zona horaria para permitir la colaboración en tiempo real y una verdadera sensación de “presencia en sucursal”, lo que garantiza una disponibilidad total durante el horario comercial.<br><br>

Escalabilidad y Soporte<br>
Trabajamos con usted en función de sus objetivos de desarrollo de software personalizado para brindarle el mayor valor y el retorno de la inversión más rápido mientras definimos tácticas y un equipo dedicado a su proyecto.<br><br>

Experiencia Específica en Múltiples Industrias<br>
Nuestros desarrolladores de software están organizados en divisiones virtuales, ofreciendo la experiencia del dominio y el conocimiento dentro de la industria para ofrecer soluciones de desarrollo de aplicaciones excepcionales.<br><br>

Código Fuente y la Titularidad de la Propiedad Intelectual<br>
Nuestras soluciones de software totalmente personalizables no requieren tarifas de licencia una vez finalizado el proyecto. Según nuestro acuerdo, usted será el propietario del código fuente y la propiedad intelectual de su software propietario.</span>
                                
                                
                                

                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div> <!-- container -->

@endsection

@section('script')
@endsection
