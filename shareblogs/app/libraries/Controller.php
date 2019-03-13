<?php
    /*
        * Base controller
        * Load model and view
    */
    class Controller{
        //LOAD MODEL
        public function model($model){
            require_once '../app/models/' . $model . '.php';
            //instantiate model
            return new $model();
            //Eg: if Post was passed in, then it will return new Post();
        }

        //LOAD VIEW
        public function view($view, $data = []){
            //check for view file
            if(file_exists('../app/views/' . $view . '.php')){
                require_once '../app/views/' . $view . '.php';
            }else{
                die('View does not exists');
            }
        }
    }
?>