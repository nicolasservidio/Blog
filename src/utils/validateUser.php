<?php

function validateUser() {

// Preprocessing
$_POST['email'] = strip_tags(trim($_POST['email'])); // avoiding code injections, trimming
$_POST['password'] = strip_tags(trim($_POST['password']));

// Validations
$Errors = '';
if (empty($_POST['email'])) {
    $Errors = "- The email field cannot be empty. <br>";
}
if (empty($_POST['password'])) {
    $Errors.="- The password field cannot be empty. <br>";
}

if (strlen($_POST['email']) < 4 || strlen($_POST['email']) > 20) {
    $Errors.="- The email cannot be less than 4 characters or more than 20. <br>";
}
if (strlen($_POST['password']) < 3) {
    $Errors.="- The password cannot be less than 3 characters long. <br>";
}

// Editing the message
if (!empty($Errors)) {
    $linebreak = '<br><br>';
    $linebreak.=$Errors;
    $Errors = $linebreak;
}
return $Errors;
}

?>
