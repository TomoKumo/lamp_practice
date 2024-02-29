<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ToDoリスト</title>
</head>

<body>
    <h1>ToDoリスト</h1>
    <?php
        include 'functions.php';

        $errMsg = "";
        $mes = "";
        $TABLE_NAME = "todo_list";
        $db = connectDB();
        createTableForTodoList($db, $TABLE_NAME);

        if (isset($_POST["add"])) {
            $errMsg = addTodoItem($db, $TABLE_NAME, $_POST["task"], $_POST["deadline"]);
        }
        if (isset($_POST["complete"])) {
            $errMsg = completeTodoItem($db, $TABLE_NAME, $_POST["id"]);
        }
        if (isset($_POST["delete"])) {
            $errMsg = deleteTodoItem($db, $TABLE_NAME, $_POST["id"]);
        }
        echo "<span style='color:red'><p>$errMsg</p></span>";
        fetchTodoItems($db, $TABLE_NAME);
    ?>

    <h2>ToDoを追加する</h2>
    <form action="" method="post">
        <p>タスク:<input type="text" name="task"></p>
        <p>締め切り:<input type="date" name="deadline"></p>
        <input type="submit" name="add" value="追加">
    </form>

    <h2>ToDoを完了する・削除する</h2>
    <form action="" method="post">
        <p>ToDoのID:<input type="number" name="id"></p>
        <input type="submit" name="complete" value="完了">
        <input type="submit" name="delete" value="削除">
    </form>
</body>

</html>
