<!-- Requiring the page that creats a connection with the data  -->
<?php 
session_start(); //creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie
require_once('connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the submit button is set 
if(isset($_POST['submit'])){
    // echo "user submitted"; //used to echo and check if working
    // Getting the entered values 
    $FullName       =   $_POST['fullName'];
    $username       =   $_POST['username'];
    $Email          =   $_POST['email'];
    $Password       =   $_POST['psw'];
    $phone          =   $_POST['phone'];
    $date_of_birth  =   $_POST['date_of_birth'];
    $SSN            =   $_POST['ssn'];
    $confirmPass    =   $_POST['psw-repeat'];


    $query = "SELECT username FROM users WHERE username =  :name";
    $chk = $pdo->prepare($query);
    $chk->bindParam(':name', $username);
    $chk->execute();
    if($chk->rowCount() > 0) echo "Username Exists";
    else{
        if ($Password != $confirmPass) echo "Passwords must be the same";
    else{
    // Creating sql query to insert all entered data into mysql database
    $sql = "INSERT INTO users (FullName, username, Email, Password, phone, date_of_birth, SSN) VALUES (?,?,?,?,?,?,?)"; 
    $insert = $pdo->prepare($sql);
    $result = $insert->execute([$FullName, $username, $Email, $Password,$phone, $date_of_birth, $SSN  ]);
    // if($result) echo "Successfully saved to database"; 
    if(!$result) echo "Errors Occured";
    }
    }
}
?>
<?php
if(isset($_POST['logIn'])){
    $username       =   $_POST['uname'];
    $Password       =   $_POST['pass'];

    $query = "SELECT username FROM users WHERE (username =  :name && Password = :Password)";
        $chk = $pdo->prepare($query);
        $chk->bindParam(':name', $username);
        $chk->bindParam(':Password', $Password);
        $chk->execute();
        if($chk->rowCount() > 0) echo "Logged Successfuly";
        else{echo "Username or password does not exist";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="html.css">
    <title>Home Page</title>
</head>
<body>
    <div class="body__main--Container">
    <div class="body__main--signUp">
        <form action="homePage.php" method="POST">
        <div class="container">
            <h2>Sign Up</h2>
            <p>Please fill in this form with the correct information to create an account.</p>

            <label for="fullName"><b>Full Name</b></label>
            <input id="fullName" type="text" placeholder="Full Name" name="fullName" required> 

            <label for="username"><b>Username</b></label>
            <input id="username" type="text" placeholder="Username" name="username" required><br/>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Password" name="psw" id="psw" required>

            <label for="pswRepeat"><b>Confirm Password</b></label>
            <input type="password" placeholder="Confirm Password" name="psw-repeat" id="pswRepeat" required><br/>

            <label for="email"><b>Email</b></label><br/>
            <input type="text" placeholder="Email" name="email" id="email" required><br/>

            <label for="phone">Phone Number</label><br/>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{2}-[0-9]{6}"><br/>

            <label for="date_of_birth">Date of Birth</label><br/>
            <input type="date" id="date_of_birth" name="date_of_birth"><br/>

            <label for="ssn">Social Security Number </label><br/>
            <input type="text" id="ssn" name="ssn" placeholder="555-55-5555" pattern="\d{3}-?\d{2}-?\d{4}"><br/>

            <button type="submit" name="submit" class="registerbtn">Register</button>
        </div>
        </form>
    </div>
    <div class="body__main--logIn">
    <form action="homePage.php" method="POST">
        <h2>Log In </h2>
        <p>Don't have an account?<a href="">Sign Up</a> </p>
            <label for="uname"><b>Username</b></label><br/>
            <input type="text" placeholder="Username" name="uname" required><br/>

            <label for="psw"><b>Password</b></label><br/>
            <input type="password" placeholder="Password" name="pass" required><br/>

            <button type="submit" name="logIn">Login</button>
    </form>
    </div>
    </div>
</body>
</html>
<?php 
$pdo = null; //used to clear connection with database when we are done 
?>