<?php
// Function to load tasks from the file
function loadTasks() {
    if (!file_exists('data.txt')) {
        file_put_contents('data.txt', ''); // Create file if it doesn't exist
    }
    $tasks = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $tasks;
}

// Function to add a task to the file
function addTask($task) {
    $task = trim($task);
    if (!empty($task)) {
        file_put_contents('data.txt', $task . "\n", FILE_APPEND);
    }
}

// Function to delete a task from the file
function deleteTask($taskIndex) {
    $tasks = loadTasks();
    if (isset($tasks[$taskIndex])) {
        unset($tasks[$taskIndex]);
        file_put_contents('data.txt', implode("\n", $tasks) . "\n");
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task'])) {
        addTask($_POST['task']);
    } elseif (isset($_POST['delete'])) {
        deleteTask($_POST['delete']);
    }
}

// Load tasks for display
$tasks = loadTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Todo List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px 0; }
        form { margin-top: 20px; }
        input[type="text"] { padding: 5px; width: 300px; }
        input[type="submit"], .delete-btn { padding: 5px 10px; cursor: pointer; }
        .delete-btn { background-color: #ff6666; color: white; border: none; margin-left: 10px; }
    </style>
</head>
<body>
    <h1>Todo List</h1>

    <!-- Display tasks -->
    <ul>
        <?php foreach ($tasks as $index => $task): ?>
            <li>
                <?php echo htmlspecialchars($task); ?>
                <!-- Delete task button -->
                <form style="display:inline;" method="POST">
                    <button type="submit" name="delete" value="<?php echo $index; ?>" class="delete-btn">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Form to add a new task -->
    <form method="POST">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <input type="submit" value="Add Task">
    </form>
</body>
</html>