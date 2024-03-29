<?php

$post = get_post($post_id);
$comments = get_comments($post_id);

?>


<main class="w-screen h-screen overflow-y-auto py-20 flex justify-center bg-gray-100">

	<div class="lg:w-[40vw] md:w-[60vw] w-[70vw]">

		<div class="flex flex-col gap-4 w-full rounded-lg p-4 bg-white border border-white transition-all ease-in-out duration-500">
			<h2 class="text-2xl font-bold break-words"><?php echo $post['title']; ?></h2>

			<p class="break-words"><?php echo $post['body']; ?></p>

			<div class="flex justify-between items-center">
				<div class="flex gap-2">
					<form action="." class="m-0 flex gap-1 items-center">
						<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
						<input type="hidden" name="page" value="post">

						<?php
						$liked = check_like($post['id'], $_SESSION['user']['id']);
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
						<input type="hidden" name="action" value="create_comment">
						<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
						<button type="submit" class="fa fa-comment-o hover:text-blue-400 transition-all ease-in-out duration-300"></button>
						<span><?php echo $post['comment_count'] ?></span>
					</form>
				</div>
				<div class="text-xs text-gray-500">
					<a href="?user=<?php echo $post['username'] ?>">
						<?php echo $post['username'] . ' - ' . date_format(date_create($post['created_at']), 'd M Y'); ?>
					</a>
				</div>
			</div>
		</div>

	</div>

</main>