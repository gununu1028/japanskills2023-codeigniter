<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー編集</title>
</head>

<body>
    <h1>ユーザー編集</h1>
    <?php if (session('errors')) : ?>
        <div style="color: red;">
            <?php foreach (session('errors') as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="/admin/user/<?php echo $user['id']; ?>" method="post">
        <input type="hidden" name="_method" value="put">

        <div>
            <label for="name">ユーザー名:</label>
            <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">更新</button>
        </div>
    </form>

</body>

</html>