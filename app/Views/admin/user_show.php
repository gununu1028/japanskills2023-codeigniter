<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー詳細</title>
    <style>
        .link-button {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            font-size: 1em;
            font-family: inherit;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <h1>ユーザー詳細</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div style="color: green;">
            <?php echo session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <div>
        <a href="/admin/user">ユーザー一覧</a>
    </div>
    <div>
        <ul>
            <li>
                ユーザー名：<?php echo $user['name']; ?>
            </li>
            <li>
                パスワード：********
            </li>
            <li>
                <?php
                if ($user['active_status']) :
                    echo '利用可能';
                    $valueText = '利用不可にする';
                else :
                    echo '利用不可';
                    $valueText = '利用可能にする';
                endif;
                ?>
                <form action="/admin/user/<?php echo $user['id']; ?>/active_status" method="post">
                    <input type="hidden" name="_method" value="patch">
                    <input type="submit" value="<?php echo $valueText; ?>" class="link-button">
                </form>
            </li>
        </ul>
    </div>
    <div>
        <a href="/admin/user/<?php echo $user['id']; ?>/edit">このユーザーを編集する</a>
    </div>
    <div>
        <form action="/admin/user/<?php echo $user['id']; ?>" method="post">
            <input type="hidden" name="_method" value="delete">
            <input type="submit" value="このユーザーを削除する" class="link-button">
        </form>
    </div>
</body>

</html>