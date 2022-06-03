<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    class PropiedadController{
        public static function index(Router $router){

            $propiedades = Propiedad::all();
            $vendedores  = Vendedor::all();

            //Muestra mensaje condicional
            $resultado  = $_GET['resultado'] ?? null;

            $router->render('propiedades/admin',[
                'propiedades' => $propiedades,
                'resultado' => $resultado,
                'vendedores' => $vendedores
            ]);
            
        }
        public static function crear(Router $router){
            $propiedad  =  new Propiedad;
            $vendedores = Vendedor::all();

            //Arreglo con mensajes de errores
            $errores = Propiedad::getErrores();

            IF ($_SERVER['REQUEST_METHOD'] === 'POST'){
                //Creamos una nueva instancia
                $propiedad = new Propiedad($_POST['propiedad']);

                //Subida de archivos
                //generar nombre de archivo
                $nombreImagen = md5(uniqid( rand(),true) ) . '.jpg';

                //Realiza un resize a la imagen con intervention
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }

                //Validar Errores
                $errores = $propiedad->validar();

                //revisar que el arreglo este vacio
                if(empty($errores)){
                    if(empty($errores)){
                        if(!is_dir(CARPETA_IMAGENES)){
                            mkdir(CARPETA_IMAGENES);
                        }
                    }
                    //Guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);

                    //Guarda en la Base de Datos
                    $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores

        ]);
    }
        public static function actualizar(Router $router){
            $id = validarORedireccionar('/admin');
            $propiedad  = Propiedad::find($id);
            $vendedores = Vendedor::all();

            //Arreglo con mensajes de errores
            $errores = Propiedad::getErrores();

            //Ejecutar el codigo despues de que el usuario envia el formulario
            IF ($_SERVER['REQUEST_METHOD'] === 'POST'){

                //Asignar los atributos
                $args = $_POST['propiedad'];

                $propiedad->sincronizar($args);

                //Validacion
                $errores = $propiedad->validar();

                //generar nombre de archivo
                $nombreImagen = md5(uniqid( rand(),true) ) . '.jpg';

                //Subida de archivos de imagen
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }
            
                //revisar que el arreglo este vacio
                if(empty($errores)){
                    if($_FILES['propiedad']['tmp_name']['imagen']){
                        //Almacenar la imagen
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }
                    $propiedad->guardar();
                }
            }

            $router->render('/propiedades/update', [
                'propiedad' => $propiedad,
                'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
?>