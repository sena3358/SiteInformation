<?php /** @var list<array{id:int,libelle:string}> $categories */ ?>
<section style="margin-bottom:28px;">
    <h2>Nouvelle categorie</h2>
    <form method="post" action="/admin/categories/create" style="max-width:420px;">
        <label for="libelle">Libelle</label>
        <input id="libelle" name="libelle" maxlength="120" required>
        <button type="submit">Ajouter</button>
    </form>
</section>

<section>
    <h2>Liste des categories</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= (int) $category['id'] ?></td>
                <td>
                    <form method="post" action="/admin/categories/update/<?= (int) $category['id'] ?>" class="inline" style="display:flex;gap:8px;align-items:center;">
                        <input style="margin:0;min-width:220px;" name="libelle" value="<?= ViewService::e((string) $category['libelle']) ?>" required>
                        <button type="submit">Modifier</button>
                    </form>
                    <form method="post" action="/admin/categories/delete/<?= (int) $category['id'] ?>" class="inline" onsubmit="return confirm('Supprimer cette categorie ?')">
                        <button class="danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
