$(document).ready(function(){
	var ExisteCookie = document.cookie.charAt(0);
	if(ExisteCookie=="e"){
		$("#modal_error").modal("show");
		document.cookie = "error=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
	}
	$("#anadir_hilo").click(function(){
		$(".new_hilo").show("fast");
	});
 	$('#botonregistro').click(function(){
		$("#myModal").modal("show");
	});
	$('#registro').click(function(){
		$("#formulario").hide("fast");
		$("#registrado").show("slow");
	});
	$(function() {
	    var pull = $('#hamburguesa');
	    menu = $('div#menu div.menuregistrado');
	    menuHeight = menu.height();
	
	    $(pull).on('click', function(e) {
	        e.preventDefault();
	        menu.slideToggle();
	    });
	});
	$(window).resize(function(){
	    var w = $(window).width();
	    if(w > 320 && menu.is(':hidden')) {
	        menu.removeAttr('style');
	    }
	});

	if(location.href.indexOf('consulta') != -1 && location.href.indexOf('xs=0') != -1 || location.href.indexOf('catalogoprop') != -1){
		$(".catalogoprop").addClass("colorear");
	}
	if(location.href.indexOf('consulta') != -1 && location.href.indexOf('xs=1') != -1 || location.href.indexOf('catalogoglobal') != -1){
		$(".catalogoglobal").addClass("colorear");
	}
	if(location.href.indexOf('informacion') != -1){
		$(".informacion").addClass("colorear");
	}
	if(location.href.indexOf('noticias') != -1 || location.href.indexOf('consultar_noticia') != -1){
		$(".noticias").addClass("colorear");
	}
	if(location.href.indexOf('foro') != -1 || location.href.indexOf('mensajes') != -1){
		$(".foro").addClass("colorear");
	}
	if(location.href.indexOf('anadir2') != -1){
		$(".registrate").addClass("colorear");
	}
	if(location.href.indexOf('index') != -1){
		$(".home").addClass("colorear");
	}
	//Consultar imagenes
	cont=1;
	$('#plus').click(function(){		
		$("#nuevos_input").append('<div class="form-group col-12 fotos'+cont+'"><label id="reg_setas">Foto '+cont+'<input type="file" class="form-control" name="imagen'+cont+'"/></label></div>');
		cont++;
		if(cont==2){
			$("#menos").show();
		}
	});
	$('#plus_foto').click(function(){		
		$("#nuevos_input").append('<div class="form-group col-xs-12 col-md-12 col-lg-12 fotos'+cont+'"><label id="reg_setas">Foto '+cont+'<input type="file" class="form-control" name="imagen'+cont+'"/></label></div>');
		cont++;
		if(cont==2){
			$("#menos").show();
		}
	});
	$('#menos_foto').click(function(){	
		cont--;	
		$(".fotos"+cont).remove();
		if(cont==0){
			$("#menos_foto").hide();
		}
	});
	$('#menos').click(function(){	
		cont--;	
		$(".fotos"+cont).remove();
		if(cont==1){
			$("#menos").hide();
		}
		
	});	
	$(".principal").fancybox(function(){
        image : {
            protect: true
        }
    });
	cont_img=$('#carrusel_image>label').length + 2;
	array_fotos=new Array();
	for (var i = 0; i < cont_img; i++) {
		$("#imagen_carru"+i).click(function(){
			$('#principal').attr('src', $(this).attr('src'));
			$('.principal').attr('href', $(this).attr('src'));
		});
	};
	$('#mas_fotos').click(function(){
		$("#Modal_fotos").modal("show");
	});
	$('#menos_fotos').click(function(){
		$("#Modal_borrar").modal("show");
	});
	// funcion_catglob='function(){$("#Modal_catglobal").modal("show");}';
	$('#quitar_global').click(function(){$("#Modal_catglobal_borrar").modal("show");});
	$('#anadir_global').click(function(){$("#Modal_catglobal_anadir").modal("show");});

	//descripcion de añadir setas
	initSample();
	$('.enviar_seta').click(function(){
		var descripcion = $(".cke_wysiwyg_frame").contents().find(".cke_contents_ltr").html();
		descripcion=descripcion.replace("&nbsp,", "");
		descripcion=descripcion.replace(";", "");
		desc=descripcion.split(";");
		descripcion="";
		for(i=0;i<desc.length;i++)descripcion=descripcion+desc[i];
		document.cookie = 'descripcion='+descripcion;
	});
	//Activar o desactivar los checkbox de mortal y comentible
	$('[name=mortal]').click(function(){
		if($('[name=mortal]').is(':checked')){
			$('[name=comestible]').attr("disabled", true);
		}else{
			$('[name=comestible]').removeAttr('disabled');
		}
	});
	$('[name=comestible]').click(function(){
		if($('[name=comestible]').is(':checked')){
			$('[name=mortal]').attr("disabled", true);
		}else{
			$('[name=mortal]').removeAttr('disabled');
		}
	});
	
});