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
            <a href="/admin/event/new">イベント情報新規登録</a>
        </li>
        <li>
            <a href="/admin/event">イベント情報一覧</a>
        </li>
        <li>
            <a href="/admin/logout">ログアウト</a>
        </li>
    </ul>
</body>

</html>