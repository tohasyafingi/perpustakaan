<!-- <script src="<?php echo base_url() ?>assets/vendors/jquery/dist/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.7/html5-qrcode.min.js"></script>

<script type="text/javascript">
    $(function() {
        $("#slcAgta").change(function() {
            var agt = $(this).val();
            $.ajax({
                url: "<?php echo base_url() ?>peminjaman/searchAgtName",
                type: "POST",
                data: {
                    "id": agt
                },
                cache: false,
                success: function(huh) {
                    $("#tbNama").val(huh);
                }
            })
        })
        //Buku 1
        $("#slcBookCode1").change(function() {
            if (this.value != '') {
                $('#row2').css('display', 'block');
                //Get Data
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookTitle",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbJudul1").val(data);
                    }
                })
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookAuthor",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbPenulis1").val(data);
                    }
                })
            }
            if (this.value == '') {
                $('#tbJudul1').val('');
                $('#tbPenulis1').val('');

                $('#row2').css('display', 'none');
                $('#slcBookCode2').prop('selectedIndex', 0);
                $('#tbJudul2').val('');
                $('#tbPenulis2').val('');
                //3
                $('#row3').css('display', 'none');
                $('#slcBookCode3').prop('selectedIndex', 0);
                $('#tbJudul3').val('');
                $('#tbPenulis3').val('');
            }
        })
        //Buku 2
        $("#slcBookCode2").change(function() {
            if (this.value != '') {
                $('#row3').css('display', 'block');
                //Get Data
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookTitle",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbJudul2").val(data);
                    }
                })
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookAuthor",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbPenulis2").val(data);
                    }
                })
            }
            if (this.value == '') {
                $('#tbJudul2').val('');
                $('#tbPenulis2').val('');

                $('#row3').css('display', 'none');
                $('#slcBookCode3').prop('selectedIndex', 0);
                $('#tbJudul3').val('');
                $('#tbPenulis3').val('');
            }
        })
        //Buku 3
        $("#slcBookCode3").change(function() {
            if (this.value != '') {
                //Get Data
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookTitle",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbJudul3").val(data);
                    }
                })
                $.ajax({
                    url: "<?php echo base_url() ?>peminjaman/searchBookAuthor",
                    type: "POST",
                    data: "id=" + this.value,
                    cache: false,
                    success: function(data) {
                        $("#tbPenulis3").val(data);
                    }
                })
            }

            if (this.value == '') {
                $('#tbJudul3').val('');
                $('#tbPenulis3').val('');
            }
        })
    })
</script>

<div class="">
    <div class="page-title" style="padding: 8px">
        <div class="title_left">
            <h1><i class="fa fa-arrow-up"></i> Peminjaman</h1>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Masukkan data peminjaman</h2>
                    <div class="clearfix"></div>
                </div>

                <!-- Container kamera -->
                <div id="scanner-container" style="display:none; margin-top: 15px;">
                    <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>
                    <div style="text-align: center; margin-top: 10px;">
                        <button type="button" id="closeScanner" class="btn btn-sm btn-danger">Tutup Scanner</button>
                    </div>
                </div>
                <div class="x_content">
                    <!-- Notif -->
                    <?php $announce = $this->session->flashdata('announce') ?>
                    <?php if (!empty($announce)): ?>
                        <?php if ($announce == 'Berhasil menyimpan data'): ?>
                            <div class="alert alert-success fade in"><?php echo $announce; ?></div>
                        <?php else: ?>
                            <div class="alert alert-danger fade in"><?php echo $announce; ?></div>
                        <?php endif; ?>

                        <script>
                            setTimeout(function() {
                                $(".alert").fadeOut("slow");
                            }, 3000);
                        </script>
                    <?php endif; ?>
                    <form method="post" action="<?php echo base_url(); ?>peminjaman/submit" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Peminjaman</label>
                                        <input type="text" name="tbBrwCode" class="form-control" value="<?php echo $kode ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- ID Anggota (Input + Scan Icon) -->
                                    <div class="form-group">
                                        <label>ID Anggota</label>
                                        <div class="input-group">
                                            <input type="text" name="slcAgta" id="slcAgta" class="form-control" placeholder="Ketik atau scan ID Anggota" list="anggotaList" autofocus>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="btnScan" data-scan-target="#slcAgta" title="Scan dengan Kamera">
                                                    <i class="fa fa-qrcode"></i>  Scan QR Code
                                                </button>
                                            </span>
                                        </div>
                                        <datalist id="anggotaList">
                                            <?php foreach ($anggota as $agt): ?>
                                                <option value="<?php echo $agt->ID_ANGGOTA ?>"><?php echo $agt->ID_ANGGOTA ?> - <?php echo $agt->FULL_NAME ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Peminjaman</label>
                                                <?php
                                                $plus = date('Y-m-d', strtotime("+7 day", strtotime(date('Y-m-d'))));
                                                ?>
                                                <input name="tbDateStart" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Pengembalian</label>
                                                <input name="tbDateEnd" class="form-control" value="<?php echo $plus ?>" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Peminjam</label>
                                        <input type="text" name="tbNama" id="tbNama" class="form-control" placeholder="Pilih Kolom ID Anggota" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Petugas</label>
                                        <input readonly="readonly" name="tbPetugas" class="form-control" value="<?php echo $petugas ?>">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <!-- Buku 1 -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Buku</label>
                                        <div class="input-group">
                                            <input type="text" name="slcBookCode1" id="slcBookCode1" class="form-control" placeholder="Ketik atau scan Kode Buku" list="bukuList1">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="btnScanBook1" data-scan-target="#slcBookCode1" title="Scan QR Buku">
                                                    <i class="fa fa-qrcode"></i> Scan QR Code
                                                </button>
                                            </span>
                                        </div>
                                        <datalist id="bukuList1">
                                            <?php foreach ($buku as $kode): ?>
                                                <option value="<?php echo $kode->ID_BUKU ?>"><?php echo $kode->ID_BUKU ?> - <?php echo $kode->TITLE ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Judul Buku</label>
                                        <input type="text" name="tbJudul" id="tbJudul1" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Penulis Buku</label>
                                        <input type="text" name="tbPenulis" id="tbPenulis1" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- Buku 2 -->
                            <div class="row" id="row2" style="display:none">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Buku</label>
                                        <div class="input-group">
                                            <input type="text" name="slcBookCode2" id="slcBookCode2" class="form-control" placeholder="Ketik atau scan Kode Buku" list="bukuList2">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="btnScanBook2" data-scan-target="#slcBookCode2" title="Scan QR Buku">
                                                    <i class="fa fa-qrcode"></i> Scan QR Code
                                                </button>
                                            </span>
                                        </div>
                                        <datalist id="bukuList2">
                                            <?php foreach ($buku as $kode): ?>
                                                <option value="<?php echo $kode->ID_BUKU ?>"><?php echo $kode->ID_BUKU ?> - <?php echo $kode->TITLE ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Judul Buku</label>
                                        <input type="text" name="tbJudul" id="tbJudul2" class="form-control" placeholder="Judul Buku" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Penulis Buku</label>
                                        <input type="text" name="tbPenulis" id="tbPenulis2" class="form-control" placeholder="Penulis Buku" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <!-- Buku 3 -->
                            <div class="row" id="row3" style="display:none">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Buku</label>
                                        <div class="input-group">
                                            <input type="text" name="slcBookCode3" id="slcBookCode3" class="form-control" placeholder="Ketik atau scan Kode Buku" list="bukuList3">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="btnScanBook3" data-scan-target="#slcBookCode3" title="Scan QR Buku">
                                                    <i class="fa fa-qrcode"></i> Scan QR Code
                                                </button>
                                            </span>
                                        </div>
                                        <datalist id="bukuList3">
                                            <?php foreach ($buku as $kode): ?>
                                                <option value="<?php echo $kode->ID_BUKU ?>"><?php echo $kode->ID_BUKU ?> - <?php echo $kode->TITLE ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Judul Buku</label>
                                        <input type="text" name="tbJudul" id="tbJudul3" class="form-control" placeholder="Judul Buku" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Penulis Buku</label>
                                        <input type="text" name="tbPenulis" id="tbPenulis3" class="form-control" placeholder="Penulis Buku" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        let html5QrCode;
        let lastTarget = null;

        function startScanner(targetInputSelector) {
            lastTarget = targetInputSelector;
            $('#scanner-container').slideDown();

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                function(decodedText, decodedResult) {
                    $(lastTarget).val(decodedText).trigger('change');
                    html5QrCode.stop();
                    $('#scanner-container').slideUp();
                },
                function(errorMessage) {
                    // ignore scan errors
                }
            ).catch(err => {
                alert("Tidak dapat mengakses kamera: " + err);
            });
        }

        // Listener tombol scan apa pun
        $('[data-scan-target]').on('click', function() {
            let target = $(this).data('scan-target');
            startScanner(target);
        });

        // Tombol tutup scanner
        $('#closeScanner').on('click', function() {
            if (html5QrCode) {
                html5QrCode.stop();
            }
            $('#scanner-container').slideUp();
        });
    });
</script>