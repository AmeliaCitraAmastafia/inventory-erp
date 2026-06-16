

<?php $__env->startSection('content'); ?>
<h1>Cetak Laporan</h1>

<div class="grid">
    <section class="span-4">
        <h2>Ringkasan</h2>
        <p>Total barang: <strong><?php echo e($items->count()); ?></strong></p>
        <p>Stok perlu perhatian: <strong><?php echo e($lowStockCount); ?></strong></p>
        <a class="button" href="<?php echo e(route('reports.stock.print')); ?>">Cetak Laporan Stok</a>
    </section>

    <section class="span-8">
        <h2>Mutasi Terbaru</h2>
        <table>
            <thead><tr><th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Referensi</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $recentMovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($movement->movement_date->format('d/m/Y')); ?></td>
                    <td><?php echo e($movement->item?->name); ?></td>
                    <td><span class="pill"><?php echo e($movement->type); ?></span></td>
                    <td><?php echo e($movement->quantity); ?></td>
                    <td><?php echo e($movement->reference ?: '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/reports/index.blade.php ENDPATH**/ ?>