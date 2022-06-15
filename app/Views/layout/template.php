<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php if (!empty($result->css_files)) : ?>
        <?php foreach ($result->css_files as $file) : ?>
            <link type="text/css" rel="stylesheet" href="<?= $file; ?>" />
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <!-- top navbar-->
    <?= $this->include('layout/topbar') ?>
    <!-- end top navbar-->

    <div id="layoutSidenav">
        <!-- top sidebar-->
        <?= $this->include('layout/sidebar') ?>
        <!-- end top sidebar-->

        <div id="layoutSidenav_content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/js/datatables-simple-demo.js"></script>
    <script>
        function previewImage() {
            const cover = document.querySelector('#cover');
            const img_preview = document.querySelector('.img-preview');
            const file_cover = new FileReader();
            file_cover.readAsDataURL(cover.files[0]);
            file_cover.onload = function(e) {
                img_preview.src = e.target.result;
            }
        }

        function previewBukti() {
            const cover = document.querySelector('#image');
            const img_preview = document.querySelector('.img-preview');
            const file_cover = new FileReader();
            file_cover.readAsDataURL(cover.files[0]);
            file_cover.onload = function(e) {
                img_preview.src = e.target.result;
            }
        }
    </script>
    <?php if (!empty($result->css_files)) : ?>
        <?php foreach ($result->js_files as $file) : ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>