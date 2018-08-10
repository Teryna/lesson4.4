<?php 
error_reporting (E_ALL);
include_once 'config.php';
if (!empty($_POST['description'])) {
    $name = $_POST['description'];
    $pdo->exec("DROP TABLE IF EXISTS $name;
    CREATE TABLE IF NOT EXISTS $name (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `login` varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

$result = $pdo->query("SHOW TABLES");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Управление таблицами и базами данных</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Создать таблицу</h2>

    <form action="index.php" method="POST">
     <input type="text" name="description" placeholder="Название таблицы" value="<?php if (!empty($_POST['description'])) echo $_POST['description']; ?>">
      <input type="submit" name="create" value="создать таблицу">
    </form>
    
<h3>Существующие таблицы в базе данных</h3>
<table>
    <thead>
        <tr>
            <th>Cписок таблиц</th>
        </tr>
    </thead>
    <tbody>
    <?php
        while ($row = $result->fetch(PDO::FETCH_NUM)) :  
            foreach ($row as $rows) : ?>
            <tr>
                <td><?php echo '<a href="tablesinfo.php?name='.$row[0].'">'.$row[0].'</a>'.'</br>';?></td>
            </tr>
            <?php endforeach; ?>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>