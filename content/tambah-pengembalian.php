<?php

if (isset($_GET['detail'])) {
    // data peminjam
    $id = $_GET['detail'];
    $detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, peminjaman.*, user.nama_lengkap FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota LEFT JOIN user ON user.id = peminjaman.id_user WHERE peminjaman.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($detail);

    //     // data buku yang dipinjam
    //     $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku WHERE id_peminjaman = '$id'");

    //     // menghitung durasi lama pinjam
    //     $tanggal_pinjam = $rowDetail['tgl_pinjam'];
    //     $tanggal_kembali = $rowDetail['tgl_kembali'];

    //     $date_pinjam = new DateTime($tanggal_pinjam);
    //     $date_kembali = new DateTime($tanggal_kembali);
    //     $interval = $date_pinjam->diff($date_kembali);
}

if (isset($_POST['simpan'])) {
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_user = $_POST['id_user'];
    $tanggal_pengembalian = $_POST['tgl_pengembalian'];
    $tanggal_pinjam = $_POST['tgl_pinjam'];
    $tanggal_kembali = $_POST['tgl_kembali'];
    $terlambat = $_POST['terlambat'];
    $denda = $_POST['denda'];


    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman, tgl_pengembalian, terlambat, denda) VALUES ('$id_peminjaman', '$tanggal_pengembalian', '$terlambat', '$denda')");
        header("location:?pg=pengembalian");

        $update = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id = '$id_peminjaman'");
    }
}

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman ORDER BY id DESC");


?>

<?php if (isset($_GET['detail'])) : ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-light" style="background-color: rgba(87, 99, 89, .8);">
                    <div class="card-header">
                        <span class="lead">Detail Transaksi Peminjaman</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Kode Transaksi</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['kode_transaksi']; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('D, d M Y', strtotime($rowDetail['tgl_pinjam'])); ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('D, d M Y', strtotime($rowDetail['tgl_kembali'])); ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Durasi Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $interval->days . " hari"; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Anggota</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_anggota']; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_lengkap']; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= getStatus($rowDetail['status']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 mt-5">
                            <table class="table table-hover text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                </tr>
                                <?php
                                $no = 1;
                                while ($rowDetail = mysqli_fetch_assoc($queryDetail)) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $rowDetail['nama_kategori']; ?></td>
                                        <td><?= $rowDetail['judul']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                    <div class="card-header">Transaksi Pengembalian</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $_SESSION['NAMA_LENGKAP']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="id_user" value="<?= $_SESSION['ID_USER']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3 mt-5">
                                <div class="col-sm-2">
                                    <label for="">Kode Peminjaman</label>
                                </div>
                                <div class="col-sm-3">
                                    <select name="id_peminjaman" id="kode_peminjaman" class="form-control">
                                        <option value="">-- Pilih Kode Transaksi --</option>
                                        <?php while ($rowPeminjaman = mysqli_fetch_assoc($queryPeminjaman)) : ?>
                                            <option value="<?= $rowPeminjaman['id']; ?>"><?= $rowPeminjaman['kode_transaksi']; ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Nama Anggota</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" readonly id="nama_anggota" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pinjam</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" readonly id="tgl_pinjam" name="tgl_pinjam" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" readonly id="tgl_kembali" name="tgl_kembali" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Keterlambatan</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" readonly name="terlambat" id="keterlambatan" value="" class="form-control">
                                    <input type="hidden" name="denda" id="denda">
                                </div>
                            </div>

                            <div class="mt-5 mb-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div align="right" class="total-denda">

                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>