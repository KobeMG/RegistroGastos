<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('subtitle') ?>Bienvenido de nuevo ✨<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form id="frmLogin" class="card-body cardbody-color p-3 p-lg-5" action="<?= base_url('login') ?>" method="POST">
    <!-- Agregar un token de seguridad     -->
    <?= csrf_field() ?>
    <div class="text-center">
        <img src="https://i.ibb.co/WW5Cm8RB/296fe121-5dfa-43f4-98b5-db50019738a7.jpg"
            class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" alt="profile">
    </div>

    <div class="mb-3">
        <input type="email" name="email" class="form-control" id="email" placeholder="Correo electrónico">
    </div>
    <div class="mb-3">
        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-color px-5 mb-5 w-100">Entrar</button>
    </div>
    <div id="emailHelp" class="form-text text-center mb-5 text-dark">
        ¿No tienes cuenta? <a href="<?= base_url('registro') ?>" class="text-dark fw-bold"> Crea una aquí</a>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Mostrar mensaje de error si existe
    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    <?php endif; ?>



    document.getElementById('frmLogin').addEventListener('submit', function(e) {
    e.preventDefault();

        // Validar que los campos no estén vacíos
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos'
            });
            return;
        }

        // Si la validación es correcta, enviar el formulario
        this.submit();
    });
</script>
<?= $this->endSection() ?>