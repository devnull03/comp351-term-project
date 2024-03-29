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

    $query = 'SELECT posts.*, count(distinct likes.id) as likes, count(distinct comments.id) as comment_count, users.username FROM posts 
            left join likes ON posts.id = likes.post_id 
            join users on posts.user_id = users.id 
            left join comments on posts.id = comments.post_id  
            WHERE posts.user_id = :user_id
            GROUP BY posts.id ORDER BY posts.id DESC';


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
