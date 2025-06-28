<?php
include 'session.php';
session_start();
if(session_destroy()){
	header("location: index.php");
}
?>