<?php

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                <div class="card-header">Data Anggota</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-anggota" class="btn btn-sm btn-success">Tambah</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">
                            Data Berhasil ditambah
                        </div>
                    <?php endif ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger">
                            Data Berhasil dihapus
                        </div>
                    <?php endif ?>
                    <?php if (isset($_GET['edit'])) : ?>
                        <div class="alert alert-warning">
                            Data Berhasil diedit
                        </div>
                    <?php endif ?>
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nisn</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th class="col-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowAnggota['nisn']; ?></td>
                                    <td><?php echo $rowAnggota['nama_lengkap']; ?></td>
                                    <td><?php echo $rowAnggota['jenis_kelamin'] ?></td>
                                    <td><?php echo $rowAnggota['no_tlp'] ?></td>
                                    <td><?php echo $rowAnggota['alamat'] ?></td>
                                    <td class="text-center">
                                        <a href="?pg=tambah-anggota&edit=<?= $rowAnggota['id']; ?>" class="btn btn-sm btn-secondary">Update</a>
                                        <a onclick="return confirm('Apakah anda ingin menghapus data ini ?')" href="?pg=tambah-anggota&delete=<?= $rowAnggota['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>