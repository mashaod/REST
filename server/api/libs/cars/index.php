<?php
include ('../../Rest.php');

Class Cars extends Rest
    {
        protected $dbMy;
        protected $pdo;

        public function __construct()
        {
            $this->pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DB , DB_USER, DB_PASSWORD);
            if (!$this->pdo)
                $this->createResponse(ERR_000, 404);
        }

        public function getCars()
        {
            $query = "SELECT id_car, brand, model, year, price  FROM `rest_cars`";

            $sth = $this->pdo->query($query);

            if($sth)
            {
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                $this->createResponse($data, 200);
            }
            else
                $this->createResponse(ERR_101, 404);
        }

        public function postCars()
        {
            $brand = Validator::clearData($this->params['brand']);
            $model = Validator::clearData($this->params['model']);
            $year = Validator::clearData($this->params['year']);
            $engine = Validator::clearData($this->params['engine']);
            $color = Validator::clearData($this->params['color']);
            $speed = Validator::clearData($this->params['speed']);
            $price = Validator::clearData($this->params['price']);            

            if($brand && $model && $year && $engine && $color && $speed && $price)
            {
                $query = "INSERT INTO rest_cars (brand, model, year, engine, color, speed, price) VALUES ('$brand', '$model', '$year', '$engine', '$color', '$speed', '$price')";
                $sth = $this->pdo->prepare($query);

                if($sth->execute())
                    $this->createResponse(ERR_104, 201);
                else
                    $this->createResponse(ERR_103, 404);
            }
            else
                $this->createResponse(ERR_102, 404);
        }

        public function putCars()
        {
            list($id_car) = explode('/', $this->params);
            $urlParams = file_get_contents("php://input")."&id_car=".$id_car;
            $params = Converter::convertPut($urlParams);

            if($params & $id_car && !empty($id_car))
            {
                $query = "UPDATE rest_cars SET brand = '$params[brand]', model = '$params[model]', year = '$params[year]', engine = '$params[engine]', color = '$params[color]', speed = '$params[speed]', price = '$params[price]' WHERE id_car = '$params[id_car]'";
                $sth = $this->pdo->prepare($query);

                if($sth->execute())
                    $this->createResponse(ERR_107, 202);
                else
                    $this->createResponse(ERR_106, 404);
            }
            else
                $this->createResponse(ERR_105, 404); 
        }

        public function deleteCars()
        {
            list($id_car) = explode('/', $this->params);

            $query = "Delete from rest_cars where id_car = '$id_car'";

            $sth = $this->pdo->prepare($query);

            if($sth->execute())
                $this->createResponse(ERR_109, 202);
            else
                $this->createResponse(ERR_108, 404); 

        }

        public function getCarsByParams()
        {
            list($params['id_car'],$params['brand'], $params['model'], $params['year'], $params['engine'], $params['color'],
                $params['speed'], $params['price']) = explode('/', $this->params, 8);
            
            foreach($params as $param => $value)
            {
                if(empty($value) || $value == false || $value == '-')
                    unset($params[$param]);
            }

            foreach ($params as $key=>$val)
            {
                if($key == 'speed' or $key == 'price' or $key == 'engine' or $key == year)
                    $operand = '>=';
                else
                    $operand = '=';
                $where[] = $key . $operand . '\'' . $val . '\' ';
            }
            $where = join('AND ', $where);

            $query = "SELECT id_car, brand, model, year, engine, color, speed, price FROM `rest_cars` where $where";
            $sth = $this->pdo->query($query);

            if($sth)
            {
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                if(count($data)>0)
                    count($data)>1?$this->createResponse($data, 200):$this->createResponse($data, 200);
                else
                    $this->createResponse(ERR_111, 404);
            }
            else
                $this->createResponse(ERR_110, 404); 
        }
    }

$obj = new Cars();
$obj->start();

