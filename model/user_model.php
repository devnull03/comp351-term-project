<?php

function get_user($user_id)
{
    global $db;
    $query = 'SELECT * FROM users
	      WHERE id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    unset($user['password']);
    return $user;
}

function get_user_by_username($username)
{
    global $db;
    $query = 'SELECT * FROM users
	      WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(":username", $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    unset($user['password']);
    return $user;
}

function get_user_posts($user_id)
{
    global $db;
    $query = 'SELECT * FROM posts
          WHERE user_id = :user_id ORDER BY created_at DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $posts = $statement->fetchAll();
    $statement->closeCursor();
    return $posts;
}

function get_user_likes($user_id)
{
    global $db;
    $query = 'SELECT * FROM likes
          WHERE user_id = :user_id ORDER BY created_at DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $likes = $statement->fetchAll();
    $statement->closeCursor();

    $posts = [];
    foreach ($likes as $like) {
        $post = get_post($like['post_id']);
        $posts[] = $post;
    }

    return $posts;
}

function get_user_comments($user_id)
{
    global $db;
    $query = 'SELECT * FROM comments
          WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $comments = $statement->fetchAll();
    $statement->closeCursor();
    return $comments;
}
