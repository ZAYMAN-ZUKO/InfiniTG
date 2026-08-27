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

<h2>Create your account</h2>
<p>Start storing files for free — takes less than a minute.</p>

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

<form method="POST" action="<?php echo e(route('register')); ?>">
    <?php echo csrf_field(); ?>

    <div class="field">
        <label for="name">Name</label>
        <input class="input" id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="username">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="new-password">
    </div>

    <div class="field">
        <label for="password_confirmation">Confirm Password</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button class="btn btn-primary btn-block" type="submit">
        <i data-lucide="user-plus" aria-hidden="true"></i>Register
    </button>
</form>

<p class="auth-alt">
    Already registered? <a href="<?php echo e(route('login')); ?>">Log in</a>
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
<?php /**PATH C:\laragon\www\infinitg\resources\views/auth/register.blade.php ENDPATH**/ ?>