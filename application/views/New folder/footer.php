<script type="text/javascript" src="<?php echo base_url('assets/vendor/jquery/jquery-3.1.0.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/materialize/js/materialize.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/jquery-ui/jquery-ui.js');?>"></script>
<script>
$('document').ready( function() {
     $(function () {
        $("#nonpwp").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
            source: function( request, response) {
            $.ajax({
            	type:'get',
                url: '<?php echo site_url("Faktur/autocompletenpwp"); ?>',
                dataType: "json",
                data: request,
                success: function(data){
                    if(data.response == 'true') {
                       response(data.message);
                       console.log(data.message);                    
                   }
                },
                error: function(){
                	console.log('asdasd');
                }
            });
        },
        select: function( event, ui ) {
            //Do something extra on select... Perhaps add user id to hidden input    
            $('#namapt').val(ui.item.nama_perusahaan);
        },

    	});
	}); 
});
    </script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plus.js');?>"></script>
</html>