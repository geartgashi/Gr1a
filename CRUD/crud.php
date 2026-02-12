<?php

//Perfshirja e objekteve dhe startimi i sesionit
require_once '../OOP/require.php';



//Marrja e emrit te db
$dbName = $conn->query('SELECT DATABASE()')->fetch_row()[0] ?? '';


//Variabla per errore 
$error = '';
//Variabla per mesazh suksesi
$message = '';

//Variabla per errore ne SIGNUP VALIDIM
$errors = [];
//Variabla per pyetjen login? NE SIGNUP
$LogInPopUp = false;



//Leximi i te gjitha objekteve
$users = $userObj->readUser();
$tours = $tourObj->readTour();
$bookings = $bookingObj->readBooking();
$reviews = $reviewObj->readReview();
$company = $companyObj->readCompany();


//action variabla qe ruan cilin veprim nga CRUD do bejme permes GET || POST
$action = $_POST['action'] ?? $_GET['action'] ?? '';

//------------------------------------------login-----------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login_user') {
    
    //Pastrimi i te dhenave
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    //Merr userin me email te caktuar
    $user = $userObj->findByEmail($email);
    
    //Nese ekziston email
    if($user){
        // Verifikim password
        if(password_verify($password, $user['password'])) {
            // Login i suksesshëm
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_surname'] = $user['surname'];
            $_SESSION['user_phone'] = $user['phone'];
            $_SESSION['user_id'] = $user['id'];
            
            $message = 'Successfully loged in.';
            //Kontrolli i roleve
            if($user['role'] === 'admin'){
                header('Location: ../CRUD/admin_dashboard.php');
                exit;
            } else {
                header('Location: index.php');
                exit;
            }
        } else {
            $error = "Password is incorrect.";
        }
    } else {
        $error = "Email not found.";
    }
}
//-------------------------------------------------logout-----------------------------------
if (isset($_GET['logout'])) {
    $userObj->logout();
    header("Location: /GitHub/Gr1a/Main/index.php");
    exit;
}


//---------------------------------------create-------------------------------------------------
// CREATE PER TOUR
if ($tourObj && $action === 'create_tour' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    //Pastrimi i te dhenave
    $location = trim($_POST['location'] ?? '');
    $date = $_POST['date'] ?? '';
    $length = (int) $_POST['length'] ?? 0;
    $price = (float) $_POST['price'] ?? 0.00;
    $image = trim($_POST['image'] ?? '');

   
        //Krijo tour
        $tourObj->createTour($location, $date, $length, $price, $image);
        $message = 'Tour created successfully.';
}

//CREATE PER USER (sign up)
if ($userObj && $action === 'create_user' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    //Pastrimi i te dhenave nga forma
    $name     = trim($_POST['name'] ?? '');
    $surname  = trim($_POST['surname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // REGEX validimi
    $nameRegex     = "/^[A-Za-z]{2,}$/";
    $emailRegex    = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $phoneRegex    = "/^[0-9]{8,15}$/";
    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";

    // VALIDIME
    if (!preg_match($nameRegex, $name)) {
        $errors[] = "Name must contain only letters (min 2).";
    }
    if (!preg_match($nameRegex, $surname)) {
        $errors[] = "Surname must contain only letters (min 2).";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match($phoneRegex, $phone)) {
        $errors[] = "Phone must be 8-15 digits and only numbers.";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors[] = "Password at least 8 chars, include upper, lower and number.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Nese ekziston User me email te njejte
    if (!$errors && $userObj->findByEmail($email)) {
        $errors[] = "User with the given email exists.";
    }

    // Krijimi i user nese nuk ka asnje error
    if (!$errors) {
        $userObj->createUser($name, $surname, $email, $phone, $password);
        $message = 'User created successfully.';
        $LogInPopUp = true;
    }
}

// CREATE PER REVIEW
if ($tourObj && $action === 'create_review' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    //Pastrimi i te dhenave
    $user_id = (int)($_POST['user_id'] ?? 0);
    $description = $_POST['description'] ?? '';
    $stars = (int)$_POST['stars'] ?? 0;

    //Krijo review
    $reviewObj->createReview($user_id, $description, $stars);
    $message = 'Review created successfully.';
}

// CREATE PER BOOKING
if ($tourObj && $action === 'create_booking' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    //Pastrimi i te dhenave
    $guests = (int)$_POST['guests'] ?? 0;
    $user_id = (int)($_POST['user_id'] ?? 0);
    $tour_id = (int)($_POST['tour_id'] ?? 0);
    

    //Krijo review
    $bookingObj->createBooking($guests, $user_id, $tour_id);
    $message = 'Booked successfully!';
}



//-------------------------------------------------update---------------------------------------
// UPDATE PER TOUR
if ($tourObj && $action === 'update_tour' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // Merr ID dhe të dhënat e reja nga forma
    $id = (int) ($_POST['id'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $date = $_POST['date'] ?? '';
    $length = ((int) $_POST['length'] ?? 0);
    $price = ((float) $_POST['price'] ?? 0.00);
    $image = trim($_POST['image'] ?? '');
    $availability = $_POST['availability'] ?? 'available';

    //Ndrysho tour
    $tourObj->updateTour($id, $location, $date, $length, $price, $image, $availability);
    $message = 'Tour updated successfully.';
    
}

// UPDATE PER COMPANY
if ($companyObj && $action === 'update_company' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // Merr të dhënat e reja nga forma
    $id = (int) ($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = ($_POST['description'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $facebook = trim($_POST['facebook'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');
    $twitter = trim($_POST['twitter'] ?? '');
    $terms_of_service = ($_POST['terms_of_service'] ?? '');
    $privacy_policy = ($_POST['privacy_policy'] ?? '');
    

    //Ndrysho kompanine
    $companyObj->updateCompany(
        $id, 
        $name, 
        $location, 
        $description, 
        $email, 
        $phone, 
        $facebook, 
        $instagram, 
        $twitter, 
        $terms_of_service, 
        $privacy_policy
        );

    $message = 'Tour updated successfully.';
    
}

// UPDATE USER
if ($_SESSION && isset( $_POST['action']) && $_POST['action'] === 'update_user') {

    $id = $_SESSION['user_id'];

    //Pastrimi i te dhenave
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
        
    $_SESSION['user_name'] = $_POST['name'];
    $_SESSION['user_surname'] = $_POST['surname'];
    $_SESSION['user_email'] = $_POST['email'];
    $_SESSION['user_phone'] = $_POST['phone']; 

    // REGEX validimi
    $nameRegex     = "/^[A-Za-z]{2,}$/";
    $emailRegex    = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $phoneRegex    = "/^[0-9]{8,15}$/";

    $userData = $userObj->findUser($id); 
    
    // VALIDIME
    if (!preg_match($nameRegex, $name)) {
        $errors[] = "Name must contain only letters (min 2).";
    }
    if (!preg_match($nameRegex, $surname)) {
        $errors[] = "Surname must contain only letters (min 2).";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match($phoneRegex, $phone)) {
        $errors[] = "Phone must be 8-15 digits and only numbers.";
    }


    // Nese ekziston User me email te njejte
    if (!$errors && $userData && ($userData['email'] != $_SESSION['user_email'])
    ) {
        if ($userObj->findByEmail($email)) {
        $errors[] = "User with the given email exists.";
    }
    }

    // Ndryshimi i user nese nuk ka asnje error
    if (!$errors) {

        $userObj->updateUser($_SESSION['user_id'], $name, $surname, $email, $phone);
        $message = "Profile updated successfully.";
    }
    else{
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_surname'] = $userData['surname'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_phone'] = $userData['phone']; 
    }
}


//Update user password
if ($userObj && $action === 'update_user_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_SESSION['user_id'];

    //Pastrimi i te dhenave nga forma
    $current = $_POST['current_password'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // REGEX validimi
    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";

    $userData = $userObj->findUser($id); 
    
    if (!$userData) {
        $errors[] = "User not found";
    }

    // VALIDIME
    if (!password_verify($current, $userData['password'])) {
        $errors[] = "Incorrect password.";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors[] = "Password at least 8 chars, include upper, lower and number.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    //Ndryshimi i pass nese nuk ka asnje error
    if (!$errors) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userObj->updateUserPassword($id, $hashedPassword);
        $message = 'Password updated successfully.';
    }
}

// UPDATE USER ROLES
if ($userObj && $action === 'update_user_role' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // Merr ID dhe të dhënat e reja nga forma
    $id = (int) ($_POST['id'] ?? 0);
    $role = $_POST['role'] ?? 'user';
    

    //Ndrysho rolin per usera
    $userObj->updaterole($id, $role);
    $message = 'User Role updated successfully.';
}

//---------------------------------------delete--------------------------
// DELETE PER TOUR
if ($tourObj && $action === 'delete_tour') {

    // Merr ID nga URL (GET)
    $id = (int) ($_GET['id'] ?? 0);

    
    //Fshij tour
    $tourObj->deleteTour($id);
    $message = 'Tour deleted successfully.';
}

// DELETE PER USER
if ($userObj && $action === 'delete_user') {

    // Merr ID nga URL (GET)
    $id = (int) ($_GET['id'] ?? 0);

    
    //Fshij user
    $userObj->deleteUser($id);
    $message = 'User deleted successfully.';
}

// DELETE PER USER personal account
if ($userObj && $action === 'delete_account') {

    // Merr ID nga URL (GET)
    $id = (int) ($_GET['id'] ?? 0);
    session_destroy();

    
    //Fshij user
    $userObj->deleteUser($id);
}

// DELETE PER BOOKING
if ($bookingObj && $action === 'delete_booking') {

    // Merr ID nga URL (GET)
    $id = (int) ($_GET['id'] ?? 0);

    
    //Fshij user
    $bookingObj->deleteBooking($id);
    $message = 'Booking deleted successfully.';
}

// DELETE PER REVIEW
if ($reviewObj && $action === 'delete_review') {

    // Merr ID nga URL (GET)
    $id = (int) ($_GET['id'] ?? 0);

    
    //Fshij user
    $reviewObj->deleteReview($id);
    $message = 'Review deleted successfully.';
}


//---------------------------------edit-----------------------------------------
//Variabla qe ruan tour qe po editohet
$editTour = null;
//Marrja e nje Tour per editim
if ($tourObj && $action === 'edit_tour') {

    // Merr ID nga URL
    $id = (int) ($_GET['id'] ?? 0);

    $editTour = $tourObj->findTour($id);
}

//Variabla qe ruan user qe po editohet
$editUser = null;
//Marrja e nje User per editim
if ($userObj && ($action === 'edit_user' || $action === 'update_user')) {

    // Merr ID nga URL
    $id = (int) ($_GET['id'] ?? 0);

    $editUser = $userObj->findUser($id);
}

//Per password
$editPassword = null;
//Marrja e nje User per editim
if ($userObj && $action === 'update_user_password') {

    // Merr ID nga URL
    $id = (int) ($_GET['id'] ?? 0);

    $editPassword = $userObj->findUser($id);
}

//Variabla qe ruan nese po editohet kompania
$editCompany = null;
if ($companyObj && $action === 'edit_company') {
    $editCompany = $companyObj->readCompany();
}

//Nuk editojme bookings
//Nuk editojme reviews

//----------------------------------------------read----------------------------------------

// Merr listat e te gjithave (READ)
$users = $userObj ? $userObj->readUser() : [];
$tours = $tourObj ? $tourObj->readTour() : [];
$bookings = $bookingObj ? $bookingObj->readBooking() : [];
$reviews = $reviewObj ? $reviewObj->readReview() : [];
$company = $companyObj ? $companyObj->readCompany() : [];






?>