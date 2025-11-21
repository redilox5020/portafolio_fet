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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
                    <p1>Repositorio de proyectos FET</p1>
                    <input name="email" type="email" placeholder="Ingresa direccion de correo">
                    <input name="password" type="password" placeholder="Contraseña">
                    <button type="submit">Entrar</button>
                    <div>
                        <input name="remember" type="checkbox" class="form-control-input" id="customCheck">
                        <label class="form-control-label" for="customCheck">Acuérdate de mi</label>
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
                    <p2>Repositorio de proyectos FET</p2>
                    <input type="text" name="name" placeholder="Nombre">
                    <input type="text" name="last_name" placeholder="Apellido">
                    <input type="email" name="email" placeholder="Correo Electronico">
                    <input type="password" name="password" placeholder="Contraseña">
                    <input type="password" name="password_confirmation" placeholder="Repetir Contraseña">
                    <button type="submit">Registrarse</button>
                </form>

            </div>
    </main>
    <script src="{{ asset('js/auth/script.js') }}"></script>

</body>

</html>
