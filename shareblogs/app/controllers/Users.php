<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function register(){
            //check for POST submit or load register view
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //process form
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                //init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                //Validate data user input
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter name';
                }

                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }else{
                    if(preg_match_all("/^[a-z][a-z0-9_\.]{3,32}@\D{2,}(\.\D{2,4}){1,2}$/",$data['email']) == false){
                        $data['email_err'] = 'Please enter valid email';
                    }else{
                        //check exists email
                        if($this->userModel->findUserByEmail($data['email'])){
                            $data['email_err'] = 'This email is already taken';
                        }
                    }
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Your password have to be at least 6 characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please enter confirm password';
                }else{
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'Your password and your confirm password do not match';
                    }
                }

                //Submit when has no errors
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    //validated

                    //Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //Register user
                    if($this->userModel->register($data)){
                        //register successfully and save user information to database
                        flash('register_success','You are registerd and now you can log in');
                        header('Location: ' . URLROOT . '/users/login');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                    //load view with errors
                    $this->view('users/register',$data);
                }
            }else{
                //save all info of user input for error input and info still in their field
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                //load register view
                $this->view('users/register',$data);
            }
        }
        public function login(){
            //check for POST submit or load login view
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //process form
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

                //init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                //Validate data user input
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }

                //check for email 
                if($this->userModel->findUserByEmail($data['email'])){
                    //user found
                }else{
                    //user isn't exists
                    $data['email_err'] = 'No user found';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }

                //Submit when has no errors
                if(empty($data['email_err']) && empty($data['password_err'])){
                   //check and set log in user
                   $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                   if($loggedInUser){
                       //user found
                       //create session 
                       $this->createUserSession($loggedInUser);
                   }else{
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login',$data);
                   }
                }else{
                    //load view with errors
                    $this->view('users/login',$data);
                }
            }else{
                //save all info of user input for error input and info still in their field
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];
                //load register view
                $this->view('users/login',$data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            header('Location: ' . URLROOT . '/blogs/index');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            header('Location: ' . URLROOT . '/users/login');
        }

        
    }
?>