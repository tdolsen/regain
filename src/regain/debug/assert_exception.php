<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error: Assert Exception</title>

    <style>
<?php include 'regain/debug/style.css'; ?>
    </style>
</head>
<body>
    <div id="header" class="error">
        <h1>Error: Assert Exception</h1>
        <p>An assertion failed in file <strong><?php echo $e->getFile(); ?></strong>.</p>
    </div>
    
    <div id="body">
        <div id="assert-message">
            <h2>Assertion message</h2>
            <p><?php echo $e->getMessage(); ?></p>
        </div>
    
        <?php include 'regain/debug/stack_trace.php'; ?>
    </div>
</body>
</html>
