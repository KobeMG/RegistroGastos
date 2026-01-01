<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - GastosPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>

<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Gastos 69 Pro Max de Kobe</h2>
                <div class="text-center mb-5 text-dark">Bienvenido de nuevo ✨</div>
                <div class="card my-5">

                    <form class="card-body cardbody-color p-lg-5" action="<?= base_url('login') ?>" method="POST">
                        <!-- Agregar un token de seguridad     -->
                        <?= csrf_field() ?>
                        <div class="text-center">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png"
                                class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px" alt="profile">
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" id="Username" placeholder="Correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-color px-5 mb-5 w-100">Entrar</button>
                        </div>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">
                            ¿No tienes cuenta? <a href="<?= base_url('registro') ?>" class="text-dark fw-bold"> Crea una aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>