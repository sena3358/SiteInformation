<?php

declare(strict_types=1);

$activeNav = (string) ($activeNav ?? '');
$navItems = [
    ['key' => 'home', 'href' => UrlHelper::home(), 'label' => 'Accueil', 'hint' => ''],
    ['key' => 'users', 'href' => UrlHelper::users(), 'label' => 'Utilisateurs', 'hint' => ''],
    ['key' => 'account', 'href' => UrlHelper::account(), 'label' => 'Mon compte', 'hint' => ''],
    ['key' => 'login', 'href' => UrlHelper::login(), 'label' => 'Connexion', 'hint' => ''],
    ['key' => 'admin', 'href' => UrlHelper::adminLogin(), 'label' => 'BackOffice', 'hint' => ''],
];
?>
<header class="fo-navbar" aria-label="Navigation frontoffice">
    <div class="fo-navbar-inner">
        <div class="fo-navbar-brand">
            <h2 class="fo-sidebar-title">Iran - Infos</h2>
        </div>

        <nav class="fo-navbar-links" aria-label="Liens principaux">
            <?php foreach ($navItems as $item): ?>
                <?php $isActive = $activeNav === $item['key']; ?>
                <a
                    class="fo-navbar-link <?= $isActive ? 'is-active' : '' ?>"
                    href="<?= htmlspecialchars($item['href'], ENT_QUOTES) ?>"
                    <?= $isActive ? 'aria-current="page"' : '' ?>
                >
                    <span class="fo-navbar-link-label"><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span>
                    <span class="fo-navbar-link-hint"><?= htmlspecialchars($item['hint'], ENT_QUOTES) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>
