<?php $__env->startSection('title', $folder->name); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success" data-toast="<?php echo e(session('success')); ?>">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <i data-lucide="alert-circle" aria-hidden="true"></i>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="breadcrumbs">
    <a href="<?php echo e(route('files.index')); ?>">My Files</a>
    <span class="sep">/</span>
    <span><?php echo e($folder->name); ?></span>
</div>

<div class="pagehead">
    <div>
        <h1><?php echo e($folder->name); ?></h1>
        <p>Folder contents &middot; created <?php echo e($folder->created_at->format('d M Y')); ?></p>
    </div>
    <div class="actions">
        <button class="btn btn-primary" type="button" data-open-modal="upload">
            <i data-lucide="upload" aria-hidden="true"></i>Upload
        </button>
        <button class="btn btn-soft" type="button" data-open-modal="folder">
            <i data-lucide="folder-plus" aria-hidden="true"></i>New Folder
        </button>
        <a class="btn btn-ghost" href="<?php echo e(route('files.index')); ?>">
            <i data-lucide="arrow-left" aria-hidden="true"></i>Back
        </a>
    </div>
</div>


<?php if($folders->count()): ?>
    <h3 class="sechead">Folders</h3>
    <div class="folder-grid">
        <?php $__currentLoopData = $folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subfolder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="folder-card" href="<?php echo e(route('folders.show', $subfolder)); ?>">
                <span class="folder-icon"><i data-lucide="folder" aria-hidden="true"></i></span>
                <h4><?php echo e($subfolder->name); ?></h4>
                <p>Created <?php echo e($subfolder->created_at->format('d M Y')); ?></p>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<div class="card">
    <div class="panel-head">
        <h3><i data-lucide="file" aria-hidden="true"></i> Files in this folder</h3>
        <span class="badge"><?php echo e($files->count()); ?> file(s)</span>
    </div>

    <?php if($files->count()): ?>
        <div class="file-list">
            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="file-row">
                    <?php echo $__env->make('partials.file-icon', ['file' => $file], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="file-info">
                        <b><?php echo e($file->original_name); ?></b>
                        <span><?php echo e($file->mime_type ?? 'Unknown type'); ?></span>
                    </div>
                    <span class="file-cell file-size"><?php echo e(number_format($file->file_size / 1024, 1)); ?> KB</span>
                    <span class="file-cell file-type"><?php echo e($file->created_at->format('d M Y')); ?></span>
                    <div class="file-actions">
                        <a class="btn btn-ghost btn-sm btn-icon" href="<?php echo e(route('download', $file->id)); ?>" title="Download">
                            <i data-lucide="download" aria-hidden="true"></i>
                        </a>
                        <form action="<?php echo e(route('favorite.toggle', $file->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <button class="btn btn-ghost btn-sm btn-icon" type="submit" title="Favorite">
                                <i data-lucide="star" aria-hidden="true" style="<?php echo e($file->is_favorite ? 'fill:var(--warn);color:var(--warn)' : ''); ?>"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('delete', $file->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Delete" onclick="return confirm('Move this file to Trash?')">
                                <i data-lucide="trash-2" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="empty">
            <span class="empty-icon"><i data-lucide="folder-open" aria-hidden="true"></i></span>
            <h3>This folder is empty</h3>
            <p>Upload files here to organize them in this folder.</p>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\infinitg\resources\views/folder.blade.php ENDPATH**/ ?>