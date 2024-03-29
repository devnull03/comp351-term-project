<?php

require('model/auth_model.php');

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {

        try {

            if (checkUsername(trim($_POST["username"]))) {
                $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
            }
        } catch (Exception $e) {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        try {
            register($username, $password);
            $user = login($username, $password);

            // session_start();
            $_SESSION['user'] = $user;

            header('Location: .');
        } catch (Exception $e) {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}

?>


<div class="w-screen h-screen overflow-y-auto py-20 flex justify-center bg-gray-100">

    <div class="lg:w-[40vw] md:w-[60vw] w-[70vw] flex flex-col items-center">

        <h2 class="text-4xl font-bold pb-2">Sign up</h2>
        <p class="pb-6">
            Please fill this form to create an account.
        </p>

        <form action="" method="post" class="flex flex-col gap-4 items-center w-full rounded-lg p-4 bg-white shadow-lg">
            <div class="flex flex-col items-center w-full">
                <div class="flex items-center w-full text-base justify-between">
                    <label>Username</label>
                    <input type="text" name="username" class="rounded-lg border p-2 px-3 outline-none w-[70%] <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </div>
                <span class="text-sm text-red-600 italic"><?php echo $username_err; ?></span>
            </div>
            <div class="flex flex-col w-full items-center">
                <div class="flex items-center w-full text-base justify-between">
                    <label>Password</label>
                    <input type="password" name="password" class="rounded-lg border p-2 px-3 outline-none w-[70%] <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <span class="text-sm text-red-600 italic"><?php echo $password_err; ?></span>
            </div>
            <div class="flex flex-col w-full items-center">
                <div class="flex items-center w-full text-base justify-between gap-1">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="rounded-lg border p-2 px-3 outline-none w-[70%] <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                </div>
                <span class="text-sm text-red-600 italic"><?php echo $confirm_password_err; ?></span>
            </div>


            <div class="w-1/2 bg-black rounded-lg">
                <button class="w-full bg-gray-100 border border-gray-100 p-2 font-semibold rounded-lg active:-translate-x-1 active:scale-95 active:translate-y-1 hover:translate-x-1 hover:-translate-y-1 transition-all ease-in-out duration-500" type="submit">
                    Register
                </button>
            </div>

            <p>Already have an account? <a href="?action=login" class="hover:border-b border-b-black">Log in</a>.</p>
        </form>

    </div>
</div>