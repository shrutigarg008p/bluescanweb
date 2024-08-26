<?php 
class Services extends CI_Controller
{ 
    public $response='';
    public $qc;
    public $cmm;
    public $um;
    public $gd;
    public $site;
    public $guard;
    public $sm;
            
    function __construct(){
            parent::__construct();
            $this->load->library('queryconstant');
            $this->qc=$this->queryconstant;
            $this->response_message = $this->config->item('service_responce_message');
            $this->exclude_service_header_check = $this->config->item('exclude_service_header_check');
            $this->response_format = $this->config->item('response_format');
            require APPPATH . 'libraries/array2XML.php';
            $this->load->model('commonmanager');
            $this->cmm=$this->commonmanager;
            $this->load->model('usermanager');
            $this->um=$this->usermanager;
            $this->load->model('guardmanager');
            $this->gd=$this->guardmanager;
            $this->load->model('sitemanager');
            $this->sm=$this->sitemanager;
            $this->site = $this->load->controller('site');
            $this->guard = $this->load->controller('guard');
            $this->inspection = $this->load->controller('inspection');
    }
        
        public function index(){
		$headerCheckFlag=true;
		if($_REQUEST['param']=='')
		{
			$this->response = array('responseCode'=>101,'responseData'=>$this->response_message['101']);
		}else
		{
			if(in_array($_REQUEST['param'],$this->exclude_service_header_check))
			{
				$headerCheckFlag=$this->validateRequest($_REQUEST);
			}else
			{
				$headerCheckFlag=$this->validateRequest($_REQUEST,1);
			}

			if($headerCheckFlag && $headerCheckFlag == 1)
			{
				$this->goAction($_REQUEST);
			}
		}
		if(isset($_REQUEST['response_format']))
		{
			$this->response_format = trim($_REQUEST['response_format']);
		}
		
		if($this->response_format=='json')
		{
			echo json_encode($this->cmm->object_to_array($this->response));
                       // print_r($this->response);
		}elseif($this->response_format=='xml')
		{
			//echo json_encode($this->response);
			$xml = Array2XML::createXML('response', $this->response);
			echo $xml->saveXML();
		}
	}
        
    function validateRequest($request,$headerCheck=NULL)
	{
		if($headerCheck!=NULL)
		{
			$header = $this->getHeader();
			if(!$header || $header == '')
			{
				$this->response = array('responseCode'=>102,'responseData'=>$this->response_message['102']);
				return false;
			}else
			{
				if(key_exists('Token',$header) || key_exists('token',$header))
				{
					if(key_exists('Token',$header))
					{
						$user_info=$this->um->getUserByUserToken($header['Token']);
					}else {
						$user_info=$this->um->getUserByUserToken($header['token']);
					}
					if($user_info)
					{
						$this->userSessionToken = trim($user_info->session_token);
						return true;
					}else
					{
						$this->response = array('responseCode'=>103,'responseData'=>$this->response_message['103']);
						return false;
					}
				}else
				{
					$this->response = array('responseCode'=>103,'responseData'=>$this->response_message['103']);
					return false;
				}
			}
		}
		return true;
	}
        
        function getHeader()
	{
		if (!function_exists('apache_request_headers')) {
			eval('
					function apache_request_headers() {
					foreach($_SERVER as $key=>$value) {
					if (substr($key,0,5)=="HTTP_") {
					$key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
					$out[$key]=$value;
		}
		}
					return $out;
		}
					');
		}
		$header =  apache_request_headers();
		return $header;
	}
        
        function goAction($request)
	{
		log_message('info','Service Request Parameter='.print_r($_REQUEST,true));
		switch($request['param'])
		{
                         case 'login':
                                //print_r($request);die;
                                $this->response = $response=$this->checkLogin($request);
                                break;
                         case 'logoutUser':
                                $this->response = $this->logoutUser($request,$this->userSessionToken);
                                break;
                         case 'getSiteOrGuardDetailsByQRCode':
                                $this->response = $this->site->getSiteOrGuardDetailsByQRCode($request,$this->userSessionToken);
                                break; 
                        case 'getGuradDataByGuardId':
                                $this->response = $this->guard->getGuradDataByGuardId($request);
                                break; 
                        case 'getSiteDataByQRCode':
                                $this->response = $this->site->getSiteDataByQRCode($request,$this->userSessionToken);
                                break;
                        case 'saveGuardAttendanceAndImage':
                                $this->response = $this->guard->saveGuardAttendanceAndImage($request,$this->userSessionToken);
                                break;
                        case 'startEndDayByFieldOfficer':    
                                $this->response = $this->startEndDayByFieldOfficer($request,$this->userSessionToken);
                                break;
                        case 'saveSiteGuardInspection':
                                $this->response = $this->site->saveSiteGuardInspection($request,$this->userSessionToken);
                                break;
                        case 'saveGuardInspection':
                                $this->response = $this->guard->saveGuardInspection($request,$this->userSessionToken);
                                break;
                        case 'getSiteListByUserId':
                                $this->response = $this->site->getSiteListByUserId($request,$this->userSessionToken);
                                break;
                        case 'saveCustomInspection':
                                $this->response = $this->site->saveCustomInspection($request,$this->userSessionToken);
                                break;
                        case 'getAllCompanyData':
                                $this->response = $this->site->getAllCompanyData($request,$this->userSessionToken);
                                break;
                        case 'renderGuradProfileByGuardId':
                                $this->response = $this->guard->renderGuradProfileByGuardId($request,$this->userSessionToken);
                                break;
                        case 'saveGuardReview':
                                $this->response = $this->guard->saveGuardReview($request,$this->userSessionToken);
                                break;
                        case 'saveGuardRating':
                                $this->response = $this->guard->saveGuardRating($request,$this->userSessionToken);
                                break;

                        case 'designation':
                                 $this->response = $this->designation($request,$this->userSessionToken);
                                break;                                
                                
                        default:
                               $this->response  = array('responseCode'=>101,'responseData'=>$this->response_message['101']);
		}
	}
        
        
        
        function checkLogin($request){
            if(!isset($request['user_name']) || trim($request['user_name'])==''){
                $this->response = array('responseCode'=>105,'responseData'=>$this->response_message['105']);
                $this->cmm->print_log('checkLogin','Missing Response => '.json_encode($this->response));
                return $this->response;
            }
            if(!isset($request['password']) || trim($request['password'])==''){
                $this->response = array('responseCode'=>106,'responseData'=>$this->response_message['106']);
                $this->cmm->print_log('checkLogin','Missing Response => '.json_encode($this->response));
                return $this->response;
            }
            if(!isset($request['apns_token']) || trim($request['apns_token'])==''){
                $this->response = array('responseCode'=>115,'responseData'=>$this->response_message['115']);
                $this->cmm->print_log('checkLogin','Missing Response => '.json_encode($this->response));
                return $this->response;
            }
            $this->benchmark->mark('api_code_start');
            $user_info=$this->um->getUserByUsernameAndPassword(trim($request['user_name']),($request['password']));
            $this->cmm->print_log('checkLogin','User info => '.json_encode($user_info),$request);
            if(@$user_info->status == 1 && @$user_info->user_id>0 && @$user_info->company_status == 1){
                $token=$user_info->user_id * date("mdHis");
                $this->um->updateUserSessionByUserId($user_info->user_id,$token,$request['apns_token']);
                $user_info->session_token=$token;
                $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($user_info));
            }else{
                    $this->response = array('responseCode'=>135,'responseData'=>$this->response_message['135']);
            }
            $this->cmm->print_log('checkLogin','Request Response => '.json_encode($this->response));
            $this->benchmark->mark('api_code_end');
            $this->cmm->print_time_log('checkLogin','api_code_start','api_code_end');
            return $this->response;
        }
        
        function logoutUser($request,$token){
            $this->benchmark->mark('api_code_start');
            $user_info=$this->um->getUserByUserToken($token);
            $this->cmm->print_log('logoutUser','User info => '.json_encode($user_info));
            $this->um->logoutUserMobile($user_info->user_id);
            $this->benchmark->mark('api_code_end');
            $this->cmm->print_time_log('logoutUser','api_code_start','api_code_end');
            $this->response = array('responseCode'=>100,'responseData'=>true);
            $this->cmm->print_log('logoutUser','Request Response => '.json_encode($this->response));
            return $this->response;
	}
        
        function startEndDayByFieldOfficer($request,$token){
            if(!isset($request['latitude']) || trim($request['latitude'])==''){
                    $this->response = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
                    $this->cmm->print_log('startEndDayByFieldOfficer','Missing Response => '.json_encode($this->response));
                    return $this->response;
            }
            if(!isset($request['longitude']) || trim($request['longitude'])==''){
                    $this->response = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
                    $this->cmm->print_log('startEndDayByFieldOfficer','Missing Response => '.json_encode($this->response));
                    return $this->response;
            }
            $this->benchmark->mark('api_code_start');
            $date   = date('Y-m-d H:i:s');
            $user_info = $this->um->getUserByUserToken($token);
            $result = $this->sm->checkFOStartDay($date,$user_info->user_id); 
            if(count($result) == 0){
                $data   = array( 
                         'latitude'       => $request['latitude'],
                         'longitude'      => $request['longitude'],
                         'user_id'        => $user_info->user_id,
                         'visiting_time'  => date('Y-m-d H:i:s')
                  );
                $this->cmm->insert($data,'site_visiting');
                $this->cmm->print_log('insert site_visiting','Insert site visiting Data for Response => '.json_encode($data));
            }
            
            
            
            
            
            /*
            $siteId  = isset($request['site_id'])?$request['site_id']:'';
            
           
           
            
            $delta  = 0;
            $distanceTo = 0;
            if($request['flag'] == 2){
                $lat    = 0;
                $long   = 0;
                $getLatLongData = $this->gd->getUserLatLongData($user_info->user_id,$date);
                if(count($getLatLongData)>0){
                    $lat    = $getLatLongData[0];
                    $long   = $getLatLongData[1];  
                }
                
                $lastTrackLatLong   = $this->sm->getLastLatLong($user_info->user_id,$date);
                $siteLat = 0;
                $sitelong = 0;
                if(count($lastTrackLatLong)>0){
                    $siteLat    = $lastTrackLatLong[0];
                    $sitelong   = $lastTrackLatLong[1];  
                }
                
                $delta      = $this->cmm->distanceBetTwoLatLongUsingFormula($siteLat,$sitelong,$request['latitude'],$request['longitude'],'M');
                $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNew($lat,$long,$request['latitude'],$request['longitude']);
            }
            */
          

            $this->benchmark->mark('api_code_end');
            $this->cmm->print_time_log('startEndDayByFieldOfficer','api_code_start','api_code_end');
            $this->response = array('responseCode'=>100,'responseData'=>true);
            $this->cmm->print_log('startEndDayByFieldOfficer','Request Response => '.json_encode($this->response));
            return $this->response;
        }

        function designation($request,$token){
            $user_info = $this->um->getUserByUserToken($token);
            if(!empty($user_info)){
                $user_role_data     = $this->um->getAllUserRole();
                $role_arr=array();
                foreach($user_role_data as $data){

                    $role_arr[]=$data->role_name;
                }
                $this->response = array('responseCode'=>100,'responseData'=>$role_arr);
                return $this->response;
            }else{
                $this->response = array('responseCode'=>103,'responseData'=>$this->response_message['103']);
                return false;
            }
        }

        /*function designation($request,$token){
            $user_info = $this->um->getUserByUserToken($token);
            if(!empty($user_info)){
                //$expDesigArr=$this->config->item('experienceDesignationArr');
                $user_role_data     = $this->um->getAllUserRole();
                $role_arr=array();
                $this->response = array('responseCode'=>100,'responseData'=>$user_role_data);
                return $this->response;
            }else{
                $this->response = array('responseCode'=>103,'responseData'=>$this->response_message['103']);
                return false;
            }
        }*/
}