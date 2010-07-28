<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error: Assert Exception</title>

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
          padding: 2em;
        }
        #header.error {
          background: #804040;
        }
        #header h1 {
          color: white;
          font-size: 2em;
          text-shadow: 1px 1px 1px #000;
        }
        #header p {
          color: #eee;
          font-size: 1.6em;
        }
        
        #body {
            padding: 0 2em;
        }
        #body p, #body ul, #body ol, #body dl {
            font-size: 1.4em;
            margin: 1em 0;
            padding: 0 1em;
        }
        #body ul, #body ol {
            margin-left: 1em;
        }
        #body p ul, #body p ol, #body p dl, #body ul p, #body ul ul, #body ul ol, #body ul dl, #body ol p, #body ol ul, #body ol ol, #body ol dl, #body dl p, #body dl ul, #body dl ol, #body dl dl {
            font-size: 100%;
            padding: 0;
            margin: 0;
        }
        #body > div {
            background: #dbd5a4;
            margin: 2em 0;
            padding: 1px 0;
        }
        #body > div h2 {
            background: #808040;
            color: white;
            font-size: 1.6em;
            padding: 0.5em;
        }
        
        #include-path li {
            color: #808040;
        }
        #include-path li strong {
            color: black;
        }
        
        #stack-trace > ul {
            margin-left: 0;
            list-style: none;
        }
        #stack-trace > ul > li {
            border-bottom: 1px solid #808040;
            margin-bottom: 1em;
            padding-bottom: 1em;
        }
        #stack-trace dt {
            position: absolute;
            width: 70px;
        }
        #stack-trace dd {
            padding-left: 70px;
        }
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
