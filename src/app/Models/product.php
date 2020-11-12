<?php 
    require("helpers.php");

    class Product {

            private $Id;
            private $Name;
            private $Author;
        
        public function __construct($name, $author){
            $this->Id = createGuid();
            $this->Name = $name;
            $this->Author = $author;
        }
    }
?>