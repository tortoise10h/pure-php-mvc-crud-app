<?php
    class Pages extends Controller{
        public function __construct(){
        }
        
        public function index(){
            if(isLoggedIn()){
                header('Location: ' . URLROOT . '/blogs');
            }

            $data = [
                'title' => 'ShareBlogs',
                'description' => 'The way to remember is SHARE, ShareBlogs the place to share your knowledge and improve your knowledge'
            ];

            $this->view('pages/index',$data);
        }

        public function about(){
            $data = [
                'title' => 'About Us',
                'description' => 'This web was created by HyHy, it completely free to use'
            ];
           $this->view('pages/about',$data);
        }
    }
?>