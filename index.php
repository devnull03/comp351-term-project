<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Blog</title>

	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://kit.fontawesome.com/30f055fc02.js" crossorigin="anonymous"></script>
</head>


<?php

$lifetime = 60 * 60 * 24 * 14; // 2 weeks in seconds
session_set_cookie_params($lifetime, '/');
session_start();

if (!isset($_SESSION['user'])) {
	$_SESSION['user'] = null;
}

require('model/database.php');
require('model/post_model.php');
require('model/comment_model.php');
require('model/like_model.php');
require('model/user_model.php');

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action');
$post_id = filter_input(INPUT_POST, 'post') ?? filter_input(INPUT_GET, 'post');
$username = filter_input(INPUT_POST, 'user') ?? filter_input(INPUT_GET, 'user');

include('view/page/header.php');

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
		$_SESSION = array();
		session_destroy();

		$name = session_name();
		$expire = strtotime('-1 year');
		$params = session_get_cookie_params();
		$path = $params['path'];
		setcookie($name, '', $expire, $path);

		header('Location: .');
		break;

	case 'create_like':

		$post_id = filter_input(INPUT_GET, 'post_id');
		$user_id = $_SESSION['user']['id'];

		like_post($post_id, $user_id);

		if (filter_input(INPUT_GET, 'page') == 'post') {
			header('Location: ?post=' . $post_id);
		} else {
			header('Location: .');
		}

		break;

	case 'unlike':

		$post_id = filter_input(INPUT_GET, 'post_id');
		$user_id = $_SESSION['user']['id'];

		unlike_post($post_id, $user_id);

		if (filter_input(INPUT_GET, 'page') == 'post') {
			header('Location: ?post=' . $post_id);
		} else {
			header('Location: .');
		}

		break;

	case 'comment':
		// TODO: add comments

	default:

		if ($post_id) {
			include('view/post.php');
		} elseif ($username) {
			include('view/user.php');
		} else {
			include('view/home.php');
		}

		break;
}



?>

<?php include('view/page/footer.php'); ?>

</html>