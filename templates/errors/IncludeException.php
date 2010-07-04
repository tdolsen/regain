<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error: Include Exception</title>

    <style>
      * {
        margin: 0;
        padding: 0;
        font-size: 100%;
      }
      body {
        font-size: 62.5%;
      }
      #header {
        background: #EF0;
      }
    </style>
</head>
<body>
    <div id="header">
        <h1>Error: Include Exception</h1>
    </div>

    <div id="include_path">
        <h2>Include path</h2>
        <ul><?php foreach(explode(PATH_SEPARATOR, get_include_path()) as $path) { ?>
            <li><?php echo rtrim($path, '/'); ?>/<strong><?php echo $e->getIncludeFile(); ?></strong></li>
<?php       } ?>
        </ul>
    </div>

    <div id="stack-trace">
        <h2>Stack trace</h2>
        <ul><?php foreach($e->getTrace() as $trace) { ?>
            <li>
                <h3><?php echo isset($trace['file']) ? $trace['file'] : $e->getFile(); ?></h3>
                <dl>
                    <dt>Line</dt>
                    <dd><?php echo isset($trace['line']) ? $trace['line'] : $e->getLine(); ?></dd>

                    <dt>Function</dt>
                    <dd><?php echo $trace['function']; ?></dd>

                    <dt>Args</dt>
                    <dd>
                        <ul><?php foreach($trace['args'] as $arg) { ?>
                            <li><?php echo $arg; ?></li>
<?php                       } ?>
                        </ul>
                    </dd>
                </dl>
            </li><?php
            } ?>
        </ul>
    </div>
</body>
</html>
