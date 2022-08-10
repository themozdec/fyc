<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.shared.title-meta', ['title' => "Iniciar Sesión"])

    @include('admin.layouts.shared.head-css')
</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <span class="logo">
                                                <span class="logo-lg-text-dark"
                                                      style="letter-spacing: 1px">{{env('APP_NAME')}} - Admin</span>
                            </span>
                            <p class="text-muted mb-4 mt-3">Ingrese su dirección de correo electrónico y contraseña para acceder al panel de administrador.</p>
                        </div>

                        <form action="{{route('admin.login')}}" method="POST" novalidate>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email</label>
                                <input class="form-control  @if($errors->has('email')) is-invalid @endif" name="email"
                                       type="email"
                                       id="emailaddress" required=""
                                       value="{{ old('email') ?? old('email')}}"
                                       placeholder="Ingresa tu email"/>

                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <a href="{{route('admin.password.request')}}" class="text-muted float-right"><small>¿Olvidó
                                        su
                                        contraseña?</small></a>
                                <label for="password">Contraseña</label>
                                <div
                                    class="input-group input-group-merge @if($errors->has('password')) is-invalid @endif">
                                    <input class="form-control @if($errors->has('password')) is-invalid @endif"
                                           name="password" type="password" required="" value=""
                                           id="password" placeholder="Ingresa tu contraseña"/>
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">Recordarme</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Iniciar sesión</button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p><a href="{{route('admin.password.request')}}" class="text-white-50 ml-1">¿Olvidaste tu contraseña?</a></p>
                        <p class="text-white-50">¿No tienes una cuenta? <a href="{{route('admin.register')}}" class="text-white ml-1"><b>Registrarse</b></a>
                        </p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<footer class="footer footer-alt">
    <script>document.write(new Date().getFullYear())</script> &copy; {{env('APP_NAME')}} by <a href="{{route('home')}}"
                                                                                               class="text-white-50">{{env('COMPANY_NAME')}}</a>
</footer>

@include('admin.layouts.shared.footer-script')

</body>
</html>
