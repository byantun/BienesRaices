<?php
    namespace MVC;
    class Router{
        public $rutasGET  = [];
        public $rutasPOST = [];

        public function get($url, $fn){
            $this->rutasGET[$url] = $fn;
        }

        public function post($url, $fn){
            $this->rutasPOST[$url] = $fn;
        }

        public function comprobarRutas(){
            session_start();
            $auth = $_SESSION['login'] ?? null;

            //Arrgelo de rutas protegidas
            $rutasProtegidas = ['/admin','/propiedades/crear','/propiedades/update','/propiedades/delete','/vendedores/crear','/vendedores/update','/vendedores/delete'];

            $urlActual = $_SERVER['PATH_INFO'] ?? '/';
            $metodo    = $_SERVER['REQUEST_METHOD'];

            if($metodo === 'GET'){
                $fn = $this->rutasGET[$urlActual] ?? null;
            }
            else{
                $fn = $this->rutasPOST[$urlActual] ?? null;
            }

            //Proteger las rutas
            if(in_array($urlActual, $rutasProtegidas) && !$auth){
                header('Location: /');
            }

            if($fn){
                //La URL existe y hay una función asociada
                call_user_func($fn, $this);
            }
            else{
                //Página no encontrada
                echo "Página no Encontrada.";
            }
        }

        //Muestra una Vista
        public function render($view, $datos = []){

            foreach($datos as $key => $value){
                $$key = $value;
            }

            ob_start(); //almacena este archivo en memoria
            include __DIR__ . "/views/$view.php";
            $contenido = ob_get_clean();//limpia la memoria
            include __DIR__ . "/views/layout.php";
        }

    }
?>