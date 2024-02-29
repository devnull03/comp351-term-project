<?php


function login($username, $password)
{
    global $db;
    $query = 'SELECT * FROM users WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if (!$user) {
        return "No user found";
    }

    // TODO: add password hashing? (password_verify($password, $user['password']))
    if ($password == $user['password']) {
        // return user without password
        unset($user['password']);
        return $user;
    } else {
        return "Password incorrect";
    }
}

function checkUsername($username)
{
    global $db;
    $query = 'SELECT username FROM users WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return boolval($user);
    
}

function register($username, $password)
{
    global $db;
    $query = 'INSERT INTO users (username, password) VALUES (:username, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}
