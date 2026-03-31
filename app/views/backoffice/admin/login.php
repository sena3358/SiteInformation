<section class="bo-login" aria-label="Connexion administrateur">
    <aside class="bo-login-side">
        <h1>Pilotez votre redaction en toute maitrise</h1>
        <p>
            Publication d'articles, suivi des categories et administration du contenu
            sur un espace securise et ergonomique.
        </p>
    </aside>

    <div class="bo-login-form-wrap">
        <form class="bo-login-form bo-form-grid" method="post" action="<?= htmlspecialchars(UrlHelper::adminLogin(), ENT_QUOTES, 'UTF-8') ?>">
            <p class="bo-login-kicker">BackOffice</p>
            <h2 class="bo-login-title">Connexion administrateur</h2>
            <p class="bo-login-help">Utilisez vos identifiants pour acceder a l'espace de gestion.</p>

            <div class="bo-field">
                <label for="username">Nom utilisateur</label>
                <input class="bo-input" id="username" name="username" autocomplete="username" value="editor1"required>
            </div>

            <div class="bo-field">
                <label for="password">Mot de passe</label>
                <input class="bo-input" id="password" type="password" name="password" value="editor123" autocomplete="current-password" required>
            </div>

            <button class="bo-btn" type="submit">Se connecter</button>
        </form>
    </div>
</section>
