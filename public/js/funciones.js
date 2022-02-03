    $( document ).ready(function() {
        $('body').show();
    });

    function Codificar(input) {
        var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
     
        input = utf8_encode(input);
     
        while (i < input.length) {
     
          chr1 = input.charCodeAt(i++);
          chr2 = input.charCodeAt(i++);
          chr3 = input.charCodeAt(i++);
     
          enc1 = chr1 >> 2;
          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
          enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
          enc4 = chr3 & 63;
     
          if (isNaN(chr2)) {
            enc3 = enc4 = 64;
          } else if (isNaN(chr3)) {
            enc4 = 64;
          }
     
          output = output +
          _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
          _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
     
        }
        return output;
    }

    function utf8_encode (string) {
        string = string.toString();
        if(!string || string == '' || string == null){
            return '';
        }
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
     
        for (var n = 0; n < string.length; n++) {
     
          var c = string.charCodeAt(n);
     
          if (c < 128) {
            utftext += String.fromCharCode(c);
          }
          else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
          }
          else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
          }
        }
        return utftext;
    }

    function CorreoValidar(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function ParametroURLObtener(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    }

    function FancyMensajeVer(mensaje, tipo){
    	var clase = '';
    	var texto = '';
    	switch (tipo){
    		case 'exito':
    			clase = 'success';
    			texto = 'Exito';
    			break;
    		case 'advertencia':
    			clase = 'warning';
    			texto = 'Advertencia';
    			break;
    		case 'error':
    			clase = 'danger';
    			texto = 'Error';
    			break;
    		default:
    			clase = 'danger';
    			texto = 'Error';
    			break;
    	}
    	var div_mensaje = '<div class="alert alert-'+clase+' alert-dismissible" role="alert">'+
								'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
							  	+mensaje+
							'</div>';
		return div_mensaje;
    }

    //FUNCION QUE VALIDA QUE SOLO NUMEROS O LETRAS SEAN INGRESADAS   
    function CaracterValidar(e,tipo){
        tecla = (document.all) ? e.keyCode : e.which;
        //Tecla de retroceso para borrar, siempre la permite
        switch (tipo){
            case 0:
                if (tecla == 8 || tecla == 32 || tecla == 0 || tecla >= 192 && tecla <= 255 || tecla == 180) return true;
                // Patron de entrada para letras
                patron =/[A-Za-z]/; 
                break;
            case 1:
                if (tecla == 8 || tecla == 0) return true;
                // Patron de entrada para numeros
                patron = /\d/;  
                break;
            case 2:
                if (tecla == 8 || tecla == 0 || tecla == 46) return true;
                // Patron de entrada para numeros con punto
                patron = /\d/;
                break;
            default:
            	if (tecla == 8 || tecla == 32 || tecla == 0) return true;
                // Patron de entrada para letras
                patron =/[A-Za-z]/; 
            	break;
        }
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function AbrirAlertaFancy(msg, alto, ancho, typemodal) {
        var modal = (typemodal != undefined) ? typemodal: false;
        $.fancybox('<div class="content_msg">'+msg+'</div>', {
            'modal': modal,
            'height' : alto,
            'width'  : ancho,
            'autoSize' : false
        });
    }

    function FancyCerrar(){
        $.fancybox.close(true);
    }

    function Redir(ruta){
        window.location.href = ruta;
    }

    function ImagenVer(imagen){
        var img = '<img src="'+imagen+'" alt="Afiche evento."/>';
        AbrirAlerta(img,'100%','100%');
    }

    function MonedaValidar(_elemento){
        let valor = parseFloat($(_elemento).val());
        if(valor)
            $(_elemento).val(valor.toFixed(2));
    }

    function ImagenValidar(_fil_imagen){
        if($('#'+_fil_imagen).prop('name') != ''){
            let mensaje = '';
            let file = document.getElementById(_fil_imagen);
            if(file.value.indexOf('.') < 0 || !file){
                file.value='';
                mensaje = 'Archivo no soportado. La imagen debe ser extensi&oacute;n "jpg" o "png".';
                AlertaMostrar('danger',mensaje);
                return false;
            }
            let ext = file.value.match(/\.([^\.]+)$/)[1];
            switch(ext.toLowerCase()) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    break;
                default:
                    file.value = '';
                    mensaje = 'Archivo no soportado. La imagen debe ser extensi&oacute;n "jpg" o "png".';
                    AlertaMostrar('danger',mensaje);
                    break;
            }
        }
    }

    function ArchivoValidar(_fil_imagen){
        if($('#'+_fil_imagen).prop('name') != ''){
            let mensaje = '';
            let file = document.getElementById(_fil_imagen);
            if(file.value.indexOf('.') < 0 || !file){
                file.value='';
                mensaje = 'Archivo no soportado. Elija un archivo diferente.';
                AlertaMostrar('danger',mensaje);
                return false;
            }
            let ext = file.value.match(/\.([^\.]+)$/)[1];
            switch(ext.toLowerCase()) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'doc':
                case 'docx':
                case 'xls':
                case 'xlsx':
                case 'ppt':
                case 'pptx':
                case 'txt':
                case 'pdf':
                case 'mp3':
                case 'wav':
                case 'wma':
                case 'mp4':
                case 'avi':
                case 'mpeg':
                case 'mpg':
                case 'flv':
                    break;
                default:
                    file.value = '';
                    mensaje = 'Archivo no soportado. Elija un archivo diferente.';
                    AlertaMostrar('danger',mensaje);
                    break;
            }
        }
    }

    function ObtenerFechaHora(_fecha_hora){
        let today = '';
        if(!_fecha_hora){
            today = new Date();
        }
        else{
            today = new Date(_fecha_hora);
        }
        var mes = today.getMonth()+1;
        mes = mes > 9 ? "" + mes: "0" + mes;
        var dia = today.getDate();
        dia = dia > 9 ? "" + dia: "0" + dia;
        var date = dia+'/'+mes+'/'+today.getFullYear();
        var horas = today.getHours();
        horas = horas > 9 ? "" + horas: "0" + horas;
        var minutos = today.getMinutes();
        minutos = minutos > 9 ? "" + minutos: "0" + minutos;
        var segundos = today.getSeconds();
        segundos = segundos > 9 ? "" + segundos: "0" + segundos;
        var time = horas + ":" + minutos + ":" + segundos;
        var dateTime = date+' '+time;
        return dateTime;
    }

    function ObtenerFecha(_fecha){
        let today = '';
        if(!_fecha){
            today = new Date();
        }
        else{
            today = new Date(_fecha);
        }
        var mes = today.getMonth()+1;
        mes = mes > 9 ? "" + mes: "0" + mes;
        var dia = today.getDate();
        dia = dia > 9 ? "" + dia: "0" + dia;
        var date = dia+'/'+mes+'/'+today.getFullYear();
        return date;
    }