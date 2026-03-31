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
<aside class="fo-sidebar" aria-label="Navigation frontoffice">
    <div class="fo-sidebar-card">
        <div class="fo-sidebar-brand">
            <h2 class="fo-sidebar-title">Iran - Infos</h2>
            
        </div>

        <nav class="fo-sidebar-nav" aria-label="Liens principaux">
            <?php foreach ($navItems as $item): ?>
                <?php $isActive = $activeNav === $item['key']; ?>
                <a
                    class="fo-sidebar-link <?= $isActive ? 'is-active' : '' ?>"
                    href="<?= htmlspecialchars($item['href'], ENT_QUOTES) ?>"
                    <?= $isActive ? 'aria-current="page"' : '' ?>
                >
                    <span class="fo-sidebar-link-label"><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span>
                    <span class="fo-sidebar-link-hint"><?= htmlspecialchars($item['hint'], ENT_QUOTES) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</aside>
