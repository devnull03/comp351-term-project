<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Blog</title>

	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://kit.fontawesome.com/30f055fc02.js" crossorigin="anonymous"></script>
</head>


<?php include('view/page/header.php'); ?>


<?php
session_start();

require('model/database.php');
require('model/post_model.php');
require('model/comment_model.php');
require('model/like_model.php');
require('model/user_model.php');

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action');

switch ($action) {
	case 'new_post':
		$title = filter_input(INPUT_POST, 'post_title');
		$content = filter_input(INPUT_POST, 'post_content');
		$author_id = $_SESSION['user']['id'];
		add_post($title, $content, $author_id);

		$_POST = array();
		header('Location: .');
		break;

	case 'login':
		include('view/auth/login.php');
		break;
	case 'register':
		include('view/auth/signup.php');
		break;
	case 'logout':
		session_destroy();
		header('Location: .');
		break;

	case 'create_like':

		$post_id = filter_input(INPUT_GET, 'post_id');
		$user_id = $_SESSION['user']['id'];

		like_post($post_id, $user_id);
		header('Location: .');

		break;
	case 'unlike':

		$post_id = filter_input(INPUT_GET, 'post_id');
		$user_id = $_SESSION['user']['id'];

		unlike_post($post_id, $user_id);
		header('Location: .');

		break;
	case 'comment':
		// TODO: add comment
	case 'view_post':
		// TODO: view post
	case 'view_user':
		// TODO: view user

	default:
		include('view/home.php');
		break;
}



?>

<?php include('view/page/footer.php'); ?>

</html>