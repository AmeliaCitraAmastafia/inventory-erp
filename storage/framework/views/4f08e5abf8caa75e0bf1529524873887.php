<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Notifikasi & Komunikasi</h1>
        <p class="page-copy">Kelola pengiriman pesan sistem dan pantau ambang batas persediaan.</p>
    </div>
</div>

<div class="grid notification-board">
    <section class="card card-light span-5">
        <div class="section-head">
            <h2>▷ Kirim Pesan</h2>
        </div>

        <div class="card-body">
            <form method="post" action="<?php echo e(route('notifications.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="field-group">
                    <label>Channel</label>
                    <select name="channel" required>
                        <option value="internal">Internal</option>
                        <option value="email">Email Notification</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="field-group">
                    <label>Penerima</label>
                    <input name="recipient" placeholder="email@vendor.com atau Nama Gudang" required>
                </div>
                <div class="field-group">
                    <label>Subjek</label>
                    <input name="subject" placeholder="Masukkan judul pesan..." required>
                </div>
                <div class="field-group">
                    <label>Pesan</label>
                    <textarea name="message" placeholder="Tulis rincian pesan di sini..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit">▹ Antrekan Pesan</button>
                </div>
            </form>
        </div>
    </section>

    <section class="card span-7">
        <div class="section-head">
            <h2>△ Stok Perlu Notifikasi</h2>
            <span class="pill warning"><?php echo e($lowStockItems->count()); ?> Kritis</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Min.</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->sku); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td class="danger"><?php echo e($item->current_stock); ?></td>
                            <td><?php echo e($item->minimum_stock); ?></td>
                            <td><a class="table-action" href="<?php echo e(route('inventory.index')); ?>">Order</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="card span-12">
        <div class="section-head">
            <h2>↻ Riwayat Komunikasi</h2>
            <div class="toolbar-actions">
                <button type="button" class="button ghost">Export CSV</button>
                <button type="button" class="button ghost">Filter</button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Channel</th>
                        <th>Penerima</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($message->created_at->format('d/m/Y H:i')); ?></td>
                            <td><?php echo e(ucfirst($message->channel)); ?></td>
                            <td><?php echo e($message->recipient); ?></td>
                            <td><?php echo e($message->subject); ?></td>
                            <td><span class="pill success"><?php echo e($message->status); ?></span></td>
                            <td><span class="muted">-</span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/notifications/index.blade.php ENDPATH**/ ?>