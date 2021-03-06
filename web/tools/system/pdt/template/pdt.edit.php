<!--
 /*
 * $Id: pdt.edit.php 287 2011-10-17 09:41:35Z untiptun $
 * Copyright (C) 2011 OpenSIPS Project
 *
 * This file is part of opensips-cp, a free Web Control Panel Application for 
 * OpenSIPS SIP server.
 *
 * opensips-cp is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * opensips-cp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
-->

<?php
if ($config->sdomain) {
	$xtra="&sdomain=".$_GET['sdomain'];
	$sql = "SELECT * FROM ".$config->table_domains." WHERE (1=1) ORDER BY domain ASC";
	$resultset = $link->queryAll($sql);
	if(PEAR::isError($resultset)) {
		die('Failed to issue query, error message : ' . $resultset->getMessage());
        }
	$sdomain_input='<select name="sdomain" class="newPdt">';
	for($i=0;count($resultset)>$i;$i++)
	{
	if ($resultset[$i]['domain']==$row_e[0]['sdomain']) $sdomain_input.='<option value="'.$resultset[$i]['domain'].'" selected>'.$resultset[$i]['domain'].'</option>';
	else $sdomain_input.='<option value="'.$resultset[$i]['domain'].'">'.$resultset[$i]['domain'].'</option>';
	}
	$sdomain_input.='</select>';
	$link->disconnect();
}
else $xtra="";
?>
<form action="<?=$page_name?>?action=modify&prefix=<?=$_GET['prefix']?><?=$xtra?>" method="post">
<input type="hidden" name="old_prefix" value="<?=$row_e[0]['prefix']?>">
<input type="hidden" name="old_sdomain" value="<?=$row_e[0]['sdomain']?>">
<table width="400" cellspacing="2" cellpadding="2" border="0">
 <tr align="center">
  <td colspan="2" class="pdtTitle">Edit Prefix 2 Domain</td>
 </tr>
<?php
if (isset($form_error)) {
	echo(' <tr align="center">');
	echo('  <td class="rowOdd" colspan="2"><div class="formError">'.$form_error.'</div></td>');
	echo(' </tr>');
}
print $resultset[0]['prefix'];
?>
 <tr>
  <td class="rowOdd"><b>Prefix:</b></td>
  <td class="rowOdd" width="250"><?=$config->start_string.$config->start_prefix?><input type="text" name="prefix" value="<?php echo substr($row_e[0]['prefix'],strlen($config->start_prefix))?>" maxlength="30" class="newPdt"></td>
 </tr>
<?php
if ($config->sdomain)
{
 ?>
 <tr>
  <td class="rowOdd"><b>source Domain:</b></td>
  <td class="rowOdd"><?=$sdomain_input?></td>
 </tr>
 <?php
}
?>
 <tr>
  <td class="rowOdd"><b>to Domain:</b></td>
  <td class="rowOdd"><input type="text" name="domain" value="<?=$row_e[0]['domain']?>" maxlength="255" class="newPdt"></td>
 </tr>
 <tr>
  <td class="rowOdd" colspan="2" align="center"><input type="submit" name="edit" value="Save" class="Button"></td>
 </tr>
 <tr>
  <td colspan="2" class="pdtTitle"><img src="images/spacer.gif" width="5" height="5"></td>
 </tr>
</table>
</form>
<?=$back_link?>
