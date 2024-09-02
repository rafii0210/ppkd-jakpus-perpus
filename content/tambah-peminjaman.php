<?php

if (isset($_GET['detail'])) {
    // data peminjam
    $id = $_GET['detail'];
    $detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, peminjaman.*, user.nama_lengkap FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota LEFT JOIN user ON user.id = peminjaman.id_user WHERE peminjaman.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($detail);

    // data buku yang dipinjam
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku LEFT JOIN kategori ON kategori.id = buku.id_kategori WHERE id_peminjaman = '$id'");

    // menghitung durasi lama pinjam
    $tanggal_pinjam = $rowDetail['tgl_pinjam'];
    $tanggal_kembali = $rowDetail['tgl_kembali'];

    $date_pinjam = new DateTime($tanggal_pinjam);
    $date_kembali = new DateTime($tanggal_kembali);
    $interval = $date_pinjam->diff($date_kembali);
}

if (isset($_POST['simpan'])) {
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';
    $kode_transaksi = $_POST['kode_transaksi'];
    $id_anggota = $_POST['id_anggota'];
    $id_user = $_POST['id_user'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    $id_kategori = $_POST['id_kategori'];
    $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, id_user, tgl_pinjam, tgl_kembali, status) VALUES ('$kode_transaksi', '$id_anggota', '$id_user', '$tgl_pinjam', '$tgl_kembali', '1')");

    if ($insert) {
        $id_peminjaman = mysqli_insert_id($koneksi);
        foreach ($id_kategori as $key => $value) {
            $id_kategori = $_POST['id_kategori'][$key];
            $id_buku = $_POST['id_buku'][$key];
            $insert = mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman, id_buku, id_kategori) VALUE ('$id_peminjaman', '$id_buku', '$id_kategori')");
            header("location:?pg=peminjaman&tambah=berhasil");
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "UPDATE peminjaman SET deleted_at = 1 WHERE id = '$id'");
    header("location:?pg=peminjaman&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryBuku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");


?>

<?php if (isset($_GET['detail'])) : ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
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
                    <div class="card-header">Transaksi Peminjaman</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Kode Transaksi</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="kode_transaksi" value="<?= ($kode_transaksi ?? '') ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Nama Anggota</label>
                                </div>
                                <div class="col-sm-3">
                                    <select name="id_anggota" id="" class="form-control">
                                        <option value="">Pilih Anggota</option>
                                        <?php while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                            <option value="<?= $rowAnggota['id']; ?>"><?= $rowAnggota['nama_lengkap']; ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pinjam</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_pinjam" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_kembali" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $_SESSION['NAMA_LENGKAP']??""; ?>" readonly>
                                    <input type="hidden" class="form-control" name="id_user" value="<?= $_SESSION['ID_USER']??""; ?>">
                                </div>
                            </div>

                            <!-- Get Data Kategori Buku dan Buku -->

                            <div class="row mb-3 mt-5">
                                <div class="col-sm-2">
                                    <label for="">Kategori Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_kategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                            <option value="<?= $rowKategori['id']; ?>"><?= $rowKategori['nama_kategori']; ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Nama Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_buku" class="form-control">
                                        <option value="">Pilih Buku</option>
                                        <?php while ($rowBuku = mysqli_fetch_assoc($queryBuku)) : ?>
                                            <option value="<?= $rowBuku['id']; ?>"><?= $rowBuku['judul']; ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="" id="tahun_terbit">

                            <div class="mt-5 mb-5">
                                <div align="right" class="mb-3">
                                    <button type="button" id="tambah-row" class="btn btn-sm btn-primary tambah-row">
                                        Tambah
                                    </button>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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