<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y registro - fet</title>
    <link href="link rel="preconnect href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/auth/estilos.css') }}" rel="stylesheet">

</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿ya tienes cuenta?</h3>
                    <p>Iniciar sesión para entrar a la pagina</p>
                    <button id="btn__iniciar-sesion"> iniciar sesión </button>

                </div>
                <div class="caja__trasera-register">
                    <h3>¿No tienes cuenta?</h3>
                    <p>Resgistrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse"> Registrarse </button>
                </div>
            </div>

            <!--formulario, parte login y registro-->

            <div class="contenedor__login-register">
                <form action="{{ route('login') }}" class="formulario__login" method="POST">
                    @csrf
                    <img src="{{ asset('img/Logo-FET.png') }}" alt="Icono de entrar" class="icono-entrar">
                    <h2>Iniciar Sesión</h2>
                    <div class="form-group">
                        <p1>Repositorio de proyectos FET</p1>
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" placeholder="Ingresa direccion de correo">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <button type="submit">Entrar</button>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input name="remember" type="checkbox" class="form-check-input" id="customCheck">
                            <label class="form-check-label" for="customCheck">Acuérdate de mi</label>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                </form>



                <!--Resgistrarse-->

                <form action="{{ route('register.store') }}" class="formulario__register" method="POST">
                    @csrf
                    <img src="{{ asset('img/Logo-FET.png') }}" alt="Icono de entrar" class="icono-entrar">
                    <h2>Registrarse</h2>
                    <div class="form-group">
                        <p2>Repositorio de proyectos FET</p2>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" placeholder="Apellido">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Correo Electronico">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="Repetir Contraseña">
                    </div>
                    <div class="form-group">
                        <button type="submit">Registrarse</button>
                    </div>
                </form>

            </div>
    </main>
    <script src="{{ asset('js/auth/script.js') }}"></script>

</body>

</html>
