<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーの管理</title>
</head>

<body>
    <h1>ユーザーの管理</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div style="color: green;">
            <?php echo session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <p>
        <a href="/admin/user/new">ユーザー作成</a>
    </p>
    <h2>ユーザー一覧</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ユーザー名</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td>
                    <?php echo $user['id']; ?>
                </td>
                <td>
                    <?php echo $user['name']; ?>
                </td>
                <td>
                    <?php
                    if ($user['active_status'] == 0) :
                        echo '利用不可';
                    else :
                        echo '利用可能';
                    endif;
                    ?>
                </td>
                <td>
                    <a href="/admin/user/<?php echo $user['id']; ?>">表示</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>