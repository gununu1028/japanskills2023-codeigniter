<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>イベント情報新規登録</title>
</head>

<body>
    <h1>イベント情報新規登録</h1>
    <?php if (session('errors')) : ?>
        <div style="color: red;">
            <?php foreach (session('errors') as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="/admin/event/create" method="post">
        <div>
            <label for="name">イベント名:</label>
            <input type="text" id="name" name="name" value="<?php echo old('name'); ?>" required>
        </div>
        <div>
            <label for="place">場所:</label>
            <input type="text" id="place" name="place" value="<?php echo old('place'); ?>" required>
        </div>
        <div>
            <label for="event_date">日時:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo old('event_date'); ?>" required>
        </div>
        <div>
            <input type="submit" value="登録">
        </div>
    </form>
</body>

</html>