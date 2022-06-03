<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Vendedor;

    class VendedorController{
        public static function index(Router $router){

            $vendedores  = Vendedor::all();

            //Muestra mensaje condicional
            $resultado  = $_GET['resultado'] ?? null;

            $router->render('propiedades/admin',[
                'resultado' => $resultado,
                'vendedores' => $vendedores
            ]);
            
        }
        public static function crear(Router $router){
            $vendedor  =  new Vendedor;

            //Arreglo con mensajes de errores
            $errores = Vendedor::getErrores();

            IF ($_SERVER['REQUEST_METHOD'] === 'POST'){
                //Creamos una nueva instancia
                $vendedor = new Vendedor($_POST['vendedor']);

                //Validar Errores
                $errores = $vendedor->validar();

                //Guarda en la Base de Datos
                if(empty($errores)){
                    $vendedor->guardar();
                }
        }

        $router->render('vendedores/crear',[
            'vendedor' => $vendedor,
            'errores' => $errores

        ]);
    }
        public static function actualizar(Router $router){
            $id = validarORedireccionar('/admin');
            $vendedor = Vendedor::find($id);

            //Arreglo con mensajes de errores
            $errores = Vendedor::getErrores();

            //Ejecutar el codigo despues de que el usuario envia el formulario
            IF ($_SERVER['REQUEST_METHOD'] === 'POST'){

                //Asignar los atributos
                $args = $_POST['vendedor'];
                $vendedor->sincronizar($args);

                //Validacion
                $errores = $vendedor->validar();
            
                //revisar que el arreglo este vacio
                if(empty($errores)){
                    $vendedor->guardar();
                }
            }

            $router->render('/vendedores/update', [
                'vendedor' => $vendedor,
                'errores' => $errores
            ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id){
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)){
                    //Consulta para obtener Propiedades
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
?>