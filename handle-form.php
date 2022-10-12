<?php

require_once 'lib/DBBlackbox.php';
require_once "Comment.php";
require_once "Session.php";
require_once "Errors.php";


/**
 * if delete button was pressed, delete the corresponding comment and return back to the article
 */

if (isset($_GET["delete"])) {

    delete($_GET["id"]);
    header("Location: index.php");
    exit();
}


/**
 * check what data were sent with post method and to be able to work with data accordingly in this script
 */
$data = new Comment;

$data->name = $_POST["name"] ?? $data->name;
$data->email = $_POST["email"] ?? $data->email;
$data->comment = $_POST["comment"] ?? $data->comment;

/**
 * store the data in session which were 
 * prefilled by the user so it doesn't have to be filled agaig
 */
Session::initialize()->set("comment", $data);


/**
 * validate the form and return back to it if some required data are missing
 */
$valid = true;
//if name is missing flash the error message
if (empty($_POST["name"])) {
    $valid = false;
    Errors::initialize()->set("name");
}

//if comment is missing flash the error message
if (empty($_POST["comment"])) {
    $valid = false;
    Errors::initialize()->set("comment");
}

/**
 * if the id was sent in the get method, make sure it will be sent back
 * WHY? because if there is id present when loading the index.php, then the script is behaving differently
 * HOW? it will look up the id in database, prefill the form with the found record and then update the record with corresponding new data
 */
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

/**
 * if some required data were missing than return back to the main page
 */
if (!$valid) {

    //add general error to array of errors
    Errors::initialize()->set("general");

    //add array of errors to the session
    Session::initialize()->set("errors", Errors::initialize()->errors);

    /**
     * get back to index.php
     * also add id if there is some
     */
    header("Location: index.php?id=" . $id);
    exit();
}

/**
 * -------------------------------------
 * !!! do the following code only if 
 * all required fields were correctly prefilled!!!
 * -------------------------------------
 */

/**
 * if the id is  present, update existing record, otherwise create new record
 */
if (!isset($_GET["id"])) {
    insert($_POST);
} else {
    update($id, $_POST);
}
// unset all of the data set by the user in the form
unset($_SESSION['comment']);
Session::initialize()->set("Success-general", "The comment was uploaded");

//empty all of the errors inside the session
Session::initialize()->set("errors", Errors::initialize()->errors);

//get back to the location
header("Location: index.php");
