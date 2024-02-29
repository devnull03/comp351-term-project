<?php

function get_likes($post_id) {
    global $db;
    $query = 'SELECT COUNT(*) FROM likes
	      WHERE id = :post_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->execute();
    $likes = $statement->fetchAll();
    $statement->closeCursor();
    return $likes;
}

function like_post($post_id, $user_id) {
    global $db;
    $query = 'INSERT INTO likes
	      (user_id, post_id)
	      VALUES
	      (:user_id, :post_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $statement->closeCursor();
}

function unlike_post($post_id, $user_id) {
    global $db;
    $query = 'DELETE FROM likes
	      WHERE user_id = :user_id AND post_id = :post_id';
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $statement->closeCursor();
}

