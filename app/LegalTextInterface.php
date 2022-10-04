<?php

/* 
 * Class ITRechtKanzlei\LegalTextInterface
 * 
 * A class for interfacing IT-Recht Kanzlei's legal text interface (LTI).
 * The charset is UTF-8.
 * 
 * @version 1.0.6
 * @author Jaromir Sonnenschein <info@jaromedia.de>
 * @copyright (c) 2020, IT-Recht Kanzlei / Jaromedia
 * 
 * CHANGELOG:
 * 1.0.0	initial version
 * 1.0.1	added namespace, renamed class
 *			added methods validate_PDF_file() and is_PDF_file()
 *			added methods get_PDF_filename_suggestion(), get_PDF_filenamebase_suggestion() and send_PDF_ERROR()
 *			added 'itrelaunch.blickreif.de' hosts in method get_PDF_URL()
 * 1.0.2	added methods download_PDF_as_string(), send_ERROR_shop_configuration_incomplete(), send_ERROR_content_target_page_not_found()
 *			corrected minimum expected xml element string length in get_PDF_filenamebase_suggestion() from 7 to 3 characters (to allow 'agb')
 * 1.0.3	reactivated SSL check while using CURL in method download_PDF_as_string(), added web links in comments to further information
 * 1.0.4	addition to ensure UTF-8 encoding of this file / correct encoding detection when cross-OS handling this file
 * 1.0.5	added methods download_PDF_to_file() and get_SELECTED_UserAccountId(), additions to method is_MULTISHOP() for assigning values to the newly added variables (see following lines)
 *			added variable $this->_mode_multishop: will be set to 'true' if method is_MULTISHOP() is called
 *			added variable $this->_selected_user_account_id: will be set to the multishop id selected by the user (on IT-Recht Kanzlei side) during method is_MULTISHOP() call
 *			added action mode check to method download_PDF_as_string() (and download_PDF_to_file() ) to prevent calling other than during action='push' in case of a wrong endpoint implementation
 *			changed method mb_strreplace(): str_replace() is already multibyte-safe
 *			added methods sanitize_string() and remove_accents() to create safe PDF filenames when user_account_id is used to form the filename
 * 1.0.6	added method get_LT_Language_ISO639_2b();
 * 
 */

namespace ITRechtKanzlei;

class LegalTextInterface{
	
	// internal settings
	const SDK_VERSION = '1.0.6';
	const API_VERSION = '1.0';
	protected $_allowed_action_values = array('getaccountlist','push','getversion');
	protected $_allowed_rechtstext_type_values = array('agb','datenschutz','widerruf','impressum');
	protected $_legal_texts_supporting_pdfs = array('agb','datenschutz','widerruf');
	
	// properties
	protected $_xmldata;
	protected $_shopversion = '';
	protected $_LT_frontendURL = '';
	protected $_mode_multishop = null;	// null = not yet set, false = no (likely not used), true = yes
	protected $_selected_user_account_id = null;	// holds selected multishop id (user_account_id) in a multishop scenario, available during push-action after gettaccountlist-action




	// METHODS - STARTUP
	
	public function __construct($rawxmldata = NULL)
	{
		
		// by default read rawxmldata from $_POST['xml']
		if(is_null($rawxmldata)){ 
			
			if(isset($_POST['xml'])){
				$rawxmldata = $_POST['xml'];
			} else {
				$this->returnError('12', 'received XML empty or too short');
			}
			
		}
		
		// process rawxmldata
		$this->process_rawxmldata($rawxmldata);
		
		// check xmldata
		$this->check_xmldata();
		
	}
	
	private function process_rawxmldata($param_rawxmldata){
		
		// check if any data was transmitted
		if(($param_rawxmldata == '') OR (is_null($param_rawxmldata)) OR (mb_strlen($param_rawxmldata, 'UTF-8') < 10)){
			$this->returnError('12', 'received XML empty or too short');
		}
		
		// check if data starts correctly
		if(mb_strtolower(mb_substr($param_rawxmldata, 0, 5, 'UTF-8'), 'UTF-8') != '<?xml'){
			$this->returnError('12', 'received XML does not start with correct char sequence');
		}
		
		// check if simplexml is available
		if(function_exists('simplexml_load_string')){
			// process xml data
			$this->_xmldata = @simplexml_load_string($param_rawxmldata);
		//	var_dump($this->_xmldata);
			
			// catch errors
			if(($this->_xmldata === false) OR (!is_object($this->_xmldata))){ $this->returnError('12', 'received XML not processable by SimpleXML'); }
		} else {
			$this->returnError('12', 'extension SimpleXML not available on host system');
		}
	}
	
	private function check_xmldata(){
		
		// checks
		$this->is_xml_element_set_and_valid('api_version', '1', self::API_VERSION);	// check if api_version exists and valid
		$this->is_xml_element_set_and_valid('action', '10', $this->_allowed_action_values);	// check if action is given and valid
		
		// depending on action
		if($this->_xmldata->action == 'getversion'){
			// output version only
			$this->returnVersion();
		} else {
			
			// checks for all other actions
			
			if($this->_xmldata->action == 'getaccountlist'){
				// (none so far)

			} elseif($this->_xmldata->action == 'push'){
				$this->is_xml_element_set_and_valid('rechtstext_type', '4', $this->_allowed_rechtstext_type_values);	// expected XML elements for action push
				$this->is_xml_element_set_and_long_enough('rechtstext_title', '18', 3);
				$this->is_xml_element_set_and_long_enough('rechtstext_text', '5', 50);
				$this->is_xml_element_set_and_long_enough('rechtstext_html', '6', 50);
				$this->is_xml_element_set_and_length_ok('rechtstext_country', '17', 2);
				$this->is_xml_element_set_and_length_ok('rechtstext_language', '9', 2);

			}

		}
		
	}
	
	
	// METHODS - PUBLIC USE
	
	public function get_LT_Country(){
		return (string)$this->_xmldata->rechtstext_country;
	}
	
	public function get_LT_Language(){
		return (string)$this->_xmldata->rechtstext_language;
	}
	
	public function get_LT_Language_ISO639_2b(){
		$this->is_xml_element_set_and_length_ok('rechtstext_language_iso639_2b', '99', 3);
		return (string)$this->_xmldata->rechtstext_language_iso639_2b;
	}
	
	public function get_LT_Title(){
		return (string)$this->_xmldata->rechtstext_title;
	}
	
	public function get_LT_Text(){
		return (string)$this->_xmldata->rechtstext_text;
	}
	
	public function get_LT_HTML(){
		return (string)$this->_xmldata->rechtstext_html;
	}
	
	public function get_LT_Type(){
		return (string)$this->_xmldata->rechtstext_type;
	}
	
	public function get_AUTH_Token(){
		$this->is_xml_element_set_and_long_enough('user_auth_token', '3', 1);
		return (string)$this->_xmldata->user_auth_token;
	}
	
	public function get_AUTH_Username(){
		$this->is_xml_element_set_and_long_enough('user_username', '3', 1);
		return (string)$this->_xmldata->user_username;
	}
	
	public function get_AUTH_Password(){
		$this->is_xml_element_set_and_long_enough('user_password', '3', 1);
		return (string)$this->_xmldata->user_password;
	}
	
	public function get_SELECTED_UserAccountId(){
		return (string)$this->_xmldata->user_account_id;
	}
	
	public function get_PDF_URL(){
		// only process a URL if current legal text supports PDFs
		if( in_array($this->get_LT_Type(), $this->_legal_texts_supporting_pdfs) ){
			// check if XML element exists and is long enough
			$this->is_xml_element_set_and_long_enough('rechtstext_pdf_url', '7', 20);
			// check if URL is a valid URL
			if(!$this->is_url_valid((string)$this->_xmldata->rechtstext_pdf_url)){ $this->returnError('7', 'PDF URL not valid'); }
			// restrict URL to allowed hosts
			$tmp_host_found = false;
			foreach( array('http://www.it-recht-kanzlei.de/','https://www.it-recht-kanzlei.de/','http://it-recht-kanzlei.de/','https://it-recht-kanzlei.de/','http://itrelaunch.blickreif.com/','https://itrelaunch.blickreif.com/','http://itrelaunch.blickreif.de/','https://itrelaunch.blickreif.de/') AS $current_host_check ){
				if(mb_strtolower(mb_substr((string)$this->_xmldata->rechtstext_pdf_url, 0, mb_strlen($current_host_check, 'UTF-8'), 'UTF-8'), 'UTF-8') == mb_strtolower($current_host_check, 'UTF-8')){
					$tmp_host_found = true;
				}
			}
			if($tmp_host_found !== true){ $this->returnError('7', 'PDF URL host not allowed'); }
			// return URL
			return (string)$this->_xmldata->rechtstext_pdf_url;
		} else {
			return false;
		}
	}
	
	public function download_PDF_as_string(){
		
		// check if in correct mode
		if(($this->_xmldata->action == 'getaccountlist') AND ($this->_mode_multishop !== true)){ $this->returnError('7', 'is_MULTISHOP() needs to be called before download_PDF_as_string()'); }
		if($this->_xmldata->action != 'push'){ $this->returnError('7', 'download_PDF_as_string() called in action other than push'); }
		
		if((extension_loaded('curl')) && (function_exists('curl_version'))){
			
			// CURL available, download with CURL
			$request = curl_init();
			curl_setopt($request, CURLOPT_URL, $this->get_PDF_URL());
			curl_setopt($request, CURLOPT_TIMEOUT,30);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS); // HTTP(S) only
			curl_setopt($request, CURLOPT_USERAGENT, 'ITK_SDK_LTI');
			curl_setopt($request, CURLOPT_ENCODING , ""); // allow gzip, etc.
			curl_setopt($request, CURLOPT_FORBID_REUSE, 1); // prevent caching
			curl_setopt($request, CURLOPT_FRESH_CONNECT, 1); // prevent caching
			//curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0); // temporarily disable SSL check in case root certificates in local PHP CURL lib are out of date, etc. ATTENTION: do not use this in production as it will comprimise security! Update your root certificates, see 1) https://curl.haxx.se/docs/caextract.html and 2) https://daniel.haxx.se/blog/2018/11/07/get-the-ca-cert-for-curl/
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0); // temporarily disable SSL check in case root certificates in local PHP CURL lib are out of date, etc. ATTENTION: do not use this in production as it will comprimise security! Update your root certificates, see 1) https://curl.haxx.se/docs/caextract.html and 2) https://daniel.haxx.se/blog/2018/11/07/get-the-ca-cert-for-curl/
			
			// execute
			$response = curl_exec($request);
			// get result info
			$curlError = curl_error($request);
			$curlErrNo = curl_errno($request);
			$curlHTTPCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
			$curlContType = curl_getinfo($request, CURLINFO_CONTENT_TYPE);
			// close connection
			curl_close($request);
			
			// check for errors
			if(($response === false) OR (!empty($curlErrNo))){
					$tmp_err_msg = 'PDF download failed - CURL error';
					if(!is_null($curlErrNo)){ $tmp_err_msg .= ' '.$curlErrNo.':'; }
					$tmp_err_msg .= ' '.$curlError;
					$this->returnError('7', $tmp_err_msg);
					
			}
			if($curlHTTPCode != 200){ $this->returnError('7', 'PDF download failed - CURL HTTP status '.$curlHTTPCode); }
			
			// check for correct MIME type
			if((!is_null($curlContType)) AND ($curlContType != 'application/pdf')){ $this->returnError('7', 'CURL downloaded file has wrong MIME type'); }
			
		} elseif(ini_get('allow_url_fopen')){
			
			// CURL not available, download with file_get_contents
			$response = @file_get_contents($this->get_PDF_URL());
			// catch errors
			if($response === false){ $this->returnError('7', 'PDF download not possible - file_get_contents failed'); }
			if(empty($response)){ $this->returnError('7', 'PDF download not possible - file_get_contents empty'); }
			
			// check for correct MIME type
			if(!in_array('Content-Type: application/pdf', $http_response_header)){ $this->returnError('7', 'Downloaded file has wrong MIME type'); }
			
		} else {
			
			// download not possible
			$this->returnError('7', 'PDF download not possible - CURL and allow_url_fopen not available');
			
		}
		
		// validate downloaded data
		if(mb_strlen($response, 'utf-8') < 5){ $this->returnError('7', 'Downloaded file is too short'); }
		if(mb_substr($response, 0, 4, 'utf-8') != '%PDF'){ $this->returnError('7', 'Downloaded file is not a PDF'); }
		// check PDF file hash
		if(md5($response) != $this->get_PDF_md5hash()){ $this->returnError('8'); }
		
		// return file as string
		return $response;
		
	}
	
	public function download_PDF_to_file($param_filepath, $param_filename = null, $param_donotinclude_multishopid_in_filename = false){
		
		// check if in correct mode
		if(($this->_xmldata->action == 'getaccountlist') AND ($this->_mode_multishop !== true)){ $this->returnError('7', 'is_MULTISHOP() needs to be called before download_PDF_to_file()'); }
		if($this->_xmldata->action != 'push'){ $this->returnError('7', 'download_PDF_to_file() called in action other than push'); }
		
		// download PDF as string
		$pdf_data = $this->download_PDF_as_string();
		
		// if a filename is passed to the method use that one, otherwise use the filename_suggestion transmitted
		if(!empty($param_filename)){
			$filename = $param_filename;
		} else {
			
			// check if multishop mode is used, so we have to differentiate that one as well probably
			if(($this->_mode_multishop === true) AND ($param_donotinclude_multishopid_in_filename !== true)){
				$filename = $this->mb_strreplace('.pdf', '_'.$this->sanitize_string($this->_selected_user_account_id).'.pdf', $this->get_PDF_filename_suggestion());
			} else {
				$filename = $this->get_PDF_filename_suggestion();
			}
			
		}
		
		// build full path
		if((mb_strlen($param_filepath) >= 1) AND (!in_array(mb_substr($param_filepath, -1), array('/','\\',DIRECTORY_SEPARATOR)))){
			$filepathandname = $param_filepath.DIRECTORY_SEPARATOR.$filename;
		} else {
			$filepathandname = $param_filepath.$filename;
		}
		
		// save file
		$filehandle = @fopen($filepathandname, 'w');
		if($filehandle === false){ $this->returnError('7', 'could not create a local target file for storing pdf (reasons likely are missing dir permissions or target dir does not exist)'); }
		
		$filewriteresult = @fwrite($filehandle, $pdf_data);
		if($filewriteresult === false){ $this->returnError('7', 'could not write into local target file while storing pdf'); }
		
		$filecloseresult = @fclose($filehandle);
		if($filecloseresult === false){ $this->returnError('7', 'could not close local target file after writing pdf'); }
		
		// validate file written
		$this->validate_PDF_file($filepathandname);
		
		// done
		return $filename;
		
	}


	public function get_PDF_md5hash(){
		$this->is_xml_element_set_and_length_ok('rechtstext_pdf_md5hash', '8', 32);
		return (string)$this->_xmldata->rechtstext_pdf_md5hash;
	}
	
	public function get_PDF_filename_suggestion(){
		$this->is_xml_element_set_and_long_enough('rechtstext_pdf_filename_suggestion', '19', 7);
		return (string)$this->_xmldata->rechtstext_pdf_filename_suggestion;
	}
	
	public function get_PDF_filenamebase_suggestion(){
		$this->is_xml_element_set_and_long_enough('rechtstext_pdf_filenamebase_suggestion', '19', 3);
		return (string)$this->_xmldata->rechtstext_pdf_filenamebase_suggestion;
	}
	
	public function send_SUCCESS(){
		$this->returnSuccess();
	}
	public function send_ERROR($param_errormessage = NULL){
		$this->returnError('99', $param_errormessage);
	}
	
	public function send_ERROR_shop_configuration_incomplete($param_errormessage = NULL){
		$this->returnError('80', $param_errormessage);
	}
	
	public function send_ERROR_content_target_page_not_found($param_errormessage = NULL){
		$this->returnError('81', $param_errormessage);
	}
	
	public function send_AUTH_ok(){
		// no action required so far but probably good for future use (e.g. prevent PDF fetching before auth is checked and confirmed)
		// if something takes place here, probably include this method into send_SUCCESS(); (and check if it was already called before)
	}
	public function send_AUTH_failed($param_errormessage = NULL){
		$this->returnError('3', $param_errormessage);
	}
	
	public function send_LT_Language_unsupported($param_errormessage = NULL){
		$this->returnError('9', $param_errormessage);
	}
	public function send_LT_Country_unsupported($param_errormessage = NULL){
		$this->returnError('17', $param_errormessage);
	}
	
	public function send_PDF_ERROR($param_errormessage = NULL){
		$this->returnError('7', $param_errormessage);
	}
	
	// validate expected AUTH value against XML value
	public function validate_AUTH_Token($param_token){
		if($this->get_AUTH_Token() == $param_token){ $this->send_AUTH_ok(); } else { $this->send_AUTH_failed(); }
	}
	
	// validate expected AUTH values against XML values
	public function validate_AUTH_username_password($param_username, $param_password){
		if(($this->get_AUTH_Username() == $param_username) AND ($this->get_AUTH_Password() == $param_password)){ $this->send_AUTH_ok(); } else { $this->send_AUTH_failed(); }		
	}
	
	public function validate_API_user_pass($param_apiuser, $param_apipass){
		$this->is_xml_element_set_and_valid('api_username', '2', $param_apiuser);
		$this->is_xml_element_set_and_valid('api_password', '2', $param_apipass);
	}
	
	public function validate_PDF_file($param_filename){
		// check if file exists locally
		if(!file_exists($param_filename)){ $this->returnError('7', 'PDF file not found when validating'); }
		// check if file is a PDF
		if(!$this->is_PDF_file($param_filename)){ $this->returnError('7', 'PDF file is not a PDF'); }
		// check if md5 hash of file is equivalant to the expected value
		if(md5_file($param_filename) != $this->get_PDF_md5hash()){ $this->returnError('8', 'PDF md5 hash not as expected'); }
		// check OK
		return true;
	}
	
	public function set_LT_frontendURL($param_url){
		if( $this->is_url_valid($param_url) ){ $this->_LT_frontendURL = $param_url; } else { $this->_LT_frontendURL = ''; }
	}
	
	public function is_MULTISHOP($param_accountlist){
		
		// set flag
		$this->_mode_multishop = true;
		
		if($this->_xmldata->action == 'getaccountlist'){
			// output if action requested
			$this->returnAccountlist($param_accountlist);
		} elseif($this->_xmldata->action == 'push'){
			// check if user_account_id was received and is in shop's accountlist
			$this->is_xml_element_set_and_valid('user_account_id', '11', array_keys($param_accountlist));
			// set class variable
			$this->_selected_user_account_id = $this->get_SELECTED_UserAccountId(); // $this->_xmldata->user_account_id;
			// return selected multishop ID
			return $this->_selected_user_account_id;
		} else {
			$this->returnError('99', 'is_MULTISHOP - action not supported');
		}
	}
	
	
	// METHODS - XML OUTPUT
	
	protected function xmloutputversions(){
		echo "	<meta_shopversion>".$this->xmlencode($this->_shopversion)."</meta_shopversion>\n";
		echo "	<meta_modulversion>ITK_SDK_LTI#".$this->xmlencode(self::SDK_VERSION)."</meta_modulversion>\n";
		echo "	<meta_phpversion>".$this->xmlencode(phpversion())."</meta_phpversion>\n";
	}
	
	protected function returnSuccess(){
		// output success
		header('Content-type: application/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		echo "<response>\n";
		echo "	<status>success</status>\n";
		// send targetURL
		if(($this->_LT_frontendURL != '') AND ($this->_LT_frontendURL !== false)){
			echo "	<target_url><![CDATA[".$this->mb_strreplace(']]>', ']] >', $this->_LT_frontendURL)."]]></target_url>\n";
		}
		$this->xmloutputversions();
		echo "</response>";
		exit();
	}
	
	protected function returnError($param_errorcode, $param_errormessage = NULL){
		// output error
		header('Content-type: application/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		echo "<response>\n";
		echo "	<status>error</status>\n";
		echo "	<error>".$this->xmlencode($param_errorcode)."</error>\n";
		if(!is_null($param_errormessage)){
			echo "	<error_message><![CDATA[".$this->mb_strreplace(']]>', ']] >', $param_errormessage)."]]></error_message>\n";
		} else {
			echo "	<error_message><![CDATA[]]></error_message>\n";
		}
		$this->xmloutputversions();
		echo "</response>";
		exit();
	}
	
	protected function returnVersion(){
		// output version
		header('Content-type: application/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		echo "<response>\n";
		echo "	<status>version</status>\n";
		$this->xmloutputversions();
		echo "</response>";
		exit();
	}
	
	protected function returnAccountlist($param_accountlist){
		// check parameter
		if(!is_array($param_accountlist)){
			$this->returnError('99', 'returnAccountlist parameter not an array');
		}
		// output version
		header('Content-type: application/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		echo "<accountlist>\n";
		foreach($param_accountlist AS $account_id => $account_name){
			echo "	<account>\n";
			echo "		<accountid>".$this->xmlencode($account_id)."</accountid>\n";
			echo "		<accountname>".$this->xmlencode($account_name)."</accountname>\n";
			echo "	</account>\n";
		}
		echo "</accountlist>\n";
		//$this->xmloutputversions();
		exit();
	}	
	
	
	// METHODS - HELPER
	
	protected function is_xml_element_set($param_element, $param_errorcode){
		if(!isset($this->_xmldata->$param_element)){ $this->returnError($param_errorcode, 'XML element '.$param_element.' not given'); }
			else { return true; }
	}
	protected function is_xml_element_valid($param_element, $param_errorcode, $param_allowed_values){
		if(is_bool($param_allowed_values) === true) {
			// check
			if($this->_xmldata->$param_element !== $param_allowed_values){ $this->returnError($param_errorcode, 'XML element '.$param_element.' value not valid'); }
				else { return true; }
		} else {
			// create array if parameter $param_allowed_values is no array
			if(!is_array($param_allowed_values)){ $param_allowed_values = array($param_allowed_values); }
			// check
			if(!in_array((string)$this->_xmldata->$param_element,$param_allowed_values)){ $this->returnError($param_errorcode, 'XML element '.$param_element.' value not valid'); }
				else { return true; }
		}
	}
	protected function is_xml_element_value_long_enough($param_element, $param_errorcode, $param_min_length){
		if(mb_strlen((string)$this->_xmldata->$param_element, 'UTF-8') < $param_min_length){ $this->returnError($param_errorcode, 'XML element '.$param_element.' too short'); }
			else { return true; }
	}
	protected function is_xml_element_value_length_ok($param_element, $param_errorcode, $param_length){
		if(mb_strlen((string)$this->_xmldata->$param_element, 'UTF-8') != $param_length){ $this->returnError($param_errorcode, 'XML element '.$param_element.' length invalid'); }
			else { return true; }
	}
	
	protected function is_xml_element_set_and_valid($param_element, $param_errorcode, $param_allowed_values){
		$this->is_xml_element_set($param_element, $param_errorcode);
		$this->is_xml_element_valid($param_element, $param_errorcode, $param_allowed_values);
	}
	protected function is_xml_element_set_and_long_enough($param_element, $param_errorcode, $param_min_length){
		$this->is_xml_element_set($param_element, $param_errorcode);
		$this->is_xml_element_value_long_enough($param_element, $param_errorcode, $param_min_length);
	}
	protected function is_xml_element_set_and_length_ok($param_element, $param_errorcode, $param_length){
		$this->is_xml_element_set($param_element, $param_errorcode);
		$this->is_xml_element_value_length_ok($param_element, $param_errorcode, $param_length);
	}
	
	protected function is_url_valid($param_url){
		if( (mb_strlen($param_url, 'UTF-8') >= 11) AND 
			((mb_substr(mb_strtolower($param_url, 'UTF-8'), 0, 7, 'UTF-8') == 'http://') OR (mb_substr(mb_strtolower($param_url, 'UTF-8'), 0, 8, 'UTF-8') == 'https://')) AND 
			( mb_strpos($param_url, '.', 8, 'UTF-8') !== false )
			// not using parse_url here due to possible UTF-8 character incompatibility
		){
			return true;
		} else {
			return false;
		}
	}
	
	protected function is_PDF_file($param_filename){
		$handle = @fopen($param_filename, "r");
		$contents = @fread($handle, 4);
		@fclose($handle);
		if($contents == '%PDF'){ return true; } else { return false; }
	}
	
	public function xmlencode($param_string){
		return htmlspecialchars($param_string, 16 | ENT_QUOTES, 'UTF-8'); // 16 = ENT_XML1
	}
	
	protected function remove_accents($param_string)
	{
		$search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
		$replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
		return str_replace($search, $replace, $param_string);
	}
	
	public function sanitize_string($param_string){
		return mb_ereg_replace("[^A-Za-z0-9_\.\-]", '-', $this->remove_accents($param_string));
	}
	
	protected function mb_strreplace($param_search, $param_replace, $param_subject){
		return str_replace($param_search, $param_replace, $param_subject);
	}
	
	
}

// UTF-8 test: ö

?>