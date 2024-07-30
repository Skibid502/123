<?php
    include('includes/database.php');
    include('includes/config.php');
    include('includes/functions.php');
    secure();

    include('includes/header.php');

    if(isset($_GET['delete'])){
        if ($stm = $connect -> prepare('DELETE FROM posts WHERE id= ?')) {
            $stm->bind_param('i', $_GET['delete']);
            $stm->execute();
            
            set_message("A post" . $_GET['delete'] . " has been deleted");
            header('Location: posts.php');
            $stm->close();
            die();
        } else {
        echo 'Could not prepare statement';
        }
    }       


    if ($stm = $connect -> prepare('SELECT * FROM posts')){
        $stm->execute();

        $result = $stm->get_result();
   
        if($result->num_rows > 0){     
    
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Posts</h1>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Autorovo Id</th>
                    <th>Content</th>
                    <th>Edit / Delete</th>
                </tr>
                <?php
                    while($record = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['title']; ?></td>
                    <td><?php echo $record['author']; ?></td>
                    <td><?php echo $record['content']; ?></td>
                    <td><a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edit</a></td>
                    <td><a href="posts.php?delete=<?php echo $record['id']; ?>">Delete</a></td>
                    
                </tr>
                <?php
                    }
                ?>
            </table>
            <a href="posts_add.php">Add new post</a>
    </div>
</div>

<?php
    } else{
        echo 'No posts Found';
    }
    $stm->close();
} else {
    echo "Failed to prepare statement";
}
    include('includes/footer.php');
?>