<?php
/*
* $Id: functions.inc.php 316 2014-06-23 12:27:25Z untiptun $
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

function get_priv() {

        $modules = get_modules();

        foreach($modules['Admin'] as $key=>$value) {
                $all_tools[$key] = $value;
        }
        foreach($modules['Users'] as $key=>$value) {
                $all_tools[$key] = $value;
        }
        foreach($modules['System'] as $key=>$value) {
                $all_tools[$key] = $value;
        }

        if($_SESSION['user_tabs']=="*") {
                foreach ($all_tools as $lable=>$val) {
                        $available_tabs[]=$lable;
                }
        } else {
                $available_tabs=explode(",",$_SESSION['user_tabs']);
        }

        if ($_SESSION['user_priv']=="*") {
                $_SESSION['read_only'] = false;
		$_SESSION['permission'] = "Read-Write";
        } else {
                $available_privs=explode(",",$_SESSION['user_priv']);
                if( ($key = array_search("permissions", $available_tabs))!==false) {
                        if ($available_privs[$key]=="read-only"){
                                $_SESSION['read_only'] = true;
				$_SESSION['permission'] = "Read-Only";
                        }
                        if ($available_privs[$key]=="read-write"){
                                $_SESSION['read_only'] = false;
				$_SESSION['permission'] = "Read-Write";
                        }

                }
        }

        return;

}


function get_proxys_by_assoc_id($my_assoc_id){

	$global="../../../../config/boxes.global.inc.php";
	require($global);

	$mi_connectors=array();

	for ($i=0;$i<count($boxes);$i++){

		if ($boxes[$i]['assoc_id']==$my_assoc_id){

			$mi_connectors[]=$boxes[$i]['mi']['conn'];

		}

	}

	return $mi_connectors;
}

function params($box_val){

	global $xmlrpc_host;
	global $xmlrpc_port;
	global $fifo_file;
	global $udp_host;
	global $udp_port;
	global $json_url;

	$a=explode(":",$box_val);

	switch ($a[0]) {
		case "udp":
			$comm_type="udp";
			$udp_host = $a[1];
			$udp_port = $a[2];
			break;
		case "xmlrpc":
			$comm_type="xmlrpc";
			$xmlrpc_host = $a[1];
			$xmlrpc_port = $a[2];
			break;
		case "fifo":
			$comm_type="fifo";
			$fifo_file = $a[1];
			break;
		case "json":
			$comm_type="json";
			$json_url = substr($box_val,5);
			break;
	}

	return $comm_type;
}

function get_modules() {
         $modules=array();
         $mod = array();
         if ($handle=opendir('../../../tools/admin/'))
         {
          while (false!==($file=readdir($handle)))
           if (($file!=".") && ($file!="..") && ($file!="CVS")  && ($file!=".svn"))
           {
            $modules[$file]=trim(file_get_contents("../../../tools/admin/".$file."/tool.name"));
           }
         closedir($handle);
         $mod['Admin'] = $modules;
        }

         $modules=array();
         if ($handle=opendir('../../../tools/users/'))
         {
          while (false!==($file=readdir($handle)))
           if (($file!=".") && ($file!="..") && ($file!="CVS")  && ($file!=".svn"))
           {
            $modules[$file]=trim(file_get_contents("../../../tools/users/".$file."/tool.name"));
           }
          closedir($handle);
          $mod['Users'] = $modules;
         }

         $modules=array();
         if ($handle=opendir('../../../tools/system/'))
         {
          while (false!==($file=readdir($handle)))
           if (($file!=".") && ($file!="..") && ($file!="CVS")  && ($file!=".svn"))
           {
            $modules[$file]=trim(file_get_contents("../../../tools/system/".$file."/tool.name"));
           }
          closedir($handle);
          $mod['System'] = $modules;
          }
     return $mod;
}


?>
