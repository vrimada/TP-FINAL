<?php
include 'Viaje.php';
include 'Pasajero.php';
include 'Responsable.php';
include 'Empresa.php';
include 'BaseDatos.php';

menu();

function precarga(){
    $obj_Responsable = new ResponsableV();
    $obj_Empresa = new Empresa();
    $obj_Viaje = new Viaje();
    $obj_Responsable->cargar(1, "Pedro", "del kioco", 8193882);
    $obj_Empresa->cargar(1, "Koko", "av argentina 500");
    $obj_Viaje->cargar(0,"Nequen", 150, $obj_Responsable, $obj_Empresa, 15000, "primera clase semicama", "si");
    $obj_Pasajero1 = new Pasajero();
    $obj_Pasajero2 = new Pasajero();
    $obj_Pasajero3 = new Pasajero();
    $obj_Pasajero4 = new Pasajero();
    $obj_Pasajero5 = new Pasajero();
    $obj_Pasajero1->cargar(132156,"Jorge", "Dominguez", 2991111,$obj_Viaje);
    $obj_Pasajero2->cargar(454666,"Bonachon", "Dominguez", 2991111,$obj_Viaje);
    $obj_Pasajero3->cargar(132566,"Luis", "Dominguez", 2991111,$obj_Viaje);
    $obj_Pasajero4->cargar(114754,"Carla", "Dominguez", 2991111,$obj_Viaje);
    $obj_Pasajero5->cargar(123456,"Maria", "Dominguez", 2991111,$obj_Viaje);
    $obj_Responsable->insertar();
    $obj_Empresa->insertar();
    if ($obj_Viaje->insertar()){
       $obj_Pasajero1->insertar();
       $obj_Pasajero2->insertar();
       $obj_Pasajero3->insertar();
       $obj_Pasajero4->insertar();
       $obj_Pasajero5->insertar();
   }
    $obj_Empresa->cargar(1, "Otra empresa", "calle 123");
}
 function imprime($arreglo){
    if(count($arreglo)){
        echo "-------------------------------------------------------------------------------------------\n";
        foreach ($arreglo as $item) {
            echo $item."\n";
        } 
        echo "-------------------------------------------------------------------------------------------\n";
    }else{
        echo "Lista vacia.\n";
    }
}
function textoMenu(){
echo "
0-Salir
1-ABM empresa
2-ABM responsable
3-ABM viaje
4-ABM pasajero\n";
}
function abmEmpresa(){
    $opcion=1;
    while($opcion!=0){
    echo "0-Salir
    1-Alta empresa
    2-Baja empresa
    3-Modificacion empresa
    4-Listar todas las empresas
            \n";
        $opcion = readline();
        switch($opcion){
            case 0:  break;
            case 1 :  agregarEmpresa();break;
            case 2 : 
                echo "*Para dar de baja una empresa se necesita que ingrese el numero identificador de la misma\n";
                echo "*Use la opcion listar para ver si esta la empresa que quiere borrar\n";
                echo "*A continuacion ingrese el identificador\n";
                $e = readline();
                $em = new Empresa();
                $em->Buscar($e);
                if($em->getIdEmpresa()!="")
                    borrarEmpresa($em);
                    else 
                    echo "No existe la empresa con el identificador ".$e."\n";
                break;
            case 3 : 
                echo "*Para modificar una empresa se necesita que ingrese el numero identificador de la misma\n";
                echo "*Use la opcion listar para ver si esta la empresa que quiere modificar\n";
                echo "*A continuacion ingrese el identificador\n";
                $e = readline();
                $em = new Empresa();
               
                $em->Buscar($e);
                if($em->getIdEmpresa()!="")
                    modificarEmpresa($em); 
                else 
                    echo "No existe la empresa con el identificador ".$e;
                break;
            case 4 : 
                $em = new Empresa();
                $ar = $em->listar("");
                if(count($ar)>0)
                    imprime($ar);
                else
                        echo "No hay empresas cargadas\n";
             break;
            default: echo "Error opcion incorrecta";
        }   
    }
    
}
function abmResponsable(){
    $opcion=1;
    while($opcion!=0){
        echo "
    0-Salir
    1-Alta Responsable
    2-Baja Responsable
    3-Modificacion Responsable
    4-Listar todos los Responsables
        \n";
        $opcion = readline();
        switch($opcion){
            case 0:  break;
            case 1 : 
                agregarResponsable();
                 break;
            case 2 : 
                echo "*Para dar de baja un responsable se necesita que ingrese el numero de empleado\n";
                echo "*Use la opcion listar para ver si esta el responsable que quiere borrar\n";
                echo "*A continuacion ingrese el identificador\n";
                $e = readline();
                $em = new ResponsableV();
                $em->Buscar($e);
                if($em->getnumEmpleado()!="")
                    borrarResponsable($em); 
                else 
                    echo "No existe el responsable con el numero ".$e;
                break;
            case 3 : 
                echo "*Para modificar un responsable se necesita que ingrese el numero de empleado\n";
                echo "*Use la opcion listar para ver si esta el responsable que quiere modificar\n";
                echo "*A continuacion ingrese el identificador\n";
                $e = readline();
                $em = new ResponsableV();
                $em->Buscar($e);
                if($em->getnumEmpleado()!="")
                modificarResponsable($em); 
                else 
                    echo "No existe el responsable con el numero ".$e."\n";
               
                break;
            case 4 : 
                $em = new ResponsableV();
                $arr = $em->listar("");
                if(count($arr)>0)
                    imprime($arr);
                    else 
                    echo "No hay responsables cargados \n";
             break;
            default: echo "Error opcion incorrecta";
        } 
    }      

    
}
function abmViaje(){
    $opcion=1;
    while($opcion!=0){
        echo "
0-Salir
1-Alta Viaje
2-Baja Viaje
3-Modificacion Viaje
4-Listar todos los Viajes
        \n";
        $opcion = readline();
        switch($opcion){
            case 0:  break;
            case 1 : 
                echo "*Para dar de alta un viaje necesita ingresar el numero de empleado responsable y la empresa que la ofrece\n";
                echo "*Use la opcion listar del ABM correspondiente para ver los responsables y empresa para asociar\n";
                echo "*A continuacion ingrese el numero de empleado\n";
                $r = readline();
                $responsable = new ResponsableV();
                $responsable->Buscar($r);
                if($responsable->getnumEmpleado()!=""){
                    echo "*A continuacion ingrese el identificador de la empresa\n";
                    $e = readline();
                    $Empresa = new Empresa();
                    $Empresa->Buscar($e);
                    if($Empresa->getIdEmpresa()!="")
                       agregarViaje($responsable,$Empresa);
                       else
                       echo "No existe una empresa con ese numero \n ";
                   } 
                    else{
                        echo "No existe un responsable con ese numero de empleado\n ";
                    }
                
                 break;
            case 2 : 
                echo "*Para dar de baja un viaje se necesita que ingrese el identificador del mismo\n";
                echo "*Use la opcion listar para ver si esta el viaje que quiere borrar\n";
                echo "*Si tiene pasajeros cargados no se le permitara borrarlo\n";
                echo "*A continuacion ingrese el identificador\n";
                $v = readline();
                $viaje = new Viaje();
                $viaje->setidviaje($v);
                borrarViaje($viaje);
                
                break;
            case 3 : 
                echo "*Para dar de baja un viaje se necesita que ingrese el identificador del mismo\n";
                echo "*Use la opcion listar para ver si esta el viaje que quiere borrar\n";
                echo "*A continuacion ingrese el identificador\n";
                $e = readline();
                $em = new Viaje();
                $em->setidviaje($e);
                modificarViaje($em);
               
                break;
            case 4: 
                $em = new Viaje();
                imprime($em->listar(""));
             break;
            default: echo "Error opcion incorrecta";
        } 
    }  
}
function abmPasajero(){
   $opcion=1;
    while($opcion!=0){
    echo "
0-Salir
1-Alta pasajero
2-Baja pasajero
3-Modificacion pasajero
4-Listar todas las pasajeros de un viaje
    \n";
    $opcion = readline();
    switch($opcion){
        case 0:  break;
        case 1 :agregarPasajero();
             break;
        case 2 :borrarPasajero();
            break;
        case 3 :modificarPasajero(); 
            break;
        case 4 : 
            $destino = readline("Ingrese Destino del pasajero\n");
            $viaje = new Viaje();
            $DatosViaje = $viaje->listar("vdestino ='".$destino."'");
            if(count($DatosViaje)==1){
                $pasajero = new Pasajero();
                imprime($pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
            }else{
                echo "No hay un viaje con ese destino ".$destino."\n";
            }
         break;
        default: echo "Error opcion incorrecta";
    }   
}
}
function menu(){
    $opcion = 1;
    while ($opcion != 0){
        textoMenu();
        $opcion = readline();
        switch($opcion){
            case 0: echo "Finalizo programa"; break;
            case 1 : abmEmpresa(); break;
            case 2 : abmResponsable(); break;
            case 3 : abmViaje(); break;
            case 4 : abmPasajero(); break;
            default: echo "Error opcion incorrecta";break;
        }  
    }
}

/**Funciones empresa */
function agregarEmpresa(){  
    $nuevaEmpresa= new Empresa();
    $nombreEmpresa = readline("Ingrese Nombre de la Empresa: ");
    
    $lista = $nuevaEmpresa->listar("enombre='".$nombreEmpresa."'");
    if(count($lista)>0){
        echo "Ya existe una Empresa con ese nombre\n";
    } else{
        $direccionEmpresa = readline("La direccion De la empresa: ");
        $nuevaEmpresa->cargar(0, $nombreEmpresa, $direccionEmpresa);
        $nuevaEmpresa->insertar();
    }
}

function modificarEmpresa($obj_Empresa){
    
    $nombreEmpresa = readline("Ingrese Nombre de la Empresa: ");
    $lista  = $obj_Empresa->listar("enombre='".$nombreEmpresa."'");
    if(count($lista)>0){
        echo "Ya existe una Empresa con ese nombre\n";
    } else{
        $direccionEmpresa = readline("La direccion De la empresa: ");
        $obj_Empresa->setEnombre($nombreEmpresa);
        $obj_Empresa->setEdireccion($direccionEmpresa); 
       if( $obj_Empresa->modificar()){
             echo "Se modifico correctamente la empresa en la BD\n";
         } else{
             echo "Error no se modifico la empresa en la BD \n";
    }
    }
     
}
function borrarEmpresa($obj_Empresa){
    if($obj_Empresa->eliminar()){
        echo "Se borro correctamente la empresa en la BD\n";
    } else{
        echo "Error no se borro la empresa en la BD, verifique no tenga viajes cargados. \n";
    }
}
/**Funciones responable */
function agregarResponsable(){
    $nombreResponsable = readline("Ingrese Nombre del Responsable: ");
    $apellidoResponsable = readline("Ingrese Apellido del Responsable: ");
    $numeroLicencia= validaNumero("Ingrese numero de licencia del responsable: ");
    $nuevoResponsable= new ResponsableV();
    $nuevoResponsable->cargar(0, $nombreResponsable, $apellidoResponsable, $numeroLicencia);
    if($nuevoResponsable->insertar()){
        echo "Se inserto correctamente el responsable en la BD \n";
    }else{
        echo "Error no se inserto el responsable en la BD \n";
    }
}
function modificarResponsable($responsable){
    $nombreResponsable = readline("Ingrese Nombre del Responsable: ");
    $apellidoResponsable = readline("Ingrese Apellido del Responsable: ");
    $numeroLicencia= readline("Ingrese numero de licencia del responsable: ");
    $responsable->setNombre($nombreResponsable);
    $responsable->setApellido($apellidoResponsable);
    $responsable->setnumLicencia($numeroLicencia);
    if($responsable->modificar()){
        echo "Se modifico correctamente el responsable en la BD \n";
    }else{
        echo "Error no se modifico el responsable en la BD \n";
    }
}
function borrarResponsable($responsable){
    if($responsable->eliminar()){ 
        echo "Se borro correctamente el responsable en la BD\n";
    } else{
        echo "Error no se borro el responsable en la BD, verifique no este asignado en algun viajes. \n";
    }
}
/**Funciones Viaje */
function agregarViaje($responsable,$Empresa){ 
    $nuevoViaje = new Viaje();
    $destino = readline("Ingrese el destino: ");
    $lista = $nuevoViaje->listar("vdestino='".$destino."'");
    if(count($lista)>0){
        echo "Ya existe un viaje con ese destino\n";
    }   else{
        $capacidad = validaNumero("Ingrese la capacidad del viaje: ");
        $importe=validaNumero("Ingrese el precio del viaje: ");
        $idayvuelta = validaSiNo("Ingrese S/N para 'ida y vuelta' ");
        $tipoAsiento =readline("Ingrese categoria de Asientos del viaje: ");
        
        $nuevoViaje->cargar(0,$destino, $capacidad, $responsable,$Empresa,$importe,$tipoAsiento,$idayvuelta);
       if( $nuevoViaje->insertar()){
        echo "Se inserto correctamente el viaje en la BD\n";
        } else{
        echo "Error no se inserto el viaje en la BD. \n";
        }
    }
   
 }

function modificarViaje($viaje)
 {
    $destino = readline("Ingrese el destino: ");
    $lista = $viaje->listar("vdestino='".$destino."'");
    if(count($lista)>0){
        echo "Ya existe un viaje con ese destino\n";
    }else{

        $capacidad = validaNumero("Ingrese la capacidad del viaje: ");
        $importe=validaNumero("Ingrese el precio del viaje: ");
        $idayvuelta = validaSiNo("Ingrese S/N para 'ida y vuelta' ");
        $tipoAsiento =readline("Ingrese categoria de Asientos del viaje: ");
       
       $viaje->setDestino($destino); 
       $viaje->setcantMaxima($capacidad);
       $viaje->setImporte($importe);
       $viaje->setTipoAsiento($idayvuelta);
       $viaje->setIdayvuelta($tipoAsiento);
       if($viaje->modificarSinDelegados()){
        echo "Se modifico correctamente el viaje en la BD\n";
        } else{
        echo "Error no se modifico el viaje en la BD. \n";
        }
    }
}
function validaSiNo($cartel){
 $bien = false;
 while(!$bien){
    $resp =  readline($cartel);
    switch ($resp) {
        case 'S':
        case 's':
            $bien=true;
            $resp ="SI";
            break;
        case 'N':
        case'n':
            $bien=true;
            $resp ="NO";
            break;
       default: echo "Error.. ingrese 'S' o 'N' \n"; break;
    }
 }
 return $resp;
}
function validaNumero($cartel){
    $bien = false;
    $numero=0;
 while(!$bien){
    $numero=readline($cartel);
    if(is_numeric($numero)){
        $bien=true;
    }else{
        echo "Error.. ingrese un número \n";
    }
 }
 return $numero;
}
function borrarViaje($viaje){
    if($viaje->eliminar()){
        echo "Se borro correctamente el viaje en la BD\n";
    } else{
    echo "Error no se borro el viaje en la BD. Verique que no tenga pasajeros asignados. \n";
    }
}
/**Funciones Pasajero */
function agregarPasajero(){    
    $destino = readline("Ingrese Destino del pasajero:\n");
    $viaje = new Viaje();
    $consulta = "vdestino ='".$destino."'";
    //echo "conuslta ".$consulta."\n";

    $DatosViaje = $viaje->listar($consulta);
//var_dump($DatosViaje);
    if(count($DatosViaje) == 1){
        $nuevoPasajero= new Pasajero();
        $viaje = $DatosViaje[0];
        $idViaje = $viaje->getidviaje();
        $cantAsientosTotal = $viaje->getCantMaxima();
        $condicion = "idviaje=".$idViaje;
        $asientos = $nuevoPasajero->listar($condicion);
        $cantAsientosOcupados = count($asientos);
        if(($cantAsientosTotal - $cantAsientosOcupados) > 0 ){
            $nombrePasajero = readline("Ingrese Nombre del Pasajero: \n");
            $apellidoPasajero = readline("Ingrese Apellido del pasajero: \n");
            $dniPasajero= readline("Ingrese Dni del pasajero: \n");
            $telefonoPasajero=validaNumero("Ingrese el telefono del pasajero:\n");
            
            $nuevoPasajero->cargar($dniPasajero,$nombrePasajero, $apellidoPasajero,  $telefonoPasajero, $viaje);
            if($nuevoPasajero->insertar()){
                echo "Se inserto correctamente el pasajero en la BD\n";
            } else{
            echo "Error no se inserto el pasajero en la BD. \n";
            }
        }else{
            echo "No hay lugar en el viaje (Total Asientos:".$cantAsientosTotal.", Asientos Vendidos:".$cantAsientosOcupados.")\n";
        }
       
    }else{
        echo "No existe el viaje con destino ".$destino." revise el ABM de viaje para verificar que exista\n";
    }
    }

function  modificarPasajero( ){  
    $pasajero = new Pasajero();
    $dni = readline("Ingrese Dni del pasajero: \n");
    $pasajero->Buscar($dni);
    if($pasajero->getNumDoc()!= ""){
        $nombrePasajero = readline("Ingrese Nombre del Pasajero: \n");
        $apellidoPasajero = readline("Ingrese Apellido del pasajero: \n");
        $telefonoPasajero=validaNumero("Ingrese el telefono del pasajero: \n");
        $pasajero->setNombre($nombrePasajero);
        $pasajero->setApellido($apellidoPasajero);
        $pasajero->setTelefono($telefonoPasajero);
    if($pasajero->modificarSoloDatosPersonales()){
        echo "Se modifico correctamente el pasajero en la BD\n";
    } else{
    echo "Error no se modifico el pasajero en la BD. \n";
    }

    $r = validaSiNo("¿Desea tambien cambiarlo de viaje? Pulse S/N\n");
   // echo $r;
    if($r=='SI'){
        $destino = readline("Ingrese nuevo destino: \n");
        $viaje = new Viaje();
        $DatosViaje = $viaje->listar("vdestino ='".$destino."'");
        if(count($DatosViaje) == 1){
            $idviaje = $DatosViaje->getidviaje;
            $viaje->Buscar($idviaje);
            $pasajero->setViaje($viaje);
            if($pasajero->modificarConViaje()){
                echo "Se modifico correctamente el pasajero en la BD\n";
            } else{
            echo "Error no se modifico el pasajero en la BD. \n";
            }
        }else{
            echo "Error no hay viajes con ese destino. \n"; 
        }
    }
    }else{
        echo "No existe ese dni:".$dni;
    }
}
function borrarPasajero(){
    $pasajero = new Pasajero();
    $dni = readline("Ingrese Dni del pasajero a eliminar ");
    $pasajero->Buscar($dni);
    if($pasajero->getNumDoc() != ""){
         if($pasajero->eliminar()){
            echo "Se borro correctamente el pasajero en la BD\n";
        } else{
        echo "Error no se borro el pasajero en la BD. \n";
        }
     } else
     echo "No existe ese pasajero dni:".$dni."\n";
    }