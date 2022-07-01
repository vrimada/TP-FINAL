<?php

class Viaje{
    private $idviaje;
    private $destino;
    private $cantMaxima;
    private $Responsable; 
    private $Empresa;
    private $importe; 
    private $tipoAsiento;
    private $idayvuelta;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->idviaje="";
        $this->destino="";
        $this->cantMaxima=0;
        $this->importe=0.00;
        $this->tipoAsiento="";
        $this->idayvuelta="";
    }

    public function cargar($id, $destino, $cantMax, $Responsable,$Empresa,$importe,$tipoAsiento,$idayvuelta){
        $this->idviaje=$id;
        $this->destino=$destino;
        $this->cantMaxima=$cantMax;
        $this->Responsable=$Responsable;
        $this->Empresa=$Empresa;
        $this->importe=$importe;
        $this->tipoAsiento=$tipoAsiento;
        $this->idayvuelta=$idayvuelta;

    }
   
    public function getidviaje(){
        return $this->idviaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxima(){
        return $this->cantMaxima;
    }
    public function getResponsable(){
        return $this->Responsable;
    }
    public function getEmpresa(){
        return $this->Empresa;
    }
    public function setEmpresa($Empresa){
        $this->Empresa = $Empresa;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function setImporte($importe){
        $this->importe = $importe;
    }
    
    public function getTipoAsiento(){
        return $this->tipoAsiento;
    }
    
    public function setTipoAsiento($tipoAsiento){
        $this->tipoAsiento = $tipoAsiento;
    }
    
    public function getIdayvuelta(){
        return $this->idayvuelta;
    }
    
    public function setIdayvuelta($idayvuelta){
        $this->idayvuelta = $idayvuelta;
    }
    public function setidviaje($c){
        $this->idviaje=$c;
    }
    public function setDestino($d){
        $this->destino=$d;
    }
    public function setcantMaxima($m){
        $this->cantMaxima=$m;
    }
       public function setResponsable($responsablev){
        $this->Responsable = $responsablev;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion=$mensajeoperacion;
     }

     public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	} 
    // == FUNCTIONS ==
    
    /**
     * Arma un string con los datos del arreglo de pasajeros
     * @return string
     */
    public function datosPasajeros($idViaje){
        $aux = "";
        //llama ala base de datos para cargar los pasajeros
        $p = new Pasajero();
        $coleccion_pasajeros = $p->listar("idviaje=".$idViaje);

        if(count($coleccion_pasajeros)>0){
            foreach ($coleccion_pasajeros as $key => $p)
            {
                $aux = $aux." ".$p->__toString()."\n";
            }
            $aux = substr($aux,0,strlen($aux)-2);
            $aux  = $aux . "\n";
        }else{
            $aux ="No se han cargado pasajeros todavía.\n";
        }
        return $aux;
       }
    
      /**
     * Definicion de metodo string
     * @return string
     */
    
    public function __toString(){
        return 
        "Reporte: Viaje 
         \nidviaje del viaje: ".$this->getidviaje().
        "\nDestino: ".$this->getDestino().
        "\nCapacidad Máxima: ".$this->getCantMaxima().
        "\nImporte: ".$this->getImporte().
        "\nTipo Asiento:\n".$this->getTipoAsiento().
        "\nIda y Vuelta:\n".$this->getidviaje().
        "\nEmpresa:\n".$this->getEmpresa().
        "\nResponsable: ".$this->getResponsable();
    }


    /** METODOS DE BASE DE DATOS */

   	
    public function Buscar($idViaje){
		$base = new BaseDatos();
		$cSql="Select * from viaje where idviaje =".$idViaje ;
		$resp= false;

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){
				if($row2=$base->Registro()){					
				    $this->setidviaje($idViaje);
					$this->setDestino($row2['vdestino']);
					$this->setcantMaxima($row2['vcantmaxpasajeros']);
                    $this->setImporte($row2['vimporte']);
                    $this->setTipoAsiento($row2['tipoAsiento']);
                    $this->setIdayvuelta($row2['idayvuelta']);
					
					//cargar Empresa
					$emp = new Empresa();
                    $idEmpresa = $row2['idempresa'];
					$emp->Buscar($idEmpresa);
               		$this->setEmpresa($emp);

                    //cargar Responsable
					$empl = new ResponsableV();
                    $numEmpleado = $row2['rnumeroempleado'];
					$empl->Buscar($numEmpleado);
               		$this->setResponsable($empl);

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
	     $datosViaje = null;
         $arregloDatos = [];
         //$arregloViajes = [];
		$base = new BaseDatos();
		$cSql="Select * from viaje ";
		if ($condicion!=""){
		    $cSql=$cSql.' where '.$condicion;
		}
		$cSql.=" order by idempresa ";
        //echo $cSql;
		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){				
				$datosViaje= array();
				while($row2=$base->Registro()){
                    $idViaje = $row2['idviaje'];
					$destino=$row2['vdestino'];
					$cantPasajero=$row2['vcantmaxpasajeros'];
					$responsable=$row2['rnumeroempleado'];
					$empresa=$row2['idempresa'];
					$importe=$row2['vimporte'];
					$tipoAsiento=$row2['tipoAsiento'];
					$idayvuelta=$row2['idayvuelta'];
                    //$pasajeros=$this->datosPasajeros($idViaje);
					
					$v = new Viaje();
					$v->cargar($idViaje,$destino,$cantPasajero,$responsable,$empresa,$importe,$tipoAsiento,$idayvuelta);
					array_push($datosViaje,$v);
                    
                    //$arregloDatos[0] = $datosViaje;
                    //$arregloDatos[1] = $pasajeros;

                   // array_push($arregloViajes,$arregloDatos);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		// return $arregloViajes;
        return $datosViaje;
	}	
	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar =
        "INSERT INTO viaje(vdestino, vcantmaxpasajeros,idempresa,  rnumeroempleado, vimporte,tipoAsiento,idayvuelta) 
		VALUES ('".$this->getDestino()."',".$this->getCantMaxima().",".$this->getEmpresa()->getIdEmpresa().",".
        $this->getResponsable()->getnumEmpleado().",".$this->getImporte().",'".$this->getTipoAsiento()."','".$this->getIdayvuelta()."')";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
                $this->setidviaje($base->DevolverID());
			    $resp=  true;
			}	else {
					$this->setmensajeoperacion($base->getError());
			}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function modificarTodo(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros=".$this->getCantMaxima()."
                           ,idempresa =".$this->getEmpresa()->getIdEmpresa().",rnumeroempleado =".$this->getResponsable()->getnumEmpleado().
                          ", vimporte =".$this->getImporte().",tipoAsiento ='".$this->getTipoAsiento()."', idayvuelta='".$this->getIdayvuelta().
                           "' WHERE idviaje =". $this->getidviaje();

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
	public function modificarSinDelegados(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',
        vcantmaxpasajeros=".$this->getCantMaxima().",
        vimporte =".$this->getImporte().",
        tipoAsiento ='".$this->getTipoAsiento()."',
        idayvuelta='".$this->getIdayvuelta()."' WHERE idviaje =". $this->getidviaje();

        echo $consultaModifica."\n";
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
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getidviaje();
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
