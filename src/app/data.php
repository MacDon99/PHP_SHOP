<?php

$host = "localhost:3307";
$db_user = "root";
$db_password = "";
$db_name = "bazasklep";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    $sql = "CREATE TABLE Products (
        Id binary(36) PRIMARY KEY,
        Name VARCHAR(30) NOT NULL,
        Author VARCHAR(30) NOT NULL,
        Price FLOAT(4,2) NOT NULL,
        Quantity Int(4) NOT NULL,
        ImgDir VARCHAR(100),
        Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";

        
       $sqlInsert = "
                    INSERT INTO Products (Id, Name, Author,Price, Quantity, ImgDir)
                    VALUES (\"9fb01de0-1d63-4d09-9415-90e0b4e93b9a\", \"The division\", \"PinkFloyd\", 123.5, 13, \"Images/pinkFloyTheDivision.jpg\"),
                    (\"34462732-ed56-4983-8f3b-e735b0c32d50\", \"The Wall\", \"PinkFloyd\", 60.9, 16, \"Images/pinkFloydTheWall.jpg\"),
                    (\"cede66b7-3d29-4da6-b700-871fc0ac57be\", \"Animals\", \"PinkFloyd\", 36.8, 21, \"Images/pinkFloydAnimals.jpg\"),
                    (\"9aad6757-fe1b-473a-a109-b89b7b358c69\", \"Dark Side Of The Moon\", \"PinkFloyd\", 78.95, 5, \"Images/pinkFloydDarkSideOfTheMoon.jpg\");
                    ";
        $sqlCheckIfUserExist = "
        SELECT * from Products WHERE Id = \"9fb01de0-1d63-4d09-9415-90e0b4e93b9a\"
        ";
    $result = $polaczenie->query($sql);
    $result = $polaczenie->query($sqlCheckIfUserExist);

    if($result->num_rows == 0){
        $result = $polaczenie->query($sqlInsert);
        if (!$result) {
            trigger_error('Invalid query: ' . $polaczenie->error);
        }
    }
?>
