<?php

function get_company_detail($company,$type) {

$splitDetails = explode("|", $company);


if($type=="symbol") {
	$symbol   = explode(":", $splitDetails[1]);
	return $symbol[1];
}
    



}


?>