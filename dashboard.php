<?php
    include('includes/database.php');
    include('includes/config.php');
    include('includes/functions.php');
    secure();

    include('includes/header.php');

    if(isset($_POST['email'])){
        if ($stm = $connect -> prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')) {
            $hashed = SHA1($_POST['password']);
            $stm->bind_param('ss', $_POST['email'], $hashed);
            $stm->execute();

            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if($user){
                $_SESSION['id'] = $user["id"];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                header('Location: dashboard.php');
                die();
            }
            $stm->close();
        } else {
            echo "Failed to prepare statement";
        }
    }
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Dashboard</h1>
            <a href="users.php">Users management </a>
            <a href="posts.php">Posts management </a>
        </div>

    </div>
</div>

<?php
    include('includes/footer.php');
?>