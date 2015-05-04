<?php
class News {	
	
    /**
     * Description.
     *
     * @url GET /news/random
     */
    public function getRandomNews() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM news, users ".
					"WHERE active = 1 ". 
					"AND news.id_user = users.id_user ".
					"ORDER BY RAND() ".
					"LIMIT 1";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /news/all
     */
    public function getNews() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM news";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /news/$id_news/status/$status
     */
    public function updateNewsStatus($id_news = null, $status = null) {
		try {
			global $con;
			$sql = 	"UPDATE news ".
					"SET active = ".$status." ".
					"WHERE id_news = ".$id_news.";";
			$stmt = $con->query($sql);
			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
}
?>