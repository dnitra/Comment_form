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


if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $data = find($id, "Comment");
}

$data->name = $_SESSION["comment"]->name ?? $data->name;
$data->email = $_SESSION["comment"]->email ?? $data->email;
$data->comment = $_SESSION["comment"]->comment ?? $data->comment;

if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
}

var_dump($_SESSION);
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

        <!-- your code here -->

        <?php if (!empty($errors["general"])) : ?>

            <div class="error">
                <?= $errors["general"] ?>
            </div>

        <?php endif ?>

        <?php if (!empty($_SESSION["Success-general"])) : ?>

            <div class="success">
                <?= $_SESSION["Success-general"] ?>
            </div>

        <?php
            unset($_SESSION['Success-general']);
        endif ?>


        <form action="handle-form.php?id=<?= $id ?>" method="post">
            <input name="name" type="text" placeholder="*Nickname" value="<?= $data->name ?>">
            <?php if (!empty($errors["name"])) : ?>

                <div class="error">
                    <?= $errors["name"] ?>
                </div>

            <?php endif ?>


            <input name="email" type="email" placeholder="Email" value="<?= $data->email ?>">

            <textarea name="comment" placeholder="*Leave your comment here"><?= $data->comment ?></textarea>
            <?php if (!empty($errors["comment"])) : ?>

                <div class="error">
                    <?= $errors["comment"] ?>
                </div>

            <?php endif ?>


            <button type="submit">Add comment</button>
        </form>



        <?php foreach ($comments as $comment) : ?>

            <div class="comments__answer answer">
                <div class="answer_name"><a href="mailto:<?= $comment->email ?>">
                        <?= $comment->name ?></a></div>




                <div class="answer_text"><?= $comment->comment ?></div>



            </div>
            <a href="index.php?id=<?= $comment->id ?>"> <button>EDIT</button></a>
            <a href="handle-form.php?delete=true&id=<?= $comment->id ?>"> <button>DELETE</button></a>


        <?php endforeach ?>







    </div>

</body>

</html>