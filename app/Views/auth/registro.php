<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Sign Up<?= $this->endSection() ?>

<?= $this->section('subtitle') ?>Crea tu cuenta<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
                            GastosPro © 2026 - No soy responsable de tus gastos ni de ofrecerte un buen manejo de la información.
                        </div>

                    </form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
            this.submit();
        });
    </script>
<?= $this->endSection() ?>