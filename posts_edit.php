<?php
    include('includes/database.php');
    include('includes/config.php');
    include('includes/functions.php');
    secure();

    include('includes/header.php');

if (isset($_POST['title'])){
    if ($stm = $connect -> prepare('UPDATE posts set title = ?,content = ?,date = ? WHERE id= ?')) {
        $stm->bind_param('sssi', $_POST['title'], $_POST['content'], $_POST['date'], $_GET['id']);
        $stm->execute();

        $stm->close();


        set_message("A post has been updated ".  $_GET['id'] . " byl přidán ");
        header('Location: posts.php');
        die();
        
    } else {
        echo "Failed to prepare password update statement";
    }
}
    
if(isset($_GET['id'])){
        if ($stm = $connect -> prepare('SELECT * FROM posts WHERE id = ?')) {
            $stm->bind_param('i', $_GET['id']);
            $stm->execute();
    
            $result = $stm->get_result();
            $post = $result->fetch_assoc();

            if($post){
             

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Add post</h1>
            <form method="post">
                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo $post['title'] ?>" />
                    <label class="form-label" for="title">Title</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="content"  name="content" class="form-control" value="<?php echo $post['content'] ?>" />
                    <label class="form-label" for="content">Content</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="date" id="date"  name="date" class="form-control" />
                    <label class="form-label" for="date">Date</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Edit post</button>
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
        echo "No post selected";
        die();
    }
    include('includes/footer.php');
?>