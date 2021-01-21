<?php

    session_start();
    unset($_SESSION['usuario']);
    unset($_SESSION['ADM']);
    header('location: login.html');

?>