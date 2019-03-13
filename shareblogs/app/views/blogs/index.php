<?php require APPROOT . '/views/inc/header.php' ?>
    <?php echo flash('blog_message'); ?>
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Blogs</h1>
        </div>
        <div class="col-md-6">
            <a href="<?php echo URLROOT ?>/blogs/add" class="btn btn-primary float-right">
                <i class="fa fa-pencil-alt"></i> Add blog
            </a>
        </div>
    </div>
    <?php foreach($data['blogs'] as $blog) : ?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?php echo $blog->title; ?></h4>
            <div class="bg-light p-2 mb-3">
                written by <?php echo $blog->name; ?> on <?php echo $blog->blogCreated; ?>
            </div>
            <p class="card-text"><?php echo $blog->body; ?></p>
            <a href="<?php echo URLROOT ?>/blogs/show/<?php echo $blog->blogId; ?>" class="btn btn-dark">Read more</a>
        </div>
    <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php' ?>