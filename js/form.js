"use strict";

var site_url = window.site_url;
var url_redirect = window.url_redirect;
var plugin_url = window.plugin_url;
var data_url = window.data_url;
var data_nonce = window.data_nonce;
var rutaEntorno = 'https://www.agencianegociadora.com'

jQuery(document).ready(function($) {
    $('#datos_solicitante2').hide();
    $('#RefiResultados').hide();
    $('#RefiViable').hide();
    $('#RefiDudoso').hide();
    $('#RefiNoviable').hide();
    $('#GraciasRefi').hide();
    $('#dosTitularesRefi').click(function(){
    $('#datos_solicitante2').show();
      $('#lbldatosSolicitante2').val('1');
    });
  $('#QuitarSolicitanteRefi').click(function(){
    $('#datos_solicitante2').hide();
      $('#lbldatosSolicitante2').val('');
  });
  
  $("input[name='HipotecaPendiente']").autoNumeric('init', {aSep: '.', aDec: ','});
  $("input[name='HipotecaMensual']").autoNumeric('init', {aSep: '.', aDec: ','}); 
  $("input[name='ValorVivienda']").autoNumeric('init', {aSep: '.', aDec: ','});
  $("input[name='Prestamo']").autoNumeric('init', {aSep: '.', aDec: ','});
  $("input[name='PrestamoMensual']").autoNumeric('init', {aSep: '.', aDec: ','});
  $("input[name='TitularIngresosMes']").autoNumeric('init', {aSep: '.', aDec: ','});
  $("input[name='txtTitular2IngresosMes']").autoNumeric('init', {aSep: '.', aDec: ','});		
  
  $('a#imgbCalcular').click(function () {
    var mensajeValidacion;
    mensajeValidacion = ValidarCalculo();
    if (mensajeValidacion == '') {
      CalcularAgruparDeudas(rutaEntorno);
      //HolaMundo(rutaEntorno);
    }
    else {
      alert(mensajeValidacion);
    }
    return false;

  });
  
  $('a#SolicitarRefi').click(function () {
    var mensajeValidacion;
    mensajeValidacion = ValidarSolicitud();
    if (mensajeValidacion == '') {
      Solicitar();
    }
    else {
      alert(mensajeValidacion);
    }
    return false;
  });
});
	
  function PendienteHipoteca(){
		PendienteHipoteca = jQuery("input[name='HipotecaPendiente']").val();
		jQuery("input[name='HipotecaPendiente']").autoNumeric('init', {aSep: '.', aDec: ','});
	}
	function HipotecaActual(){
		HipotecaActual= jQuery("input[name='HipotecaMensual']").val();
		jQuery("input[name='HipotecaMensual']").autoNumeric('init', {aSep: '.', aDec: ','}); 
	}
	function ValorCasa(){
		ValorCasa = jQuery("input[name='ValorVivienda']").val();
		jQuery("input[name='ValorVivienda']").autoNumeric('init', {aSep: '.', aDec: ','});
		}
	function TotalPrestamos (){
		TotalPrestamos = jQuery("input[name='Prestamo']").val();
		jQuery("input[name='Prestamo']").autoNumeric('init', {aSep: '.', aDec: ','});
	}
	function PagoMensualPrestamo(){
		PagoMensualPrestamo= jQuery("input[name='PrestamoMensual']").val();
		jQuery("input[name='PrestamoMensual']").autoNumeric('init', {aSep: '.', aDec: ','}); 
	}
	function IngresoRefi1(){
		IngresoRefi1 = jQuery("input[name='TitularIngresosMes']").val();
		jQuery("input[name='TitularIngresosMes']").autoNumeric('init', {aSep: '.', aDec: ','});
		IngresoRefi2 = 0
	}
	function IngresoRefi2(){
		IngresoRefi2 = jQuery("input[name='txtTitular2IngresosMes']").val();
		if  (IngresoRefi2 == "") {IngresoRefi2 == 0}
		jQuery("input[name='txtTitular2IngresosMes']").autoNumeric('init', {aSep: '.', aDec: ','});
	}
	
	function ahorrorefinanciacion(){
		
		cuota_total_actual = (parseInt(HipotecaActual) + parseInt(PagoMensualPrestamo))
		cantidadtotal = (parseInt(PendienteHipoteca) + parseInt(TotalPrestamos) )
		GestionCancelacion = 290
        RegistroCancelacion = (parseInt(PendienteHipoteca) * 0.80000000000000004) / 100
        NotariaCancelacion = (parseInt(PendienteHipoteca) * 0.20000000000000001) / 100
        TotalCancelacion = NotariaCancelacion + RegistroCancelacion + GestionCancelacion
		ImporteSolicitado = (parseInt(PendienteHipoteca) + parseInt(TotalPrestamos) +  parseInt(TotalCancelacion))

		if (ImporteSolicitado <= 90000){
			Honorarios = 4634.1999999999998
		}
		else if ((ImporteSolicitado > 90000)&&(ImporteSolicitado > 150000)){Honorarios = 5794.1999999999998}
		else if ((ImporteSolicitado > 150000)&&(ImporteSolicitado > 250000)){Honorarios =7534.1999999999998}
		else if ((ImporteSolicitado > 250000)&&(ImporteSolicitado > 400000)){Honorarios = 8114.1999999999998}
		else if ((ImporteSolicitado > 400000)&&(ImporteSolicitado > 550000)){Honorarios = 8694.2000000000007}
		else if ((ImporteSolicitado > 550000)&&(ImporteSolicitado > 700000)){Honorarios = 9274.2000000000007}
		else if ((ImporteSolicitado > 700000)&&(ImporteSolicitado > 850000)){Honorarios = 9854.2000000000007}
		else if  (ImporteSolicitado > 850000) {
			Diferencia = ImporteSolicitado - 850000
			Repeticiones = Math.round(Diferencia / 150000)
			if (Repeticiones == 0) { Repeticiones = 1 }
			Sumar = Repeticiones * 1200
			Honorarios = (parseInt(Sumar)+9854.2000000000007)
			}
			Seguro = 3000
			GastosRefi = (parseInt(TotalCancelacion)+parseInt(Honorarios)+parseInt(Seguro))
		cantidad_total_masgastos = (parseInt(ImporteSolicitado) + parseInt(Honorarios) + parseInt(Seguro))
		
		
		if (ValorCasa >0){
			 PorcentajeFinanciacion = (parseInt(cantidad_total_masgastos) / parseInt(ValorCasa)) * 100
			}
		else {
			PorcentajeFinanciacion = 0
			}
		TitularRefiPagas =  jQuery('#ddlTitularPagas').val();
		
		//jQuery("input[name='ddlTitularPagas']").val();

		Ingresos = ( parseInt(IngresoRefi1) * parseInt(TitularRefiPagas) / 12)
		if (IngresoRefi2 > 0){
			SegundoTitularPagas = jQuery('#ddlTitular2Pagas').val();
			IngresoSegundo = ( parseInt(IngresoRefi2) * parseInt(TitularRefiPagas) / 12)
			IngresosTotales = ( parseInt(Ingresos) + parseInt(IngresoSegundo))
			}
		else IngresosTotales = Ingresos
		Edad = jQuery('#TitularEdad').val();
		if (Edad <80) {
			Plazo = ((80 - Edad)*12)
			if (Plazo >360){ Plazo = 360}
			else{Plazo = 360}
			}
	 	InteresRefi = 3.5
		AnnualInterestRateRefi = 3.5/100
		YearsRefi = 30
		MonthRateRefi= AnnualInterestRateRefi/12 
		NumPaymentsRefi=YearsRefi*12
		PrinRefi = cantidad_total_masgastos
		
		CuotaRefi=Math.floor((PrinRefi*MonthRateRefi)/(1-Math.pow((1+MonthRateRefi),(-1*NumPaymentsRefi)))*100)/100 
		AhorroRefi = ( parseInt(cuota_total_actual) - parseInt(CuotaRefi));
		Endeudamiento = (((CuotaRefi) * 100) / IngresosTotales)
		
		//alert(PorcentajeFinanciacion + ' ' + Endeudamiento);
		if (PorcentajeFinanciacion <= 70){
			if(Endeudamiento <= 50){
				resultado = 'Viable'
				RefiEsViable()
				}
			if(Endeudamiento <= 80){
				resultado = 'Dudoso'
				RefiEsDudosa()
				}
			if(Endeudamiento > 80){
				resultado = 'NoViable'
				RefiNoViable()
				}
			}
		else if (PorcentajeFinanciacion > 70){
			if(Endeudamiento <= 50){
				resultado = 'Dudoso'
				RefiEsDudosa()
				}
			if(Endeudamiento <= 80){
				resultado = 'Dudoso'
				RefiEsDudosa()
				}
			if(Endeudamiento > 80){
				resultado = 'NoViable'
				RefiNoViable()
				}
			}
		else {
			resultado = 'NoViable'
				RefiNoViable()
			}
	 }
	 
	 function RefiEsViable(){
		 ValorVivienda=	(ValorCasa.toLocaleString())
		PagoPendienteCreditos =(TotalPrestamos.toLocaleString())
		CuotaActualHipPres =(cuota_total_actual.toLocaleString())
		TotalReunificacion =(GastosRefi.toLocaleString())
		NuevaCuotaapagar = (CuotaRefi.toLocaleString())
		AhorroConseguido =(AhorroRefi.toLocaleString())
		cantidad_total_masgastos =(cantidad_total_masgastos.toLocaleString())
		
			jQuery('#ModuleTabs').hide();
			jQuery('#mensajes').hide();
			jQuery('#Refinanciacion').hide();
			jQuery('#RefiResultados').show();
			jQuery('#nueva_hipoteca').show();
			jQuery('#RefiViable').show();
	 		jQuery('#RefiDudoso').hide();
			str1 = NuevaCuotaapagar
			num1 = (str1.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
			str2 = AhorroConseguido
			num2 = (str2.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));	
			jQuery('#CUotaFinalRefi').append(num1);
			jQuery('#AhorroFinalRefi').append(num2);
			jQuery('#CapitalHipotecaRefi').append(ValorVivienda);
			jQuery('#PendientePrestamoRefi').append(PagoPendienteCreditos);
			jQuery('#GastosRefi').append(TotalReunificacion);
			jQuery('#NuevaHipotecaRefi').append(cantidad_total_masgastos);
			jQuery('#NuevaCuotaRefi').append(NuevaCuotaapagar);
			jQuery('#CuotaAnteriorRef1').append(CuotaActualHipPres);
		}
		
	function RefiEsDudosa(){
			ValorVivienda=	(ValorCasa.toLocaleString())
			PagoPendienteCreditos =(TotalPrestamos.toLocaleString())
			CuotaActualHipPres =(cuota_total_actual.toLocaleString())
			TotalReunificacion =(GastosRefi.toLocaleString())
			NuevaCuotaapagar = (CuotaRefi.toLocaleString())
			AhorroConseguido =(AhorroRefi.toLocaleString())
			cantidad_total_masgastos =(cantidad_total_masgastos.toLocaleString())
		
		
			jQuery('#ModuleTabs').hide();
			jQuery('#mensajes').hide();
			jQuery('#Refinanciacion').hide();
			jQuery('#RefiResultados').show();
			jQuery('#nueva_hipoteca').show();
			jQuery('#RefiViable').hide();
	 		jQuery('#RefiDudoso').show();
			str1 = NuevaCuotaapagar
			num1 = (str1.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
			str2 = AhorroConseguido
			num2 = (str2.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));	
			jQuery('#CUotaFinalRefi').append(num1);
			jQuery('#AhorroFinalRefi').append(num2);
			jQuery('#CapitalHipotecaRefi').append(ValorVivienda);
			jQuery('#PendientePrestamoRefi').append(PagoPendienteCreditos);
			jQuery('#GastosRefi').append(TotalReunificacion);
			jQuery('#NuevaHipotecaRefi').append(cantidad_total_masgastos);
			jQuery('#NuevaCuotaRefi').append(NuevaCuotaapagar);
			jQuery('#CuotaAnteriorRef1').append(CuotaActualHipPres);
		}
		
	function RefiNoViable(){
			jQuery('#ModuleTabs').hide();
			jQuery('#mensajes').hide();
			jQuery('#Refinanciacion').hide();
			jQuery('#RefiResultados').hide();
			jQuery('#RefiNoviable').show();
		}	
		
	function ValidarSolicitud()
	{

		var mensaje = '';

		if (!(jQuery('input[name=chkClausula]').is(':checked'))) {
			mensaje = mensaje + 'Debes aceptar la clausula de privacidad.' + '\n'
		}

		if (jQuery('#NombreRefi').val() == '') {
			mensaje = mensaje + 'Debes escribir tu nombre.' + '\n'
		}
		if (jQuery('#ApellidosRefi').val() == '') {
			mensaje = mensaje + 'Debes escribir tus apellidos.' + '\n'
		}
		if (jQuery('#EmailRefi').val() == '') {
			mensaje = mensaje + 'Debes escribir tu email.' + '\n'
		}
		else {
			if (!EsEmail(jQuery('#EmailRefi').val())) {
				mensaje = mensaje + 'El email especificado no es correcto' + '\n'
			}
		}
		if ((jQuery('#MovilRefi').val() == '') && (jQuery('#FijoRefi').val() == '')) {
			mensaje = mensaje + 'Debes escribir al menos un numero de telefono' + '\n'
		}

		if (jQuery('#CodPostalRefi').val() == '') {
			mensaje = mensaje + 'Debes escribir tu codigo postal.' + '\n'
		}

		if (jQuery('select[name=ddlProvinciasRefi]').find('option:selected').text() == '') {
			mensaje = mensaje + 'Debes especificar tu provincia.' + '\n'
		}
		
		return mensaje
	}

	function SolicitaRefinancia(){
		Nombre = jQuery('#NombreRefi').val();
		Apellidos =jQuery('#ApellidosRefi').val();
		CorreoE = jQuery('#EmailRefi').val();
		Movil = jQuery('#MovilRefi').val();
		Fijo =jQuery('#FijoRefi').val();
		Provincia= jQuery('#ddlProvinciasRefi').val();
		Postal = jQuery('#CodPostalRefi').val();
		if (Nombre == ''){
			alert ("Porfavor indica tu nombre.");
			jQuery('#NombreRefi').focus();
			return (false);}
		else if (Apellidos == ''){
			alert ("Porfavor indica tus apellidos.");
			jQuery('#ApellidosRefi').focus();
			return (false);}
		else if (CorreoE == ''){
			alert ("Porfavor indica tu Email.");
			jQuery('#EmailRefi').focus();
			return (false);}
		else if (IsEmail(CorreoE) == false)	
			{
				 alert ("Por favor escriba un eMail correcto.");
				 jQuery('#EmailRefi').focus();
				 return (false);
			}
		else if ((Movil == '')&&(Fijo == '')){
			alert ("Porfavor indica un telÃ©fono de contacto.");
			jQuery('#MovilRefi').focus();
			return (false);}
		//else if (Movil != ''){
//			if (EsTelefonoMovil(Movil) == false)	{ 
//				alert ("Por favor escriba un nÃºmero de mÃ³vil vÃ¡lido.");
//				 return (false);}
//			}
//		else if (Fijo != ''){
//			if (EsTelefonoMovil(Fijo) == false)	{ 
//					alert ("Por favor escriba un nÃºmero de telÃ©fono vÃ¡lido.");
//				 return (false);}
//			}
		else if (Provincia == ''){
			alert ("Porfavor indica tu provincia.");
			jQuery('#ddlProvinciasRefi').focus();
			return (false);}
		else if (Postal == ''){
			alert ("Porfavor indica tu codigo postal.");
			jQuery('#CodPostalRefi').focus();
			return (false);}
		else if (!(jQuery('#chkPropiedad').is(":checked")))
		{alert ("Debe confrimar tener vivienda en propiedad.");
			jQuery('#chkPropiedad').focus();
			return (false);}
		else if (!(jQuery('#chkClausula').is(":checked")))
			{
			alert ("Debe aceptar la clÃ¡usula de privacidad.");
			('#chkClausula').focus();
			return (false);
			}

		//else if ((){}
		else 
			{
			//alert ('Se puede enviar')
			EnviarDatos();
			return (true);
			}
		
		function EnviarDatos() {
			
			NuevaCuotaapagar = (CuotaRefi.toLocaleString())
			AhorroConseguido =(AhorroRefi.toLocaleString())
         var html = "<table>";

		html += "<tr><td colspan='2'><h2>Solicita Estudio de Refinanciacion</h2></td></tr>";
		html += "<tr><td colspan='2'><strong>Resultado de simulacion:</strong></td></tr>";
		html += "<tr><td>Valor de la vivienda:</td><td>" + document.getElementById('ValorVivienda').value + "</td></tr>";
		html += "<tr><td>Pendiente del valor de vivienda:</td><td>" + document.getElementById('HipotecaPendiente').value + "</td></tr>";
		html += "<tr><td>Hipoteca mensual:</td><td>" + document.getElementById('HipotecaMensual').value + "</td></tr>";
		html += "<tr><td>Prestamos:</td><td>" + document.getElementById('Prestamo').value + "</td></tr>";
		html += "<tr><td>pago mensual de prestamos:</td><td>" + document.getElementById('PrestamoMensual').value + "</td></tr>";
		html += "<tr><td>Ingresos solicitantes:</td><td>" + IngresosTotales + "</td></tr>";
		html += "<tr><td><strong>Cuota refinanciada</strong>:</td><td><strong>" + NuevaCuotaapagar + "</strong></td></tr>";
		html += "<tr><td><strong>Ahorro mensual</strong>:</td><td><strong>" + AhorroConseguido + "</strong></td></tr>";
		
		html += "<tr><td>Cuota aproximada:</td><td>" + Compraposible + "</td></tr>";
		html += "<tr><td colspan='2'><strong>Datos del solicitante:</strong></td></tr>";
        html += "<tr><td>Nombre: </td><td>" + document.form1.NombreCompra.value + "</td></tr>";
        html += "<tr><td>Apellidos: </td><td>" + document.form1.ApellidosCompra.value  + "</td></tr>";
		html += "<tr><td>Email: </td><td>" + document.form1.EmailCompra.value + "</td></tr>";
		html += "<tr><td>DNI: </td><td>" + document.form1.DNICompra.value  + "</td></tr>";
		html += "<tr><td>Tel. Movil: </td><td>" + document.form1.MovilCompra.value  + "</td></tr>";
		html += "<tr><td>Tel. Fijo: </td><td>" + document.form1.FijoCompra.value  + "</td></tr>";
		html += "<tr><td>Provincia: </td><td>" + document.form1.ddlProvinciasCompra.value  + "</td></tr>";
		html += "<tr><td>Cod. Postal: </td><td>" + document.form1.CodPostalCompra.value + "</td></tr>";
	    
		

        html += "</table></td>";
		document.form1.hdnDatos.value = html;
		//jQuery('#hdnDatos').val(html);
        document.formulario.submit();
		return true;
    }
		
    jQuery(document).ready(function(){
    	jQuery("a#extLink").fancybox({
	         'width' : 550,
         	 'height' : 730,
	         'autoScale' : false,
	         'transitionIn' : 'none',
	         'transitionOut' : 'none',
	         'type' : 'iframe'
	     });
	 
	     });
		
		
		}
	
	function IsEmail(Email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(Email);
}
		//VALIDADOR MOVIL
function EsTelefonoMovil(Telefono) {
	 var test = /^[67]\d{8}$/; 
	 var telReg = new RegExp(test); 
	 var valido;
	 valido = telReg.test(Telefono); 
	 if (!valido)
	 {
		var testFijo = /^[89]\d{8}$/; 
		var telRegFijo = new RegExp(testFijo); 
		valido = telRegFijo.test(Telefono);
	 }
	 return valido;
	 } 
	//VALIDADOR TELEFONO 
	//Validaciones por expresiones regulares (Obtenidas de internet)
function EsEmail(w_email) {
    var test = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var emailReg = new RegExp(test);
    return emailReg.test(w_email);
}

function EsCodigoPostal(CP) {
    var cpexp = /(^([0-9]{5,5})|^)$/;
    var cpReg = new RegExp(cpexp);
    return cpReg.test(CP);
}
	
function ValidarCalculo() {
    var mensaje = '';

    if (jQuery('#HipotecaPendiente').val() == '') {
        mensaje = mensaje + 'Escribe cuanto te queda por pagar de hipoteca.' + '\n'
    }
    if (jQuery('#HipotecaMensual').val() == '') {
        mensaje = mensaje + 'Escribe cuanto pagas al mes de hipoteca.' + '\n'
    }
    if (jQuery('#ValorVivienda').val() == '') {
        mensaje = mensaje + 'Escribe el valor de tu casa.' + '\n'
    }
    if (jQuery('#Prestamo').val() == '') {
        mensaje = mensaje + 'Escribe cuanto te queda por pagar de otros prestamos. ' + '\n'
    }

    if (jQuery('#PrestamoMensual').val() == '') {
        mensaje = mensaje + 'Escribe cuanto pagas al mes por otros prestamos. ' + '\n'
    }
    if (jQuery('#TitularEdad').val() == '') {
        mensaje = mensaje + 'Escribe la edad del titular. ' + '\n'
    }

    if (jQuery('#TitularIngresosMes').val() == '') {
        mensaje = mensaje + 'Escribe los ingresos mensuales del titular. ' + '\n'
    }

    //Validacion de los datos del segundo solicitante
    if (jQuery('#lbldatosSolicitante2').val() != '') {
        if (jQuery('#txtTitular2Edad').val() == '') {
            mensaje = mensaje + 'Escribe la edad del segundo titular. ' + '\n'
        }
        if (jQuery('#txtTitular2IngresosMes').val() == '') {
            mensaje = mensaje + 'Escribe los ingresos mensuales del segundo titular. ' + '\n'
        }
    }

    return mensaje
}

function CalcularAgruparDeudas(rutaEntorno) {

  var argumentos = '{hipotecaPendiente:"' + jQuery('#HipotecaPendiente').val()
  argumentos = argumentos + '",Prestamo:"' + jQuery('#Prestamo').val()
  argumentos = argumentos + '",ValorVivienda:"' + jQuery('#ValorVivienda').val() + '",TitularIngresosMes:"' + jQuery('#TitularIngresosMes').val()
  argumentos = argumentos + '",TitularPagas:"' + jQuery('select[name=ddlTitularPagas]').find('option:selected').text() + '",TitularContrato:"' + jQuery('select[name=ddlTitularContrato]').find('option:selected').val()
  argumentos = argumentos + '",hipotecaMensual:"' + jQuery('#HipotecaMensual').val() + '",prestamoMensual:"' + jQuery('#PrestamoMensual').val()
  argumentos = argumentos + '",TitularEdad:"' + jQuery('#TitularEdad').val() + '",datosSolicitante2:"' + jQuery('#lbldatosSolicitante2').val()
  argumentos = argumentos + '",Titular2IngresosMes:"' + jQuery('#Titular2IngresosMes').val() + '",titular2Pagas:"' + jQuery('select[name=ddltitular2Pagas]').find('option:selected').text()
  argumentos = argumentos + '"}';

  jQuery.ajax({
    type: "POST",
    url: rutaEntorno + "/DesktopModules/valorindirecto.CalcHipotecaria/WSController.asmx/CalcularAgruparDeudasExterna",
    data: argumentos,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (response) {
      var datos = response.d
      if (datos.ResultadoEstudio == 'Viable') {
        jQuery('#ModuleTabs').hide();
        jQuery('#mensajes').hide();
        jQuery('#Refinanciacion').hide();
        jQuery('#RefiResultados').show();
        jQuery('#nueva_hipoteca').hide();
        jQuery('#RefiViable').show();
        jQuery('#RefiDudoso').hide();
        let str5 = datos.CuotaNueva
        let num5 = (str5.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
        let str6 = datos.CantidadMenos
        let num6 = (str6.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));	
        jQuery('#CUotaFinalRefi').append(num5);
        jQuery('#AhorroFinalRefi').append(num6);
        jQuery('#CapitalHipotecaRefi').append(datos.HipotecaPendiente);
        jQuery('#PendientePrestamoRefi').append(datos.Prestamo);
        jQuery('#GastosRefi').append(datos.Gastos);
        jQuery('#PlazoRefi').append(datos.PlazoAnos);

        jQuery('#NuevaHipotecaRefi').append(datos.NuevaHipoteca);
        jQuery('#NuevaCuotaRefi').append(datos.CuotaNueva);
        jQuery('#CuotaAnteriorRef1').append(datos.CuotaActual);

        jQuery('input[name$="hdPlazo"]').val(datos.Plazo);
        jQuery('input[name$="hdInteres"]').val(datos.Interes);
        jQuery('input[name$="lblImporteSolicitado"]').val(datos.ImporteSolicitado);
      }
      else if (datos.ResultadoEstudio == 'Dudoso') {
        let str5 = datos.CuotaNueva
        let num5 = (str5.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
        let str6 = datos.CantidadMenos
        let num6 = (str6.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));	
        jQuery('#CuotaFinalRefiD').append(num5);
        jQuery('#AhorroFinalRefiD').append(num6);
        jQuery('#CapitalHipotecaRefi').append(datos.HipotecaPendiente);
        jQuery('#PendientePrestamoRefi').append(datos.Prestamo);
        jQuery('#GastosRefi').append(datos.Gastos);
        jQuery('#PlazoRefi').append(datos.PlazoAnos);

        jQuery('#NuevaHipotecaRefi').append(datos.NuevaHipoteca);
        jQuery('#NuevaCuotaRefi').append(datos.CuotaNueva);
        jQuery('#CuotaAnteriorRef1').append(datos.CuotaActual);

        jQuery('input[name$="hdPlazo"]').val(datos.Plazo);
        jQuery('input[name$="hdInteres"]').val(datos.Interes);
        jQuery('input[name$="lblImporteSolicitado"]').val(datos.ImporteSolicitado);

        jQuery('#ModuleTabs').hide();
        jQuery('#mensajes').hide();
        jQuery('#Refinanciacion').hide();
        jQuery('#RefiResultados').show();
        jQuery('#nueva_hipoteca').hide();
        jQuery('#RefiViable').hide();
        jQuery('#RefiDudoso').show();
        jQuery('#dvViable').hide();
        jQuery('#semaforoverde').hide();
      }
      else if (datos.ResultadoEstudio == 'NoViable') {
        jQuery('#ModuleTabs').hide();
        jQuery('#mensajes').hide();
        jQuery('#Refinanciacion').hide();
        jQuery('#RefiResultados').show();
        jQuery('#RefiResultados').hide();
        jQuery('#RefiNoviable').show();
      }
      else {
        alert('Error en el cáculo');
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert('Error: ' + errorThrown);
    }
  });
}


function Solicitar() {

  // var argumentos = '{hipotecaPendiente:"' + jQuery('#HipotecaPendiente').val()
  //   argumentos = argumentos + '",Prestamo:"' + jQuery('#Prestamo').val()
  //   argumentos = argumentos + '",ValorVivienda:"' + jQuery('#ValorVivienda').val() + '",TitularIngresosMes:"' + jQuery('#TitularIngresosMes').val()
  //   argumentos = argumentos + '",TitularPagas:"' + jQuery('select[name=ddlTitularPagas]').find('option:selected').text() + '",TitularContrato:"' + jQuery('select[name=ddlTitularContrato]').find('option:selected').val()
  //   argumentos = argumentos + '",hipotecaMensual:"' + jQuery('#HipotecaMensual').val() + '",prestamoMensual:"' + jQuery('#PrestamoMensual').val()

  //   argumentos = argumentos + '",TitularEdad:"' + jQuery('#TitularEdad').val() + '",datosSolicitante2:"' + jQuery('#lbldatosSolicitante2').val()


  //   argumentos = argumentos + '",Titular2IngresosMes:"' + jQuery('#Titular2IngresosMes').val()
  //   argumentos = argumentos + '",Titular2Edad:"' + jQuery('#txtTitular2Edad').val()
  //   argumentos = argumentos + '",Titular2Pagas:"' + jQuery('select[name=ddltitular2Pagas]').find('option:selected').text()
  //   argumentos = argumentos + '",Titular2Contrato:"' + jQuery('select[name=ddlTitular2Contrato]').find('option:selected').val()

  //   argumentos = argumentos + '",ImporteSolicitado:"' + jQuery('input[name$="lblImporteSolicitado"]').val()
  //   argumentos = argumentos + '",Plazo:"' + jQuery('input[name$="hdPlazo"]').val()
  //   argumentos = argumentos + '",Interes:"' + jQuery('input[name$="hdInteres"]').val()
  //   argumentos = argumentos + '",descripcionOrigen:"' + 'LIBERATEDETUSDEUDAS.ES'
  //   argumentos = argumentos + '",descripcionOrigenEntradaDesglose:"' + ''
  //   argumentos = argumentos + '",Nombre:"' + jQuery('#NombreRefi').val()
  //   argumentos = argumentos + '",Apellidos:"' + jQuery('#ApellidosRefi').val()
  //   argumentos = argumentos + '",DNI:"' + ''
  //   argumentos = argumentos + '",Email:"' + jQuery('#EmailRefi').val()
  //   argumentos = argumentos + '",Movil:"' + jQuery('#MovilRefi').val()
  //   argumentos = argumentos + '",Fijo:"' + jQuery('#FijoRefi').val()
  //   argumentos = argumentos + '",Provincias:"' + jQuery('select[name=ddlProvinciasRefi]').find('option:selected').text()
  //   argumentos = argumentos + '",CodPostal:"' + jQuery('#CodPostalRefi').val()

  // if (jQuery('input[name=chkPropiedad]').is(':checked')) {
  //   argumentos = argumentos + '",chkPropiedad:"' + '1'
  // }
  // else {
  //   argumentos = argumentos + '",chkPropiedad:"' + '0'
  // }

  // if (jQuery('input[name=chkClausula]').is(':checked')) {
  //   argumentos = argumentos + '",chkClausula:"' + '1'
  // }
  // else {
  //   argumentos = argumentos + '",chkClausula:"' + '0'
	//   argumentos = argumentos + '"}';
	
		let HipotecaPendiente = jQuery("input[name='HipotecaPendiente']").val();
		let HipotecaMensual = jQuery("input[name='HipotecaMensual']").val();
		let ValorVivienda = jQuery("input[name='ValorVivienda']").val();
		let Prestamo = jQuery("input[name='Prestamo']").val();
		let PrestamoMensual = jQuery("input[name='PrestamoMensual']").val();
		let TitularEdad = jQuery("input[name='TitularEdad']").val();
		let TitularIngresosMes = jQuery("input[name='TitularIngresosMes']").val();
		let ddlTitularPagas = jQuery("select[name='ddlTitularPagas']").val();
		let ddlTitularContrato = jQuery("select[name='ddlTitularContrato']").val();

		// personal
		let Nombre = jQuery('#NombreRefi').val();
		let Apellidos =jQuery('#ApellidosRefi').val();
		let CorreoE = jQuery('#EmailRefi').val();
		let Movil = jQuery('#MovilRefi').val();
		let Fijo =jQuery('#FijoRefi').val();
		let Provincia= jQuery('#ddlProvinciasRefi').val();
		let Postal = jQuery('#CodPostalRefi').val();

    var fd = new FormData();
    fd.append('action', 'formDebt');
    fd.append('nonceT', data_nonce);
    fd.append('Nombre', Nombre);
    fd.append('Apellidos', Apellidos);
    fd.append('CorreoE', CorreoE);
    fd.append('Movil', Movil);
    fd.append('Fijo', Fijo);
    fd.append('Provincia', Provincia);
		fd.append('Postal', Postal);

    fd.append('HipotecaPendiente', HipotecaPendiente);
    fd.append('HipotecaMensual', HipotecaMensual);
    fd.append('ValorVivienda', ValorVivienda);
    fd.append('Prestamo', Prestamo);
    fd.append('PrestamoMensual', PrestamoMensual);
    fd.append('TitularEdad', TitularEdad);
    fd.append('TitularIngresosMes', TitularIngresosMes);
    fd.append('ddlTitularPagas', ddlTitularPagas);
		fd.append('ddlTitularContrato', ddlTitularContrato);
		
		console.log("data1: ", ddlTitularPagas)
		console.log("data1: ", ddlTitularContrato)

    jQuery.ajax({
      type: 'POST',
      url: data_url,
      data: fd,
      contentType: false,
      processData: false,
      error:function() {},
      success:function( r ) {
        console.log('data2: ', r);
          // jQuery('#RefiResultados').hide();
        //   jQuery('#GraciasRefi').show();
      },
    });
  // }
}