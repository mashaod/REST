<?php
include ('../../Rest.php');

Class Orders extends Rest
    {
        protected $pdo;

        public function __construct()
        {
            $this->pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DB , DB_USER, DB_PASSWORD);
            if (!$this->pdo)
                $this->createResponse(ERR_000, 404);
        }


        public function postOrders()
        {
            $id_user = Validator::checkId($this->params['id_user'])? $this->params['id_user']:false;
            $id_car = Validator::checkId($this->params['id_car'])? $this->params['id_car']:false;
            $payment = Validator::clearData($this->params['payment']);

            if($id_user && $id_car && $payment && !empty($payment))
            {
                $query = "INSERT INTO rest_orders (id_user, id_car, payment) VALUES ('$id_user', '$id_car', '$payment')";
                $sth = $this->pdo->prepare($query);

                if($sth->execute())
                    $this->createResponse(ERR_303, 201);
                else
                    $this->createResponse(ERR_302, 404);
            }
            else
                $this->createResponse(ERR_301, 404);

        }

        public function putOrders()
        {
            $params = Converter::convertPut($this->params);
            $id_order = Validator::checkId($params['id_order'])? $params['id_order']:false;
            $status = Validator::clearData($params['status']);

            if($id_order && $status && !empty($status))
            {
                $query = "UPDATE rest_orders SET status = '$status' WHERE id_orders = '$id_order'";
                $sth = $this->pdo->prepare($query);

                if($sth->execute())
                    $this->createResponse(ERR_306, 202);
                else
                    $this->createResponse(ERR_305, 404); 
            }
            else
                $this->createResponse(ERR_304, 404);
        }

        public function getOrdersByParams()
        {
            list($id_user) = explode('/', $this->params, 1);
            $id_user = Validator::checkId($id_user)? $id_user:false;

            if($id_user)
            {
                $sth = $this->pdo->query("SELECT id_orders, id_car, payment, status FROM `rest_orders` where id_user = '$id_user'");

                if($sth)
                {
                    $data = $sth->fetchAll(PDO::FETCH_ASSOC);

                    if(count($data)>0)
                        $this->createResponse($data, 200);
                    else
                        $this->createResponse(ERR_309, 404);
                }
                else
                    $this->createResponse(ERR_308, 404);
            }
            else
                $this->createResponse(ERR_307, 404);
        }
    }

$obj = new Orders();
$obj->start();

