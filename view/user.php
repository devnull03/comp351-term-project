<?php

$user = get_user_by_username($username);
$user_posts = get_user_posts($user['id']);
$user_likes = get_user_likes($user['id']);

$tab = filter_input(INPUT_GET, 'tab') ?? 'posts';

if ($tab === 'likes') {
	$curr_list = $user_likes;
} elseif ($tab === 'comments') {
	$curr_list = get_user_comments($user['id']);
} else {
	$curr_list = $user_posts;
}

?>

<main class="w-screen h-screen overflow-y-auto py-20 flex justify-center bg-gray-100">

	<div class="lg:w-[40vw] md:w-[60vw] w-[70vw] flex flex-col gap-8">

		<div class="">
			<div class="flex items-center gap-4">
				<img src=<?php echo "https://picsum.photos/seed/" . $user["username"] . "/200" ?> alt="user" class="rounded-full w-24 h-24">
				<div class="flex flex-col">
					<h1 class="text-4xl font-bold"><?php echo $user['username']; ?></h1>
					<p class="text-lg"><?php echo sizeof($user_posts); ?> <?php echo (sizeof($user_posts) === 1) ? "post" : "posts"; ?></p>
				</div>
			</div>
		</div>

		<div class="flex w-full gap-4 border-b border-black pb-2 *:cursor-pointer">
			<a href=<?php echo "/?user=" . $user["username"] . "&tab=posts" ?> class=<?php echo ($tab === "posts") ? "font-bold" : ""; ?>>Posts</a>
			<a href=<?php echo "/?user=" . $user["username"] . "&tab=likes" ?> class=<?php echo ($tab === "likes") ? "font-bold" : ""; ?>>Likes</a>
			<a href=<?php echo "/?user=" . $user["username"] . "&tab=comments" ?> class=<?php echo ($tab === "comments") ? "font-bold" : ""; ?>>Comments</a>
		</div>

		<div class="flex flex-col gap-4 pb-20">

			<?php if (sizeof($curr_list) === 0) : ?>
				<p class="w-full flex justify-center">No <?php echo $tab ?> to show</p>
			<?php endif; ?>

			<?php foreach ($curr_list as $post) : ?>

				<div class="w-full h-full rounded-lg bg-black shadow-lg">
					<div class="flex flex-col gap-4 w-full rounded-lg p-4 bg-white border border-white hover:translate-x-2 hover:-translate-y-2 transition-all ease-in-out duration-500">
						<a href="?post=<?php echo $post['id'] ?>">
							<h2 class="text-2xl font-bold break-words"><?php echo $post['title']; ?></h2>
						</a>

						<p class="break-words"><?php echo $post['body']; ?></p>

						<div class="flex justify-between items-center">
							<div class="flex gap-2">
								<form action="." class="m-0 flex gap-1 items-center">
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">

									<?php
									if (!isset($_SESSION['user'])) {
										$liked = false;
									} else {
										$liked = check_like($post['id'], $_SESSION['user']['id']);
									}
									?>
									<?php if ($liked) : ?>
										<input type="hidden" name="action" value="unlike">
										<button type="submit" class="fa fa-heart text-red-500 hover:text-black transition-all ease-in-out duration-300"></button>
									<?php else : ?>
										<input type="hidden" name="action" value="create_like">
										<button type="submit" class="fa fa-heart-o hover:text-red-400 transition-all ease-in-out duration-300"></button>
									<?php endif; ?>

									<span><?php echo $post['likes'] ?></span>
								</form>
								<form action="." class="m-0 flex gap-1 items-center">
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
									<button type="submit" class="fa fa-comment-o hover:text-blue-400 transition-all ease-in-out duration-300"></button>
									<span><?php echo $post['comment_count'] ?></span>
								</form>
							</div>

							<?php if ($tab !== 'posts') : ?>
								<div class="text-xs text-gray-500 hover:underline cursor-pointer">
									<a href="?user=<?php echo $post['username'] ?>">
										<?php echo $post['username'] . ' - ' . date_format(date_create($post['created_at']), 'd M Y'); ?>
									</a>

								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>

	</div>

</main>