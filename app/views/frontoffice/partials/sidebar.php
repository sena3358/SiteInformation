<?php

declare(strict_types=1);

$activeNav = (string) ($activeNav ?? '');
?>
<header class="fo-navbar" aria-label="Navigation frontoffice">
    <!-- Top Bar -->
    <div class="fo-navbar-top">
        <div class="fo-navbar-top-inner">
            <!-- Left: Journal & Services -->
            <div class="fo-navbar-top-left">
                <a href="<?= htmlspecialchars(UrlHelper::home(), ENT_QUOTES) ?>" class="fo-navbar-toplink" title="Le journal">
                    <span class="fo-navbar-toplink-icon">&#9783;</span>
                    <span class="fo-navbar-toplink-label">Le journal</span>
                </a>
                <a href="#services" class="fo-navbar-toplink" title="Services">
                    <span class="fo-navbar-toplink-icon"></span>
                    <span class="fo-navbar-toplink-label"></span>
                </a>
            </div>

            <!-- Center: Logo/Brand -->
            <div class="fo-navbar-top-center">
                <h1 class="fo-navbar-logo">
                    <a href="<?= htmlspecialchars(UrlHelper::home(), ENT_QUOTES) ?>">Iran - Infos</a>
                </h1>
            </div>

            <!-- Right: Language, Subscribe, Search -->
            <div class="fo-navbar-top-right">
                <div class="fo-navbar-lang">
                    <span class="fo-lang-current"></span>
                    <a href="#" class="fo-lang-link"></a>
                </div>
                
                <?php if (($visitorLoggedIn ?? false) === true): ?>
                    <span class="fo-navbar-user-badge"><?= htmlspecialchars((string) ($visitorName ?? ''), ENT_QUOTES) ?></span>
                    <a href="<?= htmlspecialchars(UrlHelper::account(), ENT_QUOTES) ?>" class="fo-navbar-toplink">Mon compte</a>
                    <a href="<?= htmlspecialchars(UrlHelper::logout(), ENT_QUOTES) ?>" class="fo-navbar-toplink">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars(UrlHelper::adminLogin(), ENT_QUOTES) ?>" class="fo-navbar-subscribe">Backoffice</a>
                <?php endif; ?>
                
                <a href="#search" class="fo-navbar-search-icon" title="Rechercher"></a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="fo-navbar-main" aria-label="Navigation principale">
        <div class="fo-navbar-main-inner">
            <!-- Menu Toggle -->
            <button class="fo-navbar-menu-toggle" aria-label="Ouvrir le menu" title="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Sections Categories -->
            <div class="fo-navbar-sections">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <a
                            class="fo-navbar-section <?= $activeNav === $category['id'] ? 'is-active' : '' ?>"
                            href="<?= htmlspecialchars(Category::url($category), ENT_QUOTES) ?>"
                            <?= $activeNav === $category['id'] ? 'aria-current="page"' : '' ?>
                        >
                            <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES) ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- <a class="fo-navbar-section" href="<?= htmlspecialchars(UrlHelper::adminLogin(), ENT_QUOTES) ?>">BackOffice</a> -->
            </div>

            <!-- Extras -->
            <div class="fo-navbar-main-extras">
                <a href="#search" class="fo-navbar-search-toggle" title="Rechercher"></a>
            </div>
        </div>
    </nav>
</header>
