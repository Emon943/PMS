<?php 
include '../../includes/core/document_head_module.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Report Print</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        ?>
        <style>
            table tr td{
                border: 1px;
            }
            .tablesorter{
                font-size:16px; 
                text-align:left;
                font-family:Tahoma, Geneva, sans-serif;
                 background-color: #ffffff;
                background-image: none;
            }
            .impCLass{
                display:none !important;
            }
            .impCLass2{
                display:block !important;
            }
            .sp_class{
                background: none repeat scroll 0 0 grey !important;
                border-radius: 5px 5px 5px 5px !important;
                float: none !important;
                margin-top: 0px !important;
                padding: 3px !important;		
            }
        </style>  
        <style>
            .lbl_title_bold{
                font-weight: bold;
                font-size: 12px;
            }
            .lbl_value_bold{
                font-weight: bold; 
                border-bottom-style: dashed;
                border-width: 1px;
                font-size: 12px;
            }
            .lbl_title{
                font-size: 12px;
            }
            .lbl_value{
                border-bottom-style: dashed; 
                border-width: 1px;
                font-size: 12px;
            }
            table tr thead th{
                background-color: #FAFAFA;
                border: 1px #000000 solid;
                font-size: 12px;
                font-family: sans-serif;
            }
            table tr td{
                border: 1px #000000 solid;
                font-size: 11px;
                font-family: sans-serif;
            }
            table{
                border-spacing: 0;
            }
        </style>
    </head>
    <body style="margin-left: 2px; margin-right: 2px; background-color: #fff;" bgcolor="#ffffff">
        <table cellpadding="0" cellspacing="0" width="450" border="0" align="left">
            <tr>
                <td valign="top" align="left">
                    <script language="javascript">
                        <!--
                        window.onerror = scripterror;				
                        function scripterror()
                        {
                            return true;
                        }
                        varele1=window.opener.document.getElementById("<?php echo $_REQUEST['selLayer']; ?>");
                        text=varele1.innerHTML;
                        document.write(text);
                        text=document;
                        print(text);
                        //-->
                    </script>
                </td>
            </tr>			
        </table>
        <script>
            $("#ReportTable").attr("border","1");
            $("#ReportTable").attr("cellpadding","3");
            $("#ReportTable").attr("cellspacing","0");
            $("#ReportTable").attr("style","border-collapse: collapse");
            $("#ReportTable tr").attr("style","display: show");
        </script>        
    </body>
</html>