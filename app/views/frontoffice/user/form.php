<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire utilisateur</title>
    <meta name="description" content="Formulaire utilisateur pour demonstration de saisie frontoffice.">
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php $activeNav = 'user_form'; require __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="fo-main">
                <section class="fo-panel">
                    <h1>Formulaire utilisateur</h1>
                    <p class="fo-page-meta">Exemple de saisie avec presentation harmonisee au frontoffice.</p>

                    <form class="fo-form" method="post" action="#">
                        <label for="username">Username</label>
                        <input id="username" name="username" required>

                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="exemple@site.com">

                        <label for="role">Role</label>
                        <input id="role" name="role" placeholder="lecteur">

                        <button type="submit">Enregistrer</button>
                    </form>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
