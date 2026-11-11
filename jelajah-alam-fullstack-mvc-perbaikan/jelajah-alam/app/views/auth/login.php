<section class="auth-wrap">
    <form class="panel" method="post" action="<?= url('auth/login') ?>">
        <span class="eyebrow">AREA ADMINISTRATOR</span>
        <h1>Masuk Dashboard</h1>
        <?php if (!empty($error)): ?><p class="error" role="alert"><?= e($error) ?></p><?php endif; ?>
        <?= csrf_field() ?>
        <label for="username">Username</label>
        <input id="username" name="username" required autocomplete="username" value="<?= e($username ?? '') ?>">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        <button class="btn full" type="submit">Login</button>
    </form>
</section>
