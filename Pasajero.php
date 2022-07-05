<?php
    class Pasajero{
        private $nombre;
        private $apellido;
        private $numDoc;
        private $telefono;
        private $obj_Viaje; 
        private $mensajeoperacion;
        
        public function __construct(){
           $this->nombre="";
           $this->apellido="";
           $this->numDoc="";
           $this->telefono=""; 
           $this->obj_Viaje= new Viaje();
        }
       
        public function cargar($NroD,$Nom,$Ape,$tel,$V){
         $this->setNumDoc($NroD);
         $this->setNombre($Nom);
         $this->setApellido($Ape);
         $this->setTelefono($tel);
         $this->setViaje($V);
        }
        public function getNombre()
        {
           return $this->nombre;
        }
        public function setNombre($nombre)
        {
           $this->nombre = $nombre;
        }
        public function getApellido()
        {
           return $this->apellido;
        }
        public function setApellido($apellido)
        {
           $this->apellido = $apellido;
        }
        public function getNumDoc()
        {
                return $this->numDoc;
        }
        public function setNumDoc($numDoc)
        {
                $this->numDoc = $numDoc;
        }
        public function getTelefono()
        {
                return $this->telefono;
        }

        public function setTelefono($telefono)
        {
                $this->telefono = $telefono;
        }
        public function getViaje(){
         return $this->obj_Viaje;
     }
     
     public function setViaje($obj_Viaje){
         $this->obj_Viaje = $obj_Viaje;
     }
        public function __toString()
        {
             return "Pasajero: Apellido: ".$this->getApellido().", Nombre:".$this->getNombre().", núm dni:".$this->getNumDoc().", Telefono:".$this->getTelefono().", idViaje:".$this->getViaje()->getidviaje()."\n";
        }
        public function setmensajeoperacion($mensajeoperacion){
         $this->mensajeoperacion=$mensajeoperacion;
      }

	  public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	} 
        
	/**
	 * Recupera los datos de una p$pna por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base = new BaseDatos();
		$cSql="Select * from pasajero where rdocumento=".$dni;
		$resp= false;

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){
				if($row2=$base->Registro()){					
				    $this->setNumDoc($dni);
					$this->setNombre($row2['pnombre']);
					$this->setApellido($row2['papellido']);
					$this->setTelefono($row2['ptelefono']);
					
					//cargar viaje
					$obj_viaje = new Viaje();
					$obj_viaje->setidviaje($row2['idviaje']);
					$obj_viaje->Buscar($v->getIdViaje());
               		$this->setViaje($obj_viaje);
					$resp= true;
				}				
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }		
		 return $resp;
	}	

	public function listar($condicion=""){
	    $arregloPasajero = null;
		$base = new BaseDatos();
		$cSql="Select * from pasajero ";
		if ($condicion!=""){
		    $cSql=$cSql.' where '.$condicion;
		}
		$cSql.=" order by papellido ";
		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){				
				$arregloPasajero= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['rdocumento'];
					$Nombre=$row2['pnombre'];
					$Apellido=$row2['papellido'];
					$telefono=$row2['ptelefono'];
					//cargar viaje
					$obj_Viaje = new Viaje();
					$obj_Viaje->setidviaje($row2['idviaje']);
					$obj_Viaje->Buscar($obj_Viaje->getIdViaje());
               		$this->setViaje($obj_Viaje);

             		
					$obj_Pasajero = new Pasajero();
					$obj_Pasajero->cargar($NroDoc,$Nombre,$Apellido,$telefono,$obj_Viaje);
					array_push($arregloPasajero,$obj_Pasajero);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arregloPasajero;
	}	
	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar="INSERT INTO pasajero(rdocumento, papellido, pnombre,  ptelefono, idviaje) 
				VALUES (".$this->getNumDoc().",'".$this->getApellido()."','".$this->getNombre()."',".$this->getTelefono().",".
            $this->getViaje()->getIdViaje().")";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
			    $resp=  true;
			}	else {
					$this->setmensajeoperacion($base->getError());
			}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function modificarSoloDatosPersonales(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE pasajero SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."'
                           ,ptelefono=".$this->getTelefono()." WHERE rdocumento=". $this->getNumDoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	public function modificarConViaje(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE pasajero SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."'
                           ,ptelefono=".$this->getTelefono().",idviaje=".$this->getViaje()->getIdViaje().
                           " WHERE rdocumento=". $this->getNumDoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE rdocumento=".$this->getNumDoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp =  true;
				}else{
						$this->setmensajeoperacion($base->getError());
				}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}




   
    }
?>