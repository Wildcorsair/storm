<?php
/*
	Класс реализации общих медотов работы с БД.
	Чтение, втавка, редактирование и удаление

	Автор: Захарченко Владимир
	Версия: 1.0
	Дата последней редакции: 24.09.2014
*/


class Record {

	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
	 	return $this->$name = "DataSet is empty!";
	}
}

class DataAccess {
	
	public $db;
	public $tableName;
	public $primaryKey;
	private $queryString;
	
	public function __construct($host, $user, $password, $dbName) {
		$this->db = new mysqli($host, $user, $password, $dbName) 
		 			or die("Database error: ".$this->db->error);
		$this->db->set_charset("UTF8");
	}
		
	public function __destruct() {
		$this->db->close();
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
	 	return $this->$name = null;
	}
	
	/*
		Private methods declaration
	*/

	private function setQueryString($query) {
		if (is_string($query)) {
			$this->queryString = $query;
		}
	}

	private function getColumns() {
		$data = array();
		$result = $this->db->query("SHOW COLUMNS FROM ".$this->tableName);
		if ($this->db->errno) {
			echo "Database error ".$this->db->errno.":".$this->db->error;
		}
		if ($result->num_rows != 0) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
		$result->close();
		return $data;
	}

	/*
		Функция получает тип поля таблицы, приводит его к общему
		типу, для того чтобы знать какое преобразование делать со значе-
		нием которое будет вставлено или изменено в этом поле, но при 
		этом не плодить кучу case-ов
	*/

	private function getCommonFieldType($subFieldType) {
		$types = array('int' 	=>	array('tinyint',
										  'smallint',
										  'mediumint',
										  'int',
										  'bit',
										  'bool'),
						'float' =>	array('decimal',
										  'float',
										  'double',
										  'real',
										  'bigint'),
						'text'	=>	array('char',
										  'varchar',
										  'tinytext',
										  'text',
										  'mediumtext',
										  'longtext',
										  'date',
										  'datetime',
										  'timestamp',
										  'time',
										  'year'));
		$resultType = "other";
		foreach ($types as $commonType => $subTypes) {
			foreach ($subTypes as $subType) {
				if ($subType == $subFieldType) {
					$resultType = $commonType;
				}
			}
		}
		return $resultType;
	}


	/*
		Функция которая получает список полей и список свойств объекта
		(которые среди прочих имеют имена как у полей таблицы) и после
		этого сравнивается, если имя свойства равно имени поля, то это
		означает что значение этого свойства будет записано в это поле.
		Получаем тип поля, преобразовываем значение свойства к
		соответсвующему типу и формируем массив в зависимости от типа
		запроса
	*/
	
	private function prepareParams($queryType) {
		$columns = $this->getColumns();
		$properties = get_object_vars($this);
		
		foreach ($properties as $propertyName => $propertyValue) {
			foreach ($columns as $column) {
				if ($column['Field'] === $propertyName) {

					$pos = strpos($column['Type'], "(");
					if ($pos != 0) {
						$type = substr($column['Type'], 0, $pos);
					} else {
						$type = $column['Type'];
					}
					
					$commonType = $this->getCommonFieldType($type); // Получаем общий тип поля

					switch ($commonType) {
						case 'int':
							$propertyValue = intval($propertyValue);
							break;
						case 'float':
							$propertyValue = floatval($propertyValue);
							break;
						case 'text':
							$propertyValue = "'".$this->db->real_escape_string(strip_tags(trim($propertyValue)))."'";
							break;
						default:
							$propertyValue = $this->db->real_escape_string(strip_tags(trim($propertyValue)));
							break;
					}
					// Если запрос на добавление, тогда готовым два массива
					if ($queryType == 'INSERT') {
						// в одном список полей
						$fieldsListArray[] = "`".$propertyName."`";
						// в другом список значений
						$valuesListArray[] = $propertyValue;
					} else {
						// Если запрос на изменение, тогда  готовим один массив
						// Список полей и значений
						$fieldsListArray[] = "`{$propertyName}` = {$propertyValue}";
					}
				}
			}
		}
		/*	
			И по тому же алгоритму возвращаем результат
			Если запрос на вставку, то многомерный массив
		*/
		if ($queryType == 'INSERT') {
			if (!empty($fieldsListArray) && !empty($valuesListArray)) {
				$params[] = $fieldsListArray; // отдельно поля
				$params[] = $valuesListArray; // и отдельно значения
				return $params;
			} else {
				return false;
			}
		} else {
			if (!empty($fieldsListArray)) {
				// иначе одномерный для SET в котором `поле`=значение
				return $fieldsListArray;
			} else {
				return false;
			}
		}
	}


	/*
		This method uses in SELECT statement, 
		when we have got result set from the database
	*/
	
	private function openSQL($query) {
		$this->setQueryString($query);
		$data = null; //array();
		$record = new Record();
		$result = $this->db->query($query) 
					or die("Database Error: ".$this->db->error);
		if ($result->num_rows > 0) {
			while ($record = $result->fetch_object("Record")) {
				$data[] = $record;
			}
		} else {
			//$data[] = $record;
		}
		$result->close();
		return $data;
	}


	/*
		This method uses in INSERT, UPDATE and DELETE statements,
		when we have got affected rows only
	*/

	private function executeSQL($query){
		$this->setQueryString($query);
		$this->db->query($query);
		if (!$this->db->errno) {
			$affected_rows = $this->db->affected_rows;
			return $affected_rows;
		} else {
			echo "Database error ".$this->db->errno.":".$this->db->error;
		}
	}

	/*
		Public methods declaration
	*/

	public function getQueryString() {
		if (isset($this->queryString))
			echo "{$this->queryString}\n";
		else
			echo "Предупреждение: Пустая строка запроса!\n";
	}

	public function recordsCount($category) {
		$count = 0;
		$query = "SELECT COUNT(`{$this->primaryKey}`) AS `count`
					FROM `{$this->tableName}`
					WHERE `{$this->tableName}`.`fcategory` = {$category}
					LIMIT 0, 1";
		$this->setQueryString($query);
		$result = $this->db->query($query) 
					or die("Database Error: ".$this->db->error);
			if ($result->num_rows > 0) {
				$count = $result->fetch_assoc();
			}
		$result->close();
		return $count['count']; //Returns INTEGER value
	}

	public function selectById($id) {
		$record = new Record();
		if (is_numeric($id)) {
			$query = "SELECT * FROM `{$this->tableName}`
						WHERE `{$this->primaryKey}`={$id} LIMIT 0, 1";
			$this->setQueryString($query);
			$result = $this->db->query($query) 
						or die("Database Error: ".$this->db->error);
			if ($result->num_rows > 0) {
				$record = $result->fetch_object("Record");
			}
			$result->close();
		}
		return $record;
	}

	public function selectAll() {
		$query = "SELECT * FROM `{$this->tableName}`";
		return $this->openSQL($query);
	}

	/**
	*	@param fields 	= array or string,
	*	@param conditions = array, 
	*	@param limit 		= array or string
	*	function select($fields, $conditions=null, $limit=null);
	*	@return array of object
	*/
	
	public function select($fields, $conditions=null, $limit=null) {
		//	Обрабавтываем имена полей
		if (is_string($fields)) {
			$fields = trim($fields);
			if (!empty($fields)) {
				$fields = explode(",", $fields);
			} else {
				$fieldsString = "*";
			}
		} else {
			$fieldsString = "*";
		}
		if (is_array($fields)) {
			$fields = array_map("trim", $fields);
			$fieldsString = "";
			foreach ($fields as $field) {
				$fieldsString .= "`".$field."`, ";
			}
			$fieldsString = rtrim($fieldsString, ",\x20");
		}
		//	Обрабавтываем выражение в условии WHERE
		if ($conditions != null) {
			if (count($conditions) == 2) {
				$condString = $conditions[0];
				$arguments = $conditions[1];
				$search = array(":i", ":d", ":s");
				$replace = array("%d", "%s", "'%s'");
				$condString = str_replace($search,	$replace, $condString);
				$arguments = array_map("trim", $arguments);
				$arguments = array_map("strip_tags", $arguments);
				$arguments = array_map(array($this->db, "real_escape_string"), $arguments);
				$condString = vsprintf($condString, $arguments);
			}
		}
		//	Обрабавтываем значения в операторе LIMIT
		if ($limit != null) {
			if (is_array($limit)) {
				$limit = array_map("intval", $limit);
				$limit = implode(", ", $limit);
			} else if (is_string($limit)) {
				$limit = trim($limit);
				$limit = $this->db->real_escape_string($limit);
			} else {
				$limit = null;
			}
		}
		//	Собираем строку запроса
		$query = "SELECT ".$fieldsString." FROM `".$this->tableName."`";
		if ($condString != null) {
			$query .= " WHERE ".$condString;
		}
		if ($limit != null) {
			$query .= " LIMIT ".$limit;
		}
		return $this->openSQL($query);
	}

	public function selectBySql($query, $arguments = null) {
		$search = array(":i", ":d", ":s");
		$replace = array("%d", "%s", "'%s'");
		$query = str_replace($search,	$replace, $query);
		if (is_array($arguments)) {
			$arguments = array_map("trim", $arguments);
			$arguments = array_map("strip_tags", $arguments);
			$arguments = array_map(array($this->db, "real_escape_string"), $arguments);
			$query = vsprintf($query, $arguments);
		}
		return $this->openSQL($query);
	}

	public function insert() {
		$fieldsListString = "";
		$valuesListString = "";
		$params = $this->prepareParams('INSERT');
		if (is_array($params)) {
			$fieldsListString = implode(", ", $params[0]);
			$valuesListString = implode(", ", $params[1]);
		} else {
			echo "Ошибка: Нет данных для добавления или несовпадение имен "
				."свойств и полей таблицы!<br />";
		}
		
		if (!empty($fieldsListString) && !empty($valuesListString)) {
			$query = "INSERT INTO `{$this->tableName}` ({$fieldsListString})
							VALUES ({$valuesListString})";
			return $this->executeSQL($query);
		}
	}

	public function updateById($id) {
		$id = intval($id);
		if (is_numeric($id)) {
			$fieldsListString = "";
			$fieldsList = $this->prepareParams('UPDATE');
			if (is_array($fieldsList)) {
				$fieldsListString = implode(", ", $fieldsList);
			} else {
				echo "Ошибка: Нет данных или несовпадение имен свойств и полей "
					."таблицы!<br />";
			}
			
			if (!empty($fieldsListString)) {
				$query = "UPDATE `{$this->tableName}` 
							SET {$fieldsListString} 
							WHERE `{$this->primaryKey}` = {$id}";
				return $this->executeSQL($query);
			}
		} else {
			echo "Ошибка: Не верное значение ключевого поля!";
		}
	}

	public function update() {
		$fieldsAndValues = null;
		$fieldsAndValuesStr = null;
		$fieldsAndValues = $this->prepareParams('UPDATE');
		if (is_array($fieldsAndValues)) {
			for ($i = 0; $i < count($fieldsAndValues); $i++) {
				if ($i < count($fieldsAndValues) - 2) {
					$fieldsAndValuesStr .= $fieldsAndValues[$i].", ";
				} else if ($i == count($fieldsAndValues) - 2) {
					$fieldsAndValuesStr .= $fieldsAndValues[$i];
				} else if ($i == count($fieldsAndValues) - 1) {
					$condition = $fieldsAndValues[$i];
				}
			}
		}
		if (!empty($fieldsAndValuesStr)) {
			$query = "UPDATE `{$this->tableName}` 
						SET {$fieldsAndValuesStr} 
						WHERE {$condition}";
			return $this->executeSQL($query);
		}
	}

	public function deleteAll() {
		$query = "DELETE FROM `{$this->tableName}`";
		return $this->executeSQL($query);
	}

	public function deleteById($id) {
		if (is_numeric($id)) {
			$query = "DELETE FROM `{$this->tableName}` 
						WHERE `{$this->primaryKey}` = {$id}";
			return $this->executeSQL($query);			
		} else {
			return false;
		}
	}

	public function deleteByParams($condition, array $params) {
		if (is_array($params)) {
			$params = array_map("trim", $params);
			$params = array_map("strip_tags", $params);
			$params = array_map(array($this->db, "real_escape_string"), $params);
		}
		if (!empty($condition)) {
			$search = array(":i", ":d", ":s");
			$replace = array("%d", "%s", "'%s'");		
			$condition = str_replace($search, $replace, $condition);
			$condition = vsprintf($condition, $params);
			$query = "DELETE FROM `{$this->tableName}` WHERE {$condition}";
			return $this->executeSQL($query);
		}
		return false;
	}

	public function getObjectInheritance($className) {
		$str = $className;
		$cls = $className;
		/*$meth = array();
		$meth = get_class_methods($cls);
		echo '<pre>';
		var_dump($meth);
		echo '</pre>';*/
		do {
			$cls = get_parent_class($cls);
			if ($cls !== false) {
				$str .= ' -> ';
				$str .= $cls;
			}
		} while ($cls !== false);
		return $str;
	}
} //class End
?>