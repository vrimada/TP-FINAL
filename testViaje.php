<?php
include 'Viaje.php';
include 'Pasajero.php';
include 'Responsable.php';
include 'Empresa.php';
include 'BaseDatos.php';
include 'Color.php';

menu();

 function imprime($arreglo){
    if(count($arreglo)){
        echo  Color::getBOLD()."·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•\n".Color::getENDC();
        foreach ($arreglo as $item) {
            echo $item."\n";
        } 
        echo  Color::getBOLD()."·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•·.·´¯`·.·•\n".Color::getENDC();
    }else{
        echo "Lista vacia.\n";
    }
}
function textoMenu(){
echo Color::getHEADER() ."Sistema Viaje".Color::getENDC();
echo Color::getBold()."
0-Salir
1-ABM empresa
2-ABM responsable
3-ABM viaje
4-ABM pasajero".Color::getENDC()."\n";
}

function abmEmpresa(){
$opcion=1;
while($opcion!=0){
echo Color::getHEADER() ."ABM EMPRESA".Color::getENDC();
echo Color::getBold()."
0-Salir
1-Alta empresa
2-Baja empresa
3-Modificacion empresa
4-Listar todas las empresas".Color::getENDC()."\n";
$opcion = readline();
switch($opcion){
    case 0:  break;
    case 1 :  agregarEmpresa();break;
    case 2 : 
        echo "Para dar de baja una empresa se necesita que ingrese el numero identificador de la misma\n";
        $obj_Empresa = new Empresa();
        $ar = $obj_Empresa->listar("");
        if(count($ar)>0){
            imprime($ar);

            echo "A continuacion ingrese el identificador\n";
            $e = readline();
            $obj_Empresa->Buscar($e);
            
            if($obj_Empresa->getIdEmpresa()!=""){
                //Se verifica que no este asociado a un viaje
                $obj_viaje = new Viaje();
                $lista = $obj_viaje->listar("idempresa=".$e);
                if(count($lista)==0){
                    borrarEmpresa($e,$obj_Empresa);
                }else{
                    echo Color::getWARNING()."Error la empresa esta relacionada a un viaje.\n".Color::getENDC();
                }
            }else 
                echo Color::getWARNING()."No existe la empresa con el identificador: ".$e."\n".Color::getENDC();
        }
        else
            echo Color::getWARNING()."No hay empresas cargadas\n".Color::getENDC();

       break;
    case 3 : 
        echo "Para modificar una empresa se necesita que ingrese el numero identificador de la misma\n";
       
        $obj_Empresa = new Empresa();
        $ar = $obj_Empresa->listar("");
        if(count($ar)>0){
            imprime($ar);

            echo "A continuacion ingrese el identificador\n";
            $e = readline();
            
            $obj_Empresa->Buscar($e);
            if($obj_Empresa->getIdEmpresa()!=""){
                modificarEmpresa($obj_Empresa);
             } else
                 echo Color::getWARNING()."No existe la empresa con el identificador ".$e."\n".Color::getENDC();
        }else
                echo Color::getWARNING()."No hay empresas cargadas\n".Color::getENDC();
        break;
    case 4 : 
        $obj_Empresa = new Empresa();
        $ar = $obj_Empresa->listar("");
        if(count($ar)>0)
            imprime($ar);
        else
            echo Color::getWARNING()."No hay empresas cargadas\n".Color::getENDC();
        break;
    default: echo Color::getWARNING()."Error opcion incorrecta\n".Color::getENDC();
    }   
}
}

function abmResponsable(){
$opcion=1;
while($opcion!=0){
echo Color::getHEADER() ."ABM RESPONSABLE ".Color::getENDC();
echo Color::getBOLD()."
0-Salir
1-Alta Responsable
2-Baja Responsable
3-Modificacion Responsable
4-Listar todos los Responsables\n".Color::getENDC();
$opcion = readline();
    switch($opcion){
        case 0:  break;
        case 1 :agregarResponsable();break;
        case 2 : 
            echo "Para dar de baja un responsable se necesita que ingrese el numero de empleado\n";
            $obj_empleado = new ResponsableV();
            $arr = $obj_empleado->listar("");
            if(count($arr)>0){
                imprime($arr);

                echo "A continuacion ingrese el identificador\n";
                $e = readline();
                
                $obj_empleado->Buscar($e);
                if($obj_empleado->getnumEmpleado()!=""){

                    $obj_viaje = new Viaje();
                    $lista = $obj_viaje->listar("rnumeroempleado=".$e);
                    if(count($lista)==0){
                        borrarResponsable($e,$obj_empleado);
                    }
                    else
                        echo Color::getWARNING()."No se puede borrar el responsable, esta relacionado a un viaje\n".Color::getENDC();
                }
                else 
                    echo Color::getWARNING()."No existe el responsable con el numero ".$e."\n".Color::getENDC();
            }
            else 
                echo  Color::getWARNING()."No hay responsables cargados \n".Color::getENDC();
           
            break;
        case 3 : 
            echo "Para modificar un responsable se necesita que ingrese el numero de empleado\n";
            
            $obj_empleado = new ResponsableV();
            $arr = $obj_empleado->listar("");
            if(count($arr)>0){
                imprime($arr);

                echo "A continuacion ingrese el identificador\n";
                $e = readline();
                $obj_empleado = new ResponsableV();
                $obj_empleado->Buscar($e);
                if($obj_empleado->getnumEmpleado()!="")
                   modificarResponsable($obj_empleado);
                else 
                    echo Color::getWARNING()."No existe el responsable con el numero ".$e."\n",Color::getENDC();
            }
            else 
                echo Color::getWARNING()."No hay responsables cargados \n".Color::getENDC(); break;
        case 4 : 
            $em = new ResponsableV();
            $arr = $em->listar("");
            if(count($arr)>0)
                imprime($arr);
                else 
                  echo Color::getWARNING()."No hay responsables cargados \n".Color::getENDC(); break;
        default: echo Color::getWARNING()."Error opcion incorrecta\n".Color::getENDC();
    } 
}      
    
}
function abmViaje(){
$opcion=1;
while($opcion!=0){
echo Color::getHEADER() ."ABM VIAJE".Color::getENDC();
echo Color::getBOLD()."
0-Salir
1-Alta Viaje
2-Baja Viaje
3-Modificacion Viaje
4-Listar todos los Viajes\n".Color::getENDC();
$opcion = readline();
switch($opcion){
    case 0:  break;
    case 1 : 
        echo "Para dar de alta un viaje necesita ingresar el numero de empleado responsable y la empresa que la ofrece\n";
      
        //imprime responsables
        $obj_empleado = new ResponsableV();
        $arr = $obj_empleado->listar("");
        if(count($arr)>0){
            imprime($arr);
            echo "A continuacion ingrese el numero de empleado\n";
            $r = readline();
            $obj_empleado = new ResponsableV();
            $obj_empleado->Buscar($r);
            if($obj_empleado->getnumEmpleado()!=""){
                $obj_Empresa = new Empresa();
                $arr2 = $obj_Empresa->listar("");
                if(count($arr2)>0){
                    imprime($arr2);
                    echo "A continuacion ingrese el identificador de la empresa\n";
                    $e = readline();
                    $obj_Empresa->Buscar($e);
                    if($obj_Empresa->getIdEmpresa()!="")
                        agregarViaje($obj_empleado,$obj_Empresa);
                    else
                        echo Color::getWARNING()."No existe una empresa con ese numero \n ".Color::getENDC();
                    } 
                    else{
                        echo Color::getWARNING()."No existe un responsable con ese numero de empleado\n ".Color::getENDC();
                    }
                }
        }else{
            echo Color::getWARNING()."No existen responsables para asignar al viaje\n".Color::getENDC();
        } break;
    case 2 : 
        echo "Para dar de baja un viaje se necesita que ingrese el identificador del mismo\n";

        $obj_viaje = new Viaje();
        $arr = $obj_viaje->listar("");

        if(count($arr)>0){
            imprime($arr);

            echo "A continuacion ingrese el identificador\n";
            $v = readline();
            $obj_viaje->setidviaje($v);
            borrarViaje($obj_viaje);
        }else{
            echo Color::getWARNING()."No existe viajes para borrar\n ".Color::getENDC();
        } break;
    case 3 : 
        echo "Para dar de baja un viaje se necesita que ingrese el identificador del mismo\n";
        $obj_viaje = new Viaje();
        $arr = $obj_viaje->listar("");

        if(count($arr)>0){
            imprime($arr);
            echo "A continuacion ingrese el identificador\n";
            $e = readline();
            $obj_viaje->setidviaje($e);
            modificarViaje($obj_viaje);
        }else{
            echo Color::getWARNING()."No existe viajes para modificar\n ".Color::getENDC();
        }
        break;
    case 4: 
        $obj_viaje = new Viaje();
        $arr = $obj_viaje->listar("");
        if(count($arr)>0){
            imprime($arr);
        }else{
            echo Color::getWARNING()."No existen viajes\n ".Color::getENDC();
        } break;
    default: echo Color::getWARNING()."Error opcion incorrecta\n".Color::getENDC(); break;
}    
}  
}
function abmPasajero(){
$opcion=1;
while($opcion!=0){
echo Color::getHEADER() ."ABM PASAJERO".Color::getENDC();
echo Color::getBOLD()."
0-Salir
1-Alta pasajero
2-Baja pasajero
3-Modificacion pasajero
4-Listar todas las pasajeros de un viaje
5-Listar todas las pasajeros de la BD\n".Color::getENDC();
$opcion = readline();
switch($opcion){
    case 0:  break;
    case 1 :agregarPasajero();break;
    case 2 :borrarPasajero();break;
    case 3 :modificarPasajero();  break;
    case 4 : 
        $destino = readline("Ingrese Destino del pasajero");
        $obj_viaje = new Viaje();
        $DatosViaje = $obj_viaje->listar("vdestino ='".$destino."'");
        if(count($DatosViaje)==1){
            $obj_pasajero = new Pasajero();
            imprime($obj_pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
        }else{
            echo Color::getWARNING()."No hay un viaje con ese destino ".$destino."\n".Color::getENDC();
        }break;
    case 5: 
        $obj_pasajero = new Pasajero();
        $lista = $obj_pasajero->listar();
        if(count($lista)>0)
            imprime($lista);
            else
            echo Color::getWARNING()."No pasajeros en el sistema\n".Color::getENDC();
        break;
    default: echo Color::getWARNING()."Error opcion incorrecta\n".Color::getENDC();
}   
}
}
function menu(){
    $opcion = 1;
    while ($opcion != 0){
        textoMenu();
        $opcion = readline();
        switch($opcion){
            case 0: echo Color::getUNDERLINE() ."Finalizo programa.".Color::getENDC();break;
            case 1 : abmEmpresa(); break;
            case 2 : abmResponsable(); break;
            case 3 : abmViaje(); break;
            case 4 : abmPasajero(); break;
            default: echo Color::getWARNING()."Error opcion incorrecta\n".Color::getENDC();break;
        }  
    }
}
/********************************* */
//***************Funciones empresa */
/********************************* */
function agregarEmpresa(){  
    $nuevaEmpresa= new Empresa();
    $nombreEmpresa = readline("Ingrese Nombre de la Empresa: ");
    
    $lista = $nuevaEmpresa->listar("enombre='".$nombreEmpresa."'");
    if(count($lista)>0){
        echo Color::getWARNING()."Ya existe una Empresa con ese nombre\n".Color::getENDC();
    } else{
        $direccionEmpresa = readline("La direccion De la empresa: ");
        $nuevaEmpresa->cargar(0, $nombreEmpresa, $direccionEmpresa);
        if($nuevaEmpresa->insertar()){
            echo Color::getOKGREEN()."Se ingreso correctamente la empresa en la BD\n".Color::getENDC();
        }
    }
}

function modificarEmpresa($obj_Empresa){
    $respuesta = validaSiNo("¿Conserva el nombre de Empresa? S|N");
    if($respuesta=="SI"){
        $direccionEmpresa = readline("La direccion De la empresa: ");
        $obj_Empresa->setEdireccion($direccionEmpresa); 
        if( $obj_Empresa->modificar()){
             echo Color::getOKGREEN()."Se modifico correctamente la empresa en la BD\n".Color::getENDC();
         } else{
             echo Color::getWARNING()."Error no se modifico la empresa en la BD \n".Color::getENDC();
            }
    }else{
        $nombreEmpresa = readline("Ingrese Nombre de la Empresa: ");
        $lista  = $obj_Empresa->listar("enombre='".$nombreEmpresa."'");
        if(count($lista)>0){
            echo Color::getWARNING()."Ya existe una Empresa con ese nombre\n".Color::getENDC();
        } else{
            $direccionEmpresa = readline("La direccion De la empresa: ");
            $obj_Empresa->setEnombre($nombreEmpresa);
            $obj_Empresa->setEdireccion($direccionEmpresa); 
            if( $obj_Empresa->modificar()){
                 echo Color::getOKGREEN()."Se modifico correctamente la empresa en la BD\n".Color::getENDC();
             } else{
                 echo Color::getWARNING()."Error no se modifico la empresa en la BD \n".Color::getENDC();
        }
        }
    }

   
     
}
function borrarEmpresa($idempresa, $obj_Empresa){
    //verifico que no este referenciado en un viaje
    $obj_viaje = new Viaje();
    $condicion = "idempresa=".$idempresa;
    $listaEmpresa = $obj_viaje->listar($condicion);

    if(count($listaEmpresa)==0){
        if($obj_Empresa->eliminar()){
            echo Color::getOKGREEN()."Se borro correctamente la empresa en la BD\n".Color::getENDC();
        } else{
            echo Color::getWARNING()."Error no se borro la empresa en la BD \n".Color::getENDC();
        }
    }else{
        echo  Color::getWARNING()."Error la empresa esta cargada en un Viaje. \n".Color::getENDC();
    }
    
}
/********************************* */
/*************Funciones responable */
/********************************* */
function agregarResponsable(){
    $nombreResponsable = readline("Ingrese Nombre del Responsable: ");
    $apellidoResponsable = readline("Ingrese Apellido del Responsable: ");
    $numeroLicencia= validaNumero("Ingrese numero de licencia del responsable: ");
    $obj_responsable= new ResponsableV();
    $obj_responsable->cargar(0, $nombreResponsable, $apellidoResponsable, $numeroLicencia);
    if($obj_responsable->insertar()){
        echo Color::getOKGREEN()."Se inserto correctamente el responsable en la BD \n".Color::getENDC();
    }else{
        echo Color::getWARNING()."Error no se inserto el responsable en la BD \n".Color::getENDC();
    }
}
function modificarResponsable($obj_responsable){
    $nombreResponsable = readline("Ingrese Nombre del Responsable: ");
    $apellidoResponsable = readline("Ingrese Apellido del Responsable: ");
    $numeroLicencia= readline("Ingrese numero de licencia del responsable: ");
    $obj_responsable->setNombre($nombreResponsable);
    $obj_responsable->setApellido($apellidoResponsable);
    $obj_responsable->setnumLicencia($numeroLicencia);

    if($obj_responsable->modificar()){
        echo  Color::getOKGREEN()."Se modifico correctamente el responsable en la BD \n".Color::getENDC();
    }else{
        echo  Color::getWARNING()."Error no se modifico el responsable en la BD \n".Color::getENDC();
    }
}
function borrarResponsable($numEmpleado, $obj_responsable){
    //verifico que no este referenciado en un viaje
    $obj_viaje = new Viaje();
    $arr = $obj_viaje -> listar("rnumeroempleado=".$numEmpleado);
    if(count($arr)==0){
        if($obj_responsable->eliminar()){ 
            echo Color::getOKGREEN()."Se borro correctamente el responsable en la BD\n".Color::getENDC();
        } else{
            echo Color::getWARNING()."Error no se borro el responsable en la BD, verifique no este asignado en algun viajes. \n".Color::getENDC();
        }
    }else{
        echo Color::getWARNING()."No se puede borrar el responsable porque esta relacionado a un viaje \n".Color::getENDC();
    }
  
}
/********************************* */
/***************** Funciones Viaje */
/********************************* */
function agregarViaje($obj_responsable,$obj_Empresa){ 
    $obj_Viaje = new Viaje();
    $destino = readline("Ingrese el destino: ");
    $lista = $obj_Viaje->listar("vdestino='".$destino."'");
    if(count($lista)>0){
        echo Color::getWARNING()."Ya existe un viaje con ese destino\n".Color::getENDC();
    }   else{
        $capacidad = validaNumero("Ingrese la capacidad del viaje: ");
        $importe=validaNumero("Ingrese el precio del viaje: ");
        $idayvuelta = validaSiNo("Ingrese S/N para 'ida y vuelta' ");
        $tipoAsiento =readline("Ingrese categoria de Asientos del viaje: ");
        
        $obj_Viaje->cargar(0,$destino, $capacidad, $obj_responsable,$obj_Empresa,$importe,$tipoAsiento,$idayvuelta);
       if( $obj_Viaje->insertar()){
        echo Color::getOKGREEN()."Se inserto correctamente el viaje en la BD\n".Color::getENDC();
        } else{
        echo Color::getWARNING().">rror no se inserto el viaje en la BD. \n".Color::getENDC();
        }
    }
   
 }

function modificarViaje($obj_viaje){
    $respuesta = validaSiNo("¿Conserva el destino? S|N");
    if($respuesta == "NO"){
        $destino = readline("Ingrese el destino: ");
        $lista = $obj_viaje->listar("vdestino='".$destino."'");

        if(count($lista)>0){
            echo Color::getWARNING()."Ya existe un viaje con ese destino\n".Color::getENDC();
        }else{
           $capacidad = validaNumero("Ingrese la capacidad del viaje: ");
           $importe=validaNumero("Ingrese el precio del viaje: ");
           $idayvuelta = validaSiNo("Ingrese S/N para 'ida y vuelta' ");
           $tipoAsiento =readline("Ingrese categoria de Asientos del viaje: ");
           $obj_viaje->setDestino($destino); 
           $obj_viaje->setcantMaxima($capacidad);
           $obj_viaje->setImporte($importe);
           $obj_viaje->setTipoAsiento($idayvuelta);
           $obj_viaje->setIdayvuelta($tipoAsiento);
           if($obj_viaje->modificarSinDelegados()){
            echo Color::getOKGREEN()."Se modifico correctamente el viaje en la BD\n".Color::getENDC();
            } else{
            echo Color::getWARNING()."Error no se modifico el viaje en la BD. \n".Color::getENDC();
            }
        }

    } else{
        //Mantengo el destino del viaje
        $capacidad = validaNumero("Ingrese la capacidad del viaje: ");
        $importe=validaNumero("Ingrese el precio del viaje: $");
        $idayvuelta = validaSiNo("Ingrese S/N para 'ida y vuelta' ");
        $tipoAsiento =readline("Ingrese categoria de Asientos del viaje: ");
        $obj_viaje->Buscar($obj_viaje->getidviaje()); ///asi carga el destino que ya estaba
        $obj_viaje->setcantMaxima($capacidad);
        $obj_viaje->setImporte($importe);
        $obj_viaje->setTipoAsiento($idayvuelta);
        $obj_viaje->setIdayvuelta($tipoAsiento);
        if($obj_viaje->modificarSinDelegados()){
            echo Color::getOKGREEN()."Se modifico correctamente el viaje en la BD\n".Color::getENDC();
        } else{
             echo Color::getWARNING()."Error no se modifico el viaje en la BD. \n".Color::getENDC();
        }
    }
    
   
}

function borrarViaje($obj_viaje){
    $obj_pasajero = new Pasajero();
    $lista = $obj_pasajero->listar("idviaje=".$obj_viaje->getidviaje());
    if(count($lista)>0){
        echo Color::getWARNING()."Error hay pasajeros asignados. \n".Color::getENDC();
    }else{
        if($obj_viaje->eliminar()){
            echo Color::getOKGREEN()."Se borro correctamente el viaje en la BD\n".Color::getENDC();
        } else{
        echo Color::getWARNING()."Error no se borro el viaje en la BD \n".Color::getENDC();
        }
    }
        
}

/********************************* */
/***************Funciones Pasajero */
/********************************* */
function agregarPasajero(){    
    $destino = readline("Ingrese Destino del pasajero:");
    $obj_viaje = new Viaje();

    $DatosViaje = $obj_viaje->listar("vdestino ='".$destino."'");
    if(count($DatosViaje) == 1){
    $obj_pasajero = new Pasajero();
    $obj_viaje = $DatosViaje[0];
    $idViaje = $obj_viaje->getidviaje();
    $cantAsientosTotal = $obj_viaje->getCantMaxima();

    $asientos = $obj_pasajero->listar("idviaje=".$idViaje);
    $cantAsientosOcupados = count($asientos);

    if(($cantAsientosTotal - $cantAsientosOcupados) > 0 ){
        $nombrePasajero = readline("Ingrese Nombre del Pasajero: ");
        $apellidoPasajero = readline("Ingrese Apellido del pasajero:");
        $dniPasajero= readline("Ingrese Dni del pasajero: ");
        $telefonoPasajero=validaNumero("Ingrese el telefono del pasajero:");

        $obj_pasajero->cargar($dniPasajero,$nombrePasajero, $apellidoPasajero,  $telefonoPasajero, $obj_viaje);
        if($obj_pasajero->insertar()){
            echo Color::getOKGREEN()."Se inserto correctamente el pasajero en la BD\n".Color::getENDC();;
        } else{
             echo Color::getWARNING()."Error no se inserto el pasajero en la BD. \n".Color::getENDC();
        }
     }else{
        echo Color::getWARNING()."No hay lugar en el viaje (Total Asientos:".$cantAsientosTotal.", Asientos Vendidos:".$cantAsientosOcupados.")\n".Color::getENDC();
    }
}else{
    echo Color::getWARNING()."No existe el viaje con destino ".$destino." revise el ABM de viaje para verificar que exista\n".Color::getENDC();
}
}

function  modificarPasajero( ){  
    $obj_pasajero = new Pasajero();
    $lista = $obj_pasajero->listar();
    if(count($lista)>0){
        imprime($lista);
        $dni = validaNumero("Ingrese Dni del pasajero:");
        $obj_pasajero->Buscar($dni);
        if($obj_pasajero->getNumDoc()!= ""){
            $nombrePasajero = readline("Ingrese Nombre del Pasajero: ");
            $apellidoPasajero = readline("Ingrese Apellido del pasajero: ");
            $telefonoPasajero=validaNumero("Ingrese el telefono del pasajero: ");
            $pasajero->setNombre($nombrePasajero);
            $pasajero->setApellido($apellidoPasajero);
            $pasajero->setTelefono($telefonoPasajero);
            if($obj_pasajero->modificarSoloDatosPersonales()){
                echo Color::getOKGREEN()."Se modifico correctamente el pasajero en la BD\n".Color::getENDC();
            } else{
            echo Color::getWARNING()."Error no se modifico el pasajero en la BD.\n".Color::getENDC();
            }


            $r = validaSiNo("¿Desea tambien cambiarlo de viaje? Pulse S/N\n");
        if($r=='SI'){
            $destino = readline("Ingrese nuevo destino: ");
            $obj_viaje = new Viaje();
            $DatosViaje = $obj_viaje->listar("vdestino ='".$destino."'");
            if(count($DatosViaje) == 1){
                $idviaje = $DatosViaje->getidviaje();
                $obj_viaje->Buscar($idviaje);
                $obj_pasajero->setViaje($obj_viaje);
                if($obj_pasajero->modificarConViaje()){
                    echo Color::getOKGREEN()."Se modifico correctamente el destino del pasajero en la BD\n".Color::getENDC();
                } else{
                echo Color::getWARNING()."Error no se modifico el pasajero en la BD. \n".Color::getENDC();
                }
            }else{
                echo Color::getWARNING()."Error no hay viajes con ese destino. \n".Color::getENDC();
            }
        }
        }else{
            echo Color::getWARNING()."No existe ese dni:".$dni."\n".Color::getENDC();
        }
    } else
        echo Color::getWARNING()."No pasajeros en el sistema\n".Color::getENDC();
}

function borrarPasajero(){
    $obj_pasajero = new Pasajero();
    $dni = validaNumero("Ingrese Dni del pasajero a eliminar ");

    $obj_pasajero->Buscar($dni);
    if($obj_pasajero->getNumDoc() != ""){
         if($obj_pasajero->eliminar()){
            echo Color::getWARNING()."Se borro correctamente el pasajero en la BD\n".Color::getENDC();
        } else{
        echo Color::getWARNING()."Error no se borro el pasajero en la BD. \n".Color::getENDC();
        }
     } else
     echo Color::getWARNING()."No existe ese pasajero dni:".$dni."\n".Color::getENDC();
    }
/********************************* */
/*************Funciones auxiliares */
/********************************* */

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