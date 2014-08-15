<?php
/**
 * Created by PhpStorm.
 * User: rajaishwary
 * Date: 8/14/14
 * Time: 2:36 AM
 */
try{
    if (empty($_POST['id'])){
        throw new PDOException('Invalid request');
    }



     $id = $_POST['id'];
   $done = empty($_POST['done']) ? 0 : 1;




    $objDb = new PDO ('sqlite:shopping-list.sqlite3');
      $objDb->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION );

       $sql= "UPDATE `items`
              SET `done` = ?
              WHERE `id` = ?";

    $statement = $objDb-> prepare($sql);

    if(!$statement->execute(array($done, $id)))
    {
        throw new PDOException('the execute method failed');
    }


    $id= $objDb->lastInsertId();




    echo json_encode(array(
        'error' =>false,


    ),JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);


} catch(PDOException $e){
    echo json_encode(array(
         'error' => true,
         'message' => $e -> getMessage()
    ),JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

}1