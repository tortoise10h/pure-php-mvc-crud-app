<?php require APPROOT . '/views/inc/header.php' ?> 
    <a href="<?php echo URLROOT ?>/blogs" class="btn btn-light"><i class="fa fa-chevron-left"></i> Back</a>
    <div class="card card-body bg-light mt-5">
        <h2 class="text-center">Edit post</h2>
        <form action="<?php echo URLROOT ?>/blogs/edit/<?php echo $data['id'] ?>" method="POST">              
            <div class="form-group">
                <label for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="body">Body <sup>*</sup></label>
                <textarea name="body" class="form-control form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ?>" ><?php echo $data['body'];?></textarea>
                <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
            </div>

            <input type="submit" name="submit" value="Submit" class="btn btn-success">
        </form>
    </div>
<?php require APPROOT . '/views/inc/footer.php' ?> 