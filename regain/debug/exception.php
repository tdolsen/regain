<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error: Uncaught Exception</title>

    <style>
<?php include 'regain/debug/style.css'; ?>
    </style>
</head>
<body>
    <div id="header" class="error">
        <h1>Error: Uncaught Exception</h1>
        <p>An uncaught execption was thrown in file <strong><?php echo $e->getFile(); ?></strong>.</p>
    </div>
    
    <div id="body">
        <div>
            <h2>Exception Class</h2>
            <p><?php echo get_class($e); ?></p>
        </div>
        <div>
            <h2>Message</h2>
            <p><?php echo $e->getMessage(); ?></p>
        </div>
    
        <?php include 'regain/debug/stack_trace.php'; ?>
    </div>
</body>
</html>
