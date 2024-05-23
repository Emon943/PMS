<?php
include '../../includes/core/document_head_module.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Report Print</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script language="javascript" type="text/javascript" src="../jquery/jquery-1.4.4.js"></script>
        <style>
            .tablesorter{
                font-size:11px; 
                text-align:left;
                font-family:Tahoma, Geneva, sans-serif;
            }
            body{
                /*                font-size:16px; 
                                text-align:left;
                                font-family:Tahoma, Geneva, sans-serif;*/
                background-color: #ffffff;
                background-image: none;
                color: #000;
            }
            table tr thead th
            {
                background-color: #FAFAFA;
                /*border: 1px #000000 solid;*/
                font-size: 12px;
                font-family: sans-serif;
                color: #000;
            }
            table tr td{
                /*border: 1px #000000 solid;*/
                font-size: 12px;
                font-family: sans-serif;
                color: #000;
            }
            table{
                border-spacing: 0;
            }
        </style>                     
    </head>
    <body style="margin-left: 20px;margin-right: 20px;" bgcolor="#ffffff">
        <table cellpadding="0" cellspacing="0" width="842" border="0" align="left" style="border: none !important;">
            <tr style="border: none !important;">
                <td valign="top" align="left" style="border: none !important;">
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
            $("#ReportTableInner").attr("border","1");
            $("#ReportTableInner").attr("cellpadding","3");
            $("#ReportTableInner").attr("cellspacing","0");
            $("#ReportTableInner").attr("style","border-collapse: collapse");
        </script>        
    </body>
</html>