<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfiniTG | Unlimited Cloud Storage</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <defs>
        <linearGradient id="ig-grad" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#6366f1"/>
            <stop offset="100%" stop-color="#a78bfa"/>
        </linearGradient>
    </defs>
</svg>

<div class="landing">

    <nav class="landing-nav">
        <a href="<?php echo e(route('home')); ?>" class="landing-brand">
            <span class="sidebar-brand-mark"><i data-lucide="infinity" aria-hidden="true"></i></span>
            InfiniTG
        </a>
        <div class="landing-nav-actions">
            <a class="btn btn-ghost" href="<?php echo e(route('login')); ?>">Log in</a>
            <a class="btn btn-primary" href="<?php echo e(route('register')); ?>">Get Started</a>
        </div>
    </nav>

    <section class="hero">
        <div>
            <span class="hero-badge">
                <i data-lucide="zap" aria-hidden="true"></i>Powered by Telegram infrastructure
            </span>
            <h1>Unlimited cloud storage, <em>infinitely yours.</em></h1>
            <p>
                Store, organize and access your files from anywhere with a modern,
                fast and secure cloud experience — backed by the reliability of Telegram.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?php echo e(route('register')); ?>">
                    <i data-lucide="rocket" aria-hidden="true"></i>Start Free
                </a>
                <a class="btn btn-ghost" href="<?php echo e(route('login')); ?>">
                    <i data-lucide="log-in" aria-hidden="true"></i>Log in
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <b>∞</b>
                    <span>Unlimited storage</span>
                </div>
                <div class="hero-stat">
                    <b>100%</b>
                    <span>Encrypted &amp; safe</span>
                </div>
                <div class="hero-stat">
                    <b>24/7</b>
                    <span>Always accessible</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card">
                <div class="hero-ring">
                    <svg viewBox="0 0 150 150" aria-hidden="true">
                        <circle class="ring-bg" cx="75" cy="75" r="50"></circle>
                        <circle class="ring-fg" cx="75" cy="75" r="50"></circle>
                    </svg>
                    <div class="hero-ring-center">
                        <b>∞</b>
                        <span>Free space</span>
                    </div>
                </div>
                <div class="hero-files">
                    <div class="hero-file-row">
                        <span class="file-icon fi-img"><i data-lucide="image" aria-hidden="true"></i></span>
                        <div class="file-info">
                            <b>sunset-vacation.jpg</b>
                            <span>2.4 MB &middot; Image</span>
                        </div>
                        <i data-lucide="check-circle" style="width:16px;height:16px;color:var(--success)" aria-hidden="true"></i>
                    </div>
                    <div class="hero-file-row">
                        <span class="file-icon fi-pdf"><i data-lucide="file-text" aria-hidden="true"></i></span>
                        <div class="file-info">
                            <b>portfolio-2026.pdf</b>
                            <span>8.1 MB &middot; PDF</span>
                        </div>
                        <i data-lucide="check-circle" style="width:16px;height:16px;color:var(--success)" aria-hidden="true"></i>
                    </div>
                    <div class="hero-file-row">
                        <span class="file-icon fi-zip"><i data-lucide="archive" aria-hidden="true"></i></span>
                        <div class="file-info">
                            <b>project-backup.zip</b>
                            <span>124 MB &middot; Archive</span>
                        </div>
                        <i data-lucide="check-circle" style="width:16px;height:16px;color:var(--success)" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <h2>Everything you need, nothing you don't</h2>
        <p class="features-sub">A clean, fast and reliable cloud for your files.</p>

        <div class="feature-grid">
            <div class="feature">
                <span class="feature-icon"><i data-lucide="infinity" aria-hidden="true"></i></span>
                <h3>Unlimited Storage</h3>
                <p>Store as many files as you want using Telegram cloud infrastructure — no quota anxiety.</p>
            </div>
            <div class="feature">
                <span class="feature-icon"><i data-lucide="zap" aria-hidden="true"></i></span>
                <h3>Lightning Fast</h3>
                <p>Quickly upload, organize and access your files anytime, on any device with a browser.</p>
            </div>
            <div class="feature">
                <span class="feature-icon"><i data-lucide="shield-check" aria-hidden="true"></i></span>
                <h3>Secure &amp; Reliable</h3>
                <p>Your files stay protected on a clean, secure platform backed by Telegram's infrastructure.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-card">
            <h2>Ready to get started?</h2>
            <p>Create your free account and start managing your files today — it takes less than a minute.</p>
            <a class="btn btn-primary" href="<?php echo e(route('register')); ?>">
                <i data-lucide="rocket" aria-hidden="true"></i>Create Free Account
            </a>
        </div>
    </section>

    <footer class="landing-footer">
        <span>&copy; <?php echo e(date('Y')); ?> InfiniTG &mdash; Unlimited cloud storage, powered by Telegram.</span>
        <span>Support: nahimmasrur01@gmail.com &middot; +880 1875668148</span>
    </footer>

</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>if (window.lucide) { lucide.createIcons(); }</script>

</body>
</html>
<?php /**PATH C:\laragon\www\infinitg\resources\views/index.blade.php ENDPATH**/ ?>