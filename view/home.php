<?php

$posts = get_posts();

?>

<main class="w-screen h-screen overflow-y-auto py-20 flex justify-center bg-gray-100">

	<div class="lg:w-[40vw] md:w-[60vw] w-[70vw]">

		<form action="index.php" method="POST" class="flex flex-col gap-4 items-center w-full rounded-lg p-4 bg-white shadow-lg">
			<?php if (isset($_SESSION['user'])) : ?>
				<span class="font-semibold text-xl w-full">New post</span>

				<input type="hidden" name="action" value="new_post">
				<input class="rounded-lg border p-2 px-3 outline-none w-full" placeholder="Title" type="text" name="post_title">
				<textarea class="rounded-lg border p-2 px-3 outline-none w-full" placeholder="Content" name="post_content"></textarea>

				<div class="w-1/2 bg-black rounded-lg">
					<button class="w-full bg-gray-100 border border-gray-100 p-2 font-semibold rounded-lg active:-translate-x-1 active:scale-95 active:translate-y-1 hover:translate-x-1 hover:-translate-y-1 transition-all ease-in-out duration-500" type="submit">Post</button>
				</div>
			<?php else : ?>
				<p class="w-full flex justify-center">You must be logged in to post</p>
			<?php endif; ?>
		</form>

		<div class="flex flex-col gap-4 pb-20">
			<?php foreach ($posts as $post) : ?>

				<div class="w-full h-full rounded-lg bg-black shadow-lg">
					<div class="flex flex-col gap-4 w-full rounded-lg p-4 bg-white border border-white hover:translate-x-2 hover:-translate-y-2 transition-all ease-in-out duration-500">
						<a href="?post=<?php echo $post['id'] ?>">
							<h2 class="text-2xl font-bold break-words"><?php echo $post['title']; ?></h2>
						</a>

						<p class="break-words"><?php echo $post['body']; ?></p>

						<div class="flex justify-between items-center">
							<div class="flex gap-2">
								<form action="." class="m-0">
									<input type="hidden" name="action" value="create_like">
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
									<button type="submit" class="fa fa-heart-o"></button>
								</form>
								<form action="." class="m-0">
									<input type="hidden" name="action" value="create_comment">
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
									<button type="submit" class="fa fa-comment-o"></button>
								</form>
							</div>
							<div class="text-xs text-gray-500">
								<?php echo $post['username'] . ' - ' . date_format(date_create($post['created_at']), 'd M Y'); ?>
							</div>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>

	</div>

</main>