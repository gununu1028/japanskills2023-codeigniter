<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
</head>

<body>
    <h1>管理画面</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div style="color: green;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <ul>
        <li>
            <a href="/admin/user/">ユーザー管理</a>
        </li>
    </ul>
</body>

</html>