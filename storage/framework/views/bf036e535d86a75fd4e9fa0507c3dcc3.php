<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<h2>Welcome back</h2>
<p>Log in to your InfiniTG account.</p>

<?php if(session('status')): ?>
    <div class="alert alert-success">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span><?php echo e(session('status')); ?></span>
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

<form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="current-password">
    </div>

    <div class="auth-links">
        <label class="check">
            <input type="checkbox" name="remember" id="remember_me">
            Remember me
        </label>
        <?php if(Route::has('password.request')): ?>
            <a href="<?php echo e(route('password.request')); ?>">Forgot password?</a>
        <?php endif; ?>
    </div>

    <button class="btn btn-primary btn-block" type="submit" style="margin-top:20px">
        <i data-lucide="log-in" aria-hidden="true"></i>Log in
    </button>
</form>

<p class="auth-alt">
    Don't have an account? <a href="<?php echo e(route('register')); ?>">Create one</a>
</p>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\infinitg\resources\views/auth/login.blade.php ENDPATH**/ ?>