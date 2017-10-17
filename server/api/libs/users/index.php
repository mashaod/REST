<?php
include ('../../Rest.php');

Class Users extends Rest
    {
        protected $pdo;

        public function __construct()
        {
            $this->pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DB , DB_USER, DB_PASSWORD);
            if (!$this->pdo)
                $this->createResponse(ERR_000, 404);
        }


        public function postUsers()
        {
            $login =  Validator::checkLogin($this->params['login'])? $this->params['login'] : false;
            $password = Validator::checkPassword($this->params['password'])? password_hash($this->params['password'], PASSWORD_BCRYPT):false;

            if($login || $password)
            {
                $query = "SELECT id_user from `rest_users` where login = '$login'";
                $sth = $this->pdo->query($query);

                if(!$sth->fetchColumn()>0)
                {
                    $hash =  md5(mt_rand());
                    $time = time();

                    $query = "INSERT INTO rest_users (login, password, hash, time) VALUES ('$login', '$password', '$hash', '$time')";
                    $sth = $this->pdo->prepare($query);

                    if($sth->execute())
                        $this->createResponse(ERR_204, 201);
                    else
                        $this->createResponse(ERR_203, 404);               
                }
                else
                    $this->createResponse(ERR_202, 404);
            }
            else
                $this->createResponse(ERR_201, 404);
        }

        public function putUsers()
        {
            //$paramsArray = (explode('&', $this->params));
            $params = Converter::convertPut($this->params);

            if(count($params)>0)
            {
                $login =  Validator::checkLogin($params['login'])? $params['login'] : false;
                $password = Validator::checkPassword($params['password'])? $params['password']:false;

                $query = "SELECT id_user, password from `rest_users` where login = '$login'";
                $sth = $this->pdo->query($query);
                $user = $sth->fetch(PDO::FETCH_ASSOC);

                if(count($user)>0)
                {
                    if(password_verify($password, $user['password']))
                    {
                        $hash =  md5(mt_rand());
                        $time = time();

                        $query = "UPDATE rest_users SET hash = '$hash', time = '$time' where login = '$login'";
                        $sth = $this->pdo->prepare($query);

                        if($sth->execute())
                        {
                            $data['id_user']=$user['id_user'];
                            $data['hash']=$hash;
                            $this->createResponse($data, 202);
                        } 
                        else 
                            $this->createResponse(ERR_208, 404);             
                    }
                    else
                        $this->createResponse(ERR_207, 404);
                }
                else
                    $this->createResponse(ERR_206, 404);
            }         
            else
                $this->createResponse(ERR_205, 404);
        }

        public function getUsersByParams()
        {
            list($id_user, $hash) = explode('/', $this->params, 2);
            $id_user = Validator::checkId($id_user)? $id_user : false;

            if($id_user && $hash && !empty($hash))
            {
                $sth = $this->pdo->prepare("SELECT hash from `rest_users` where id_user = '$id_user'");
                $sth->execute();

                if($sth->execute())
                {
                    $hashInput = strlen($hash)==32?$hash:false;
                    $hashUser = $sth->fetch(PDO::FETCH_ASSOC);

                    if($hashInput == $hashUser['hash'])
                        $this->createResponse(true, 200);
                    else
                        $this->createResponse(false, 200);
                }
                else
                    $this->createResponse($sth->errorInfo(), 404); 
            }
            else
                $this->createResponse(ERR_209, 404);               
        }
    }

$obj = new Users();
$obj->start();

