<?php 
    require("helpers.php");
    
    class ProductDto {

            private $Id;
            private $Name;
            private $Author;
            private $Price;
            private $Quantity;
            private $ImgDir;

        public function __construct($id, $name, $author, $price, $quantity, $imgDir){
            $this->Id = $id;
            $this->Name = $name;
            $this->Author = $author;
            $this->Price = $price;
            $this->Quantity = $quantity;
            $this->ImgDir = $imgDir;
        }
        public function getId()
        {
            return $this->Id;
        }
        public function getName()
        {
            return $this->Name;
        }
        public function getAuthor()
        {
            return $this->Author;
        }
        public function getPrice()
        {
            return $this->Price;
        }
        public function getQuantity()
        {
            return $this->Quantity;
        }
        public function getImgPath()
        {
            return $this->ImgDir;
        }
    }
?>