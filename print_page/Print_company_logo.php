<?php
@session_start();
@require_once '../../includes/core/all_class.inc.php';
$db=new Database();
?>
<table width="100%" id="" border="0">
    <tr>
        <td colspan="12" style="text-align: center;">
            <div>
                <img class="center" src="../../images/<?php echo $_SESSION['school_logo']; ?>" width="100" style="margin-left: 45%;"/>
                <h3>
                    <?php echo $_SESSION['school_name']; ?>
                </h3>
            </div>
            <div style="float: right;  ">
                Printing Date: <?php echo $db->date_formate($db->ToDayDate()) ?>
            </div>
        </td>
    </tr>
</table>