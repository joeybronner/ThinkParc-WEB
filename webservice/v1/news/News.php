<?php

/* ======================================================================== *
 * @filename:		News.php												*
 * @topic:			News 													*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 07/05/2015 | J.BRONNER      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/

class News {	
	
    /**
     * Retrieves a news randomly.
     *
     * @url GET /news/random
     */
    public function getRandomNews() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM news, users ".
					"WHERE active = 1 ". 
					"AND news.id_user = users.id_user ".
					"ORDER BY RAND() ".
					"LIMIT 1";
					
			/* Statement execution */
			$stmt = $con->prepare($sql);
			$stmt->execute();
			
			/* Statement results */
			return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Retrieves all news.
     *
     * @url GET /news/all
     */
    public function getNews() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM news";
					
			/* Statement execution */
			$stmt = $con->prepare($sql);
			$stmt->execute();
			
			/* Statement results */
			return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Updates a news status (0/1).
     *
     * @url GET /news/$id_news/status/$status
     */
    public function updateNewsStatus($id_news = null, $status = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE news ".
					"SET active = ? ".
					"WHERE id_news = ?";
					
			/* Statement execution */
			$stmt = $con->prepare($sql);
			$stmt->execute(array($status,$id_news));
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Deletes a specific news (by ID).
     *
     * @url GET /news/$id_news/delete
     */
    public function deleteNews($id_news = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM news ".
					"WHERE id_news = ".$id_news.";";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_news', $id_news);
					
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else 
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Adds a news.
     *
     * @url GET /news/add/$id_user/$msg
     */
    public function addNews($id_user = null, $msg = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO news (date_news, msg, id_user, active)".
					"VALUES (NOW(),:msg, :id_user, 1)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':msg', $msg);
			$stmt->bindParam(':id_user', $id_user);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
}
?>