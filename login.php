<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Support\Auth;

Auth::start();

if (Auth::check()) {
    header('Location: dashboard.php');
    exit;
}

$error = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Informe email e senha.';
    } else {
        // Placeholder: you said you'll add DB-backed login later.
        // For now, we accept any credentials to unblock navigation/UX.
        Auth::login([
            'email' => $email,
        ]);
        header('Location: dashboard.php');
        exit;
    }
}
?>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Entrar</h2>
    <p style="margin-top:-6px;color:var(--muted)">Login temporário (sem banco) — você vai ligar no banco depois.</p>

    <?php if ($error) { ?>
        <div style="margin:12px 0;padding:10px 12px;border:1px solid var(--border);border-radius:12px;background:color-mix(in srgb, var(--danger) 10%, transparent);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php } ?>

    <form method="POST" action="login.php">
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" autocomplete="username" required>
        </div>
        <div class="field">
            <label>Senha</label>
            <input type="password" name="password" autocomplete="current-password" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

