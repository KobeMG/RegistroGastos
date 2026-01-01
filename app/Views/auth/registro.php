<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sign Up - GastosPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Gastos 69 Pro Max de Kobe</h2>
                <div class="text-center mb-5 text-dark">Crea tu cuenta</div>
                <div class="card my-5">
                    
                    <form id="formRegistro" class="card-body cardbody-color p-lg-5" action="<?= base_url('/registrar') ?>" method="POST">
                        <!-- Agregar un token de seguridad     -->
                        <?= csrf_field() ?>
                        <div class="text-center">
                            <img src="https://i.ibb.co/HfWPj1XG/0b25f465f3fac630ab8392e4ca48da3f.jpg"
                                class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px" alt="profile">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre completo" >
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" id="Username" placeholder="Correo electrónico" >
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" >
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-color px-5 mb-5 w-100">Crear Usuario</button>
                        </div>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">
                            ¿Ya tienes una cuenta? <a href="<?= base_url('') ?>" class="text-dark fw-bold"> Inicia sesión aquí</a>
                        </div>
                      
                        <div class="text-center text-dark">
                            GastosPro © 2024 - No soy responsable de tus gastos ni de ofrecerte un buen manejo de la información.
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formRegistro').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar que los campos no estén vacíos
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('Username').value;
            const password = document.getElementById('password').value;

            if (!nombre || !email || !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos los campos son requeridos'
                });
                return;
            }

            // Si la validación es correcta, enviar el formulario
            Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Usuario creado exitosamente'
                });
            this.submit();
        });
    </script>

</body>

</html>