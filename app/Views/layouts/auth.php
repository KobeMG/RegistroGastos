<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - GastosPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-3 mt-md-5">Gastos 69 Pro Max de Kobe</h2>
                <div class="text-center mb-3 mb-md-5 text-dark"><?= $this->renderSection('subtitle') ?></div>
                <div class="card my-3 my-md-5">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
