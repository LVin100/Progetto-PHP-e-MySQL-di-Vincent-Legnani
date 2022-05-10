<?php

require 'config/router.php';
echo "SEI NELL'INDEX-PHP";

$uri = (($_SERVER['REQUEST_URI']));
echo $uri;
Router::load('routes.php')->direct($uri);


