<?php
/******************************************************************************
#                      PayPal PRO Payment Terminal v3.0
#******************************************************************************
#      Author:     Convergine.com
#      Email:      info@convergine.com
#      Website:    http://www.convergine.com
#
#
#      Version:    3.0
#      Copyright:  (c) 2012 - Convergine.com
#
#*******************************************************************************/
	
	//REQUIRE CONFIGURATION FILE
	require("includes/config.php"); //important file. Don't forget to edit it!
	//DEFAULT PARAMETERS FOR FORM [!DO NOT EDIT!]
	$show_form=1;
	$mess="";
	//REQUEST VARIABLES 
	$profileID = (!empty($_REQUEST["profileID"]))?strip_tags(str_replace("'","`",$_REQUEST["profileID"])):'';
	$action = (!empty($_REQUEST["action"]))?strip_tags(str_replace("'","`",$_REQUEST["action"])):'';
	$description = (!empty($_REQUEST["description"]))?strip_tags(str_replace("'","`",$_REQUEST["description"])):'';
	//FORM SUBMISSION PROCESSING 
	if(!empty($_POST["process"]) && $_POST["process"]=="yes"){
		require("includes/form.processing.recurring.php");
	}  
	//REQUIRE SITE HEADER TEMPLATE		
	require "includes/site.header.php";
?>
<div align="center" class="wrapper">

    <div class="form_container">
    	<h1>Manage Recuriing Payments Profile</h1>
        <form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data"  class="pppt_form">
            <?php echo $mess; ?>
            <div id="accordion">               
                <?php if($show_form){ ?>
            	<!-- PAYMENT BLOCK -->
                <h2 class="current">Payment Information</h2>
                <div class="pane" style="display:block">
						
						
						<label>ProfileID:</label>
                        <input name="profileID" id="profileID" type="text" class="long-field" value="<?php echo $profileID;?>"  onkeyup="checkFieldBack(this);noAlpha(this);" onkeypress="noAlpha(this);" />
                        <div class="clr"></div>
						
						<label>Action:</label>
						<select onchange="checkFieldBack(this)" class="long-field" id="action" name="action">
							<option value="">Please Select</option>
							<option value="Cancel">Cancel </option>
							<option value="Suspend">Suspend </option>
							<option value="Reactivate">Reactivate </option>
							
						</select>
						
                        <label>Description:</label>
                        <input name="description" id="description" type="text" class="long-field"  value="<?php echo $description;?>" onkeyup="checkFieldBack(this);" />
                        <div class="clr"></div>
                        <div class="submit-btn"><input src="images/btn_submit.jpg" type="image" name="submit" /></div>
                    <input type="hidden" name="process" value="yes" />
                    
                </div>
            	<!-- PAYMENT BLOCK -->

                <?php } ?>
            
            </div>
        </form> 
    </div>
    

    
</div>


<?php require "includes/site.footer.php"; ?>