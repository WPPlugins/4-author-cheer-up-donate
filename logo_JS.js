jQuery( function() {
var AcuD_POZ = false;
    jQuery( ".AcuD_logo" ).tooltip();

	jQuery(".AcuD_logo").bind('click', function(e) {
		jQuery('#AcuD_popUp').css("width",(document.body.clientWidth*0.7).toFixed()+"px");
		e.preventDefault();
                jQuery('#AcuD_popUp').bPopup({
            speed: 350,
			 transition: 'slideIn',
			onClose: function() { if(AcuD_POZ){jQuery('#AcuD_popUp2').bPopup({speed: 300});AcuD_POZ = false;} }
        });
		jQuery('#AcuD_popUp').css("max-width","70%");
            });
			jQuery('.AcuD_logo_Levels').bind('click', function(e) {
                e.preventDefault();
			 AcuD_shp_item = jQuery(this).attr("id").substr(-1);
                AcuD_POZ = true;
                jQuery(".b-close").click();
				
		
            });
			
		
  } );
