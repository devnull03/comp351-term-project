<?php


function get_posts()
{
    global $db;
    $query = 'SELECT posts.*, count(distinct likes.id) as likes, count(distinct comments.id) as comment_count, users.username FROM posts 
            left join likes ON posts.id = likes.post_id 
            join users on posts.user_id = users.id 
            left join comments on posts.id = comments.post_id 
            GROUP BY posts.id ORDER BY posts.id DESC';

    $statement = $db->prepare($query);
    $statement->execute();
    $posts = $statement->fetchAll();

    $statement->closeCursor();
    return $posts;
}

function get_post($post_id)
{
    global $db;
    $query = 'SELECT posts.*, count(distinct likes.id) as likes, count(distinct comments.id) as comment_count, users.username FROM posts 
            left join likes ON posts.id = likes.post_id 
            join users on posts.user_id = users.id 
            left join comments on posts.id = comments.post_id 
            WHERE posts.id = :post_id
            GROUP BY posts.id ORDER BY posts.id DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->execute();
    $post = $statement->fetch();
    $statement->closeCursor();
    return $post;
}

function delete_post($post_id)
{
    global $db;
    $query = 'DELETE FROM posts
	      WHERE id = :post_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_post($title, $content, $author_id)
{
    global $db;
    $query = 'INSERT INTO posts
	      (title, body, user_id)
	      VALUES
	      (:title, :content, :author)';
    $statement = $db->prepare($query);
    $statement->bindValue(":title", $title);
    $statement->bindValue(":content", $content);
    $statement->bindValue(":author", $author_id);
    $statement->execute();
    $statement->closeCursor();
}
