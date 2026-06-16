<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Pencatatan Inventory</h1>
        <p class="page-copy">Tambahkan barang baru, catat mutasi stok, dan pantau status persediaan secara langsung dalam satu tampilan yang lebih bersih.</p>
    </div>
</div>

<div class="page-content">
    <section class="card card-light">
        <div class="section-head">
            <div>
                <h2 id="item-form-title">Tambah Barang</h2>
                <p class="muted" id="item-form-copy">Data barang baru akan muncul langsung di daftar saat tersimpan.</p>
            </div>
            <span class="pill" id="item-form-pill">Form Input</span>
        </div>

        <form id="item-form" method="post" action="<?php echo e(route('inventory.items.store')); ?>" enctype="multipart/form-data" data-store-action="<?php echo e(route('inventory.items.store')); ?>">
            <?php echo csrf_field(); ?>
            <input id="item-form-method" type="hidden" name="_method" value="">
            <div class="field-group"><label>SKU</label><input id="item-sku" name="sku" required></div>
            <div class="field-group"><label>Nama Barang</label><input id="item-name" name="name" required></div>
            <div class="field-group"><label>Kategori</label><input id="item-category" name="category"></div>
            <div class="field-group"><label>Satuan</label><input id="item-unit" name="unit" value="pcs" required></div>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 18px;">
                <div class="field-group"><label>Stok Minimum</label><input id="item-minimum-stock" type="number" name="minimum_stock" min="0" value="0" required></div>
                <div class="field-group"><label>Stok Awal</label><input id="item-current-stock" type="number" name="current_stock" min="0" value="0" required></div>
            </div>
            <div class="field-group"><label>Gambar Barang</label><input type="file" name="image" accept="image/*"></div>
            <div class="form-actions split-actions">
                <button type="button" class="button ghost" id="cancel-item-edit" hidden>Batal Edit</button>
                <button type="submit" id="item-submit">Simpan Barang</button>
            </div>
        </form>
    </section>

    <section class="card">
        <div class="section-head">
            <div>
                <h2>Catat Mutasi</h2>
                <p class="muted">Rekam masuk atau keluar barang untuk memperbarui stok secara akurat.</p>
            </div>
            <span class="pill">Mutasi</span>
        </div>

        <form method="post" action="<?php echo e(route('inventory.movements.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 18px;">
                <div class="field-group"><label>Barang</label>
                    <select name="item_id" required>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->sku); ?> - <?php echo e($item->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="field-group"><label>Tipe</label><select name="type" required><option value="masuk">Masuk</option><option value="keluar">Keluar</option></select></div>
            </div>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 18px;">
                <div class="field-group"><label>Jumlah</label><input type="number" name="quantity" min="1" required></div>
                <div class="field-group"><label>Tanggal</label><input type="date" name="movement_date" value="<?php echo e(now()->toDateString()); ?>" required></div>
            </div>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 18px;">
                <div class="field-group"><label>Referensi</label><input name="reference"></div>
                <div class="field-group"><label>Catatan</label><textarea name="notes"></textarea></div>
            </div>
            <button type="submit">Simpan Mutasi</button>
        </form>
    </section>

    <section class="card">
        <div class="section-head">
            <div>
                <h2>Daftar Barang</h2>
                <p class="muted">Semua item terdaftar di sini dengan status persediaan dan aksi kelola data.</p>
            </div>
            <span class="pill"><?php echo e($items->count()); ?> Barang</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Minimum</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($item->image_url): ?>
                                    <img class="item-thumb" src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>">
                                <?php else: ?>
                                    <span class="muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->sku); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->category ?: '-'); ?></td>
                            <td><?php echo e($item->current_stock); ?> <?php echo e($item->unit); ?></td>
                            <td><?php echo e($item->minimum_stock); ?> <?php echo e($item->unit); ?></td>
                            <td><?php echo $item->current_stock <= $item->minimum_stock ? '<span class="pill warning">Perlu Restock</span>' : '<span class="pill success">Aman</span>'; ?></td>
                            <td>
                                <div class="item-actions">
                                    <button
                                        type="button"
                                        class="button ghost edit-item-button"
                                        data-update-action="<?php echo e(route('inventory.items.update', $item)); ?>"
                                        data-sku="<?php echo e($item->sku); ?>"
                                        data-name="<?php echo e($item->name); ?>"
                                        data-category="<?php echo e($item->category); ?>"
                                        data-unit="<?php echo e($item->unit); ?>"
                                        data-minimum-stock="<?php echo e($item->minimum_stock); ?>"
                                        data-current-stock="<?php echo e($item->current_stock); ?>"
                                    >Edit</button>
                                    <form method="post" action="<?php echo e(route('inventory.items.destroy', $item)); ?>" onsubmit="return confirm('Hapus barang <?php echo e($item->name); ?>? Riwayat mutasi barang ini juga akan ikut terhapus.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('delete'); ?>
                                        <button type="submit" class="button danger-button">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    const itemForm = document.getElementById('item-form');
    const itemFormMethod = document.getElementById('item-form-method');
    const itemFormTitle = document.getElementById('item-form-title');
    const itemFormCopy = document.getElementById('item-form-copy');
    const itemFormPill = document.getElementById('item-form-pill');
    const itemSubmit = document.getElementById('item-submit');
    const cancelItemEdit = document.getElementById('cancel-item-edit');
    const itemSku = document.getElementById('item-sku');
    const itemName = document.getElementById('item-name');
    const itemCategory = document.getElementById('item-category');
    const itemUnit = document.getElementById('item-unit');
    const itemMinimumStock = document.getElementById('item-minimum-stock');
    const itemCurrentStock = document.getElementById('item-current-stock');

    function resetItemForm() {
        itemForm.action = itemForm.dataset.storeAction;
        itemFormMethod.value = '';
        itemForm.reset();
        itemSku.readOnly = false;
        itemSku.classList.remove('readonly-input');
        itemUnit.value = 'pcs';
        itemMinimumStock.value = 0;
        itemCurrentStock.value = 0;
        itemFormTitle.textContent = 'Tambah Barang';
        itemFormCopy.textContent = 'Data barang baru akan muncul langsung di daftar saat tersimpan.';
        itemFormPill.textContent = 'Form Input';
        itemSubmit.textContent = 'Simpan Barang';
        cancelItemEdit.hidden = true;
    }

    document.querySelectorAll('.edit-item-button').forEach((button) => {
        button.addEventListener('click', () => {
            itemForm.action = button.dataset.updateAction;
            itemFormMethod.value = 'put';
            itemSku.value = button.dataset.sku || '';
            itemName.value = button.dataset.name || '';
            itemCategory.value = button.dataset.category || '';
            itemUnit.value = button.dataset.unit || 'pcs';
            itemMinimumStock.value = button.dataset.minimumStock || 0;
            itemCurrentStock.value = button.dataset.currentStock || 0;
            itemSku.readOnly = true;
            itemSku.classList.add('readonly-input');
            itemFormTitle.textContent = 'Edit Barang';
            itemFormCopy.textContent = 'Perbarui data barang dari form ini. SKU tidak dapat diubah.';
            itemFormPill.textContent = 'Mode Edit';
            itemSubmit.textContent = 'Simpan Perubahan';
            cancelItemEdit.hidden = false;
            itemForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    cancelItemEdit.addEventListener('click', resetItemForm);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/inventory/index.blade.php ENDPATH**/ ?>