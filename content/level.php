<?php

$queryLevel = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-light" style="background-color: rgba(87, 99, 89, .8)">
                <div class="card-header">Data Level</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-level" class="btn btn-sm btn-success">Tambah</a>
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
                        <div class="alert alert-secondary">
                            Data Berhasil diedit
                        </div>
                    <?php endif ?>
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th class="col-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowLevel = mysqli_fetch_assoc($queryLevel)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowLevel['nama_level'] ?></td>
                                    <td><?php echo $rowLevel['keterangan'] ?></td>
                                    <td class="text-center">
                                        <a href="?pg=tambah-level&edit=<?= $rowLevel['id']; ?>" class="btn btn-sm btn-secondary">Update</a>
                                        <a onclick="return confirm('Apakah anda ingin menghapus data ini ?')" href="?pg=tambah-level&delete=<?= $rowLevel['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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