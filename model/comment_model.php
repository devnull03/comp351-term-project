<?php

function get_comments($post_id) {
    global $db;
    $query = 'SELECT * FROM comments
	      WHERE id = :post_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->execute();
    $comments = $statement->fetchAll();
    $statement->closeCursor();
    return $comments;
}

function add_comment($post_id, $user_id, $comment) {
    global $db;
    $query = 'INSERT INTO comments
	      (body, post_id, user_id)
	      VALUES
	      (:comment, :post_id, :user_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->bindValue(":user_id", $user_id);
    $statement->bindValue(":comment", $comment);
    $statement->execute();
    $statement->closeCursor();
}

function delete_comment($comment_id) {
    global $db;
    $query = 'DELETE FROM comments
	      WHERE id = :comment_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":comment_id", $comment_id);
    $statement->execute();
    $statement->closeCursor();
}