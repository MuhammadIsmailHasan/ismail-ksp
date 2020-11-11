<?php
$host   = 'ec2-34-237-236-32.compute-1.amazonaws.com';
$user   = 'nhrcurpjjnunxq';
$password = 'a6533ce3bdec15977f0b0526df6be4898dee6a9e92e3e583c3cab3a88ca2addf';
$database = 'd7i8qs9qhehj8s';

$con = mysqli_connect($host, $user, $password);
$db  = mysqli_select_db($con, $database) or die(mysqli_error($con));
