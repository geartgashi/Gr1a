<?php

//Kontrolli i datatypes
declare(strict_types=1);

//Startimi i sesionit
session_start();



//Perfshirja e objekteve
require_once '../OOP/Database.php';
require_once '../OOP/User.php';
require_once '../OOP/Tour.php';
require_once '../OOP/Booking.php';
require_once '../OOP/Review.php';
require_once '../OOP/Company.php';

//Krijimi i objektit DB dhe ruajtja e connection
$db = new Database();

$conn = $db->getConnection();

try {
    //Krijon DB nese nuk ekziston
        $db->initialize();

    //Krijimi i te gjitha objekteve
        $userObj = new User($conn);
        $tourObj = new Tour($conn);
        $bookingObj = new Booking($conn);
        $reviewObj = new Review($conn);
        $companyObj = new Company($conn);
} catch (RuntimeException $exception) {
    // Nëse ndodh gabim gjatë lidhjes me databazë
    $dbError = $exception->getMessage();
}