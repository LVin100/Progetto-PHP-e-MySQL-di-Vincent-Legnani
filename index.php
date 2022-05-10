<?php

include 'config/Router.php';
include 'config/request.php';



require Router::load('routes.php')->direct(Request::uri());