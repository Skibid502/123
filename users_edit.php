<?php
    include('includes/database.php');
    include('includes/config.php');
    include('includes/functions.php');
    secure();

    include('includes/header.php');

if (isset($_POST['username'])){
    if ($stm = $connect -> prepare('UPDATE users set username = ?,email = ?,active = ? WHERE id= ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm->execute();

        $stm->close();

        if (isset($_POST['password'])) {
            if ($stm = $connect -> prepare('UPDATE users set password = ? WHERE id= ?')) {
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed, $_GET['id']);
                $stm->execute();

                $stm->close();
            } else {
                echo "Failed to prepare password update statement";
            }
        }    


        set_message("A user has been updated ".  $_GET['id'] . " byl přidán ");
        header('Location: users.php');
        die();
        
    } else {
        echo "Failed to prepare password update statement";
    }
}
    
if(isset($_GET['id'])){
        if ($stm = $connect -> prepare('SELECT * FROM users WHERE id = ?')) {
            $stm->bind_param('i', $_GET['id']);
            $stm->execute();
    
            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if($user){
             

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Edit user</h1>

            <form method="post">
                <div class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username']?>" />
                    <label class="form-label" for="username">username</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email']?>" />
                    <label class="form-label" for="email">Email address</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="password" id="password"  name="password" class="form-control " />
                    <label class="form-label" for="password">Password</label>
                </div>
                <div class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
                        <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </form>
    </div>
</div>

<?php
                }
                $stm->close();
                die();
        } else {
            echo "Failed to prepare statement";
        }
    } else {
        echo "No user selected";
        die();
    }
    include('includes/footer.php');
?>