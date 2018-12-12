<?php
// Silence is golden.
   if (current_user_can('administrator') || current_user_can('contentmanager') ) {
    
    $woocommerce_rest_api_keys = get_option( 'ContenteManager_Settings' );
    $wooconsumerkey = $woocommerce_rest_api_keys['ContentManager']['wooconsumerkey'];
    $wooseceretkey = $woocommerce_rest_api_keys['ContentManager']['wooseceretkey'];
    

    $test = 'custome_task_manager_data';
    $taskkeyContent = get_option($test);
    
    
  
if(!empty($wooconsumerkey) && !empty($wooseceretkey)){
    
       require_once( 'lib/woocommerce-api.php' );
       $url = get_site_url();
       $options = array(
            'debug'           => true,
            'return_as_array' => false,
            'validate_url'    => false,
            'timeout'         => 30,
            'ssl_verify'      => false,
        );
       
       
       global $wp_roles;
      
       
     
       
       
       
       
       $all_roles = $wp_roles->roles;
       $client = new WC_API_Client( $url, $wooconsumerkey, $wooseceretkey, $options );
       $product_cat_list = $client->products->get_categories() ;
       
       if(isset($_GET['producttype'])){
       
           
           $product_type = $_GET['producttype'];
           if ($product_type == 'Packages') {
                 
                 $product_name_for_fields_lebal = "Package";
                 
                 
             }elseif ($product_type == 'addons') {
                 
                 $product_name_for_fields_lebal = "Add-on";
             }elseif ($product_type == 'booths') {
                 
                 $product_name_for_fields_lebal = "Booth";
             }
           
           
           
           
       }
       
       if(isset($_GET['productid'])){
           
           $product_id = $_GET['productid'];
           $update_product = wc_get_product( $product_id );
           
          
           $selectedTaskListData = get_post_meta( $product_id);
           $selectedTaskList = unserialize($selectedTaskListData['seletedtaskKeys'][0]);
         
            foreach ($product_cat_list->product_categories as $cat_key=>$cat_value){
           
           
                if($cat_value->id == $update_product->category_ids[0]){
                    
                    $selectedcat_name = $cat_value->name;
                    
                    
                    
                }
           
           
                }
       
           
           
           
           if ($selectedcat_name == 'Packages') {
               
                $product_type = "package";
                
                $product_name_for_fields_lebal = "Package";
                
           }elseif ($selectedcat_name == 'Add-ons') {
                $product_type = "addons";
                $product_name_for_fields_lebal = "Add-on";
               
           }elseif ($selectedcat_name == 'Booths'){
               $product_type = "booths";
               $product_name_for_fields_lebal = "Booth";
           }
           
         
           
       }
       
        include 'cm_header.php';
        include 'cm_left_menu_bar.php';
       
    
       
                ?>
        <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            
                                   

                                        <h3><?php echo $product_name_for_fields_lebal;?></h3>
                                        
                                   
                            
                            
                           
                        </div>
                    </div>
                </div>
            </header>

            <div class="box-typical box-typical-padding">
                
                <?php if($product_type == 'package'){?>
                
                <p>
                    Fill out the required fields to create your package. A package is a Level in ExpoGenie that your users have the option to purchase. Whenever a user purchases a package, they will be automatically assigned OR re-assigned to the level associated with that package.
                </p>
                <?php }elseif($product_type == 'addons'){?>
                
                <p>
                    Fill out the required fields to create your add-on. Once published, these will be made available for all of your users within the portal to view and purchase.
                </p>
                
               
                <?php }elseif($product_type == 'booths'){?>
                
                <p>
                    Fill out the required fields to create your Booth.
                </p>
                
                <?php }?>
                <h5 class="m-t-lg with-border"></h5>
                

              <form method="post" action="javascript:void(0);" onSubmit="check_whocat_selet()">
                
              

                  <input type="hidden" id="productid" value="<?php echo $product_id;?>" />
                  <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Title <strong>*</strong></label>
                          <div class="col-sm-10">

                              <input type="text"  class="form-control" id="ptitle" value="<?php echo $update_product->name; ?>" placeholder="<?php echo $product_name_for_fields_lebal;?> Title" required>


                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Price <strong>*</strong></label>
                          <div class="col-sm-10">

                              <input type="number"  class="form-control" id="pprice" name="pprice" value="<?php echo $update_product->regular_price; ?>" placeholder="<?php echo $product_name_for_fields_lebal;?> Price" required>


                          </div>
                      </div>
                     
                     <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Stock status <strong>*</strong></label>
                          <div class="col-sm-10">

                              <select onchange="checkstockstatus()" id="pstrockstatus" class="form-control" required>
                                 
                                <?php if(isset($_GET['productid'])){
                                    if($update_product->stock_status == 'instock'){?>
                                    
                                    <option value="instock" selected="selected">In Stock</option> 
                                    <option value="outofstock">Out of Stock</option>
                                    <?php }else{ ?>
                                    <option value="instock">In Stock</option>
                                    <option value="outofstock" selected="selected">Out of Stock</option> 
                                   <?php }  ?>
                                <?php }else{?>
                                    <option value="instock" selected="selected">In Stock</option> 
                                    <option value="outofstock">Out of Stock</option>
                                <?php }?>
                              </select>


                          </div>
                    </div>
                  <div class="quanititybox">
                      <?php if (isset($_GET['productid'])) { if($update_product->stock_status == 'instock'){ ?>
                  <div class="form-group row stockstatusbox">
                          <label class="col-sm-2 form-control-label">Stock Quantity<strong>*</strong></label>
                          <div class="col-sm-10">

                              <input type="number"  class="form-control" id="pquanitity" value="<?php echo $update_product->stock_quantity; ?>" name="pquanitity" placeholder="Stock Quantity" >


                          </div>
                 </div>
                      <?php }}else{?>
                  <div class="form-group row stockstatusbox" >
                          <label class="col-sm-2 form-control-label">Stock Quantity<strong>*</strong></label>
                          <div class="col-sm-10">

                              <input type="number"  class="form-control" id="pquanitity" name="pquanitity" placeholder="Stock Quantity" >


                          </div></div>
                    <?php }?>
                  </div>  
                  <div class="form-group row">
                          <label class="col-sm-2 form-control-label"><?php echo $product_name_for_fields_lebal;?> Status <strong>*</strong></label>
                          <div class="col-sm-10">

                              <select id="pstatus" class="form-control" required>
                                     
                                      
                                      <?php if (isset($_GET['productid'])) {
                                          if ($update_product->status == 'publish') {
                                              ?>

                                              <option value="publish" selected="selected">Published</option>
                                             
                                              <option value="draft">Draft (<?php echo $product_name_for_fields_lebal;?> will not be visible in the shop)</option>

                                            <?php } else if ($update_product->status == 'draft') { ?>

                                              <option value="publish" >Published</option>
                                              
                                              <option value="draft" selected="selected">Draft (<?php echo $product_name_for_fields_lebal;?> will not be visible in the shop)</option>

                                            <?php } } else { ?>

                                               <option value="publish" >Published</option>
                                              
                                               <option value="draft" selected="selected">Draft (<?php echo $product_name_for_fields_lebal;?> will not be visible in the shop)</option>
                                        <?php } ?>
                              </select>


                          </div>
                   </div>
                  <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Type </label>
                          <div class="col-sm-10">
                              
                              
                              
                              <select id="pcategories" class="form-control" onchange="checkptoducttype()" required style="display: none;">
                                    
                                      <?php if (isset($_GET['productid'])) { 
                                          
                                           
                                            $typename =  $selectedcat_name;
                                          
                                          ?>
                                          
                                         
                                          <?php
                                          foreach ($product_cat_list->product_categories as $key => $value) {

                                              if ($selectedcat_name == $value->name) {
                                                  ?>

                                                  <option value="<?php echo $value->id; ?>" selected="selected"><?php echo $value->name; ?></option>
                                              <?php } 
                                          }
                                      } elseif($product_type == 'package') { 
                                          
                                          $typename =  'Packages';
                                          
                                          
                                          ?>
                                          
                                            <?php foreach ($product_cat_list->product_categories as $key => $value) { ?>
                                                  <?php if($value->name == 'Packages'){?>
                                                  
                                                  <option value="<?php echo $value->id; ?>" selected="selected"><?php echo $value->name; ?></option>
                                                      
                                                  <?php } }
                                  } elseif($product_type == 'addons') { 
                                      
                                      $typename =  'Add-ons';
                                      
                                      ?>
                                              
                                       <?php foreach ($product_cat_list->product_categories as $key => $value) { ?>
                                            <?php if($value->name == 'Add-ons'){?>
                                              
                                                  <option value="<?php echo $value->id; ?>" selected="selected"><?php echo $value->name; ?></option>

                                            <?php  } }}else if($product_type == 'booths') { 
                                      
                                      $typename =  'Booths';
                                      
                                      ?> ?> 
                                             <?php foreach ($product_cat_list->product_categories as $key => $value) { ?>
                                            <?php if($value->name == 'Booths'){?>
                                              
                                                  <option value="<?php echo $value->id; ?>" selected="selected"><?php echo $value->name; ?></option>

                                            <?php  } }} ?> 
                                              
                                  </select>
                                  <label class="col-sm-2 form-control-label"><?php echo $typename;?></label>

                          </div>
                   </div>
                  <?php if($product_type == 'booths'){?>
                  <div class="form-group row" id="assignmentlevelfield" style="display: none;">
                    
                  <?php }else{ ?>
                  <div class="form-group row" id="assignmentlevelfield" >
                  <?php }?>
                                    <label class="col-sm-2 form-control-label">Assign Level <i data-toggle="tooltip" title="If you select a level here, the buyer of this product will be automatically assigned this level on successfully placing the order." class="fa fa-question-circle" aria-hidden="true"></i></label>
                                    <div class="col-sm-10">
                                           
								 <select  class="form-control" id="roleassign" >
								
                                                                     <option></option>
                                                                     <?php if (isset($_GET['productid'])) { 
                                                                         foreach ($all_roles as $key => $name) {


                                                                             if ($key != 'administrator' && $key != 'contentmanager' && $key != 'subscriber') {
                                                                                
                                                                                 if($update_product->tax_class == $key){
                                                                                     
                                                                                     echo '<option value="' . $key . '" selected="selected">' . $name['name'] . '</option>';
                                                                                 }else{
                                                                                 echo '<option value="' . $key . '">' . $name['name'] . '</option>';
                                                                                 }
                                                                             }
                                                                         } 
                                                                     }else{ 
                                                                        foreach ($all_roles as $key => $name) {


                                                                             if ($key != 'administrator' && $key != 'contentmanager' && $key != 'subscriber') {
                                                                                 echo '<option value="' . $key . '">' . $name['name'] . '</option>';
                                                                             }
                                                                         }
                                                                        
                                                                         
                                                                        }?>
								 </select>
					    
                                        
                                    </div>
                 </div>
                 <?php if($product_type == 'booths'){?>
                   <div class="form-group row" id="assignmentlevelfield" style="display: none;">
                    
                  <?php }else{ ?>
                   <div class="form-group row" id="assignmentlevelfield">
                  <?php }?>
                
                    
                 
                                    <label class="col-sm-2 form-control-label">Select Tasks <i data-toggle="tooltip" title="If you select one or more tasks here, the buyer of this product will be automatically assigned these tasks on successfully placing the order." class="fa fa-question-circle" aria-hidden="true"></i></label>
                                    <div class="col-sm-10">
                                           
								 <select  class="form-control" class="select2"  data-placeholder="Select Tasks" data-allow-clear="true" data-toggle="tooltip" multiple="multiple" id="selectedtasks" >
								
                                                                     <option></option>
                                                                     <?php if (isset($_GET['productid'])) { 
                                                                         foreach ($taskkeyContent['profile_fields'] as $taskindex => $taskValue) {


                                                                             
                                                                                
                                                                                 if (in_array($taskindex, $selectedTaskList['selectedtasks'])) {
                                                                                     
                                                                                     echo '<option value="' . $taskindex . '" selected="selected">' . $taskValue['label'] . '</option>';
                                                                                     
                                                                                 }else{
                                                                                     
                                                                                    echo '<option value="' . $taskindex . '">' . $taskValue['label'] . '</option>';
                                                                                 
                                                                                   
                                                                                 }
                                                                           
                                                                         } 
                                                                     }else{ 
                                                                        foreach ($taskkeyContent['profile_fields'] as $taskindex => $taskValue) {


                                                                           
                                                                                 echo '<option value="' . $taskindex . '">' . $taskValue['label'] . '</option>';
                                                                            
                                                                         }
                                                                        
                                                                         
                                                                        }?>
								 </select>
					    
                                        
                                    </div>
                 </div>
                  <div class="form-group row">
                          <label class="col-sm-2 form-control-label"><?php echo $product_name_for_fields_lebal;?> Image </label>
                          <div class="col-sm-10" id="changeimageupload" style="display:none;">
                              <input  type="file" class="form-control" id="updateproductimage" >				
                            </div>
                           <?php if (isset($_GET['productid'])) { 
                               $url = wp_get_attachment_thumb_url($update_product->image_id);
                               
                               
                              
                               
                               ?>
                                <div class="col-sm-5 productremoveimageblock">
                                   <img src="<?php echo $url; ?>" width="150" />
                                    <input type="hidden" id="productoldimage" value="<?php echo $update_product->image_id; ?>" />
                                </div>
                                <div class="col-sm-5 productremoveimageblock" style="margin-top: 5%;">
                                    <a   onclick="changeimage()" class="btn btn-lg btn-danger" >Change Image</a>
                                </div>
                           <?php }else{ ?>
                            <div class="col-sm-10">
                              <input  type="file" class="form-control" id="productimage" >				
                            </div>
                          <?php } ?>
                 </div>
                 <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Position</label>
                          <div class="col-sm-10">

                            <input  id="menu_order" class="form-control"  value="<?php echo $update_product->menu_order; ?>" type="number" >		

                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2 form-control-label"><?php echo $product_name_for_fields_lebal;?> Description </br>(Shown on Detail Page)</label>
                          <div class="col-sm-10">

                             
                              <textarea  class="pdescriptionbox"   id="pdescription"  ><?php echo $update_product->description; ?></textarea>		

                          </div>
                      </div>
                     <div class="form-group row">
                          <label class="col-sm-2 form-control-label"><?php echo $product_name_for_fields_lebal;?> Short Description </br>(Shown on Listing Page)</label>
                          <div class="col-sm-10">

                             <textarea   class="pdescriptionbox"  id="pshortdescription"  ><?php echo $update_product->short_description; ?></textarea>	


                          </div>
                      </div>
                    

                      <div class="form-group row">
                          <label class="col-sm-2 form-control-label"></label>
                          <div class="col-sm-6">
                              <button type="submit" id="addnewproduct" name="addsponsor"  class="btn btn-lg mycustomwidth btn-success" value="Register">Save</button>


                          </div>
                      </div>

                

                </form>
            </div>
        </div>
    </div>
    <?php  }else{?>
   <div class="page-content">
        <div class="container-fluid">
            <header class="section-header" id="bulkimport">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3><?php echo $product_name_for_fields_lebal;?></h3>
                           
                        </div>
                    </div>
                </div>
            </header>
            

            <div class="box-typical box-typical-padding" >
                <div class="form-group row">
                
                    <p class="col-sm-12 "><strong>Shop is not configured for this site. Please contact ExpoGenie.</strong></p>
               
                </div>
            </div>
        </div>
    </div>

    <?php }include 'cm_footer.php'; ?>
<script type="text/javascript" src="/wp-content/plugins/EGPL/js/manage-products.js?v=2.29"></script>
   
        
        
   <?php }else{
       $redirect = get_site_url();
    wp_redirect( $redirect );exit;
   
   }
   ?>