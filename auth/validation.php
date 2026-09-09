<?php
// auth/validation.php

function sanitizeInput($v) {
    return htmlspecialchars(trim($v));
}

function validateRequired($value, $label) {
    if ($value === "" || $value === null) {
        return "$label is required.";
    }
    return null;
}

function validateEmailFormat($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email address.";
    }
    return null;
}

function validateMinLength($value, $label, $min) {
    if (strlen($value) < $min) {
        return "$label must be at least $min characters.";
    }
    return null;
}

function validateRegisterInput($full_name, $email, $password, $confirm) {
    $errors = [];

    $e1 = validateRequired($full_name, "Full name");
    if ($e1) $errors[] = $e1;

    $e2 = validateRequired($email, "Email");
    if ($e2) $errors[] = $e2;
    elseif ($e3 = validateEmailFormat($email)) $errors[] = $e3;

    $e4 = validateRequired($password, "Password");
    if ($e4) $errors[] = $e4;
    elseif ($e5 = validateMinLength($password, "Password", 6)) $errors[] = $e5;

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    return array_values($errors);
}
?>