<?php
    class Blogs extends Controller{
        public function __construct(){
            if(!isLoggedIn()){
                header('Location: ' . URLROOT . '/users/login');
            }

            $this->blogModel = $this->model('Blog');
            $this->userModel = $this->model('User');
        }

        public function index(){
            //Get blogs
            $blogs = $this->blogModel->getBlogs();
            $data = [
                'blogs' => $blogs
            ];

            $this->view('blogs/index',$data);
        }

        public function add(){
            //get blog data
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //sanitize data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                //validation
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                //make sure no error
                if(empty($data['title_err']) && empty($data['body_err'])){
                    //validated
                    if($this->blogModel->addBlog($data)){
                        flash('blog_message','Your blog is added');
                        header('Location: ' . URLROOT . '/blogs');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                    //load view with error
                    $this->view('blogs/add', $data);
                }
            }else{
                $data = [
                    'title' => '',
                    'body' => ''
                ];
            }

            $this->view('blogs/add',$data);
        }

        public function edit($id){
             //get blog data
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //sanitize data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => '',
                ];

                //validation
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                //make sure no error
                if(empty($data['title_err']) && empty($data['body_err'])){
                    //validated
                    if($this->blogModel->updateBlog($data)){
                        flash('blog_message','Your blog is updated');
                        header('Location: ' . URLROOT . '/blogs');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                    //load view with error
                    $this->view('blogs/edit', $data);
                }
            }else{
                $blog = $this->blogModel->getBlogById($id);

                //check for blog owner
                if($blog->user_id != $_SESSION['user_id']){
                    header('Location: ' . URLROOT . '/blogs');
                }

                $data = [
                    'id' => $id,
                    'title' => $blog->title,
                    'body' => $blog->body,
                ];
            }

            $this->view('blogs/edit',$data);
        }

        public function show($id){
            $blog = $this->blogModel->getBlogById($id);
            $user = $this->userModel->findUserById($blog->user_id);

            $data = [
                'blog' => $blog,
                'user' => $user,
            ];
            $this->view('blogs/show',$data);
        }

        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $blog = $this->blogModel->getBlogById($id);

                //check for blog owner
                if($blog->user_id != $_SESSION['user_id']){
                    header('Location: ' . URLROOT . '/blogs');
                }
                
                if($this->blogModel->deleteBlog($id)){
                    flash('blog_message', 'Your blog is deleted');
                    header('Location: ' . URLROOT . '/blogs');
                }else{
                    die('Something went wrong');
                }
            }else{
                header('Location: ' . URLROOT . '/blogs');
            }
        }
    }
?>