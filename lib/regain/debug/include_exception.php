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
        <h1>Error: Include Exception</h1>
        <p>The file <strong><?php echo $e->getIncludeFile(); ?></strong> was not found on the system. Make sure the file is in the right place, and you don't have any typos in the file name.</p>
    </div>
    
    <div id="body">
        <div id="include-path">
            <h2>Include path</h2>
            
            <p>The following paths on your system was tried:</p>
            
            <ul><?php foreach(explode(PATH_SEPARATOR, get_include_path()) as $path) { ?>
                <li><strong><?php echo str_replace('\\', '/', rtrim($path, '/')); ?></strong>/<?php echo $e->getIncludeFile(); ?></li>
    <?php       } ?>
            </ul>
        </div>
    
        <?php include 'regain/debug/stack_trace.php'; ?>
    </div>
</body>
</html>
