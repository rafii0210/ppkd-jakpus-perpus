<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';
    $judul = $_POST['judul'];
    $jumlah = $_POST['jumlah'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $penulis = $_POST['penulis'];
    $id_kategori = $_POST['id_kategori'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO buku (judul, jumlah, penerbit, tahun_terbit, penulis, id_kategori) VALUES ('$judul', '$jumlah', '$penerbit', '$tahun', '$penulis', '$id_kategori')");
        header("location:?pg=buku&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE buku SET judul = '$judul', jumlah = '$jumlah', penerbit = '$penerbit', tahun_terbit = '$tahun', penulis = '$penulis', id_kategori = '$id_kategori' WHERE id = '$id'");
        header("location:?pg=buku&edit=berhasil");
    }

    
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM buku WHERE id = '$id'");
    header("location:?pg=buku&hapus=berhasil");
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                <div class="card-header">Tambah Buku</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="id_kategori" id="" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php while ($rowKategori = mysqli_fetch_assoc($kategori)) : ?>
                                    <option <?php echo isset($rowEdit['id_kategori']) ? ($rowEdit['id_kategori'] == $rowKategori['id']) ? 'selected' : '' : '' ?> value="<?php echo $rowKategori['id']; ?>"><?php echo $rowKategori['nama_kategori']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?= $rowEdit['judul'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" value="<?= $rowEdit['jumlah'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" value="<?= $rowEdit['penerbit'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tahun Terbit</label>
                            <input type="text" class="form-control" name="tahun_terbit" value="<?= $rowEdit['tahun_terbit'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" value="<?= $rowEdit['penulis'] ?? '' ?>">
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