<?php $__env->startSection('title', 'My Files'); ?>

<?php $__env->startSection('content'); ?>

<div class="pagehead">
    <div>
        <h1>My Files</h1>
        <p>Store, organize and access your files.</p>
    </div>
    <div class="actions">
        <button class="btn btn-primary" type="button" data-open-modal="upload">
            <i data-lucide="upload" aria-hidden="true"></i>Upload
        </button>
        <button class="btn btn-soft" type="button" data-open-modal="folder">
            <i data-lucide="folder-plus" aria-hidden="true"></i>New Folder
        </button>
    </div>
</div>

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

<?php if(isset($search)): ?>
    <div class="alert alert-info">
        <i data-lucide="search" aria-hidden="true"></i>
        <span>Search results for &ldquo;<?php echo e($search); ?>&rdquo; &mdash; <?php echo e($files->count()); ?> file(s) found.</span>
    </div>
<?php endif; ?>


<div class="card" style="margin-bottom:20px">
    <div class="panel-head">
        <h3><i data-lucide="folder" aria-hidden="true"></i> Folders</h3>
        <button class="btn btn-ghost btn-sm" type="button" data-open-modal="folder">
            <i data-lucide="plus" aria-hidden="true"></i>New Folder
        </button>
    </div>

    <?php if($folders->count()): ?>
        <div class="folder-grid">
            <?php $__currentLoopData = $folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="folder-card">
                    <span class="folder-icon"><i data-lucide="folder" aria-hidden="true"></i></span>
                    <h4><a href="<?php echo e(route('folders.show', $folder)); ?>"><?php echo e($folder->name); ?></a></h4>
                    <p>Created <?php echo e($folder->created_at->format('d M Y')); ?></p>

                    <div class="folder-rename">
                        <form action="<?php echo e(route('folders.update', $folder)); ?>" method="POST" class="rename-form" id="folder-rename-<?php echo e($folder->id); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input class="input" type="text" name="name" value="<?php echo e($folder->name); ?>" required maxlength="255">
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                            </div>
                        </form>
                        <div style="display:flex;gap:6px">
                            <button class="btn btn-ghost btn-sm" type="button" data-rename-toggle="folder-rename-<?php echo e($folder->id); ?>">
                                <i data-lucide="pencil" aria-hidden="true"></i>Rename
                            </button>
                            <form action="<?php echo e(route('folders.destroy', $folder)); ?>" method="POST" style="flex:1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm btn-block" type="submit" onclick="return confirm('Delete this folder?')">
                                    <i data-lucide="trash-2" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="empty">
            <span class="empty-icon"><i data-lucide="folder-plus" aria-hidden="true"></i></span>
            <h3>No folders yet</h3>
            <p>Create folders to organize your files.</p>
        </div>
    <?php endif; ?>
</div>


<div class="card">
    <div class="panel-head">
        <h3><i data-lucide="file" aria-hidden="true"></i> Uploaded Files</h3>
        <div class="file-head-actions">
            <label class="check check-sm" title="Select all on this page">
                <input type="checkbox" id="select-all" aria-label="Select all files">
                <span>Select all</span>
            </label>
            <span class="badge"><?php echo e($files->count()); ?> file(s)</span>
        </div>
    </div>

    <?php if($files->count()): ?>
        <div class="file-list">
            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="file-row">
                    <label class="file-check-wrap" title="Select file">
                        <input type="checkbox" class="file-check" value="<?php echo e($file->id); ?>" aria-label="Select <?php echo e($file->original_name); ?>">
                    </label>
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
                            <button class="btn btn-ghost btn-sm btn-icon <?php echo e($file->is_favorite ? 'is-fav' : ''); ?>" type="submit" title="<?php echo e($file->is_favorite ? 'Unfavorite' : 'Favorite'); ?>">
                                <i data-lucide="<?php echo e($file->is_favorite ? 'star' : 'star'); ?>" aria-hidden="true" style="<?php echo e($file->is_favorite ? 'fill:var(--warn);color:var(--warn)' : ''); ?>"></i>
                            </button>
                        </form>
                        <button class="btn btn-ghost btn-sm btn-icon" type="button" data-rename-toggle="file-rename-<?php echo e($file->id); ?>" title="Rename">
                            <i data-lucide="pencil" aria-hidden="true"></i>
                        </button>
                        <form action="<?php echo e(route('delete', $file->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Delete" onclick="return confirm('Move this file to Trash?')">
                                <i data-lucide="trash-2" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <form class="rename-form" id="file-rename-<?php echo e($file->id); ?>" action="<?php echo e(route('rename', $file->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input class="input" type="text" name="original_name" value="<?php echo e($file->original_name); ?>" required maxlength="255">
                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                    <button class="btn btn-ghost btn-sm" type="button" data-rename-toggle="file-rename-<?php echo e($file->id); ?>">Cancel</button>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="empty">
            <span class="empty-icon"><i data-lucide="upload-cloud" aria-hidden="true"></i></span>
            <h3>No files uploaded yet</h3>
            <p>Drop your first file and it will be stored on Telegram's cloud.</p>
            <button class="btn btn-primary" type="button" data-open-modal="upload">
                <i data-lucide="upload" aria-hidden="true"></i>Upload a file
            </button>
        </div>
    <?php endif; ?>
</div>




<div class="bulk-bar" id="bulk-bar" aria-hidden="true">
    <span class="bulk-count" id="bulk-count">0 selected</span>
    <div class="bulk-actions">
        <button class="btn btn-ghost btn-sm" type="button" data-bulk="download" data-url="<?php echo e(route('download', '__ID__')); ?>">
            <i data-lucide="download" aria-hidden="true"></i>Download
        </button>
        <button class="btn btn-soft btn-sm" type="button" data-bulk="favorite" data-url="<?php echo e(route('favorite.toggle', '__ID__')); ?>" data-method="PUT">
            <i data-lucide="star" aria-hidden="true"></i>Favorite
        </button>
        <button class="btn btn-danger btn-sm" type="button" data-bulk="trash" data-url="<?php echo e(route('delete', '__ID__')); ?>" data-method="DELETE" data-confirm="Move the selected files to Trash?">
            <i data-lucide="trash-2" aria-hidden="true"></i>Trash
        </button>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\infinitg\resources\views/files.blade.php ENDPATH**/ ?>