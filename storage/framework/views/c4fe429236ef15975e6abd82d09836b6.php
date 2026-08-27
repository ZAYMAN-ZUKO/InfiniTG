<header class="topbar">
    <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
        <i data-lucide="menu" aria-hidden="true"></i>
    </button>

    <div class="topbar-title">
        InfiniTG <span>&middot; Cloud Storage</span>
    </div>

    <form class="search" action="<?php echo e(route('search')); ?>" method="GET" role="search">
        <i data-lucide="search" aria-hidden="true"></i>
        <input type="search" name="search" placeholder="Search files..." value="<?php echo e(request('search')); ?>" aria-label="Search files">
    </form>

    <div class="topbar-right">
        <button class="icon-btn" type="button" aria-label="Notifications" title="Notifications">
            <i data-lucide="bell" aria-hidden="true"></i>
        </button>
        <a class="avatar" href="<?php echo e(route('settings')); ?>" title="<?php echo e(Auth::user()->name); ?>">
            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

        </a>
    </div>
</header>
<?php /**PATH C:\laragon\www\infinitg\resources\views/partials/topbar.blade.php ENDPATH**/ ?>