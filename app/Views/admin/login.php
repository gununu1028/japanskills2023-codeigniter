<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
</head>

<body>
    <h1>管理画面 ログイン</h1>
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <form action="/admin/login" method="post">
        <div>
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">ログイン</button>
        </div>
    </form>
</body>

</html>