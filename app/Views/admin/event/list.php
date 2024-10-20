<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>イベント情報一覧表示</title>
</head>

<body>
    <h1>イベント情報一覧表示</h1>

    <?php if (session()->getFlashdata('success')) : ?>
        <div style="color: green;">
            <?php echo session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>イベント名</th>
            <th>開催場所</th>
            <th>開催日</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($event_list as $event) : ?>
            <tr>
                <td>
                    <?php echo $event['id']; ?>
                </td>
                <td>
                    <?php echo $event['name']; ?>
                </td>
                <td>
                    <?php echo $event['place']; ?>
                </td>
                <td>
                    <?php echo $event['event_date']; ?>
                </td>
                <td>
                    <a href="/admin/event/<?php echo $event['id']; ?>">編集</a>
                </td>
                <td>
                    <a href="/admin/event/<?php echo $event['id']; ?>">削除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>