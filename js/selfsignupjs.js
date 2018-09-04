function selfisignupadd_new_sponsor(){
    
    
  var url = currentsiteurl + "/";
  var email =  jQuery("#Semail").val();
  var profilepic = jQuery('#profilepic')[0].files[0]; 
  var data = new FormData();
  
  var sponsorlevel = 'subscriber';
  var urlnew = url + 'wp-content/plugins/EGPL/userreport.php?contentManagerRequest=selfsignadd_new_sponsor_metafields';
 
  jQuery("body").css("cursor", "progress");
  if(email !=""  ){
      
       data.append('username', email);
       data.append('email', email);
       data.append('profilepic', profilepic);
       data.append('sponsorlevel', sponsorlevel);
       
       jQuery('.mymetakey').each(function(){
           
            data.append(jQuery(this).attr( "name" ), jQuery(this).val());
       });
       
       
       jQuery.ajax({
            url: urlnew,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data) {
                
               var message = jQuery.parseJSON(data);
              
               
               jQuery('body').css('cursor', 'default');
                if(message.msg == 'User created'){
                    
                    jQuery("form")[0].reset();
                    swal({
					title: "Success",
					text: message.showmsg,
					type: "success",
                                        html:true,
					confirmButtonClass: "btn-success",
					confirmButtonText: "Ok"
				});
                    


                }else{
                    
                    swal({
					title: "Error",
					text: message.msg,
					type: "error",
                                        html:true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Ok"
                                       
				});
                }
               
                
            },error: function (xhr, ajaxOptions, thrownError) {
                    swal({
					title: "Error",
					text: "There was an error during the requested operation. Please try again.",
					type: "error",
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Ok"
				});
            }
        });

        
      
      
      
  }
}

function openpopup(){
    
    var url = currentsiteurl + "/";
    jQuery('.fusion-header-wrapper').css("z-index", "9998");
    
    jQuery.confirm({
            title: 'Floor Plan',
            content:'<iframe height="600" src="'+url+'/floor-plan-viewer/" width="100%"  frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
            closeIcon: true,
            columnClass: 'jconfirm-box-container-special',
            confirmButton:false,
            cancelButton:false,
         });
    
    
    
}