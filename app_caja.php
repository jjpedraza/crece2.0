    <?php
include("head.php");
include("header.php");
?>
<script>$('body').css('background-color','#d0cdcdab');</script>

<div id='DivQuien' style='
padding: 5px;
background-color: #79284a;
'>
    <table width=100%>
    <tr><td align=center valign=top>
        <input id='NoSol' placeholder='No. de Contrato' type="text" list="contratos"
         style="
            width: 100%;
            height: 50px;
            border-width: 0px;
            border-radius: 5px;
            text-align: center;
            font-size: 18pt;
            background-color: #28a745;
            color: white;
            font-weight: bold;
        "
        
        >
    </td><td width=50px align=center valign=top>
        <button onclick='CargaContrato(0);' class='btn btn-success' style='
        height:50px;
        '>Entrar</button>
    </td></tr>
    </table>
    <div id='rdata' style='display:none;'></div>
</div>

<div id='CajaInfo'>

</div>

<div id='CajaPago'>
    <div id='CajaPago_recibe'></div>
    <div id='CajaPago_distribucion'></div>
    <div id='CajaAhorro'>    
        
       
    </div>

</div>


<script>
function Clientes(){        
    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_datindex.php',
        type: 'post',        
        data: {
            
        },
    success: function(data){
        $('#rdata').html(data);                
        $('#PreLoader').hide();
        
    }
    });




            
}
Clientes();
var btn = document.getElementById("NoSol");
btn.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        CargaContrato(0);
    }
});  
function CargaContrato(n){

$('#CajaPago').html('<div id="CajaPago_recibe"></div><div id="CajaPago_distribucion"></div><div id="CajaAhorro"></div>');

    NoSol = $('#NoSol').val();
    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_contrato.php',
        type: 'post',        
        data: {
            NoSol:NoSol, n:n
            
        },
    success: function(data){
        $('#CajaInfo').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  


function CargaContrato_full(n){
    NoSol = $('#NoSol').val();
    mode = 'full';
    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_contrato.php',
        type: 'post',        
        data: {
            NoSol:NoSol, n:n, mode:mode
            
        },
    success: function(data){
        $('#CajaInfo').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  

function CajaComponents(n){
    $('#CajaPago').html('<div id="CajaPago_recibe"></div><div id="CajaPago_distribucion"></div><div id="CajaAhorro"></div>');
    NoSol = $('#NoSol').val();
    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_component.php',
        type: 'post',        
        data: {
            NoSol:NoSol, n:n
            
        },
    success: function(data){
        $('#CajaPago_recibe').html(data);                
        $('#PreLoader').hide();
        
    }
    });
    AhorroDiv();

}  



function RepartirPago(){
    NoSol = $('#NoSol').val();
    recibe = $('#CantidadRecibida').val();

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_repartir.php',
        type: 'post',        
        data: {
            NoSol:NoSol, recibe:recibe
            
        },
    success: function(data){
        $('#CajaPago_distribucion').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  


function Pagar(){
    NoSol = $('#NoSol').val();
    recibe = $('#CantidadRecibida').val();

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_pagar.php',
        type: 'post',        
        data: {
            NoSol:NoSol, recibe:recibe
            
        },
    success: function(data){
        $('#CajaPago_distribucion').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  



function AhorroDiv(){
    NoSol = $('#NoSol').val();
    

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_ahorro.php',
        type: 'post',        
        data: {
            NoSol:NoSol
            
        },
    success: function(data){
        $('#CajaAhorro').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  

    
function Ahorrar(){
    NoSol = $('#NoSol').val();
    CantidadAhorro = $('#CantidadAhorro').val();

    // console.log('Ahorrar');

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_ahorrar.php',
        type: 'post',        
        data: {
            NoSol:NoSol, CantidadAhorro:CantidadAhorro
            
        },
    success: function(data){
        $('#R').html(data);                
        $('#PreLoader').hide();
        
    }
    });


}  


function Ahorrar_retiro(){
    NoSol = $('#NoSol').val();
    CantidadAhorro_retirar = $('#CantidadAhorro_retirar').val();
    

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_ahorrar_retiro.php',
        type: 'post',        
        data: {
            NoSol:NoSol, CantidadAhorro_retirar:CantidadAhorro_retirar
            
        },
    success: function(data){
        $('#R').html(data);                
        $('#PreLoader').hide();
        
    }
    });


} 


function Ahorrar_crearDescuento(){
    NoSol = $('#NoSol').val();
    CantidadAhorro_retirar = $('#CantidadAhorro_retirar').val();
    

    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_ahorrar_creardescuento.php',
        type: 'post',        
        data: {
            NoSol:NoSol, CantidadAhorro_retirar:CantidadAhorro_retirar            
        },
    success: function(data){
        $('#R').html(data);                
        $('#PreLoader').hide();
        
    }
    });


} 

function CajaNPago(NoSol, NPago){
    
    
    $('#PreLoader').show();           
    $.ajax({
        url: 'app_caja_dat_npago.php',
        type: 'post',        
        data: {
            NoSol:NoSol, NPago:NPago
            
        },
    success: function(data){
        $('#CajaPago').html(data);                
        $('#PreLoader').hide();
        
    }
    });


} 
</script> 


<?php
?>
<?php
include("footer.php");
?>