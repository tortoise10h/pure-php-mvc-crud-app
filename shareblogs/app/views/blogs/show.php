<?php require APPROOT . '/views/inc/header.php' ?>
    <a href="<?php echo URLROOT ?>/blogs" class="btn btn-light"><i class="fa fa-chevron-left"></i> Back</a>
    <h1><?php echo $data['blog']->title; ?></h1>
    <div class="container bg-secondary text-white p-2 mb-3">
        Written by <strong><?php echo $data['user']->name; ?></strong> on <?php echo $data['blog']->created_at; ?>
    </div>
    <p><?php echo $data['blog']->body; ?></p>

    <?php if($data['blog']->user_id == $_SESSION['user_id']) : ?>
        <hr>
        <a href="<?php echo URLROOT; ?>/blogs/edit/<?php echo $data['blog']->id; ?>" class="btn btn-dark">Edit</a>

        <form action="<?php echo URLROOT; ?>/blogs/delete/<?php echo $data['blog']->id; ?>" method="POST" class="float-right">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
        </form>
    <?php endif ?>
<?php require APPROOT . '/views/inc/footer.php' ?>