<?php
session_start();
// Обнуляем данные о юзере в сессии и переводим на главную
unset($_SESSION['user']);
header( "Location: index.php");
exit();