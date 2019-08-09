<?php
include_once('ajax.php');

class shortcode {
  public function __construct() {
    add_shortcode( 'debt', array($this, 'shortcode_debt'));
  }

  function shortcode_debt($atts) {
    ob_start();
    wp_enqueue_style('leads/bootstrap.css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, null);
    wp_enqueue_script('beat/main.js', plugins_url('../js/form.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_script('beat/autoNumeric.js', plugins_url('../js/autoNumeric.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_script('beat/jquery.fancybox.pack.js', plugins_url('../js/jquery.fancybox.pack.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_style('beat/style.css', plugins_url('../css/style.css', __FILE__), false, null);
    wp_enqueue_style('beat/jquery.fancybox.css', plugins_url('../css/jquery.fancybox.css', __FILE__), false, null);
    wp_enqueue_style('beat/animate.css', plugins_url('../css/animate.css', __FILE__), false, null);
    wp_enqueue_style('beat/animate.css', plugins_url('../css/animate.css', __FILE__), false, null);
    wp_enqueue_style('beat/Liberate.css', plugins_url('../css/Liberate.css', __FILE__), false, null);

    $atts = shortcode_atts(
      array(
        'redirect' => 'https://google.com'
      ), $atts, 'debt' );
    $this->form_public($atts);
    return ob_get_clean();
  }

  function form_public($atts) {
    global $wpdb; ?>
			<div id="Calculadora">
				<input name="lblImporteSolicitado" type="hidden" id="lblImporteSolicitado">
                <input name="hdPlazo" type="hidden" id="hdPlazo">
                <input name="hdInteres" type="hidden" id="hdInteres">
                <div id="Refinanciacion" >
                	<div id="crono">
                    Comprueba ahora si tu operación es viable</div>
                    <div id="datos_hipoteca">
                    	<div class="HipotecaDiv">
                        	<div id="pink">&nbsp;</div>
                            <div id="mensajes">
                            	<div class="ModuleHeaderTit">
                            </div>
                            </div>
                        <div>
                            <h3 class="Hipoteca">Datos de la hipoteca</h3>
                            <div class="LabelCalc">&iquest;Cu&aacute;nto te queda por pagar de hipoteca?*</div>
                            <div class="DivInputCalc">
                              <input  type="text" class="CajaModulo" id="HipotecaPendiente" name="HipotecaPendiente" onblur="PendienteHipoteca()">
                            </div>
                            <div class="CalcAc">euros <span class="EXP">(Capital pendiente)</span></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">&iquest;Cu&aacute;nto pagas al mes de hipoteca?*</div>
                            <div class="DivInputCalc"><input name="HipotecaMensual" type="text" class="CajaModulo" id="HipotecaMensual" onblur="HipotecaActual()"></div>
                            <div class="CalcAc">euros <span class="EXP">(Capital mensual)</span></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Valor de la vivienda*:</div>
                            <div class="DivInputCalc"><input name="ValorVivienda" type="text" class="CajaModulo" id="ValorVivienda" onblur="ValorCasa()" ></div>
                            <div class="CalcAc">euros</div>
                            <div class="Espacio"></div>
                        </div>
                    	</div>
                	</div>
                	<div id="datos_prestamo">
                        <div class="PrestamosDiv">
                            <h3 class="Prestamo">Datos de los préstamos</h3>
                            <div>
                                <div class="LabelCalc">&iquest;Cu&aacute;nto te queda por pagar de otros pr&eacute;stamos?*</div>
                                <div class="DivInputCalc"><input name="Prestamo" type="text" class="CajaModulo" id="Prestamo" onblur="TotalPrestamos()" ></div>
                                <div class="CalcAc">euros <span class="EXP">(Suma total)</span></div>
                                <div class="Espacio"></div>
                                <div class="LabelCalc">&iquest;Cu&aacute;nto pagas al mes de otros pr&eacute;stamos?*</div>
                                <div class="DivInputCalc"><input name="PrestamoMensual" type="text" class="CajaModulo" id="PrestamoMensual" onblur="PagoMensualPrestamo()" ></div>
                                <div class="CalcAc">euros <span class="EXP">(Suma total)</span></div>
                                <div class="Espacio"></div>
                            </div>
                        </div>
                    </div>
                	<div id="datos_solicitante">
                    	<div class="SolicitanteDiv">
                        	<h3 class="Solicitante">Datos del Solicitante</h3>
                        	<div>
                            <div class="LabelCalc">Edad del titular:*</div>
                            <div class="DivInputCalc"><input name="TitularEdad" type="text" class="CajaModulo" id="TitularEdad" ></div>
                            <div class="CalcAc">años</div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Ingresos mensuales del titular:*</div>
                            <div class="DivInputCalc"><input name="TitularIngresosMes" type="text" class="CajaModulo" id="TitularIngresosMes" onblur="IngresoRefi1()" ></div>
                            <div class="CalcAc">euros <span class="EXP">(netos al mes)</span></div>
                            <div class="Espacio"></div>
                            <div><!--<asp:RequiredFieldValidator ID="rfvtxtTitularIngresosMes" runat="server" ErrorMessage="Escribe los ingresos mensuales del titular. " ControlToValidate="txtTitularIngresosMes" Display="Dynamic"  ForeColor="#f60808"></asp:RequiredFieldValidator>--></div>   
                            <div class="LabelCalc">N&ordm; pagas al a&ntilde;o:</div>
                            <div class="DivInputCalc">
                                <select name="ddlTitularPagas" id="ddlTitularPagas" class="SelectModulo">
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                </select>
                            </div>
                            <div class="CalcAc">pagas al año</div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Tipo de contrato:</div>
                            <div class="DivInputCalc">
                                <select name="ddlTitularContrato" id="ddlTitularContrato" class="SelectModulo">
                                    <option value="1">Indefinido</option>
                                    <option value="2">Temporal</option>
                                    <option value="3">Autónomo</option>
                                    <option value="4">Funcionario</option>
                                    <option value="5">Desempleado</option>
                                    <option value="6">Pensionista</option>
                                </select>
                            </div>
                            <div class="Espacio"></div>
                            <div style="display:none"><div class="LabelCalc">&nbsp;</div>
                            <div class="CalcAc3"><a href="#" id="dosTitularesRefi">&iquest;Hay otro solicitante o titular m&aacute;s?</a></div>
                            <div class="Espacio"></div></div>
                        </div>
                    	</div>
                	</div>
                	<div id="datos_solicitante2" >
                    	<div class="SolicitanteDiv">
                        	<input name="lbldatosSolicitante2" type="hidden" id="lbldatosSolicitante2">
                        	<h3 class="Solicitante">Datos del Segundo Solicitante<span><a href="#" id="QuitarSolicitanteRefi">quitar</a></span></h3>	
                        	<div class="LabelCalc">Edad del titular:*</div>
                        	<div class="DivInputCalc"><input name="Titular2Edad" type="text" class="CajaModulo" id="txtTitular2Edad" ></div>
                        	<div class="CalcAc">años</div>
                        	<div class="Espacio"></div>
                        	<div class="LabelCalc">Ingresos mensuales del titular:</div>
                        	<div class="DivInputCalc"><input name="Titular2IngresosMes" type="text" class="CajaModulo" id="Titular2IngresosMes" onblur="IngresoRefi2()" ></div>
                            <div class="CalcAc">euros <span class="EXP">(netos al mes)</span></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">N&ordm; pagas al a&ntilde;o:</div>
                            <div class="DivInputCalc">
                              <select name="ddlTitular2Pagas" id="ddlTitular2Pagas" class="SelectModulo">
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                              </select>
                            </div>
                            <div class="CalcAc">pagas al año</div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Tipo de contrato:</div>
                            <div class="DivInputCalc">
                              <select name="ddlTitular2Contrato" id="ddlTitular2Contrato" class="SelectModulo">
                                <option value="1">Indefinido</option>
                                <option value="2">Temporal</option>
                                <option value="3">Autónomo</option>
                                <option value="4">Funcionario</option>
                                <option value="5">Desempleado</option>
                                <option value="6">Pensionista</option>
                              </select>
                            </div>
                        	<div class="Espacio"></div>
                	</div>
                	</div>
                    <div id="botones">
                    <br/><a href="#" id="imgbCalcular">Comprobar</a>
                    </div>
            	</div>
            	<div id="RefiResultados">
                	<div class="HeaderViable" id="RefiViable">
                        <div id="semaforo" class="Semaforo">
                            <img src="<?php echo plugins_url('../icon/', __FILE__); ?>semaforo_verde.jpg" width="34" height="91">
                        </div>
                        
                        
                        <div>
                            <div id="dvViable" class="Enhorabuena">Enhorabuena, tu operaci&oacute;n es <strong><span class="viable">viable*</span></strong></div>
                            <div class="AvisoCalc">Con la nueva hipoteca pagar&iacute;as una &uacute;nica<br />cuota de <span class="NuevaRefi"><span id="CUotaFinalRefi">&nbsp;</span> al mes.</span><br />Son <span id="AhorroFinalRefi">&nbsp;</span> menos al mes.</div>
                        </div>
                	</div>
                	<div class="HeaderViable" id="RefiDudoso">
                    	<div id="semaforo" class="Semaforo">
                        <img src="<?php echo plugins_url('../icon/', __FILE__); ?>semaforo_ambar.jpg" width="34" height="91">
                    </div>
                    	<div>
                       	 	<div id="dvDudoso" runat="server" class="Enhorabuena">Tu operaci&oacute;n podr&iacute;a ser <strong><span class="posible">viable*</span></strong></div> 
                        	<div class="AvisoCalc">Con la nueva hipoteca pagar&iacute;as una &uacute;nica<br />cuota de <span class="NuevaRefi"><span id="CuotaFinalRefiD">&nbsp;</span> al mes.</span><br />Son <span id="AhorroFinalRefiD">&nbsp;</span> menos al mes.</div>
                    	</div>
                	</div>
                	<div id="nueva_hipoteca">
                		<div class="NuevaHipoteca">
                    		<h3 class="Resultado">Resultado de la simulación</h3>
                    		<div class="LabelResultados">Capital pendiente de hipoteca:</div>
                            <div class="CantResultados"><span id="CapitalHipotecaRefi"></span></div>
                            <div class="ACResultados">euros</div>
                            <div class="Espacio"></div>
                            <div class="LabelResultados">Cancelación de otros préstamos:</div>
                            <div class="CantResultados"><span id="PendientePrestamoRefi"></span></div>
                            <div class="ACResultados">euros</div>
                            <div class="Espacio"></div>
                            <div class="LabelResultados">Total gastos de operación:</div>
                            <div class="CantResultados"><span id="GastosRefi"></span></div>
                            <div class="ACResultados">euros</div>
                            <div class="Espacio"></div>
                            <div class="DividerResultados">&nbsp;</div>
                            <div class="LabelResultados">Capital total nueva hipoteca:</div>
                            <div class="CantResultados"><span id="NuevaHipotecaRefi"></span></div>
                            <div class="ACResultados">euros</div>
                            <div class="Espacio"></div> 
                            <div class="LabelResultados">Plazo:</div>
                            <div class="CantResultados" id="PlazoRefi" > </div>
                            <div class="ACResultados">años </div>
                            <div class="Espacio"></div>
                            <div class="LabelResultados2">Nueva cuota:</div>
                            <div class="CantResultados2"><span id="NuevaCuotaRefi"></span></div>
                            <div class="ACResultados">euros &nbsp;(Cuota anterior:<span id="CuotaAnteriorRef1">&nbsp;</span> )<br>
<span class="EXP2">(Sobre un tipo de inter&eacute;s del 3%)</span></div>
                            <div class="Espacio"></div> 
                		</div>
                	</div>
                	<div id="solicitudRefi">
                		<div class="inner_solicitud">
                    		<h3 class="Solicitante">Solicítanos ahora el Estudio Gratuíto de tu operación</h3>
                            <div class="LabelCalc">Nombre:</div>
                            <div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="NombreRefi"></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Apellidos:</div>
                            <div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="ApellidosRefi"></div>
                    		<div class="Espacio"></div>
                    		<div class="LabelCalc">Email:</div>
                    		<div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="EmailRefi"></div>
                    		<div class="Espacio"></div>
                    		<div class="LabelCalc">Teléfono móvil:</div>
                            <div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="MovilRefi"></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Teléfono fijo:</div>
                            <div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="FijoRefi"></div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Provincia:</div>
                            <div class="DivInputCalc2">
                                <select name="ddlProvinciasRefi" id="ddlProvinciasRefi" class="CajaSolicitud">
                          <option value=""></option>
                          <option value="ALAVA">&Aacute;lava</option>
                          <option value="ALBACETE">Albacete</option>
                          <option value="ALICANTE">Alicante</option>
                          <option value="ALMERIA">Almer&iacute;a</option>
                          <option value="ASTURIAS">Asturias</option>
                          <option value="AVILA">&Aacute;vila</option>
                          <option value="BADAJOZ">Badaj&oacute;z</option>
                          <option value="BALEARES">Baleares</option>
                          <option value="BARCELONA">Barcelona</option>
                          <option value="BURGOS">Burgos</option>
                          <option value="CACERES">C&aacute;ceres</option>
                          <option value="CADIZ">C&aacute;diz</option>
                          <option value="CANTABRIA">Cantabria</option>
                          <option value="CASTELLON">Castell&oacute;n</option>
                          <option value="CEUTA">Ceuta</option>
                          <option value="CIUDAD REAL">Ciudad Real</option>
                          <option value="CORDOBA">C&oacute;rdoba</option>
                          <option value="CUENCA">Cuenca</option>
                          <option value="GERONA">Gerona</option>
                          <option value="GRANADA">Granada</option>
                          <option value="GUADALAJARA">Guadalajara</option>
                          <option value="GUIPUZCOA">Guipuzc&oacute;a</option>
                          <option value="HUELVA">Huelva</option>
                          <option value="HUESCA">Huesca</option>
                          <option value="JAEN">Ja&eacute;n</option>
                          <option value="LA CORUÑA">La Coru&ntilde;a</option>
                          <option value="LA RIOJA">La Rioja</option>
                          <option value="LAS PALMAS">Las Palmas</option>
                          <option value="LEON">Le&oacute;n</option>
                          <option value="LERIDA">L&eacute;rida</option>
                          <option value="LUGO">Lugo</option>
                          <option value="MADRID">Madrid</option>
                          <option value="MALAGA">M&aacute;laga</option>
                          <option value="MELILLA">Melilla</option>
                          <option value="MURCIA">Murcia</option>
                          <option value="NAVARRA">Navarra</option>
                          <option value="ORENSE">Orense</option>
                          <option value="PALENCIA">Palencia</option>
                          <option value="PONTEVEDRA">Pontevedra</option>
                          <option value="S.C. TENERIFE">S.C. Tenerife</option>
                          <option value="SALAMANCA">Salamanca</option>
                          <option value="SEGOVIA">Segovia</option>
                          <option value="SEVILLA">Sevilla</option>
                          <option value="SORIA">Soria</option>
                          <option value="TARRAGONA">Tarragona</option>
                          <option value="TERUEL">Teruel</option>
                          <option value="TOLEDO">Toledo</option>
                          <option value="VALENCIA">Valencia</option>
                          <option value="VALLADOLID">Valladolid</option>
                          <option value="VIZCAYA">Vizcaya</option>
                          <option value="ZAMORA">Zamora</option>
                          <option value="ZARAGOZA">Zaragoza</option>
                          </select>
                            </div>
                            <div class="Espacio"></div>
                            <div class="LabelCalc">Código Postal:</div>
                            <div class="DivInputCalc2"><input name="" type="text" class="CajaSolicitud" ID="CodPostalRefi"></div>
                            <div class="Espacio"></div>
                            <div class="CalcChecks"><input name="chkPropiedad" type="checkbox" value="" id="chkPropiedad"><label>Confirmo tener la vivienda en propiedad</label></div>
                            <div class="CalcChecks"><input name="chkClausula" type="checkbox" value="" id="chkClausula">
                            <label>He leído y acepto la <a href="#" target="_blank">cl&aacute;usula de protección de datos</a></label></div>
                        </div>
                        <div class="CalcChecks" style="display:none"><input name="chkEmpresas" type="checkbox" value="" id="chkEmpresas">
                            <label><a href="#EmpresasReacciona" id="clausulalegal">Acepto recibir información de otras compañías del Grupo Reacciona </a></label></div>
                        </div>
                        <div align="center"><br/>
                          <a href="#" id="SolicitarRefi">Solicitar estudios</a>
                        </div>
                         <div id="aviso" class="EXP2" style="text-align:justify"><br/>*Aviso: De acuerdo  con la informaci&oacute;n introducida, la operaci&oacute;n cumple con los criterios b&aacute;sicos de viabilidad de una o varias entidades bancarias. En todo caso est&aacute; informaci&oacute;n no es vinculante y esta sujeta a la posterior aprobaci&oacute;n por parte del departamento de riesgos de las entidades bancarias en las que se presente la operaci&oacute;n, una vez que se haya documentado en su totalidad.</div>
                	</div>
            	</div>
            	<div id="RefiNoviable" >
            		<div id="estructura3" style="text-align:left">
            			<div id="mensajes5" class="HeaderNoviable">
                
                <div id="semaforo" class="Semaforo"><img src="<?php echo plugins_url('../icon/', __FILE__); ?>semaforo_rojo.jpg" width="34" height="91" style="margin-bottom:130px">
              </div>
                <div>
                <div class="LoSentimos">
                    Lo sentimos, tu operaci&oacute;n <strong><span class="no_viable">no es viable</span></strong><br />
              </div>
                <div class="AvisoCalc" style="margin-left:50px">Lamentablemente, con los datos que has introducido, actualmente, ninguna entidad bancaria aprobar&iacute;a la operaci&oacute;n. <br/><br/>Si necesitas alguna aclaraci&oacute;n o crees que existe informaci&oacute;n adicional que puede ser relevante, ll&aacute;manos al 900 346 376 y uno de nuestros consultores
    te atender&aacute; personalmente.
               </div>
                </div>
            </div>
       
        			</div>
        		</div>
        	</div>
          	<!-- GRACIAS-->
        	<div id="GraciasRefi" >
            <div id="mensajes4"  class="GraciasCalc">
                
                <div id="GraciasLbl" name="GraciasLbl" class="Enhorabuena" style="color:#ffffff">Gracias, en un plazo m&aacute;ximo de 24 horas nos pondremos en contacto contigo.</div>
            </div>
        </div>
      </div>
    <script>
      var site_url = '<?php echo get_site_url(); ?>';
      var url_redirect = '<?php echo $atts['redirect']; ?>';
      var plugin_url = '<?php echo plugins_url('../icon/', __FILE__); ?>';
      var data_url='<?php echo admin_url('admin-ajax.php'); ?>';
      var data_nonce='<?php echo wp_create_nonce('debt'); ?>'
    </script>
    <?php
  }
}