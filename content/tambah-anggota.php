<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';
    $nisn = $_POST['nisn'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['no_tlp'];
    $alamat = $_POST['alamat'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO anggota (nisn, nama_lengkap, jenis_kelamin, no_tlp, alamat) VALUES ('$nisn', '$nama_lengkap', '$jk', '$telp', '$alamat')");
        header("location:?pg=anggota&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE anggota SET nisn = '$nisn', nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jk', no_tlp = $telp, alamat = '$alamat' WHERE id = '$id'");
        header("location:?pg=anggota&edit=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = '$id'");
    header("location:?pg=anggota&hapus=berhasil");
}

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                <div class="card-header">Data Anggota</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">NISN</label>
                            <input type="number" class="form-control" name="nisn" value="<?= $rowEdit['nisn'] ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $rowEdit['nama_lengkap'] ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class="form-control">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">No Telpon</label>
                            <input type="number" class="form-control" name="no_tlp" value="<?= $rowEdit['no_tlp'] ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= $rowEdit['alamat'] ?? '' ?>" required>
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