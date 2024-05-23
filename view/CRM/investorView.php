<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$investorID=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM   `investor_personal`  INNER JOIN `investor` 
        ON (`investor_personal`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_passport` 
        ON (`investor_passport`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_tax_details` 
        ON (`investor_tax_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_bank_details` 
        ON (`investor_bank_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_exchange_details` 
        ON (`investor_exchange_details`.`investor_id` = `investor`.`investor_id`) WHERE `investor`.`investor_id`='".$db_obj->EString($investorID)."'");
			  $investor=$db_obj->getResult();
			  if(!$investor){
				   echo "<h2>Investor Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?investor_list" class="btn alert-info"><span class="icon-th-large"></span> All Investor </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Investor</h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
                     
       	
        <div align="center">
          <table width="80%" border="0">
            <tr>
              <td colspan="2" align="center"><strong>CAPM Advisory Limited</strong><br />
                16 Kemal Ataturk Avenue Banani<br />
                Tower Hamlet (9th Fl)<br />
                Dhaka 1213 Bangladesh<br />
              Tel. No.: 9822391-2</td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td height="83"><strong><?php echo $investor[0]['created_set_date']?></strong><br />
                <strong><?php echo $investor[0]['investor_name']?></strong><br />
                <?php echo $investor[0]['address']?></td>
              <td rowspan="2" align="right"><table width="140" height="118" border="1" cellpadding="3" cellspacing="3">
                <tr>
                  <td width="130" height="112">
                  <?php 
				  if(file_exists("pms_doc_upload/investor_img/".$investor[0]['investor_ac_number'].".jpeg")){
?>
 <img src="pms_doc_upload/investor_img/<?php echo $investor[0]['investor_ac_number'];?>.jpeg" width="130" height="130" />
<?php
					  }
				  ?>
                  
                  
                 </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="18"><p><br />
              </p></td>
            </tr>
            <tr>
              <td colspan="2"><p>&nbsp;</p>
                <p><strong>Subject: BO Setup Acknowledgement</strong><br />
                  Dear Sir/Madam,<br />
                  We are pleased to inform you that your request for opening a new BO account has been setup.<br />
                  BO Account Number :<strong><?php echo $investor[0]['investor_ac_number']?></strong><br />
                  DP Internal Reference Number :<strong><?php echo $investor[0]['dp_internal_ref_number']?></strong><br />
                  Please verify BO Account Details specified in Annexure.<br />
                  All further communication in this connection should be addressed quoting Beneficiary Identification Number (BO ID) to us as stated above. Assuring you of our best services always.<br />
                  Thanking You,<br />
                  Yours faithfully<br />
              Authorised Signatory</p></td>
            </tr>
            <tr>
              <td height="24" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>PERSONAL DETAILS</strong></td>
            </tr>
            <tr>
              <td width="49%"><strong>DP Internal Reference Number</strong></td>
              <td width="51%" align="center"><strong><?php echo $investor[0]['dp_internal_ref_number']?></strong></td>
            </tr>
            <tr>
              <td><strong>BO ID</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['investor_ac_number']?></strong></td>
            </tr>
            <tr>
              <td><strong>Account Status</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['account_status']?></strong></td>
            </tr>
            <tr>
              <td><strong>BO Type</strong></td>
              <td align="center"><strong><?php echo $investor[0]['bo_type']?></strong></td>
            </tr>
			 <tr>
              <td><strong>BO Category</strong></td>
              <td align="center"><strong><?php echo $investor[0]['bo_catagory']?></strong></td>
            </tr>
            <tr>
              <td><strong>Name of the First Holder / </strong><strong>Company</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['name_of_first_holder']?></strong></td>
            </tr>
            <tr>
              <td><strong>Second Joint Holder</strong></td>
              <td align="center"><strong><?php echo $investor[0]['second_joint_holder']?></strong></td>
            </tr>
            <tr>
              <td><strong>Third Joint Holder</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['third_joint_holder']?></strong></td>
            </tr>
            <tr>
              <td><strong>Contact Person</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['contact_person']?></strong></td>
            </tr>
            <tr>
              <td><strong>Sex Code</strong></td>
              <td align="center"><strong><?php echo $investor[0]['sex_code']?></strong></td>
            </tr>
            <tr>
              <td><strong>Date of Birth / Registration</strong></td>
              <td align="center"><strong><?php echo $investor[0]['date_of_birth']?></strong></td>
            </tr>
            <tr>
              <td><strong>Registration Number</strong></td>
              <td align="center"><strong><?php echo $investor[0]['registration_number']?></strong></td>
            </tr>
            <tr>
              <td><strong>Father / Husbands Name</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['father_husbands']?></strong></td>
            </tr>
            <tr>
              <td><strong>Mothers Name</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['mothers_name']?></strong></td>
            </tr>
            <tr>
              <td><strong>Occupation</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['occupation']?></strong></td>
            </tr>
            <tr>
              <td><strong>Residency Flag</strong><br />
              <br /></td>
              <td align="center"><strong><?php echo $investor[0]['residency_flag']?></strong></td>
            </tr>
            <tr>
              <td><strong>Citizen Of</strong><br />
              <br /></td>
              <td align="center"><strong><?php echo $investor[0]['citizen_of']?></strong></td>
            </tr>
            <tr>
              <td><strong>Address</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['address']?></strong></td>
            </tr>
            <tr>
              <td><strong>City</strong></td>
              <td align="center"><strong><?php echo $investor[0]['city']?></strong></td>
            </tr>
            <tr>
              <td><strong>State/Division</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['state']?></strong></td>
            </tr>
            <tr>
              <td><strong>Country</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['country']?></strong></td>
            </tr>
            <tr>
              <td><strong>Postal Code</strong><br />
              <br /></td>
              <td align="center"><strong><?php echo $investor[0]['postal_code']?></strong></td>
            </tr>
            <tr>
              <td><strong>Phone</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['phone']?></strong></td>
            </tr>
            <tr>
              <td><strong>Email</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['email']?></strong></td>
            </tr>
            <tr>
              <td><strong>Fax</strong><br /></td>
              <td align="center"><strong><?php echo $investor[0]['fax']?></strong></td>
            </tr>
            <tr>
              <td><strong>Statement Cycle Code</strong></td>
              <td align="center"><strong><?php echo $investor[0]['statement_cycle_code']?></strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>SHORT NAME</strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>First Holder</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong><?php echo $investor[0]['name_of_first_holder']?></strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Second Holder</strong><br /></td>
              <td height="-2" align="center" valign="top"  ><strong><?php echo $investor[0]['second_joint_holder']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Third Holder</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['third_joint_holder']?></strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>PASSPORT DETAILS</strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Passport No.</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong><?php echo $investor[0]['passport_no']?></strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Passport Issue Date</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['passport_issu_date']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Passport Expiry Date</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['passport_expiry_date']?></strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Passport Issue Place</strong></td>
              <td height="-4" align="center" valign="top"  ><strong><?php echo $investor[0]['passport_issue_place']?></strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>BANK DETAILS</strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Routing Number</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['routing_number']?></strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Bank Name</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong><?php echo $investor[0]['bank_name']?></strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Branch Name</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['branch_name']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Bank A/C No.</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['bank_ac_no']?></strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Bank Identifier Code (BIC)</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong><?php echo $investor[0]['bic_code']?></strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>International Bank A/C No. (IBAN)</strong></td>
              <td height="-2" align="center" valign="top"  ><strong><?php echo $investor[0]['iban']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>SWIFT CODE</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['swift_code']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Electronic Dividend</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['electronic_divi']?></strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>TAX DETAILS</strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Tax Exemption</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['exemption']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Tax Identification No</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['identification_no']?></strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>EXCHANGE DETAILS</strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Exchange Name</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['exchang_name']?></strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Trading ID</strong></td>
              <td height="-1" align="center" valign="top"  ><strong><?php echo $investor[0]['trading_id']?></strong></td>
            </tr>
          </table>
          </form> 
        </div>

                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
            <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script> 
            <script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'Investor', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Investor</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<p align="right">
           <input type="button" value="Print" onclick="PrintElem('#mydiv')" />
           
           </p>
         