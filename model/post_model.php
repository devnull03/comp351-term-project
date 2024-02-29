<?php


function get_posts()
{
    global $db;
    $query = 'SELECT * FROM posts JOIN users ON posts.user_id = users.id
	      ORDER BY posts.id DESC';
    $statement = $db->prepare($query);
    $statement->execute();
    $posts = $statement->fetchAll();
    $statement->closeCursor();
    return $posts;
}

function get_post($post_id)
{
    global $db;
    $query = 'SELECT * FROM posts
	      WHERE id = :post_id';
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
