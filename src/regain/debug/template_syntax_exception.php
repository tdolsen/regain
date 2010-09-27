<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error: Include Exception</title>

    <style>
<?php include 'regain/debug/style.css'; ?>
    </style>
</head>
<body>
    <div id="header" class="error">
        <h1>Error: Template Syntax Exception</h1>
        <p>A syntax error occured in <strong><?php echo $e->getFile(); ?></strong>, on line <strong><?php echo $e->getLine(); ?></strong>, with the message "<strong><?php echo $e->getMessage(); ?></strong>".</p>
    </div>
    
    <div id="body">
        <?php include 'regain/debug/stack_trace.php'; ?>
    </div>
</body>
</html>
