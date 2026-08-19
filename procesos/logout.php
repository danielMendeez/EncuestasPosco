<?php

session_start();
session_destroy();
header("Location:../admins/login.html");
?>