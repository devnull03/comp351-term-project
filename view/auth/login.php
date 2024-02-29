<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

require('model/auth_model.php');

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {

        $user = login($username, $password);

        if (is_array($user)) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: .');
        } else {
            $login_err = $user;
        }
    }
}
?>

<div class="w-screen h-screen overflow-y-auto py-20 flex justify-center bg-gray-100">

    <div class="lg:w-[40vw] md:w-[60vw] w-[70vw] flex flex-col items-center">

        <h2 class="text-4xl font-bold pb-2">Login</h2>
        <p class="pb-6">Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="" method="post" class="flex flex-col gap-4 items-center w-full rounded-lg p-4 bg-white shadow-lg">
            <div class="flex items-center w-full text-base justify-between">
                <label>Username</label>
                <input type="text" name="username" class="rounded-lg border p-2 px-3 outline-none w-[80%] <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="flex items-center w-full text-base justify-between">
                <label>Password</label>
                <input type="password" name="password" class="rounded-lg border p-2 px-3 outline-none w-[80%] <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <div class="w-1/2 bg-black rounded-lg">
                <button class="w-full bg-gray-100 p-2 font-semibold rounded-lg active:-translate-x-1 active:scale-95 active:translate-y-1 hover:translate-x-1 hover:-translate-y-1 transition-all ease-in-out duration-500" type="submit">
                    Login
                </button>
            </div>

            <p>Don't have an account? <a href="?action=register" class="hover:border-b border-b-black">Sign up now</a>.</p>
        </form>

    </div>
</div>