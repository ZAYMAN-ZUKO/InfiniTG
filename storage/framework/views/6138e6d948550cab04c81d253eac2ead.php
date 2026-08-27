<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success" data-toast="<?php echo e(session('success')); ?>">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<div class="hello">
    <span class="hello-icon"><i data-lucide="cloud" aria-hidden="true"></i></span>
    <div>
        <h2>Welcome back, <?php echo e(Auth::user()->name); ?></h2>
        <p>Here's what's happening with your cloud today.</p>
    </div>
    <div class="hello-meta">
        <span class="chip"><i data-lucide="zap" aria-hidden="true"></i>Telegram powered</span>
        <span class="chip"><i data-lucide="infinity" aria-hidden="true"></i>Unlimited storage</span>
    </div>
</div>

<div class="stats">
    <div class="stat">
        <span class="stat-icon ic-indigo"><i data-lucide="folder" aria-hidden="true"></i></span>
        <div>
            <b><?php echo e($totalFiles); ?></b>
            <span>Total Files</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-violet"><i data-lucide="hard-drive" aria-hidden="true"></i></span>
        <div>
            <b><?php echo e($storageUsed); ?> MB</b>
            <span>Storage Used</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-amber"><i data-lucide="star" aria-hidden="true"></i></span>
        <div>
            <b><?php echo e($favoriteCount); ?></b>
            <span>Favorites</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-red"><i data-lucide="trash-2" aria-hidden="true"></i></span>
        <div>
            <b><?php echo e($trashCount); ?></b>
            <span>In Trash</span>
        </div>
    </div>
</div>

<div class="dash-grid">

    <div class="card">
        <div class="card-head">
            <h3>Recent Files</h3>
            <a class="link" href="<?php echo e(route('recent')); ?>">
                View all <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <?php
        $recentFiles = $recentFiles ?? collect();
        ?>
        <div class="recent">
        <?php $__empty_1 = true; $__currentLoopData = $recentFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="recent-row">
                <?php echo $__env->make('partials.file-icon', ['file' => $file], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="recent-meta">
                    <b><?php echo e($file->original_name); ?></b>
                    <span><?php echo e($file->mime_type ?? 'Unknown type'); ?></span>
                </div>
                <span class="recent-time"><?php echo e($file->created_at->diffForHumans()); ?></span>
                <div class="file-actions">
                    <a class="btn btn-ghost btn-sm btn-icon" href="<?php echo e(route('download', $file->id)); ?>" title="Download">
                        <i data-lucide="download" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty">
                <span class="empty-icon"><i data-lucide="file" aria-hidden="true"></i></span>
                <h3>No files yet</h3>
                <p>Upload your first file to get started.</p>
                <button class="btn btn-primary" type="button" data-open-modal="upload">
                    <i data-lucide="upload" aria-hidden="true"></i>Upload a file
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="storage-detail unlimited-storage-overview">
            <h3>Storage Overview</h3>

            <div class="unlimited-storage-overview-icon">
                <i data-lucide="infinity" aria-hidden="true"></i>
            </div>

            <strong class="unlimited-storage-overview-title">Unlimited Storage</strong>

            <div class="unlimited-storage-overview-used"><?php echo e($storageUsed); ?> MB</div>

            <span class="unlimited-storage-overview-caption">Currently Used</span>

            <div class="unlimited-storage-powered">
                <i data-lucide="send" aria-hidden="true"></i>
                <span>Powered by Telegram</span>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\infinitg\resources\views/dashboard.blade.php ENDPATH**/ ?>