<?php
// Silence is golden.
   if (current_user_can('administrator') || current_user_can('contentmanager') ) {
       
  
   
   
       
     // update_user_meta( get_current_user_id(), 'company_name_new', get_site_url() );
      
      
     
     // $currentsite = get_user_meta(get_current_user_id(), 'company_name_new', true); 
   //   $all_meta_for_user = get_user_meta(get_current_user_id());
   //   echo $wpdb->get_blog_prefix();
    
   //   echo '<pre>';
   //   print_r($user_role);exit;
      $test = 'custome_task_manager_data';
      $result = get_option($test);
      $settitng_key='ContenteManager_Settings';
      $additional_fields_settings_key = 'EGPL_Settings_Additionalfield';
      $additional_fields = get_option($additional_fields_settings_key);
      $welcomeemail_template_info_key='AR_Contentmanager_Email_Template_welcome';
      $welcomeemail_template_info = get_option($welcomeemail_template_info_key);
    
      
      
      $sponsor_info = get_option($settitng_key);
    
      $sponsor_name = $sponsor_info['ContentManager']['sponsor-name'];
      //echo '<pre>';
     //print_r( $result); exit;
      global $wp_roles;

      $all_roles = $wp_roles->roles;
      $welcomeemail_template_info_key='AR_Contentmanager_Email_Template_welcome';
      $welcomeemail_template_info = get_option($welcomeemail_template_info_key);
     
       include 'cm_header.php';
       include 'cm_left_menu_bar.php';
                ?>


          <select id="hiddenlistemaillist" style="display: none;">
                
                <?php  foreach ($welcomeemail_template_info as $key=>$value) { 
                                            
                                            $template_name = ucwords(str_replace('_', ' ', $key));
                                            if($key == "welcome_email_template"){
                                                 echo  '<option value="' . $key . '" selected="selected">Default Welcome Email</option>';
                                            }else{
                                                 echo  '<option value="' . $key . '" >'.$template_name.'</option>';
                                            }
                                          
                                         }
                ?>
                                     
                
        </select>
         <select  id="hiddenlistusersrole" style="display: none;">
								
                                                                     
                                                                         <?php
                                                                         foreach ($all_roles as $key => $name) {


                                                                             if ($key != 'administrator' && $key != 'contentmanager' && $key != 'subscriber') {
                                                                                 echo '<option value="' . $key . '">' . $name['name'] . '</option>';
                                                                             }
                                                                         }
                                                                         ?>
								 </select>


        <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Create User</h3>
                           
                        </div>
                    </div>
                </div>
            </header>

            <div class="box-typical box-typical-padding">
                <p>
                Create a new user with a unique and valid email address.
                </p>

                

              <form method="post" action="javascript:void(0);" onSubmit="add_new_sponsor()">
                  <br>
                  <br>
                <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										<i class="fa fa-info-circle" ></i>
										Basic Information
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										<span class="fa fa-list-alt"></span>
										Additional Information
									</span>
								</a>
							</li>
							
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                                        <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Email <strong>*</strong></label>
                                    <div class="col-sm-5">
                                           
					<input type="text"  class="form-control" id="Semail" placeholder="Email" required>
                                                               
                                        
                                    </div>
                                    <div class="col-sm-5">
                                        
                                        <a class="btn btn-inline" onclick="checkemailaddressalreadyexist()" >Find email address</a>
                                        
                                    </div>
                                </div>
                   <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">First Name <strong>*</strong></label>
                                    <div class="col-sm-10">
                                         
								<input type="text"  class="form-control mymetakey" id="Sfname" name="first_name" placeholder="First Name" required>
								
                                        
                                    </div>
                                </div>
                   <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Last Name <strong>*</strong></label>
                                    <div class="col-sm-10">
                                        
								<input type="text"  class="form-control mymetakey" id="Slname" name="last_name" placeholder="Last Name" required>
								
                                        
                                    </div>
                                </div>
                  <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">User Level <strong>*</strong></label>
                                    <div class="col-sm-10">
                                           
								 <select  class="form-control" id="Srole" required>
								
                                                                     <option></option>
                                                                         <?php
                                                                         foreach ($all_roles as $key => $name) {


                                                                             if ($key != 'administrator' && $key != 'contentmanager' && $key != 'subscriber') {
                                                                                 echo '<option value="' . $key . '">' . $name['name'] . '</option>';
                                                                             }
                                                                         }
                                                                         ?>
								 </select>
					    
                                        
                                    </div>
                 </div>
                
                    <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Company Name <strong>*</strong></label>
                                    <div class="col-sm-10">
                                        
				<input type="text"  class="form-control mymetakey" id="company_name" name="company_name" placeholder="Company Name" required>
								
                                        
                                    </div>
                                </div>
                    <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Company Logo </label>
                                    <div class="col-sm-10">
                                                     
                                          
					<input  type="file" class="form-control" name="profilepic" id="profilepic" >				
								
				    </div>
                                    
		</div>
                                        
                                    </div><!--.tab-pane-->
                <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
                           
                       <?php   foreach ($additional_fields as $key=>$value){  if($additional_fields[$key]['name'] !='Notes'){?>
                               
                                <div class="form-group row" >
                                    <label class="col-sm-2 form-control-label"><?php echo $additional_fields[$key]['name'];?></label>
                                    <div class="col-sm-10">
                                        
					<input type="text"  class="form-control mymetakey" id="<?php echo $additional_fields[$key]['key'];?>" name="<?php echo $additional_fields[$key]['key'];?>" placeholder="<?php echo $additional_fields[$key]['name'];?>" >
								
                                        
                                    </div>
                                </div>
                           
                       <?php }} ?>
                             
                                <div class="form-group row" >
                                    <label class="col-sm-2 form-control-label">Notes</label>
                                    <div class="col-sm-10">
                                        
                                        <textarea   class="form-control mymetakey" id="usernotes" name="usernotes"  ></textarea>
								
                                        
                                    </div>
                                </div>
	                  
                                    </div><!--.tab-pane-->
					
				</div><!--.tab-content-->
			</section><!--.tabs-section-->
                  
                   
             
           
                       
                    
                     <div class="row" style="margin-bottom: 5px;">
                        <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <div class="checkbox" id="checknewuserdiv">
                                    <input  type="checkbox" id="checknewuser">Send welcome email.<br/>
                                    
                                   
                                </div>
                               

                            </div>
                    </div>
                        <div class="row" id="showlistofselectwelcomeemail" style="display:none;margin-bottom: 15px;">
                        <label class="col-sm-2 form-control-label">Select Welcome Email Template</label>
                            <div class="col-sm-10">
                                
                                    <select style="width:100%;height:38px;"class="form-control" id="selectedwelcomeemailtemp">
                                    <?php  foreach ($welcomeemail_template_info as $key=>$value) { 
                                            
                                            $template_name = ucwords(str_replace('_', ' ', $key));
                                            if($key == "welcome_email_template"){
                                                 echo  '<option value="' . $key . '" selected="selected">Default Welcome Email</option>';
                                            }else{
                                                 echo  '<option value="' . $key . '" >'.$template_name.'</option>';
                                            }
                                          
                                         }
                                        ?>
                                     
                                   </select>
                                
                               

                            </div>
                    </div>
                  <div class="form-group row">
                                    <label class="col-sm-2 form-control-label"></label>
                                    <div class="col-sm-6">
                                             <button type="submit" id="addnewsponsor_q" name="addsponsor"  class="btn btn-lg mycustomwidth btn-success" value="Register">Create</button>
                                            
                                        
                                    </div>
                                </div>
                  
                

                </form>
            </div>
        </div>
    </div>
     
                              
                                   




        
       
				<?php   include 'cm_footer.php';
		
      
      
      
       
   }else{
       $redirect = get_site_url();
    wp_redirect( $redirect );exit;
   
   }
   ?>