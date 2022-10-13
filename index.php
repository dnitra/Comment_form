<?php

require_once 'lib/DBBlackbox.php';
require_once "./Comment.php";
require_once "Session.php";

//select all comments form the database
$comments = select(null, 0, "Comment");

// make sure id variable is null unless id was present in GET method 
$id = null;

//create new instance of the Session class
Session::initialize();

//create new instance of the Comment class
$data = new Comment;


//if the id is present in the get method - find corresponding comment in the database and put the data into $data variable
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $data = find($id, "Comment");
}


/**
 * if the comment data were passed in the $_SESSION variable, then use them
 * if not, use the data which were already set
 */

$data->name = $_SESSION["comment"]->name ?? $data->name;
$data->email = $_SESSION["comment"]->email ?? $data->email;
$data->comment = $_SESSION["comment"]->comment ?? $data->comment;


//if there were some errors passed in the $_SESSION variable, insert them in the $errors variable
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Disney buys Star Wars maker Lucasfilm from George Lucas | BBC News</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>

    <article>

        <div class="img">
            <img src="img/article.jpg" alt="Disney buys Star Wars maker Lucasfilm from George Lucas">
        </div>

        <h1>Disney buys Star Wars maker Lucasfilm from George Lucas</h1>

        <p class="story">Disney is buying Lucasfilm, the company behind the Star Wars films, from its chairman and founder George Lucas for $4.05bn (£2.5bn).</p>

        <p>Mr Lucas said: "It's now time for me to pass Star Wars on to a new generation of film-makers."</p>

        <p>In a statement announcing the purchase, Disney said it planned to release a new Star Wars film, episode seven, in 2015.</p>

        <p>That will be followed by episodes eight and nine and then one new movie every two or three years, the company said.</p>

    </article>

    <div class="comments">
        <h2>Comment below:</h2>



        <?php
        // display if the general error message is present in the $errors
        if (!empty($errors["general"])) : ?>

            <div class="error">
                <?= $errors["general"] ?>
            </div>

        <?php endif ?>

        <?php
        // display if the general success message is present in $_SESSION
        if (!empty($_SESSION["Success-general"])) : ?>

            <div class="success">
                <?= $_SESSION["Success-general"] ?>
            </div>

        <?php
            // unset the succeess generral message from the $_SESSION
            unset($_SESSION['Success-general']);
        endif ?>

        <?php
        /**
         * create the form and put the values from $data variable as 
         * values (or text in textarea) if there are some data present 
         */
        ?>
        <form action="handle-form.php?id=<?= $id ?>" method="post">
            <input name="name" type="text" placeholder="*Nickname" value="<?= $data->name ?>">
            <?php if (!empty($errors["name"])) : ?>

                <div class="error">
                    <?= $errors["name"] ?>
                </div>

            <?php endif ?>


            <input name="email" type="email" placeholder="Email" value="<?= $data->email ?>">

            <textarea name="comment" placeholder="*Leave your comment here"><?= $data->comment ?></textarea>
            <?php
            // display if the comment error message is present in the $errors
            if (!empty($errors["comment"])) : ?>

                <div class="error">
                    <?= $errors["comment"] ?>
                </div>

            <?php endif ?>


            <button type="submit">Add comment</button>
        </form>



        <?php
        //loop from all comments from database and display them on the page
        foreach ($comments as $comment) : ?>

            <div class="comments__answer answer">
                <div class="answer_name"><a href="mailto:<?= $comment->email ?>">
                        <?= $comment->name ?></a></div>




                <div class="answer_text"><?= $comment->comment ?></div>



            </div>
            <?php
            /**
             * EDIT button is added to each comment loaded from
             * the database. It directs back to this page but passes id in the GET method
             * and that triggers the condition of finding corresponding comment in the database
             * and inserting the data from it in the form
             */
            ?>
            <a href="index.php?id=<?= $comment->id ?>"> <button>EDIT</button></a>

            <?php
            // DELETE button deletes corresponding comment from the database and from the page
            ?>
            <a href="handle-form.php?delete=true&id=<?= $comment->id ?>"> <button>DELETE</button></a>


        <?php endforeach ?>







    </div>

</body>

</html>