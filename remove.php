<?php
/**
 * Created by PhpStorm.
 * User: rajaishwary
 * Date: 8/14/14
 * Time: 2:36 AM
 */
try{
    if (empty($_POST['ids'])){
        throw new PDOException('Invalid request');
    }



     $ids = $_POST['ids'];
     $idsArray = explode('|',$ids);
    $placeholders = implode(',',array_fill(0, count($idsArray),'?'));




    $objDb = new PDO ('sqlite:shopping-list.sqlite3');
      $objDb->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION );

       $sql= "DELETE FROM `items`
              WHERE `id` IN ({$placeholders})";

    $statement = $objDb-> prepare($sql);

    if(!$statement->execute($idsArray))
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

}