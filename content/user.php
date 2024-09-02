<?php

$queryUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level ON level.id = user.id_level ORDER BY id DESC");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                <div class="card-header">Data User</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-user" class="btn btn-sm btn-success">Tambah</a>
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
                                <th>Level</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th class="col-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowUser = mysqli_fetch_assoc($queryUser)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowUser['nama_level']; ?></td>
                                    <td><?php echo $rowUser['nama_lengkap'] ?></td>
                                    <td><?php echo $rowUser['email'] ?></td>
                                    <td class="text-center">
                                        <a href="?pg=tambah-user&edit=<?= $rowUser['id']; ?>" class="btn btn-sm btn-secondary">Update</a>
                                        <a onclick="return confirm('Apakah anda ingin menghapus data ini ?')" href="?pg=tambah-user&delete=<?= $rowUser['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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