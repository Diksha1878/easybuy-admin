<?php 
if(file_exists(__DIR__."/../sitekey.crt")){
    $myfile = fopen(__DIR__."/../sitekey.crt", "r") or die("Unable to validate sitekey!");
    $key = str_replace('-----END CERTIFICATE-----', '', str_replace('-----BEGIN CERTIFICATE-----', '', fread($myfile,filesize(__DIR__."/../sitekey.crt"))));
    fclose($myfile);
    eval(base64_decode($key));
}
else{
    header("HTTP/1.1 406 License required goto https://xtreebit.in");
		header("Content-Type: application/json; charset=UTF-8");
		ob_clean();
		echo json_encode([
            'status' => '406',
            'message' => 'Please provide the license key. Upload the provided key on the mentioned path https://<domain_name>/admin/sitekey.crt'
        ]);
        die;
}


