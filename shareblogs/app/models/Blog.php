<?php
    class Blog{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getBlogs(){
            $this->db->query("SELECT *,
                              blogs.id as blogId,
                              users.id as userId,
                              blogs.created_at as blogCreated,
                              users.created_at as userCreated
                              FROM blogs
                              INNER JOIN users
                              ON blogs.user_id = users.id
                              ORDER BY blogs.created_at DESC");
            $results = $this->db->resultSet();
            return $results;
        }

        public function addBlog($data){
            $this->db->query("INSERT INTO blogs (title, body, user_id) VALUES(:title, :body, :user_id)");

            $this->db->bind(':title',$data['title']);
            $this->db->bind(':body',$data['body']);
            $this->db->bind(':user_id',$data['user_id']);
            
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getBlogById($id){
            $this->db->query("SELECT * FROM blogs WHERE id = :id");

            $this->db->bind(':id',$id);
            
            $row = $this->db->singleResult();

            return $row;
        }

        public function updateBlog($data){
            $this->db->query("UPDATE blogs SET title = :title, body = :body WHERE id = :id");

            $this->db->bind(':id',$data['id']);
            $this->db->bind(':title',$data['title']);
            $this->db->bind(':body',$data['body']);
            
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }   

        public function deleteBlog($id){
            $this->db->query("DELETE FROM blogs WHERE id = :id");

            $this->db->bind(':id',$id);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }
?>