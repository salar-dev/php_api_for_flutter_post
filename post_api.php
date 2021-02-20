<?php

// Thes project by Salar Brefki
//برمجة وتطوير سالار بريفكي
// YouTube: https://www.youtube.com/channel/UCphD-Ww9JnrBXRfzy6Ivg0g
// Facebook: https://www.facebook.com/salar.brefki
//Instagram: https://www.instagram.com/salarbrefki

$servername = "localhost";
$username = "id16201330_salarbrefki";
$password = "_99118822Sa_";
$dbname = "id16201330_salar_database";
$table = "post"; // Create a table named posts

// Create concction
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
    return;
}

//we will get actions from the app to do operations in the database...
$action = $_POST["action"];

//if the app sends an action to create the table...
if("CREATE_TABLE" == $action){
    $sql = "CREATE TABLE IF NOT EXISTS $table 
        ( id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        posttitle VARCHAR(30) NOT NULL,
        posttext TEXT(500) NOT NULL
        )";

if($conn->query($sql) === TRUE){
    //send back success message 
    echo "success";
}else{
    echo "error";
    }
}

// These action to add post to table
if("ADD_POST" == $action){
    // App will be posting these values to this serve
    $username = $_POST["user_name"];
    $title = $_POST["post_title"];
    $posttext = $_POST["post_text"];
    $sql = "INSERT INTO $table
        (username, posttitle, posttext) VALUES ('$username', '$title', '$posttext')";
        $result = $conn->query($sql);
    echo "success";
    $conn-> close();
    return;
}

// Get all posts records from the database
if("GET_ALL" == $action){
    $db_data = array();
    $sql = "SELECT id, username, posttitle, posttext from $table ORDER BY id DESC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $db_data[] = $row;
        }
        // Send back the coplete records as a json
        echo json_encode($db_data);
    }else{
        echo "error";
    }
    $conn-> close();
    return;
}

//Update an Post
if('UPDATE_POST' == $action){
    $post_id = $_POST['post_id'];
    $username = $_POST["user_name"];
    $title = $_POST["post_title"];
    $posttext = $_POST["post_text"];
    $sql = "UPDATE $table SET username = '$username', posttitle = '$title', posttext = '$posttext'  WHERE id = $post_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

// Delete Post
if("DELETE_POST" == $action){
    $post_id = $_POST['POST_ID'];
    $sql = "DELETE FROM $table WHERE id = $post_id";
    if($conn->query($sql) === TRUE){
        echo "success";
    }else{
        echo "error";
    }

    $conn-> close();
    return;
}

?>