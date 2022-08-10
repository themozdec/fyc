<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.shared.title-meta', ['title' => "Registro"])

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
                            <p class="text-muted mb-4 mt-3">¿No tienes una cuenta? Crea tu cuenta, te tamará menos
                                de un minuto</p>
                        </div>

                        <form action="{{route('admin.register')}}" method="POST" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="fullname">Nombre completo</label>
                                <input class="form-control @if($errors->has('name')) is-invalid @endif" name="name"
                                       type="text"
                                       id="fullname" placeholder="Ingresa tu nombre" required
                                       value="{{ old('name')}}"/>
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email</label>
                                <input class="form-control @if($errors->has('email')) is-invalid @endif" name="email"
                                       type="email"
                                       id="emailaddress" required placeholder="Ingresa tu email"
                                       value="{{ old('email')}}"/>

                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input class="form-control @if($errors->has('password')) is-invalid @endif"
                                       name="password" type="password" required id="password"
                                       placeholder="Ingresa tu contraseña"/>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirma tu contraseña</label>
                                <input class="form-control @if($errors->has('confirm_password')) is-invalid @endif"
                                       name="confirm_password" type="password" required id="confirm_password"
                                       placeholder="Confirma tu contraseña"/>

                                @if($errors->has('confirm_password'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('confirm_password') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                    <label class="custom-control-label" for="checkbox-signup">Yo acepto <a
                                            href="javascript: void(0);" class="text-dark">Términos y condiciones</a></label>
                                            <label for="captcha">Captcha</label>
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        @error('g-recaptcha-response')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror     
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Registrarme</button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-white-50">¿Ya tienes una cuenta? <a href="{{route('admin.login')}}"
                                                                          class="text-white ml-1"><b>Inicar Sesión</b></a></p>
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
    <script>document.write(new Date().getFullYear())</script> &copy; {{env('APP_NAME')}} by <a href=""
                                                                                               class="text-white-50">{{env('COMPANY_NAME')}}</a>
</footer>

@include('layouts.shared.footer-script')

</body>
</html>
