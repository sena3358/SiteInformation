<?php /** @var list<array<string,mixed>> $articles */ ?>
<a href="/admin/articles/create">Ajouter un article</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Categorie</th>
            <th>Auteur</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= (int) $article['id'] ?></td>
            <td><?= ViewService::e((string) $article['titre']) ?></td>
            <td><?= ViewService::e((string) ($article['categorie'] ?? 'Sans categorie')) ?></td>
            <td><?= ViewService::e((string) $article['nom_auteur']) ?></td>
            <td><?= ViewService::e((string) $article['statut']) ?></td>
            <td><?= ViewService::e((string) $article['date']) ?></td>
            <td>
                <a class="inline" href="/admin/articles/edit/<?= (int) $article['id'] ?>">Editer</a>
                <form method="post" action="/admin/articles/delete/<?= (int) $article['id'] ?>" class="inline" onsubmit="return confirm('Supprimer cet article ?')">
                    <button class="danger" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
