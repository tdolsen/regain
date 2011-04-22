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
                                <li><?php
                                
                                if(is_array($arg)) {
                                    ?><pre><?php print_r($arg); ?></pre><?php
                                } elseif(is_bool($arg)) {
                                    echo $arg === true ? 'true' : 'false';
                                } elseif(is_null($arg)) {
                                    echo 'null';
                                } elseif(is_object($arg)) {
                                    echo get_class($arg);
                                } else {
                                    echo $arg;
                                }
                                
                                ?></li>
    <?php                       } ?>
                            </ul>
                        </dd>
                    </dl>
                </li><?php
                } ?>
            </ul>
        </div>