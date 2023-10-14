<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー作成</title>
</head>

<body>
    <h1>ユーザー作成</h1>
    <?php if (session('errors')) : ?>
        <div style="color: red;">
            <?php foreach (session('errors') as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="/admin/user/create" method="post">
        <div>
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" value="<?php echo old('name'); ?>" required>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="作成">
        </div>
    </form>

</body>

</html>