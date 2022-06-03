<?php

namespace Model;

class Propiedad extends ActiveRecord{

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id','titulo','precio','imagen', 'descripcion','habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id              = $args['id'] ?? NULL;
        $this->titulo          = $args['titulo'] ?? '';
        $this->precio          = $args['precio'] ?? '';
        $this->imagen          = $args['imagen'] ?? '';
        $this->descripcion     = $args['descripcion'] ?? '';
        $this->habitaciones    = $args['habitaciones'] ?? '';
        $this->wc              = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado          = date('Y/m/d');
        $this->vendedorId      = $args['vendedorId'] ?? '';
    }

    public function validar(){
        if (!$this->titulo){
            self::$errores[] = 'Debes añadir un titulo';
        }
        if (!$this->precio){
            self::$errores[] = 'El precio es Obligatorio';
        }
        if (strlen($this->descripcion) < 15 ){
            self::$errores[] = 'Inserte una breve descripcion a la propiedad.';
        }
        if (!$this->habitaciones){
            self::$errores[] = 'Especifique las habitaciones de la propiedad';
        }
        if (!$this->wc){
            self::$errores[] = 'Especifique la cantidad de baños';
        }
        if (!$this->estacionamiento){
            self::$errores[] = 'Especifique estacionamiento';
        }
        if (!$this->vendedorId){
            self::$errores[] = 'Seleccione un Vendedor';
        }
        if (!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        }
        return self::$errores;
    }
    
}
?>