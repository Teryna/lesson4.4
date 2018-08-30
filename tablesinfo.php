<?php
include_once 'config.php';

if(!empty($_GET['name'])){
	$table = strip_tags($_GET['name']);   
} else {
    header('Location: index.php');
}

$columns = $pdo->query("DESCRIBE $table");		
$res = $columns->fetchAll(PDO::FETCH_ASSOC); 

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'delete') {
        $name = $_POST['field'];
        $pdo->exec("ALTER TABLE $table DROP COLUMN $name");
        header('Location: tablesinfo.php?name='.$table);
    }
}

if (isset($_POST['add_new_name'])) {
    $name = $_POST['name'];
    $new_name = strip_tags($_POST['new_name']);
    $type = $_POST['type'];
    $pdo->exec("ALTER TABLE $table CHANGE $name $new_name $type");
    header('Location: tablesinfo.php?name='.$table);
}

if (isset($_POST['add_new_type'])) {
    $name = $_POST['name'];
    $type = strip_tags($_POST['new_type']);
    $pdo->exec("ALTER TABLE $table MODIFY $name $type");
    header('Location: tablesinfo.php?name='.$table);
}    
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Управление таблицами и базами данных</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Таблица <?=$table?></h2>
<table>
    <thead>
        <tr>
            <th>Поле</th>
            <th>Тип</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($res as $result) : ?>
        <tr>
            <td><?=$result['Field']?></td>
            <td><?=$result['Type']?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="field" value="<?=$result['Field']?>">
                    <input type="hidden" name="type" value="<?=$result['Type']?>">
                    <select name="action">
                        <option>Выберите:</option>
                        <option value="delete">Удалить</option>
                        <option value="edit_name">Изменить название</option>
                        <option value="edit_type">Изменить тип</option>
                    </select>
                    <input type="submit" value="Выполнить">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>       
    </tbody>
</table>
<?php
    if (isset($_POST['action'])) : ?>
    <form method="post">
        <input type="hidden" name="name" value="<?=$_POST['field']?>">
        <input type="hidden" name="type" value="<?=$_POST['type']?>">
            <?php if ($_POST['action'] == 'edit_name') : ?>
            <input type="text" name="new_name" value="<?= $_POST['field'] ?>">
            <input type="submit" name="add_new_name" value="Изменить название поля">
            <?php endif; ?>
            <?php if ($_POST['action'] == 'edit_type') : ?>
            <input type="text" name="new_type" value="<?= $_POST['type'] ?>">
            <input type="submit" name="add_new_type" value="Изменить тип поля">
            <?php endif; ?>
    </form>
<?php endif; ?>
<p><a href="index.php">Назад к списку таблиц</a></p>
</body>
</html>