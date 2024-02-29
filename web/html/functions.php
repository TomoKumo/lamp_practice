<?php
//データベースに接続するためのPDOインスタンスを作成
function connectDB() {
    try {
        $dsn = 'mysql:host=mysql;dbname=test_db;charset=utf8';
        $pdo = new PDO($dsn, 'test_user', 'test_password');
        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

//ToDoリストのタスクを保存するためのテーブルを作成(既にある場合は作成しない)
function createTableForTodoList(PDO $pdo, $TABLE_NAME): bool {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $TABLE_NAME
            (
                id INT AUTO_INCREMENT PRIMARY KEY,
                task VARCHAR(255),
                deadline DATE,
                completed BOOLEAN
            );";
        $stmt = $pdo->query($sql);
        return true;
    } catch (PDOExeption $e) {
        echo $e->getMessage();
        return false;
    }
}

//テーブルからToDoアイテムを取得し、表示する（タスク、締め切り、完了状態を表示）
function fetchTodoItems(PDO $pdo, $TABLE_NAME){
    $sql = "SELECT * FROM $TABLE_NAME";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        echo $row['id'] . ' ';
        echo "タスク:" . $row['task'] . " ";
        echo "締め切り:" . $row['deadline'] . '<br>';
        if ($row['completed']) {
            echo "状態: 完了";
        } else {
            echo "状態: 未完了";
        }
        echo "<hr>";
    }
}

//渡された文字列が空白でないかを確認
function is_not_space(?string $str): bool {
    $str = preg_replace("/( | )/", "", $str);
    if ($str == "") {
        return false;
    } else {
        return true;
    }
}

//新しいToDoアイテムを追加。タスクと締め切りの入力が空白でないことを確認し、空白の場合はエラーメッセージを返す。
function addTodoItem(PDO $pdo, string $TABLE_NAME, $task, $deadline): string {
    if (!is_not_space($task)) {
        return "タスクを入力してください";
    }

    if (!is_not_space($deadline)) {
        return "締め切りを入力してください";
    }

    $sql = $pdo->prepare
        ("INSERT INTO $TABLE_NAME (task, deadline, completed) 
        VALUES (:task, :deadline, false)");
    $sql->bindParam(':task', $task, PDO::PARAM_STR);
    $sql->bindParam(':deadline', $deadline, PDO::PARAM_STR);
    $sql->execute();
    return "ToDoアイテムを追加しました";
}

//指定されたIDのToDoアイテムを完了状態に更新します。（テーブルも更新）
function completeTodoItem(PDO $pdo, string $TABLE_NAME, $id): string{
    $sql = "UPDATE $TABLE_NAME SET completed=true WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return "ToDoアイテムを完了しました";
}

//指定されたIDのToDoアイテムを削除します。(テーブルからも削除)
function deleteTodoItem(PDO $pdo, string $TABLE_NAME, $id): string{
    $sql = "DELETE FROM $TABLE_NAME WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return "ToDoアイテムを削除しました";
}
?>
