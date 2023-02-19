<?php
include("head.php");
include("header.php");

if (isset($_GET['id'])){
    $Curp = VarClean($_GET['id']);
    $IdGrupo = Cliente_IdGrupo($Curp);
    echo '<input type="hidden" name="IdSucursal" id="IdSucursal" value="'.$IdSucursal.'">';

    $sql = "select * from clientes where curp='".$Curp."'";
    // echo $sql;
    $rc = $db1->query($sql);        
    if ($db1->query($sql) == TRUE){
        if($f = $rc -> fetch_array())
        {
            
            echo "<div id='ClienteForm'>";
            
            echo "<div class='row'>";
                echo '
                <div class="form-group col-sm btn " style="background-color:#e6e3e3;">';

              
                $fotoFile = 'fotos/'.$f['curp'].'.jpg';
                if (is_file($fotoFile)){
                    echo "<img name='foto' id='foto'  src='".$fotoFile."' style='width:150px; height:150px; border-radius:5px;'>";

                } else {
                    echo "<img name='foto' id='foto' src='iconos/user.png' style='width:150px; height:150px;'>";
                }


                 echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";


                echo '
                    <label for="VFile" style="font-size:8pt;">Fotografia:</label>
                    ';    
                        echo "<input type='file' id='VFile' name='VFile' class='form-control' style='font-size:9pt; margin-top:-7px;' accept='.jpg'>";
                 echo "</form>";



                

               

                echo '
                </div>';

                echo '
                <div class="form-group col-md">';

                echo '<span
                style="
                margin: 10px;
                background-color: #17a2b8;
                padding: 7px;
                border-radius: 6px;
                color: white;
                "
                ><label>CURP:</label>'.$Curp.'</span><br><br>';

                echo '
                    <label for="exampleFormControlInput1">Nombre del Cliente:</label>
                    <input style="
                        background-color: orange;
                        color: white;
                        font-weight: bold;
                        font-size: large;
                    " type="text" class="form-control" name="nombre" id="nombre" placeholder="" value="'.$f['nombre'].'">
                ';


                       

                echo '
                </div>';


               
            echo "</div>";




            echo "<div class='row'>";
                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Domicilio:</label>
                    <textarea class="form-control" name="domicilio" id="domicilio" placeholder="" style="font-size:8pt;">'.$f['domicilio'].'</textarea>
                </div>';


                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Municipio:</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="" value="'.$f['municipio'].'">
                </div>';


                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Estado:</label>
                    <input type="text" class="form-control" name="estado" id="estado" placeholder="" value="'.$f['estado'].'">
                </div>';
            echo "</div>";

         




            echo "<div class='row'>";
                echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">IFE:</label>
                            <input type="text" class="form-control" name="ife" id="ife" placeholder="" value="'.$f['IFE'].'">
                        </div>';


                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Correo electronico:</label>
                    <input type="text" class="form-control" name="correo" id="correo" placeholder="" value="'.$f['correo'].'">
                </div>';


                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Estado Civil:</label>';

                // echo '<input type="text" class="form-control" name="estadocivil" id="estadocivil" placeholder="" value="'.$f['estadocivil'].'">';
                echo '<select id="estadocivil" name="estadocivil " class="form-control">';
                echo '<option value="SOLTERO">Soltero(a)</option>';
                echo '<option value="CASADO">Casado(a)</option>';
                echo '<option value="UNION LIBRE">Union Libre</option>';
                echo '<option value="VIUDEZ">Viudo(a)</option>';
                echo '</select>';

                echo '</div>';
            echo "</div>";


            echo "<hr><div class='row'>";
                echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fechadenacimiento" id="fechadenacimiento" placeholder="" value="'.$f['fechadenacimiento'].'">
                        </div>';


                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Profesion:</label>
                    <input type="text" class="form-control" name="profesion" id="profesion" placeholder="" value="'.$f['profesion'].'">
                </div>';



                echo '
                <div class="form-group col-sm">
                    <label for="sexo">Sexo: '.$f['sexo'].'</label>';
                    echo '
                    <select class="form-control" id="sexo">';

                    if ($f['sexo']=='mujer'){
                        echo '<option value="mujer" selected>mujer</option>';
                        echo '<option value="hombre" >hombre</option>';
                    } else {
                        echo '<option value="mujer" >mujer</option>';
                        echo '<option value="hombre" selected >hombre</option>';

                    }

                  echo '</select>';

                echo '                    
                </div>';


                
                echo '
                <div class="form-group col-sm">
                    <label for="exampleFormControlInput1">Telefono:</label>
                    <input type="text" class="form-control bg-warning" name="telefono" id="telefono" placeholder="" value="'.$f['telefono'].'">
                </div>';


            echo "</div>";       
            
            
            //estudio socioeconomico

            echo '
            <div id="accordion">
                <div class="card">';

                 echo '
                    <div class="card-header" id="headingOne" style="
                    background-color:#cecece;
                    color:black;
                    ">
                    <h5 class="mb-0">
                    <button class="btn " data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" 
                        style=";width:100%;"
                        onclick="checkTot();"
                        
                        >
                       <table border=0 style="
                            width:100%;
                            margin-top: -12px;
                            margin-bottom: -12px;
                       "><tr><td align=left>
                            <b>Informacion Socioeconomica </b></td>
                        <td width=30%>
                        <div id="InfoTot">
                            <table class="tabla">
                                    <th>Ingresos </th><th>Gastos</th><th>Ingresos Dispoinibles</th>
                                    <tr>
                                        <td ><div class="number" id="TotIngresos">0</div> </td>
                                        <td ><div class="number" id="TotGastos">0</div> </td>
                                        <td ><div class="number" id="TotIngresosDisponibles" style="font-weight: bold;">0</div> </td>
                                        
                                        
                                    </tr>
                            </table>
                        </div>
                        </td>
                      
                        </tr></table>
                    </button>
                    </h5>
                </div>
            
                <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion"
                style="
                background-color: #e3e2e3;"
                >
                    <div class="card-body">
                   ';



                   echo "<div class='row'>"; // ---------------------------------------- r  o  w --- begin
                   echo '
                   <div class="form-group col-sm">
                       <label for="exampleFormControlInput1">Empresa donde trabaja:</label>
                       <input type="text" class="form-control" name="trabajo_nombre" id="trabajo_nombre" placeholder="" value="'.$f['trabajo_nombre'].'">
                   </div>';
   
   
                   echo '
                   <div class="form-group col-sm">
                       <label for="exampleFormControlInput1">Domicilio donde trabaja:</label>
                       <textarea class="form-control" name="trabajo_domicilio" id="trabajo_domicilio">'.$f['trabajo_domicilio'].'</textarea>
                   </div>';
   
   
                   echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Telefono del trabajo:</label>
                            <input type="text" class="form-control" name="trabajo_telefono" id="trabajo_telefono" placeholder="" value="'.$f['trabajo_telefono'].'">
                        </div>';
                    echo "</div>"; // ---------------------------------------- r  o  w --- end


                    echo "<div class='row'>"; // ---------------------------------------- r  o  w --- begin
                    echo '
                    <div class="form-group col-sm">
                        <label for="exampleFormControlInput1">Giro de la Empresa:</label>
                        <input type="text" class="form-control" name="trabajo_giro" id="trabajo_giro" placeholder="" value="'.$f['trabajo_giro'].'">
                    </div>';
    
    
                    echo '
                    <div class="form-group col-sm">
                        <label for="exampleFormControlInput1">Puesto:</label>
                        <input type="text" class="form-control" name="trabajo_puesto" id="trabajo_puesto" value="'.$f['trabajo_puesto'].'">
                    </div>';
    
    
                    echo '
                         <div class="form-group col-sm">
                             <label for="exampleFormControlInput1">Salario:</label>
                             <input onchange="checkTot();" type="number" class="form-control" name="trabajo_salario" id="trabajo_salario" placeholder="" value="'.$f['trabajo_salario'].'">
                         </div>';
                     echo "</div>"; // ---------------------------------------- r  o  w --- end




                     echo "<div class='row'>"; // ---------------------------------------- r  o  w --- begin
                     echo '
                     <div class="form-group col-sm">
                         <label for="exampleFormControlInput1">¿Cuantas Personas dependen de el?:</label>
                         <input type="number" class="form-control" name="socio_dependen" id="socio_dependen" placeholder="" value="'.$f['socio_dependen'].'">
                     </div>';
     
     
                     echo '
                     <div class="form-group col-sm">
                         <label for="exampleFormControlInput1">Casa Propia?:</label>
                         <select name="socio_casapropia" id="socio_casapropia"  class="form-control">
                         ';

                          if ($f['socio_casapropia'] =='SI'){
                            echo '<option class="form-control" value="SI" selected>SI</option>';
                            echo '<option class="form-control" value="NO" >NO</option>';
                                
                          } else {
                            echo '<option class="form-control" value="SI" >SI</option>';
                            echo '<option class="form-control" value="NO" selected >NO</option>';
                            
                          }

                    echo '</select>                         
                     </div>';
     
     
                  

                     echo '
                     <div class="form-group col-sm" >
                         <label for="exampleFormControlInput1">Negocio Propio?:</label>
                         <select name="minegocio_propio" id="minegocio_propio"  class="form-control" style="background-color:#e8d1f0;"
                         onchange="checkMiNegocio();";
                         >
                         ';

                          if ($f['minegocio_propio'] =='SI'){
                            echo '<option class="form-control" value="SI" selected>SI</option>';
                            echo '<option class="form-control" value="NO" >NO</option>';
                                
                          } else {
                            echo '<option class="form-control" value="SI" >SI</option>';
                            echo '<option class="form-control" value="NO" selected >NO</option>';
                            
                          }

                    echo '</select>                         
                     </div>';     

                    echo "</div>"; // ---------------------------------------- r  o  w --- end


                    //Opciones si tiene negocio propio
                    echo '<div id="DivMiNegocio" style="display:none;">';
                        echo "<div class='row' style='
                            background-color: #e8d1f0;
                            border-radius: 5px;
                        '>"; // ---------------------------------------- r  o  w --- begin
                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Giro del negocio?</label>
                            <input type="text" class="form-control" name="minegocio_giro" id="minegocio_giro" placeholder="" value="'.$f['minegocio_giro'].'">
                        </div>';

                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Ingresos por su negocio:</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="minegocio_ingresos" id="minegocio_ingresos" placeholder="" value="'.$f['minegocio_ingresos'].'">
                        </div>';



                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Telefono de mi negocio:</label>
                            <input type="text" class="form-control" name="minegocio_telefono" id="minegocio_telefono" placeholder="" value="'.$f['minegocio_telefono'].'">
                        </div>';
                        
                        echo "</div>"; // ---------------------------------------- r  o  w --- end


                        echo "<div class='row' style='
                        background-color: #e8d1f0;
                        border-radius: 5px;
                            '>"; // ---------------------------------------- r  o  w --- begin
                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">Numero de empleados?</label>
                                <input type="number" class="form-control" name="minegocio_empleados" id="minegocio_empleados" placeholder="" value="'.$f['minegocio_empleados'].'">
                            </div>';

                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">Domicilio del negocio:</label>
                                <textarea class="form-control" name="minegocio_domicilio" id="minegocio_domicilio">'.$f['minegocio_domicilio'].'</textarea>
                            </div>';


                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">Antiguedad del negocio:</label>
                                <input type="text" class="form-control" name="minegocio_antiguedad" id="minegocio_antiguedad" placeholder="" value="'.$f['minegocio_antiguedad'].'">
                            </div>';


                            
                            echo "</div>"; // ---------------------------------------- r  o  w --- end





                                                
                    echo '</div>';


                    echo "
                 
                    <div class='row' style='
           
                        '>"; // ---------------------------------------- r  o  w --- begin
                        echo '
                      
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Cuantos hijos?</label>
                            <input type="number" class="form-control" name="socio_hijos" id="socio_hijos" placeholder="" value="'.$f['socio_hijos'].'">
                        </div><br>';
                    echo "</div>";


                    echo "
                    <hr><h5>Gastos mensuales: </h5><br>
                    <div class='row' style='
           
                        '>"; // ---------------------------------------- r  o  w --- begin
                        echo '
                      
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">¿cuanto gasta en el hogar?</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="socio_hogar" id="socio_hogar" placeholder="" value="'.$f['socio_hogar'].'">
                        </div><br>';

                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Gasto Renta?:</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="socio_renta" id="socio_renta" value="'.$f['socio_renta'].'">
                        </div>';


                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">Gasto de agua y luz?:</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="socio_agualuz" id="socio_agualuz" placeholder="" value="'.$f['socio_agualuz'].'">
                        </div>';

                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">otros gastos?:</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="socio_drenaje" id="socio_drenaje" placeholder="" value="'.$f['socio_drenaje'].'">
                        </div>';


                        
                        echo "</div>"; // ---------------------------------------- r  o  w --- end       



                   echo '
                    </div>';

                   


                echo '</div>';

                echo '
                <div class="card">
                <div class="card-header" id="headingTwo" style="
                    background-color: #5cbfbf;
                ">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                    style="
                    display: block;
                    color: #137d7d;
                    width: 100%;
                    font-weight: bold;
                    "
                    >
                    

                    <table border=0 style="
                    width:100%;
                    margin-top: -12px;
                    margin-bottom: -12px;
               "><tr><td align=left>
                    <b>Referencias </b></td>
                <td width=30%>
                <div id="InfoReferencias">
                   
                </div>
                </td>
               
                </tr></table>


                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="
                background-color: #97dddd;
                ">
                  <div class="card-body">';



                    echo "
                
                    <div class='row' style='
           
                        '>"; // ---------------------------------------- r  o  w --- begin
                        echo '
                      
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">(1) Nombre </label>
                            <input onchange="checkTot();" type="text" class="form-control" name="refc1_nombre" id="refc1_nombre" placeholder="" value="'.$f['refc1_nombre'].'">
                        </div><br>';

                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">(1) Telefono:</label>
                            <input onchange="checkTot();" type="tel" class="form-control" name="refc1_tel" id="refc1_tel" value="'.$f['refc1_tel'].'">
                        </div>';


                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">(1) Domicilio</label>
                            <input onchange="checkTot();" type="text" class="form-control" name="refc1_domicilio" id="refc1_domicilio" placeholder="" value="'.$f['refc1_domicilio'].'">
                        </div>';

                        echo '
                        <div class="form-group col-sm">
                            <label for="exampleFormControlInput1">(1) Años de conocerlo</label>
                            <input onchange="checkTot();" type="number" class="form-control" name="refc1_antiguedad" id="refc1_antiguedad" placeholder="" value="'.$f['refc1_antiguedad'].'">
                        </div>';


                        
                        echo "</div>"; // ---------------------------------------- r  o  w --- end     
                        
                        



                        echo "
                        <hr>
                        <div class='row' style='
               
                            '>"; // ---------------------------------------- r  o  w --- begin
                            echo '
                          
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">(2) Nombre </label>
                                <input type="text" class="form-control" name="refc2_nombre" id="refc2_nombre" placeholder="" value="'.$f['refc2_nombre'].'">
                            </div><br>';
    
                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">(2) Telefono:</label>
                                <input  type="tel" class="form-control" name="refc2_tel" id="refc2_tel" value="'.$f['refc2_tel'].'">
                            </div>';
    
    
                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">(2) Domicilio</label>
                                <input type="text" class="form-control" name="refc2_domicilio" id="refc2_domicilio" placeholder="" value="'.$f['refc2_domicilio'].'">
                            </div>';
    
                            echo '
                            <div class="form-group col-sm">
                                <label for="exampleFormControlInput1">(2) Años de conocerlo</label>
                                <input type="number" class="form-control" name="refc2_antiguedad" id="refc2_antiguedad" placeholder="" value="'.$f['refc2_antiguedad'].'">
                            </div>';
    
    
                            
                            echo "</div>"; // ---------------------------------------- r  o  w --- end   



                            echo "
                            <hr>
                            <div class='row' style='
                   
                                '>"; // ---------------------------------------- r  o  w --- begin
                                echo '
                              
                                <div class="form-group col-sm">
                                    <label for="exampleFormControlInput1">(3) Nombre </label>
                                    <input  type="text" class="form-control" name="refc3_nombre" id="refc3_nombre" placeholder="" value="'.$f['refc3_nombre'].'">
                                </div><br>';
        
                                echo '
                                <div class="form-group col-sm">
                                    <label for="exampleFormControlInput1">(3) Telefono:</label>
                                    <input  type="tel" class="form-control" name="refc3_tel" id="refc3_tel" value="'.$f['refc3_tel'].'">
                                </div>';
        
        
                                echo '
                                <div class="form-group col-sm">
                                    <label for="exampleFormControlInput1">(3) Domicilio</label>
                                    <input  type="text" class="form-control" name="refc3_domicilio" id="refc3_domicilio" placeholder="" value="'.$f['refc3_domicilio'].'">
                                </div>';
        
                                echo '
                                <div class="form-group col-sm">
                                    <label for="exampleFormControlInput1">(3) Años de conocerlo</label>
                                    <input  type="number" class="form-control" name="refc3_antiguedad" id="refc3_antiguedad" placeholder="" value="'.$f['refc3_antiguedad'].'">
                                </div>';
        
        
                                
                                echo "</div>"; // ---------------------------------------- r  o  w --- end   


                  echo '
                
                  </div>
                </div>
              </div>';

            

        echo '</div>

        
        
        </div>';

        
        echo '
        <div class="form-group col-sm">               
        <button style="font-size:14pt;"  class="btn btn-success" onclick="CrearSolicitud();">
        
        <table width=100%><tr><td><img src="iconos/cuentaindividual.png" style="widt:28px"></td>
        <td><b>Crear </b><br>solicitud individual</button></td></tr></table>
        
        </button>
        </div>

       ';
       
        echo "
        <hr>
        <div class='row' style='
           
            background-color: #ffc10752;
            padding: 8px;
            '>
            
            "; // ---------------------------------------- r  o  w --- begin
            echo '
          
            <div class="form-group col-sm">
                <label for="exampleFormControlInput1">Grupo</label>
                <select name="grupo" id="grupo" class="form-control bg-warning">
                ';
                
            // echo '<option  class="form-control" value="" selected></option>';

            if ($IdSucursal == 0){
                $sqlG = "select g.*, (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal from grupos_html g";    
            } else {
                $sqlG = "select g.*, (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal from grupos_html g where IdSucursal='".$IdSucursal."'";
            }
            
            $r2= $db1 -> query($sqlG);
            $ninguno = '';
            while($f2 = $r2 -> fetch_array()) {               
                if ($f2['IdGrupo']==$f['IdGrupo']){
                    $ninguno = $f2['IdGrupo'];
                    echo '<option  class="form-control" value="'.$f2['IdGrupo'].'" selected>'.$f2['Grupo'].' ('.$f2['Sucursal'].')</option>';
                } else {
                    echo '<option  class="form-control" value="'.$f2['IdGrupo'].'" >'.$f2['Grupo'].' ('.$f2['Sucursal'].')</option>';
                }
            }
            echo '<option  class="form-control" value="" >Ningun grupo</option>';
            if ($ninguno== ''){
                echo '<option  class="form-control" value="" selected >Ningun grupo</option>';
            }


            echo '</select>
            </div><br>';

            echo '
            <div class="form-group col-sm">
                <label for="exampleFormControlInput1">Cargo en el grupo</label>';
            // echo '
            //     <input onchange="checkTot();" type="tel" class="form-control" name="grupo_cargo" id="grupo_cargo" value="'.$f['grupo_cargo'].'">'
            //     ;
            
            // echo $f['grupo_cargo'];
            echo '<select name="grupo_cargo" id="grupo_cargo" class="form-control">';

            if ($f['grupo_cargo']=='PRESIDENTE') {
                echo '<option value="PRESIDENTE" selected>Presidente</option>';
            } else {
                echo '<option value="PRESIDENTE">Presidente</option>';
            }
            
            if ($f['grupo_cargo']=='SECRETARIO') {
                echo '<option value="SECRETARIO" selected>Secretario</option>';
            } else {
                echo '<option value="SECRETARIO">Secretario</option>';
            }

            if ($f['grupo_cargo']=='TESORERO') {
                echo '<option value="TESORERO" selected>Tesorero</option>';
            }else {
                echo '<option value="TESORERO">Tesorero</option>';
            }
            
            if ($f['grupo_cargo']=='MIEMBRO') {
                echo '<option value="MIEMBRO" selected>Miembro del grupo</option>';
            } else {
                echo '<option value="MIEMBRO" >Miembro del grupo</option>';
            }


            echo '</select>';

            
            echo '
            </div>';

            
            echo '
           

            <div class="form-group col-sm">               
            <button style="font-size:14pt;"  class="btn btn-success" onclick="CrearSolicitud_grupo();">
            <table width=100%><tr><td><img src="iconos/cuentagrupal.png" style="widt:28px"></td>
            <td><b>Crear </b><br>solicitud Grupal</button></td></tr></table>
            </div>';

       
            
            echo "</div>"; // ---------------------------------------- r  o  w --- end   

         
         


            
        echo "
        <br><br>
        <div class='row' style='
        background-color:#ddd; padding:10px;

            '>"; // ---------------------------------------- r  o  w --- begin
     

            echo '<br>
            <div class="form-group col-sm">               
               <button  style="font-size:14pt;" class="btn btn-success" onclick="Guardar();">Guardar </button>
            </div>';


            echo '
            <div class="form-group col-sm">               
               <a  style="font-size:14pt;" class="btn btn-primary" href="print_carnet.php?id='.$_GET['id'].'">Imprimir Registro </a>
            </div>';

          
           
       echo "</div>"; // ---------------------------------------- r  o  w --- end   


         echo "
        <br><br>
        <div class='row' style='

            '>"; // ---------------------------------------- r  o  w --- begin
     
            echo '<div class="form-group col-sm" style="background-color: #e8e8e8;
                margin: 10px;
                border-top-style: dashed;
                border-top-color: gray;
                border-top-width: 1px;"> ';
            echo "<h2>Historial:</h2>";

            $sqlX = "
            select 
h.nosol,
(select fechacontrato from cuentas where nosol=h.nosol) as Fecha,
(select cuentas.cantidad from cuentas where nosol=h.nosol) as Cantidad,

h.idgrupo,
(select grupo from grupos where idgrupo=h.idgrupo) as grupo,
h.grupo_cargo,
h.idsucursal,
(select Sucursal from sucursales where IdSucursal=h.IdSucursal) as suc

from historial_contrato h where curp='".$Curp."'

            ";   
// echo $sqlX; 
            $rx = $db1->query($sqlX);    
            // var_dump($rx);
            if ($db1->query($sqlX) == TRUE){        
            echo "<table class='tabla'>";
            echo "
                <th style='text-align:center;'>NoSol</th>
                
                <th style='text-align:center;'>Cantidad</th>
                <th style='text-align:center;'>Fecha del Contrato</th>
                <th style='text-align:center;'>Grupo</th>
                <th style='text-align:center;'>Sucursal</th>
            ";
            while($fx= $rx -> fetch_array()) {  
          
                echo "<tr>";
            
                
                echo "<td><a href='app_solicitud.php?n=".$fx['nosol']."' title='Haga clic aqui para ver la solicitud'>".$fx['nosol']."<a></td>";
               
                echo "<td>".Pesos($fx['Cantidad'])."</td>";
                echo "<td>".$fx['Fecha']."</td>";
                echo "<td>".$fx['grupo']." ".$fx['grupo_cargo']."</td>";
                echo "<td>".SucursalName($fx['suc'])."</td>";
                echo "</tr>";
            }
            unset($fx, $rx, $sqlX);

            echo "</table>";
            }
            echo '</div>';
           
       echo "</div>"; // ---------------------------------------- r  o  w --- end   


            echo '                    
            </div>';
        echo "</div>";          
            echo "</div>";




      

        } else {
            // Error("No existe ningun usuario con esta curp ".$Curp);
            MsgBox("No hay registro con el CURP=".$Curp."<br><b>¿Desea darlo de alta?","app_carnet.php?new=".$Curp."","SI" ,"NO" , 1); 

        }
        

    } else {
        Error("Error al consultar al usuario ".$Curp);
    }





} else {
    if (isset($_GET['new'])){
        if ($_GET['cuestion']== 'FALSE'){
            echo '<script>
            window.location.assign("r.php?id=2")
            </script>';
        } else {
            //Agregar nuevo registro

            $txtCurp  = VarClean($_GET['new']);
            $sqlIn= "INSERT INTO clientes (curp) VALUES('".$txtCurp."')";
            if ($db1->query($sqlIn) == TRUE){                
                MsgBox("Guardado correctamente ".$txtCurp."","app_carnet.php?id=".$txtCurp, "Continuar Captura");
            } else {
                Toast("Error al guardar ".$txtCurp." ",2,"");
        
            }
        }

    } else {
        Error("Parametros incorrectos");
    }
}

?>

<script>
function checkMiNegocio(){
    NegocioQuest = $('#minegocio_propio').val();
    if (NegocioQuest=='SI'){
        $('#DivMiNegocio').show();
    } else {
        $('#DivMiNegocio').hide();
    }
}
checkMiNegocio();

function checkTot(){
    Ingresos = parseInt($('#trabajo_salario').val()) +   parseInt($('#minegocio_ingresos').val());
    $('#TotIngresos').html('$' + Ingresos);
    $('#TotIngresos').formatCurrency();
    
    Gastos = parseInt($('#socio_hogar').val()) +   parseInt($('#socio_renta').val()) +  parseInt($('#socio_agualuz').val()) +  parseInt($('#socio_drenaje').val());    
    $('#TotGastos').html('$' +Gastos);
    $('#TotGastos').formatCurrency();
    
    IngresoDisponible = Ingresos - Gastos;
    $('#TotIngresosDisponibles').html('$' +IngresoDisponible);    
    $('#TotIngresosDisponibles').formatCurrency();
    if (IngresoDisponible<=0) {
        $("#TotIngresosDisponibles").css("color","red");
    } else {
        $("#TotIngresosDisponibles").css("color","green");
    }
    

}

checkTot();



function Guardar(){
   //Variables
   IdCliente = '<?php echo $Curp; ?>';
   Nombre = $('#nombre').val();
   Domicilio = $('#domicilio').val();
   Municipio = $('#municipio').val();
   Estado = $('#estado').val();
   IFE = $('#ife').val();
   Correo = $('#correo').val();
   EstadoCivil = $('#estadocivil').val();
   FechaDeNacimiento = $('#fechadenacimiento').val();
   Profesion = $('#profesion').val();
   Sexo = $('#sexo').val();    
   Telefono = $('#telefono').val();
   IdSucursal = $('#IdSucursal').val();
   
   
   trabajo_nombre = $('#trabajo_nombre').val();

   trabajo_domicilio = $('#trabajo_domicilio').val();
   trabajo_telefono = $('#trabajo_telefono').val();
   trabajo_giro = $('#trabajo_giro').val();
   trabajo_puesto = $('#trabajo_puesto').val();
   trabajo_salario = $('#trabajo_salario').val();
   socio_dependen = $('#socio_dependen').val();
   socio_casapropia = $('#socio_casapropia').val();
   minegocio_propio = $('#minegocio_propio').val();
   minegocio_giro = $('#minegocio_giro').val();
   minegocio_ingresos = $('#minegocio_ingresos').val();
   minegocio_telefono = $('#minegocio_telefono').val();
   minegocio_empleados = $('#minegocio_empleados').val();
   minegocio_domicilio = $('#minegocio_domicilio').val();
   minegocio_antiguedad = $('#minegocio_antiguedad').val();

   socio_hijos = $('#socio_hijos').val();
   socio_hogar = $('#socio_hogar').val();
   socio_renta = $('#socio_renta').val();
   socio_agualuz = $('#socio_agualuz').val();
   socio_drenaje = $('#socio_drenaje').val();

   refc1_nombre = $('#refc1_nombre').val();
   refc1_tel = $('#refc1_tel').val();
   refc1_domicilio = $('#refc1_domicilio').val();
   refc1_antiguedad = $('#refc1_antiguedad').val();
  

   refc2_nombre = $('#refc2_nombre').val();
   refc2_tel = $('#refc2_tel').val();
   refc2_domicilio = $('#refc2_domicilio').val();
   refc2_antiguedad = $('#refc2_antiguedad').val();
  

   refc3_nombre = $('#refc3_nombre').val();
   refc3_tel = $('#refc3_tel').val();
   refc3_domicilio = $('#refc3_domicilio').val();
   refc3_antiguedad = $('#refc3_antiguedad').val();

   grupo = $('#grupo').val();
   grupo_cargo = $('#grupo_cargo').val();

   $('#PreLoader').show();
            $.ajax({
                url: 'app_carnet_save.php',
                type: 'post',
                data: {
                    IdUser: '<?php echo $RinteraUser; ?>',         
                    IdCliente: IdCliente,
                    Nombre : Nombre,  
                    Domicilio : Domicilio,
                    Municipio : Municipio,
                    Estado:  Estado,
                    IFE : IFE, 
                    Correo : Correo, 
                    EstadoCivil : EstadoCivil,
                    FechaDeNacimiento : FechaDeNacimiento,
                    Profesion : Profesion,
                    Sexo : Sexo,
                    Telefono : Telefono, 
                    trabajo_nombre : trabajo_nombre,
                    trabajo_domicilio: trabajo_domicilio,
                    trabajo_telefono : trabajo_telefono,
                    trabajo_giro: trabajo_giro,
                    trabajo_puesto: trabajo_puesto,
                    trabajo_salario: trabajo_salario,
                    socio_dependen: socio_dependen,
                    socio_casapropia:socio_casapropia,
                    minegocio_propio:minegocio_propio,
                    minegocio_giro:minegocio_giro,
                    minegocio_ingresos:minegocio_ingresos,
                    minegocio_telefono:minegocio_telefono,
                    minegocio_empleados:minegocio_empleados,
                    minegocio_domicilio:minegocio_domicilio,
                    minegocio_antiguedad:minegocio_antiguedad,
                    socio_hijos: socio_hijos, 
                    socio_hogar: socio_hogar,
                    socio_renta: socio_renta,
                    socio_agualuz: socio_agualuz,
                    socio_drenaje: socio_drenaje,
                    refc1_nombre:refc1_nombre,
                    refc1_tel:refc1_tel,
                    refc1_domicilio:refc1_domicilio,
                    refc1_antiguedad: refc1_antiguedad,       
                    refc2_nombre: refc2_nombre,
                    refc2_tel: refc2_tel,
                    refc2_domicilio : refc2_domicilio,
                    refc2_antiguedad : refc2_antiguedad,
                    refc3_nombre: refc3_nombre,
                    refc3_tel:refc3_tel,
                    refc3_domicilio:refc3_domicilio,
                    refc3_antiguedad:refc3_antiguedad,
                    grupo : grupo,
                    grupo_cargo:grupo_cargo,
                    IdSucursal:IdSucursal
                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}



function GuardarFoto(){    
    Curp = '<?php echo $Curp; ?>';
    $('#VFile').html($('#VFile').val());        
    var formData = new FormData(document.getElementById('VForm'));        
        formData.append('Curp',  Curp);
    $('#progressbar').show();
    $.ajax({
    url: 'app_carnet_save_foto.php',
    type: 'post',
    dataType: 'html',
    data: formData,             
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        // console.log('Cargando..');
    },
    success:function(data){
        // console.log(data);
        $('#R').html(data);
        $('#progressbar').hide();
    }
});
}


function CrearSolicitud(){
    IdCliente = '<?php echo VarClean($_GET['id']); ?>';  
    IdSucursal = '<?php echo $IdSucursal ?>';  
    IdGrupo = $('#grupo').val();
    Cargo = $('#cargo').val();
    TipoCredito='Individual';
   $('#PreLoader').show();
            $.ajax({
                url: 'app_dat_crearsol.php',
                type: 'post',
                data: {IdCliente:IdCliente, IdSucursal:IdSucursal, TipoCredito:TipoCredito,
                    IdGrupo:IdGrupo, Cargo:Cargo
                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}

function CrearSolicitud_grupo(){
    IdCliente = '<?php echo VarClean($_GET['id']); ?>';  
    IdSucursal = '<?php echo $IdSucursal ?>';  
    IdGrupo = $('#grupo').val();
    Cargo = $('#grupo_cargo').val();
    console.log(Cargo);
    TipoCredito='GRUPAL';
   $('#PreLoader').show();
            $.ajax({
                url: 'app_dat_crearsol2.php',
                type: 'post',
                data: {IdCliente:IdCliente, IdSucursal:IdSucursal, TipoCredito:TipoCredito,
                    IdGrupo:IdGrupo, Cargo:Cargo},
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}


function ActualizaFoto(){
    d = new Date();    
    Curp = "<?php if (isset($_GET['id'])) {echo $_GET['id'].'.jpg';} else { echo "iconos/user.png";}?>";    
    src='fotos/'+Curp+'?';
    $("#foto").attr("src",src+d.getTime());
}
</script>


<?php
include("footer.php");
?>