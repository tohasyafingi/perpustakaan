<body>
<div class="container my-4">
    <div class="row shadow p-4 rounded bg-white">
        <!-- Foto Profil -->
        <div class="col-md-4 text-center mb-3 mb-md-0">
            <img src="<?php echo base_url('assets/images/upload/profile/' . $detail->PHOTO); ?>"
                 alt="Foto Profil"
                 class="img-fluid rounded"
                 style="max-height: 150px; width: auto;">
        </div>

        <!-- Informasi Petugas -->
        <div class="col-md-8">
            <h5 class="mb-4">Profil Petugas</h5>

            <div class="mb-3">
                <strong>Nama Lengkap:</strong>
                <p class="mb-0 text-muted"><?php echo $detail->FULLNAME; ?></p>
            </div>

            <div class="mb-3">
                <strong>Username:</strong>
                <p class="mb-0 text-muted"><?php echo $detail->USERNAME; ?></p>
            </div>

            <div class="mb-3">
                <strong>Jenis Kelamin:</strong>
                <p class="mb-0 text-muted">
                    <?php echo $detail->JENKEL ? $detail->JENKEL : '<i>BELUM DIISI</i>'; ?>
                </p>
            </div>

            <div class="mb-3">
                <strong>No Telp.:</strong>
                <p class="mb-0 text-muted">
                    <?php echo $detail->NO_TELP ? $detail->NO_TELP : '<i>BELUM DIISI</i>'; ?>
                </p>
            </div>

            <div class="mb-3">
                <strong>Alamat:</strong>
                <p class="mb-0 text-muted">
                    <?php echo $detail->ALAMAT ? $detail->ALAMAT : '<i>BELUM DIISI</i>'; ?>
                </p>
            </div>

            <a href="<?php echo base_url('profile/edit?change_key=' . $detail->ID_ADMIN . '&signup=0'); ?>"
               class="btn btn-primary mt-3">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
</body>
