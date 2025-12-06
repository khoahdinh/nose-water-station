<!-- Shift + Alt + F để canh lề -->
<?php include("path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php"); 
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');


guestOnly();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/69714c34b3.js" crossorigin="anonymous"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Register | Nose Water Station</title>

</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <!-- Login -->
    <div class="auth-content">
        <form action="register.php" method="post">
            <h2 class="form-title"><?php echo $text['Register']; ?></h2>

            <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

            <div>
                <label><?php echo $text['User_name']; ?></label>
                <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="text-input">
            </div>
            <div>
                <label><?php echo $text['Password']; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
            </div>
            <div>
                <label><?php echo $text['Password_Confirmation']; ?></label>
                <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
            </div>
            <div>
                <button type="submit" name="register-btn" class="btn btn-big"><?php echo $text['Register']; ?></button>
            </div>
            <p><?php echo $text['or']; ?><a href="<?php echo BASE_URL . '/login.php' ?>"><?php echo $text['Login']; ?></a></p>
        </form>
    </div>



    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom Script -->
    <script src="assets/js/script.js"></script>

</body>

</html>