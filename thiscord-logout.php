<?php

session_destroy();

header("Location: index.php");


exit;

//https://stackoverflow.com/questions/29829996/destroy-session-with-redirect