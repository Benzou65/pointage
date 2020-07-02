<?php
session_start();
if (isset($_SESSION['id']))
{
    header("Location: ./view/checkin.php");
}
else
{
    header("Location: ./view/connect.php");
}
