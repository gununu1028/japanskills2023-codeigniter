<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>イベント情報編集</title>
</head>

<body>
    <h1>イベント情報編集</h1>
    <?php if (session(val: 'errors')) : ?>
        <div style="color: red;">
            <?php foreach (session('errors') as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="/admin/event/<?php echo $event['id']; ?>/update" method="post">
        <div>
            <label for="name">イベント名:</label>
            <input type="text" name="name" id="name" value="<?php echo $event['name']; ?>" required>
        </div>
        <div>
            <label for="place">場所:</label>
            <input type="text" name="place" id="place" value="<?php echo $event['place']; ?>" required>
        </div>
        <div>
            <label for="event_date">日時:</label>
            <input type="date" name="event_date" id="event_date" value="<?php echo $event['event_date']; ?>" required>
        </div>
        <div>
            <button type="submit">更新</button>
        </div>
    </form>
</body>

</html>