<?php
class IndexModel {
	/*
	* Сокращаем ссылку
	*/
	public function shortenLink($connectionDb) {
		if (empty($_POST['longLink'])) {
			echo json_encode(["status" => false, "message" => "Error: Введите ссылку"]);	
			return;
		}
		$longLink = $_POST['longLink'];
		/*
		* Проверяем форму 
		*/
		$resultCheckForm = $this->checkForm($longLink);
		if ($resultCheckForm !== true) {
			echo json_encode(["status" => false, "message" => "Error: $resultCheckForm"]);
			return;
		}
		/*
		* Получаем строку таблицы links, где long_link = $longLink из поля формы
		*/
		$arrLink = $this->getLink($connectionDb, $longLink);
		/*
		* Если эту ссылку еще никто не сокращал - сокращаем
		*/
		if (!isset($arrLink) || $arrLink == false) {
			$link = $this->generateLink($connectionDb);
			$data = ['longLink' => $longLink, 'link' => $link];
			/*
			* Добавляем в БД полную и сокращенную ссылки
			*/
			$status = $this->addLink($connectionDb, $data); 
			if ($status == true) {
				$messageLong = "Полная ссылка: $longLink";
				$message = "Короткая ссылка: $link";
				echo json_encode(["status" => true, "message" => $message, "messageLong" => $messageLong]);
			} else  {
				$message = "Error";
				echo json_encode(["status" => false, "message" => $message]);
			}	
		} 
		/*
		* Иначе - получаем из БД сокращенную ранее ссылку
		*/
		else {
			$link = $arrLink['link'];
			$messageLong = "Полная ссылка: $longLink";
			$message = "Короткая ссылка: $link";
			echo json_encode(["status" => true, "message" => $message, "messageLong" => $messageLong]);
		}
	}


	/*
	* Проверяем форму 
	*/
	public function checkForm($longLink) {
		/*
		* Проверяем валидность url 
		*/
		$validateUrl = filter_var($longLink, FILTER_VALIDATE_URL);
		if ($validateUrl == false) {
			return "Проверьте url";
		}
		/*
		* Проверяем существование url (код ответа страницы)
		*/	
		$exictenceUrl = $this->checkExictenceUrl($longLink);
		if ($exictenceUrl !== true) {
			return "Url не существует";
		}
		return true;
	}


	/*
	* Проверяем существование url
	*/
	public function checkExictenceUrl($longLink) { 
	    $ch = curl_init($longLink);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	    if ($code !== 404) { // == 200
	        return true;
	    } 
	}	


	/*
	* Получаем строку таблицы links, где long_link = $longLink из поля формы
	*/
	public function getLink($connectionDb, $longLink) {
		$sql = "SELECT * FROM links WHERE long_link = :longLink";
		$prep = $connectionDb->prepare($sql);
		$prep->bindValue(':longLink', $longLink, PDO::PARAM_INT);
		$prep->execute(); 
		$arr = $prep->fetch(PDO::FETCH_ASSOC);
		return $arr;
	}


	/*
	* Создаем короткую ссылку
	*/
	public function generateLink($connectionDb) {
		$string = '';
		for ($i = 0; $i < 7; $i++) { 
			$string .= substr('abdefhiknrstyzABDEFGHKNQRSTYZ23456789', rand(1, 37) - 1, 1); 
		}
		$link = "http://" . "shortener.local" . "/". $string;
		$existenceLink = $this->checkExistenceLink($connectionDb, $link);
		if (!isset($existenceLink) || $existenceLink == false) {
			return $link;
		}
		$this->generateLink($connectionDb);
		
	}

	/*
	* Проверяем есть ли в БД уже поле с такой же короткой ссылкой
	*/
	public function checkExistenceLink($connectionDb, $link) {
		$sql = "SELECT * FROM links WHERE link = :link";
		$prep = $connectionDb->prepare($sql);
		$prep->bindValue(':link', $link, PDO::PARAM_INT);
		$prep->execute(); 
		$arr = $prep->fetch(PDO::FETCH_ASSOC);
		return $arr;
	}


	/*
	* Добавляем в БД полную и сокращенную ссылки
	*/
	public function addLink($connectionDb, $data) {
		$sql = 'INSERT INTO links (long_link, link) VALUES (:longLink, :link)';
		$prep = $connectionDb->prepare($sql);
		$prep->bindValue(':longLink', $data['longLink'], PDO::PARAM_STR);
		$prep->bindValue(':link', $data['link'], PDO::PARAM_STR);
		return $prep->execute(); 
	}


	/*
	* Переходим по сокращенной ссылке 
	*/
	public function goToLink($connectionDb) {
		$id = $this->getId();
		$link = "http://" . $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI'];
		if (isset($id)) {
			$arr = $this->checkExistenceLink($connectionDb, $link);
			if ($this->checkExistenceLink($connectionDb, $link) == false) {
				header("Location: /index.php");
			} else {
				header("Location: " . $arr['long_link']);
			}
		}
	}


	public function getId() {
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[1]) && $routes[1] !== "index.php") {
			$id = $routes[1]; 
			return $id;
		}
	}	
}



