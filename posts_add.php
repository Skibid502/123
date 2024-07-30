<?php
    include('includes/database.php');
    include('includes/config.php');
    include('includes/functions.php');
    secure();

    include('includes/header.php');
if (isset($_POST['title'])){
    if ($stm = $connect -> prepare('INSERT INTO posts (title,content,author,date) VALUES (?,?,?,?)')) {
        $stm->bind_param('ssis', $_POST['title'], $_POST['content'], $_SESSION['id'], $_POST['date']);
        $stm->execute();

            set_message("Nový post ". $_SESSION['title'] . "byl přidán ");
            header('Location: posts.php');
            $stm->close();
            die();

    } else {
        echo "Failed to prepare statement";
    }
}
    
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Add post</h1>
            <form method="post">
                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="content"  name="content" class="form-control" />
                    <label class="form-label" for="content">Content</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="date" id="date"  name="date" class="form-control" />
                    <label class="form-label" for="date">Date</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add post</button>
            </form>
    </div>
</div>

<?php
    include('includes/footer.php');
?>