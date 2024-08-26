<?php
class CommonManager extends CI_Model{
    
	function update($updateArray,$condition,$table){
		$affected_id	=	'';
		log_message('info', $table.' Updated Array:'.print_r($updateArray,true));
		log_message('info', $table.' Where Array:'.print_r($condition,true));
		if((is_array($updateArray)&&$condition)||(is_array($updateArray))){
			$this->db->trans_start();
			if($this->db->update($table, $updateArray, $condition)){
				log_message('info', $table.' Updated Query:'.$this->db->last_query());
				$affected_id	=	TRUE;
			}
		}
		$this->db->trans_complete();
		return $affected_id;
	}
	
	function insert($insertArray,$table){
		$insert_id	=	'';
		log_message('info', $table.' Insert Array:'.print_r($insertArray,true));
		if(is_array($insertArray)){
			$this->db->trans_start();
			if($this->db->insert($table,$insertArray)){
				//echo $this->db->last_query();
				log_message('info', $table.' Insert Query:'.$this->db->last_query());
				$insert_id	=	$this->db->insert_id();
				log_message('info', $table.' Insert Id:'.$insert_id);
			}
		}
		$this->db->trans_complete();
		return $insert_id;
	}
        
        function delete($condition,$table){
            $this->db->delete($table, $condition); 
            //echo $this->db->last_query();die;
            return true;
        }
        
    function checkLoginSessionAjax(){
        $sessionData= $this->session->userdata('users');
        if(!empty($sessionData)){
            return true;
        }
        return false;
    }
    
    function checkSetSessionForRoleBasedSecurity($companyId=''){
        if(!$this->session->userdata('session_company_id')){
            if($companyId){
                 $this->session->set_userdata('session_company_id', $companyId);
            }else{
                $sessionData= unserialize($this->session->userdata('users'));
                if($sessionData->role_code != 'sadmin'){
                    $companyId = $this->getComapnyIdForCompanySession($sessionData->user_id,$sessionData->role_code);
                    $this->session->set_userdata('session_company_id', $companyId);
                }
            }
        }else{
            if($companyId){
                 $this->session->set_userdata('session_company_id', $companyId);
            }
        }
        return true;
    }
    
    
    function getComapnyIdForCompanySession($user_id,$role_code){
        $this->db->trans_start();
        if(in_array($role_code, array('cadmin','cuser'))){
             $query = $this->db->query($this->qc->queryGetComapnyIdForCompanySession, array($user_id));
        }else if(in_array($role_code, array('RM','BO'))){
            $query = $this->db->query($this->qc->queryGetComapnyIdForRegionCompanySession, array($user_id));
        }
       
       // echo $this->db->last_query();die;
        $this->print_log('Model:commonmanager:getComapnyIdForCompanySession','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
                $this->print_log('Model:commonmanager:getComapnyIdForCompanySession','Query Response => '.print_r($result,true));

        }
        $this->db->trans_complete();
        return $result->company_id;
        
    }
        
    function print_log($method, $log) {
        $print_overall_log = $this->config->item('print_overall_log');
        $print_log_type = $this->config->item('print_log_type');
        $printLog = '';
        $logType  = '';  
        if(isset($_REQUEST['printLog'])){
             $printLog = $_REQUEST['printLog'];
        }
        if(isset($_REQUEST['logType'])){
             $logType = $_REQUEST['logType'];
        }
        if(isset($printLog) && !empty($printLog)){
            $print_overall_log = $printLog;
        }
        if(isset($logType) && !empty($logType)){
            $print_log_type = $logType;
        }  
        if ($print_overall_log == '1'||$print_overall_log==true|| in_array($method, $this->config->item('print_service_log'))) {
            if ($print_log_type == '1') {
                log_message('info', "Method Name : " . $method . ', Log Message :' . $log);
            } else {
                echo '<pre>' . $log . '</pre>';
            }
        }
    }
        
    function print_time_log($method, $start, $end) {
        if ($this->config->item('track_time_log') == '1' || in_array($method, $this->config->item('track_service_time_log'))) {
            if ($this->config->item('print_log_type') == '1') {
                log_message('info', "Method Name : " . $method . ' Execution Time For ' . $this->benchmark->elapsed_time($start, $end));
            } else {
                echo '<pre>Methord Name : ' . $method . ' Execution Time For ' . $this->benchmark->elapsed_time($start, $end) . '</pre>';
            }
        }
    }
        
    function object_to_array($array) {
        //echo "<pre>";print_r($array);die;
        $responseArray = array();
        $st = 0;
        if(is_object($array)) {
            $array = get_object_vars($array);
            $st = 1;
        }
        if (!empty($array)) {
            foreach ($array as $key => $val) {
                if (is_object($array[$key]) ) {
                    $responseArray[$key] = get_object_vars($array[$key]);
                } else {
                    $responseArray[$key] = $array[$key];
                }
            }
        }
        return $responseArray;
    }

    function getSingleRow($tableName,$id)
    {   
        $query = $this->db->get_where($tableName,$id);
        return $datarow = $query->row();
    }    
    
    function getBarcode($Id,$filename=NULL,$dir=NULL)
	{
		//html PNG location prefix
		//$PNG_WEB_DIR = $_SERVER['DOCUMENT_ROOT'].'/barcel_pos_web/uploads/';
		
		require_once(APPPATH. 'libraries/phpqrcode/qrlib.php');
		if($filename==NULL || $filename=='')
		{
			$filename = 'img'.$Id.".png";
		}
		if($dir==NULL || $dir=='')
		{
			$PNG_WEB_DIR ='./uploads/barcode/';
		}else
		{
			$PNG_WEB_DIR =$dir;
		}
		
		//$matrixPointSize = min(max(4, 1), 10);
		QRcode::png($Id, $PNG_WEB_DIR.$filename, $errorCorrectionLevel='H', $matrixPointSize=40, 2);
		
		//QRtools::timeBenchmark();
		return $filename;
	}
        
        function getLatLongByAddress($address){
		$apiURL="http://maps.google.com/maps/api/geocode/json?address=".urlencode($address).'&sensor=true';
                $ch = curl_init(trim($apiURL));             
		$fields=array();
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$addressData = curl_exec($ch);
		//close connection
		curl_close($ch);
		log_message('error','XML Responce=='.$addressData);
		$output= json_decode($addressData);
		//print_r($output);
		if($output)
		{
			if(isset($output->results))
			{
				if(count($output->results)>0)
				return array($output->results[0]->geometry->location->lat,$output->results[0]->geometry->location->lng);
			}
		}
	}
        
        function saveAsImageBase64($imagesPath){
            $path=$this->config->item('image_path');
            $filename = rand().date("YmdHis");
            $im = base64_decode($imagesPath);
            log_message('info',"File Path->".$path.$filename.'.png');
            $this->cmm->print_log('saveAsImageBase64','info',"File Path->".$path.$filename.'.png');  

            if (!function_exists('file_put_contents')) {
                    $fh = fopen($path.$filename.'.png', 'w') or die("can't open file");
                    fwrite($fh, $im);
                    fclose($fh);
            }else {
                    $result=file_put_contents($path.$filename.'.png', $im, TRUE);
                    $this->cmm->print_log('saveAsImageBase64','info',"Result->".$result);  
            }
            $filename=$filename.'.png';
            return $filename;
        }
        
        function distanceBetTwoLatLongUsingFormula($lat1,$lon1,$lat2,$lon2,$unit="") {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            
            
            

            if ($unit == "K") {
              return ($miles * 1.609344);
            }else if($unit == "M"){ //meter
                return ($miles * 1609.34);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
              } else {
                  return $miles;
                }
          }
          
        function distanceBetTwoLatLong($lat1,$lon1,$lat2,$lon2,$unit="") {
            $url    = $this->config->item('gMapDirectionMatrixUrl');  
            $url    .= $this->config->item('output').'?';
            $url    .= 'origins='.$lat1.','.$lon1;
            $url    .= '&destinations='.$lat2.','.$lon2;
            $url    .= '&key='.$this->config->item('gMapDirectionMatrixKey');
            $url    .= '&mode='.$this->config->item('gMapMode');
            $url    .= '&units='.$this->config->item('units');
            
            $distance   = 0;
            $response   = file_get_contents($url);
            $response   = json_decode($response);
            if(!empty($response)){
                if($response->status == 'OK'){
                    $row    = $response->rows;
                    for($i=0;$i<count($row);$i++){
                        $element    = $row[$i]->elements;
                        for($j=0;$j<count($element);$j++){
                            if($this->config->item('units') == 'metric'){
                                $distance   = str_replace('km','',$element[$j]->distance->text);
                            }else{
                                $distance   = str_replace('mi','',$element[$j]->distance->text);
                            }
                        }
                    }
                }
            }
            return $distance;
        }
        
        function distanceBetTwoLatLongTest($lat1,$lon1,$lat2,$lon2,$unit="") {
        	
            $url    = $this->config->item('gMapDirectionMatrixUrl');
        	$url    .= $this->config->item('output').'?';
        	$url    .= 'origins='.$lat1.','.$lon1;
        	$url    .= '&destinations='.$lat2.','.$lon2;
        	$url    .= '&key='.$this->config->item('gMapDirectionMatrixKey');
        	$url    .= '&mode='.$this->config->item('gMapMode');
        	$url    .= '&units='.$this->config->item('units');
        
        	$distance   = 0;
        	$response   = file_get_contents($url);
        	$response   = json_decode($response);
        	
        	return $response;
        }

        function maxDistanceBetTwoLatLongTestNew($lat1,$lon1,$lat2,$lon2,$unit="") {
            //$url    = $this->config->item('gMapDirectionMatrixUrl');
            $greaterD = 0;
            $url     = $this->config->item('gMapDirectionMaxKmsUrl');
            $url    .= $this->config->item('output').'?';
            $url    .= 'origin='.$lat1.','.$lon1;
            $url    .= '&destination='.$lat2.','.$lon2;
            $url    .= '&alternatives=true&units=metric';
            $distance   = 0;
            $response   = file_get_contents($url);
            $this->cmm->print_log('Model:commonmanager:maxDistanceBetTwoLatLongTestNew','Url  Response => '.$url);
            
            $response   = json_decode($response);
            
            if(!empty($response))
            {
                if($response->status == 'OK'){
                    for($i=0;$i<count($response->routes);$i++)
                    {                        
                        $greaterD = (($greaterD < $response->routes[$i]->legs[0]->distance->text) ? $response->routes[$i]->legs[0]->distance->text : $greaterD );
                    }
                }
            }                    
            $replaceVal = 0;
            $distanceArr    = explode(' ',$greaterD);
            if(count($distanceArr) == 2){
                if($distanceArr[1] == 'm'){
                    $greaterD   = str_replace('m', '', $greaterD);
                    $replaceVal = (intval($distanceArr[0])/1000);
                }else if($distanceArr[1] == 'km'){
                    $replaceVal = str_replace('km', '', $greaterD);
                    $replaceVal = intval(trim($replaceVal));
                }else{
                    $replaceVal = str_replace('mi', '', $greaterD);
                }
            }
            return $replaceVal;
        }

        function maxDistanceBetTwoLatLongTestNewVersion($lat1,$lon1,$lat2,$lon2,$unit="") {
            //$url    = $this->config->item('gMapDirectionMatrixUrl');                        
            $distance = 0;
            $url     = $this->config->item('gMapDirectionMaxKmsUrl');
            $url    .= $this->config->item('output').'?';
            $url    .= 'origin='.$lat1.','.$lon1;
            $url    .= '&destination='.$lat2.','.$lon2;
            $url    .= '&alternatives=true&units=metric';            
            $response   = file_get_contents($url);
            $this->cmm->print_log('Model:commonmanager:maxDistanceBetTwoLatLongTestNew','Url  Response => '.$url);
            
            $response   = json_decode($response);
            $distanceArr = array();              
            $distanceData = array();

            if(!empty($response))
            {
                if($response->status == 'OK'){
                    for($i=0;$i<count($response->routes);$i++)
                    {   
                        $distanceArr = explode(' ', $response->routes[$i]->legs[0]->distance->text);                        
                        if(count($distanceArr) == 2)
                        {
                            if($distanceArr[1] == 'm')
                            {                                

                                $distance =(floatval($distanceArr[0])/1000);                                                          
                                $greaterD = floatval($distance);
                                array_push($distanceData, $greaterD);
                            }elseif($distanceArr[1] == 'km')
                            {                                
                                $distance = floatval($distanceArr[0]);
                                array_push($distanceData, $distance);
                            }
                            else
                            {                                
                                $distance =(floatval($distanceArr[0])/0.62137);
                                $greaterD = floatval($distance);
                                array_push($distanceData, $greaterD);
                            }
                        }                       
                    }
                }
            }
            
            if(count($distanceData)>0)
            {
            	$distance = max($distanceData);
            }         
            
            return $distance;
        }
        
        function getRoleByRoleCode($role_code){
            $sql = $this->qc->queryGetRoleByRoleCode;
            $this->db->trans_start();
            $query=$this->db->query($sql, array($role_code));
            $this->cmm->print_log('Model:Commonmanager:getRoleByRoleCode','Query => '.$this->db->last_query($role_code));
           //echo $this->db->last_query();die;
            $result=array();
            if($query->num_rows() > 0){
                $result=$query->row();
                $this->cmm->print_log('Model:Commonmanager:getRoleByRoleCode','Result => '.print_r($result,true));
            }
            $this->db->trans_complete();        
            return $result;
        }
        
        function sendMail($to,$subject,$message){

            $fromEmail= $this->config->item('from_email');
            $fromName = $this->config->item('from_name');

            $is_sent=0;
            $is_error=0;
            $error_content='';
            if($this->config->item('email_send_by')==1 || $this->config->item('email_send_by')==2){
                if($this->config->item('email_send_by')==1){
                    $config = Array(
                      'protocol' => 'smtp',
                      'smtp_host' => $this->config->item('smtp_host'),
                      'smtp_port' => $this->config->item('smtp_port'),
                      'smtp_user' => $this->config->item('smtp_user'),
                      'smtp_pass' => $this->config->item('smtp_pass'),
                      'mailtype'  => 'html',
                      'charset'   => 'iso-8859-1'
                    );
                    $this->load->library('email', $config);
                }else{
                 $this->load->library('email');
                }

                $this->email->set_newline("\r\n");
                $this->email->set_mailtype('html');
                $this->email->set_crlf("\r\n");
                $this->email->from($fromEmail, $fromName);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                $result = $this->email->send();
                
                if(!$result){
                    $is_error= 1;
                    $errorContent = $this->email->print_debugger();
                }else{
                    $is_sent = 1;
                }
            }else{
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $headers .= 'From: '.$fromName . "\r\n" .
                  'Reply-To: '.$fromEmail . "\r\n" .
                  'X-Mailer: PHP/' . phpversion();
                $result = mail($to,$subject,$message, $headers);
                if($result){
                    $is_sent = 1;
                }else{
                     $is_error= 1;
                     $error_content='There was a problem sending your email.';
                }
            }
            if($is_sent){
                return $is_sent;
            }else{
                return $error_content;
            }
    }
    
   
}