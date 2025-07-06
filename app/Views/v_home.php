<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php foreach ($product as $key => $item) : ?>
        <?php
            $diskon = session()->get('diskon_hari_ini') ?? 0;
            $harga_awal = $item['harga'];
            $harga_diskon = max(0, $harga_awal - $diskon);
        ?>
        <div class="col-lg-6">
            <?= form_open('keranjang/add') ?>
                <?php
                    echo form_hidden('id', (string) $item['id']);
                    echo form_hidden('nama', $item['nama']);
                    echo form_hidden('harga', (string) $harga_diskon);
                    echo form_hidden('foto', $item['foto']);
                    echo form_hidden('harga_awal', (string) $harga_awal);
                ?>
                <!-- Tampilan produk -->
                <div class="card">
                    <div class="card-body">
                        <img src="<?= base_url("img/" . $item['foto']) ?>" width="300px">
                        <h5 class="card-title"><?= $item['nama'] ?></h5>
                        <p>
                            <?php if ($diskon > 0): ?>
                                <strong><?= number_to_currency($item['harga_diskon'], 'IDR') ?></strong><br>
                                <small class="text-muted"><del><?= number_to_currency($item['harga_awal'], 'IDR') ?></del></small>
                            <?php else: ?>
                                <strong><?= number_to_currency($item['harga_awal'], 'IDR') ?></strong>
                            <?php endif ?>
                        </p>
                        <button type="submit" class="btn btn-info">Beli</button>
                    </div>
                </div>
            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>