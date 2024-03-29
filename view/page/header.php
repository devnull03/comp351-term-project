<?php
?>

<header class="fixed top-0 h-16 w-screen shadow p-4 px-10 z-50 flex items-center justify-between bg-white">

	<div>
		<a href="index.php" class="text-3xl font-bold">PHP Blog Platform</a>
	</div>

	<div class="flex items-center gap-8">

		<a href=".">Home</a>

		<?php if (isset($_SESSION['user'])) : ?>
			<a href="">
				Welcome <span class="font-semibold"> 
					<?php echo $_SESSION['user']['username'] ?>
				</span>
			</a>
		<?php else : ?>
			<a href="?action=login">Login</a>
		<?php endif; ?>

		<?php if (isset($_SESSION['user'])) : ?>
			<a href="?action=logout">Logout</a>
		<?php endif; ?>

	</div>

</header>