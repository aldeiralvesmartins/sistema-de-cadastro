<?php
session_start();

if(isset($_SESSION['usuarioLog']))
{
    session_destroy();
    header("location:login.php");
}
