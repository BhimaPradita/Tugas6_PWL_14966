<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Tambah Data
        </button>

        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Search..." disabled>
        </div>
    </div>

    <!-- Modal Tambah Diskon -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="<?= base_url('diskon/simpan') ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Diskon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal Diskon</label>
                            <input type="number" name="nominal" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Diskon -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nominal (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($diskon as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm">Ubah</a>
                        <a href="<?= base_url('diskon/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
