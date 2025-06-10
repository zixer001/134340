
<?php
 include('connectdb.php');  
          $sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
$GLOBALS['user_ag']=$agent;
$GLOBALS['pass_ag']=$pass_agent;

error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
class Ufa
{
	
	private $cookie = false;
	private $token = false;
	public function Curl($method, $url, $header, $data, $cookie)
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36');
	
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_TIMEOUT, 9);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		if ($data) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		if ($cookie) {
			curl_setopt($ch, CURLOPT_COOKIESESSION, true);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		return curl_exec($ch);
	}
	public function Curl_cookie($method, $url, $header, $data, $cookie)
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36');
	
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 9);
		if ($data) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		if ($cookie) {
			curl_setopt($ch, CURLOPT_COOKIESESSION, true);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		$result = curl_exec($ch);
		return $result;
	}
	public function Cookie($name)
	{
		$cookie = file_get_contents($name);
		$line = explode("\n", $cookie);
		$cookie = '';
		foreach ($line as $key => $value) {
			$tokens = explode("\t", $value);
			if (count($tokens) == 7) {

				$tokens = array_map(null, $tokens);
				//print_r($tokens);
				$cookie .= trim($tokens[5]) . "=" . trim($tokens[6]) . ";";
			}
		}
		return $cookie;
	}
	public function check()
	{
		$url = file_get_contents('http://ocean.isme99.com');
		$res = @explode("<script language='javascript'>window.open('", $url);
		$res = @explode("','_top');</script>", $res[1]);
		if ($res[0] != '') {

			$url = file_get_contents('http://ocean.isme99.com/Public/' . $res[0]);
			$rows = $this->DOMXPath($url, '//td[@class="smartFont"]');
			$data = $rows[0]->nodeValue;
			$string = trim(preg_replace('/\s\s+/', ' ', $data));
			return  true;
		} else {
			return false;
		}
	}
	private function DOMXPath($html, $qry)
	{
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$xpath = new DOMXPath($doc);
		$nodeList = $xpath->query($qry);

		return $nodeList;
	}
	public function check_login($ASPXAUTH)
	{
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: .ASPXAUTH=' . $ASPXAUTH,
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		$res = $this->Curl("GET", "https://ocean.isme99.com/AccInfo.aspx", $header, false, false);
		// print_r($res);
		// exit();
		$check = explode('<title>', $res);
		$check = explode('</title>', $check[1]);
		if ($check[0] == "Object moved") {

			return json_encode(['stats' => false]);
		} else {
			return json_encode(['stats' => true]);
		}
	}
	public function genarate_cookie($name)
	{
		$cookie_name = $name;
		//file_put_contents(dirname(__FILE__).'/'.$cookie_name, "");
		file_put_contents($cookie_name, "");
		$this->cookie = realpath($cookie_name);
		return $this->cookie;
	}

	public function getCookie()
	{
		return $this->cookie;
	}

	public function genarate_Password()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	public function captcha($cookie)
	{
		if ($this->check() == false) {
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded",
				"origin: https://ocean.isme99.com",
				"sec-fetch-dest: document",
				"sec-fetch-mode: navigate",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);
			$res  = $this->Curl('GET', 'https://ocean.isme99.com/Public/ValidateImgGen.aspx', $header, false, $cookie);
			preg_match_all("/src='(.+?)'/is", $res, $data);
			//print_r($data[1][0]);
			$cap = $this->Curl('GET', 'https://ocean.isme99.com/Public/' . $data[1][0], $header, false, $cookie);
			file_put_contents("test.jpg", $cap);

			return $this->OCR('test.jpg'); //$this->crackOcr('test.jpg'); สำรองแคปช่าแบบเสียตัง
		} else {
			return exit('ปิดปรับปรุง');
		}
	}
	private  function crackOcr($picture) //http://www.ocrwebservice.com สำรองแคปช่าแบบเสียตัง
	{

		$license_code = "";
		$username = "";


		$url = 'http://www.ocrwebservice.com/restservices/processDocument?gettext=true';

		$filePath = $picture;

		$fp = fopen($filePath, 'r');
		$session = curl_init();

		curl_setopt($session, CURLOPT_URL, $url);
		curl_setopt($session, CURLOPT_USERPWD, "$username:$license_code");

		curl_setopt($session, CURLOPT_UPLOAD, true);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($session, CURLOPT_TIMEOUT, 200);
		curl_setopt($session, CURLOPT_HEADER, false);


		// For SSL using
		//curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);

		curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		curl_setopt($session, CURLOPT_INFILE, $fp);
		curl_setopt($session, CURLOPT_INFILESIZE, filesize($filePath));

		$result = curl_exec($session);

		$httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
		curl_close($session);
		fclose($fp);

		if ($httpCode == 401) {
			die('Unauthorized request');
		}
		$data = json_decode($result);

		if ($httpCode != 200) {
			exit($data->ErrorMessage);
		}

		return trim($data->OCRText[0][0]);
	}
	private function OCR($picture)
	{
		$pictures = file_get_contents("test.jpg");

		$pictures = base64_encode($pictures);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://103.13.229.169:5000/api/ocr/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
				"image": "' . $pictures . '"
			}',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$json = json_decode($response, true);



		if (isset($json['answer'])) {
			return $json['answer'];
		} else {
			exit('error captcha');
		}
	}
	public function code_login($cookie)
	{
		date_default_timezone_set('Asia/Manila');
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded",
			"origin: https://ocean.isme99.com",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: __cfduid=' . $cookie['cfduid'] . '; ASP.NET_SessionId=' . $cookie['aspid'],
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		$res = $this->Curl("GET", "https://ocean.isme99.com/Public/Default11.aspx?rt=" . date('yyMdHis') . "&lang=EN-GB", $header, false, FALSE);
		$__VIEWSTATE = $this->DOMXPath($res, "//input[@name='__VIEWSTATE']/@value");
		$__EVENTVALIDATION = $this->DOMXPath($res, "//input[@name='__EVENTVALIDATION']/@value");
		$__VIEWSTATEGENERATOR = $this->DOMXPath($res, "//input[@name='__VIEWSTATEGENERATOR']/@value");
		$arr = [
			"__VIEWSTATE" => $__VIEWSTATE[0]->nodeValue,
			"__EVENTVALIDATION" => $__EVENTVALIDATION[0]->nodeValue,
			"__VIEWSTATEGENERATOR" => $__VIEWSTATEGENERATOR[0]->nodeValue,
		];
		return $arr;
	}
	public function login_Ufa($cookie, $code, $cookie1)
	{
		date_default_timezone_set('Asia/Manila');
		$user = $GLOBALS['user_ag'];
		$pass = $GLOBALS['pass_ag'];
		$code_login = $this->code_login($cookie);

		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded",
			"origin: https://ocean.isme99.com",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: __cfduid=' . $cookie['cfduid'] . '; ASP.NET_SessionId=' . $cookie['aspid'],
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		$_data = array(
			'__EVENTTARGET' => 'btnSignIn',
			'__EVENTARGUMENT' => '',
			'__VIEWSTATE' => $code_login['__VIEWSTATE'],
			'__VIEWSTATEGENERATOR' => '3186803D',
			'__EVENTVALIDATION' => $code_login['__EVENTVALIDATION'],
			'txtUserName' => $user,
			'txtPassword' => $pass,
			'txtCode' => $code,
			'lstLang' => 'Default11.aspx?rt=' . date('yyMdHis') . '&lang=EN-GB'
		);
		$data = http_build_query($_data);


		$res = $this->Curl_cookie("POST", "https://ocean.isme99.com/Public/Default11.aspx?rt=" . date('yyMdHis') . "&lang=EN-GB", $header, $data, $cookie1);

		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $res, $matches);
		$cookies = array();
		foreach ($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		if ($cookies['_ASPXAUTH']) {
			return $cookies['_ASPXAUTH'];
		} else {
			exit("login error");
		}
	}
	public function agent_info()
	{

		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"sec-fetch-dest: document",
				"sec-fetch-mode: navigate",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				'Cookie: .ASPXAUTH=' . $ASPXAUTH,
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);

			$res = $this->Curl("GET", "https://ocean.isme99.com/AccInfo.aspx", $header, false, false);

			$check = explode('<title>', $res);
			$check = explode('</title>', $check[1]);
			if ($check[0] == "Object moved") {
				return json_encode(['stats' => false]);
			} else {
				$member = explode('<span id="lblsTotalMemberCount" class="Bold">', $res);
				$member = explode('</span>', $member[1]);
				$member = $member[0];
				$credit = explode('<span id="lblsCredit" class="Bold">', $res);
				$credit = explode('</SPAN>', $credit[1]);
				$credit = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $credit[0]);
				$credit_total = explode('<span id="lblsTotalGivenCredit" class="Bold">', $res);
				$credit_total = explode('</SPAN>', $credit_total[1]);
				$credit_total = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $credit_total[0]);
				$TotalMemberCredit = explode('<span id="lblsTotalMemberCredit" class="Bold">', $res);
				$TotalMemberCredit = explode('</SPAN>', $TotalMemberCredit[1]);
				$TotalMemberCredit = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $TotalMemberCredit[0]);
				$TotalOutstanding = explode('<span id="lblsTotalOutstanding" class="Bold">', $res);
				$TotalOutstanding = explode('</SPAN>', $TotalOutstanding[1]);
				$TotalOutstanding = str_replace("<SPAN class='Positive'>", "", $TotalOutstanding[0]);
				$TotalBalance = explode('<span id="lblsTotalBalance" class="Bold">', $res);
				$TotalBalance = explode('</SPAN>', $TotalBalance[1]);
				$TotalBalance = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $TotalBalance[0]);
				$AccBalance = explode('<span id="lblsAccBalance" class="Bold">', $res);
				$AccBalance = explode('</SPAN>', $AccBalance[1]);
				$AccBalance = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $AccBalance[0]);
				$CashBalance = explode('<span id="lblsCashBalance" class="Bold">', $res);
				$CashBalance = explode('</SPAN>', $CashBalance[1]);
				$CashBalance = str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $CashBalance[0]);
				$UserName = explode('<span id="lblsUserName" class="Bold">', $res);
				$UserName = explode('</span>', $UserName[1]);
				$UserName =  str_replace(array("<SPAN class='Negative'>", "<SPAN class='Positive'>"), "", $UserName[0]);
				$arr = [
					"member" => $member,
					"credit" => $credit,
					"credit_total" => $credit_total,
					"TotalMemberCredit" => $TotalMemberCredit,
					"TotalOutstanding" => $TotalOutstanding,
					"TotalBalance" => $TotalBalance,
					"AccBalance" => $AccBalance,
					"CashBalance" => $CashBalance,
					"UserName" => $UserName
				];
				return json_encode($arr);
			}
		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->agent_info();
		}
	}

	
	public function Search($ASPXAUTH, $user)
	{
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: .ASPXAUTH=' . $ASPXAUTH,
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		//$data = "__EVENTARGUMENT=&__EVENTTARGET=btnSubmit&__EVENTVALIDATION=%2FwEdACt1UBFKocwKXQGciLNXIJ3191HZKp63RN6FCSC3Y9mxeGii0%2FYluWGgX0nz8e1xxaB3Vsk%2BmjeKDlVvwAmN%2Fxn8rWq%2F1czLAFa5e7BLjMU%2BWfOvf%2FgQki9pKjilO6JowZ8nLemMuDI2vnyOx0uPLMJ1%2BOMJcr0HyixxFGhF17mUCLsz2W3OR8CiHVIE%2FcLTHgnYs3X7ddAqiAczvOgVzB4rTs9j0PKHXf%2F5FrVcfy0Ou7rUYz1X%2Fh%2B2rPOv5PKyw8885pbWlDO2hADfoPXD%2F5tdAK%2FbHtqm0nweaKv6e7wKmqF7ll0lpGtrUJ5FvBLiaaeZSuLF6NgGUUeTEMqzRAQAkZs7n%2FFnGIrr%2BJwwwjCZyASVeTsNZE8evcg04hhV8aTJ0yDpXLbMs2D%2BtQVkbiskX%2BYYAnoiyWL9akRQTl6yc9H%2BLdlqWTjR6phqJL7HcrgFldSzj2D3i2NU6qzuy%2FluvegE1%2BvPapepyAPdkWhvUEMKDHVGjbete%2B5BoIf3E1nXJUW7tIkYLiE1IXN1TluMrTCpeQELEGp935c0j1KaIFF9d1ziHoPWJROMGxwuoWjV59mvrz3ubVL01TW10GPfj%2BaaGy%2BT8sxnfVTHCPrPp0SO8uLs6Wl1Gl3s1BWLXi1Kj6G9V0xvv16plWmAWxsZnSGwQSjYsLxhyAZ6ZGGNqQT3DTg70BrG4M%2Bb5Xv%2F4dnelEBRepAfeOYdfWWDfj31JAGIo47xUgabTxFPcgqHhF%2Bs9wg0jh6tP6AQ4%2FkslBwgpPbpkNv%2FaCRdZeoaUIoQZoWJgXqqPqzmqLa9FkoF3kfWt83WfhM9PyTHJID7VUplk5R9Z5lj4Ua8MeQk%2FsoDT3wxKtxSWu7FCx9fIkCq%2FYJSftxbs4YBUHKpJM4inxij4QWxQmyMnc3S3rEtTpyjUKrNGg8yHClsXYHrm4tVkiFM%2BLc%3D&__VIEWSTATE=%2FwEPDwUJMjk3ODI1MDk5D2QWAgIDD2QWCmYPFgIeB1Zpc2libGVnZAIDD2QWAgIBDxBkDxYDZgIBAgIWAwUe4Lij4Lir4Lix4Liq4Lic4Li54LmJ4LmD4LiK4LmJBRLguKLguK3guJTguJTguLjguKUFIeC4p%2BC4seC4meC4l%2BC4teC5iOC4quC4o%2BC5ieC4suC4h2RkAgYPEGQPFgRmAgECAgIDFgQFFeC4l%2BC4seC5ieC4h%2BC4q%2BC4oeC4lAUGQWN0aXZlBRvguJvguLTguJTguKrguKfguLTguJXguIrguYwFD%2BC4o%2BC4sOC4h%2BC4seC4mmRkAgcPDxYCHgRUZXh0BSs8c3BhbiBjbGFzcz0nRU5HJz7guKLguLfguJnguKLguLHguJk8L3NwYW4%2BZGQCCA8PFgIeBHR5cGUFBm1lbWJlcmQWBAIBDzwrAAsCAA8WCB4IRGF0YUtleXMWAB4LXyFJdGVtQ291bnQCCh4JUGFnZUNvdW50AgEeFV8hRGF0YVNvdXJjZUl0ZW1Db3VudAIKZAQWBB4IQ3NzQ2xhc3MFCEdyaWRJdGVtHgRfIVNCAgIWAmYPZBYWAgEPZBYeZg9kFgJmDxUBATFkAgIPZBYIAgEPDxYCHwEFCnVmemthMjExMjJkZAIDDw8WAh8BBQp1ZnprYTIxMTIyZGQCBQ8PFgIfAQUFRmFsc2VkZAIHDw8WAh8BBQVGYWxzZWRkAgMPZBYCAgEPDxYCHwFlZGQCBA9kFgJmDxUBCjA5NjkyODA4MTBkAgUPZBYCAgEPDxYCHwEFGzxzcGFuIGNsYXNzPSdHQic%2BVEhCPC9zcGFuPmRkAgYPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIHD2QWAmYPFQEhPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz42MDA8L1NQQU4%2BZAIID2QWAgIBDw8WBB8BBQbguJTguLkfAGhkZAIJD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAIKD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAILD2QWAmYPFQENMTcxLjYuMjQ4LjIxMmQCDA9kFgJmDxUBEzA4LzA0LzIwMjAgMDg6NDEgUE1kAg0PZBYCZg8VATY8c3BhbiBjbGFzcz0nRGVhY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj5kAg4PZBYCZg8VAcMBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyMTEyMiZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj48L2E%2BZAIPD2QWAmYPFQG6ATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjExMjImdHlwZT1tZW1iZXImcm9sZT1hZycgdGFyZ2V0PSdfaVN1c0xvY2snID48c3BhbiBjbGFzcz0nQWN0aXZhdGVkJz7guYDguJvguLTguJQ8L3NwYW4%2BPC9hPmQCAg9kFh5mD2QWAmYPFQEBMmQCAg9kFggCAQ8PFgIfAQUMdWZ6a2EyMTIzMTIxZGQCAw8PFgIfAQUMdWZ6a2EyMTIzMTIxZGQCBQ8PFgIfAQUFRmFsc2VkZAIHDw8WAh8BBQVGYWxzZWRkAgMPZBYCAgEPDxYCHwFlZGQCBA9kFgJmDxUBCjA5NjkyODA4MTBkAgUPZBYCAgEPDxYCHwEFGzxzcGFuIGNsYXNzPSdHQic%2BVEhCPC9zcGFuPmRkAgYPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIHD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCCA9kFgICAQ8PFgQfAQUG4LiU4Li5HwBoZGQCCQ9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCg9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCw9kFgJmDxUBCTEyNy4wLjAuMWQCDA9kFgJmDxUBEzA5LzA0LzIwMjAgMDk6MjYgQU1kAg0PZBYCZg8VATY8c3BhbiBjbGFzcz0nRGVhY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj5kAg4PZBYCZg8VAcUBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyMTIzMTIxJnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPjwvYT5kAg8PZBYCZg8VAbwBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyMTIzMTIxJnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4LmA4Lib4Li04LiUPC9zcGFuPjwvYT5kAgMPZBYeZg9kFgJmDxUBATNkAgIPZBYIAgEPDxYCHwEFDHVmemthMjEyMzEyM2RkAgMPDxYCHwEFDHVmemthMjEyMzEyM2RkAgUPDxYCHwEFBUZhbHNlZGQCBw8PFgIfAQUFRmFsc2VkZAIDD2QWAgIBDw8WAh8BZWRkAgQPZBYCZg8VAQowOTY5MjgwODEwZAIFD2QWAgIBDw8WAh8BBRs8c3BhbiBjbGFzcz0nR0InPlRIQjwvc3Bhbj5kZAIGD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCBw9kFgJmDxUBHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kAggPZBYCAgEPDxYEHwEFBuC4lOC4uR8AaGRkAgkPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgoPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgsPZBYCZg8VAQkxMjcuMC4wLjFkAgwPZBYCZg8VARMwOS8wNC8yMDIwIDA5OjIzIEFNZAIND2QWAmYPFQE2PHNwYW4gY2xhc3M9J0RlYWN0aXZhdGVkJz7guKvguKHguLLguKLguYDguKXguII8L3NwYW4%2BZAIOD2QWAmYPFQHFATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjEyMzEyMyZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj48L2E%2BZAIPD2QWAmYPFQG8ATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjEyMzEyMyZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC5gOC4m%2BC4tOC4lDwvc3Bhbj48L2E%2BZAIED2QWHmYPZBYCZg8VAQE0ZAICD2QWCAIBDw8WAh8BBQx1ZnprYTIxMjMxMjVkZAIDDw8WAh8BBQx1ZnprYTIxMjMxMjVkZAIFDw8WAh8BBQVGYWxzZWRkAgcPDxYCHwEFBUZhbHNlZGQCAw9kFgICAQ8PFgIfAWVkZAIED2QWAmYPFQEKMDk2OTI4MDgxMGQCBQ9kFgICAQ8PFgIfAQUbPHNwYW4gY2xhc3M9J0dCJz5USEI8L3NwYW4%2BZGQCBg9kFgJmDxUBHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kAgcPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIID2QWAgIBDw8WBB8BBQbguJTguLkfAGhkZAIJD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAIKD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAILD2QWAmYPFQEJMTI3LjAuMC4xZAIMD2QWAmYPFQETMDkvMDQvMjAyMCAwOTo1NSBBTWQCDQ9kFgJmDxUBNjxzcGFuIGNsYXNzPSdEZWFjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPmQCDg9kFgJmDxUBxQE8YSBjbGFzcz0nTGluazInIG9uY2xpY2s9J18kU3VzcGVuZExvY2sodGhpcyk7JyAgaHJlZj0nL19BZ2UvU3VzcGVuZExvY2suYXNweD91c2VyTmFtZT11ZnprYTIxMjMxMjUmdHlwZT1tZW1iZXImcm9sZT1hZycgdGFyZ2V0PSdfaVN1c0xvY2snID48c3BhbiBjbGFzcz0nQWN0aXZhdGVkJz7guKvguKHguLLguKLguYDguKXguII8L3NwYW4%2BPC9hPmQCDw9kFgJmDxUBvAE8YSBjbGFzcz0nTGluazInIG9uY2xpY2s9J18kU3VzcGVuZExvY2sodGhpcyk7JyAgaHJlZj0nL19BZ2UvU3VzcGVuZExvY2suYXNweD91c2VyTmFtZT11ZnprYTIxMjMxMjUmdHlwZT1tZW1iZXImcm9sZT1hZycgdGFyZ2V0PSdfaVN1c0xvY2snID48c3BhbiBjbGFzcz0nQWN0aXZhdGVkJz7guYDguJvguLTguJQ8L3NwYW4%2BPC9hPmQCBQ9kFh5mD2QWAmYPFQEBNWQCAg9kFggCAQ8PFgIfAQUMdWZ6a2EyMTIzMTI4ZGQCAw8PFgIfAQUMdWZ6a2EyMTIzMTI4ZGQCBQ8PFgIfAQUFRmFsc2VkZAIHDw8WAh8BBQVGYWxzZWRkAgMPZBYCAgEPDxYCHwFlZGQCBA9kFgJmDxUBCjA5NjkyODA4MTBkAgUPZBYCAgEPDxYCHwEFGzxzcGFuIGNsYXNzPSdHQic%2BVEhCPC9zcGFuPmRkAgYPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIHD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCCA9kFgICAQ8PFgQfAQUG4LiU4Li5HwBoZGQCCQ9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCg9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCw9kFgJmDxUBCTEyNy4wLjAuMWQCDA9kFgJmDxUBEzA5LzA0LzIwMjAgMDk6NTcgQU1kAg0PZBYCZg8VATY8c3BhbiBjbGFzcz0nRGVhY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj5kAg4PZBYCZg8VAcUBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyMTIzMTI4JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPjwvYT5kAg8PZBYCZg8VAbwBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyMTIzMTI4JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4LmA4Lib4Li04LiUPC9zcGFuPjwvYT5kAgYPZBYeZg9kFgJmDxUBATZkAgIPZBYIAgEPDxYCHwEFDHVmemthMjEyMzEyOWRkAgMPDxYCHwEFDHVmemthMjEyMzEyOWRkAgUPDxYCHwEFBUZhbHNlZGQCBw8PFgIfAQUFRmFsc2VkZAIDD2QWAgIBDw8WAh8BZWRkAgQPZBYCZg8VAQowOTY5MjgwODEwZAIFD2QWAgIBDw8WAh8BBRs8c3BhbiBjbGFzcz0nR0InPlRIQjwvc3Bhbj5kZAIGD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCBw9kFgJmDxUBHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kAggPZBYCAgEPDxYEHwEFBuC4lOC4uR8AaGRkAgkPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgoPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgsPZBYCZg8VAQkxMjcuMC4wLjFkAgwPZBYCZg8VARMwOS8wNC8yMDIwIDA5OjU5IEFNZAIND2QWAmYPFQE2PHNwYW4gY2xhc3M9J0RlYWN0aXZhdGVkJz7guKvguKHguLLguKLguYDguKXguII8L3NwYW4%2BZAIOD2QWAmYPFQHFATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjEyMzEyOSZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj48L2E%2BZAIPD2QWAmYPFQG8ATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjEyMzEyOSZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC5gOC4m%2BC4tOC4lDwvc3Bhbj48L2E%2BZAIHD2QWHmYPZBYCZg8VAQE3ZAICD2QWCAIBDw8WAh8BBQx1ZnprYTIxNTM0OTdkZAIDDw8WAh8BBQx1ZnprYTIxNTM0OTdkZAIFDw8WAh8BBQVGYWxzZWRkAgcPDxYCHwEFBUZhbHNlZGQCAw9kFgICAQ8PFgIfAWVkZAIED2QWAmYPFQEKMDk2OTI4MDgxMGQCBQ9kFgICAQ8PFgIfAQUbPHNwYW4gY2xhc3M9J0dCJz5USEI8L3NwYW4%2BZGQCBg9kFgJmDxUBHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kAgcPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIID2QWAgIBDw8WBB8BBQbguJTguLkfAGhkZAIJD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAIKD2QWAgIBDw8WAh8BBQ%2FguYHguIHguYnguYTguIJkZAILD2QWAmYPFQEJMTI3LjAuMC4xZAIMD2QWAmYPFQETMDkvMDQvMjAyMCAxMDowNSBBTWQCDQ9kFgJmDxUBNjxzcGFuIGNsYXNzPSdEZWFjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPmQCDg9kFgJmDxUBxQE8YSBjbGFzcz0nTGluazInIG9uY2xpY2s9J18kU3VzcGVuZExvY2sodGhpcyk7JyAgaHJlZj0nL19BZ2UvU3VzcGVuZExvY2suYXNweD91c2VyTmFtZT11ZnprYTIxNTM0OTcmdHlwZT1tZW1iZXImcm9sZT1hZycgdGFyZ2V0PSdfaVN1c0xvY2snID48c3BhbiBjbGFzcz0nQWN0aXZhdGVkJz7guKvguKHguLLguKLguYDguKXguII8L3NwYW4%2BPC9hPmQCDw9kFgJmDxUBvAE8YSBjbGFzcz0nTGluazInIG9uY2xpY2s9J18kU3VzcGVuZExvY2sodGhpcyk7JyAgaHJlZj0nL19BZ2UvU3VzcGVuZExvY2suYXNweD91c2VyTmFtZT11ZnprYTIxNTM0OTcmdHlwZT1tZW1iZXImcm9sZT1hZycgdGFyZ2V0PSdfaVN1c0xvY2snID48c3BhbiBjbGFzcz0nQWN0aXZhdGVkJz7guYDguJvguLTguJQ8L3NwYW4%2BPC9hPmQCCA9kFh5mD2QWAmYPFQEBOGQCAg9kFggCAQ8PFgIfAQUMdWZ6a2EyNDE3MjI1ZGQCAw8PFgIfAQUMdWZ6a2EyNDE3MjI1ZGQCBQ8PFgIfAQUFRmFsc2VkZAIHDw8WAh8BBQVGYWxzZWRkAgMPZBYCAgEPDxYCHwFlZGQCBA9kFgJmDxUBCjA5NjkyODA4MTBkAgUPZBYCAgEPDxYCHwEFGzxzcGFuIGNsYXNzPSdHQic%2BVEhCPC9zcGFuPmRkAgYPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIHD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCCA9kFgICAQ8PFgQfAQUG4LiU4Li5HwBoZGQCCQ9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCg9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCw9kFgJmDxUBCTEyNy4wLjAuMWQCDA9kFgJmDxUBEzA5LzA0LzIwMjAgMTA6MDUgQU1kAg0PZBYCZg8VATY8c3BhbiBjbGFzcz0nRGVhY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj5kAg4PZBYCZg8VAcUBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyNDE3MjI1JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPjwvYT5kAg8PZBYCZg8VAbwBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyNDE3MjI1JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4LmA4Lib4Li04LiUPC9zcGFuPjwvYT5kAgkPZBYeZg9kFgJmDxUBATlkAgIPZBYIAgEPDxYCHwEFDHVmemthMjUxMzY2NmRkAgMPDxYCHwEFDHVmemthMjUxMzY2NmRkAgUPDxYCHwEFBUZhbHNlZGQCBw8PFgIfAQUFRmFsc2VkZAIDD2QWAgIBDw8WAh8BZWRkAgQPZBYCZg8VAQowOTY5MjgwODEwZAIFD2QWAgIBDw8WAh8BBRs8c3BhbiBjbGFzcz0nR0InPlRIQjwvc3Bhbj5kZAIGD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCBw9kFgJmDxUBHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kAggPZBYCAgEPDxYEHwEFBuC4lOC4uR8AaGRkAgkPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgoPZBYCAgEPDxYCHwEFD%2BC5geC4geC5ieC5hOC4gmRkAgsPZBYCZg8VAQkxMjcuMC4wLjFkAgwPZBYCZg8VARMwOS8wNC8yMDIwIDEwOjA3IEFNZAIND2QWAmYPFQE2PHNwYW4gY2xhc3M9J0RlYWN0aXZhdGVkJz7guKvguKHguLLguKLguYDguKXguII8L3NwYW4%2BZAIOD2QWAmYPFQHFATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjUxMzY2NiZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj48L2E%2BZAIPD2QWAmYPFQG8ATxhIGNsYXNzPSdMaW5rMicgb25jbGljaz0nXyRTdXNwZW5kTG9jayh0aGlzKTsnICBocmVmPScvX0FnZS9TdXNwZW5kTG9jay5hc3B4P3VzZXJOYW1lPXVmemthMjUxMzY2NiZ0eXBlPW1lbWJlciZyb2xlPWFnJyB0YXJnZXQ9J19pU3VzTG9jaycgPjxzcGFuIGNsYXNzPSdBY3RpdmF0ZWQnPuC5gOC4m%2BC4tOC4lDwvc3Bhbj48L2E%2BZAIKD2QWHmYPZBYCZg8VAQIxMGQCAg9kFggCAQ8PFgIfAQUMdWZ6a2EyNTQ3MTk5ZGQCAw8PFgIfAQUMdWZ6a2EyNTQ3MTk5ZGQCBQ8PFgIfAQUFRmFsc2VkZAIHDw8WAh8BBQVGYWxzZWRkAgMPZBYCAgEPDxYCHwFlZGQCBA9kFgJmDxUBCjA5NjkyODA4MTBkAgUPZBYCAgEPDxYCHwEFGzxzcGFuIGNsYXNzPSdHQic%2BVEhCPC9zcGFuPmRkAgYPZBYCZg8VAR88U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjA8L1NQQU4%2BZAIHD2QWAmYPFQEfPFNQQU4gY2xhc3M9J1Bvc2l0aXZlJz4wPC9TUEFOPmQCCA9kFgICAQ8PFgQfAQUG4LiU4Li5HwBoZGQCCQ9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCg9kFgICAQ8PFgIfAQUP4LmB4LiB4LmJ4LmE4LiCZGQCCw9kFgJmDxUBCTEyNy4wLjAuMWQCDA9kFgJmDxUBEzA5LzA0LzIwMjAgMTA6MDIgQU1kAg0PZBYCZg8VATY8c3BhbiBjbGFzcz0nRGVhY3RpdmF0ZWQnPuC4q%2BC4oeC4suC4ouC5gOC4peC4gjwvc3Bhbj5kAg4PZBYCZg8VAcUBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyNTQ3MTk5JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4Lir4Lih4Liy4Lii4LmA4Lil4LiCPC9zcGFuPjwvYT5kAg8PZBYCZg8VAbwBPGEgY2xhc3M9J0xpbmsyJyBvbmNsaWNrPSdfJFN1c3BlbmRMb2NrKHRoaXMpOycgIGhyZWY9Jy9fQWdlL1N1c3BlbmRMb2NrLmFzcHg%2FdXNlck5hbWU9dWZ6a2EyNTQ3MTk5JnR5cGU9bWVtYmVyJnJvbGU9YWcnIHRhcmdldD0nX2lTdXNMb2NrJyA%2BPHNwYW4gY2xhc3M9J0FjdGl2YXRlZCc%2B4LmA4Lib4Li04LiUPC9zcGFuPjwvYT5kAgsPZBYEAgYPZBYCAgEPDxYCHwEFHzxTUEFOIGNsYXNzPSdQb3NpdGl2ZSc%2BMDwvU1BBTj5kZAIHD2QWAgIBDw8WAh8BBSE8U1BBTiBjbGFzcz0nUG9zaXRpdmUnPjYwMDwvU1BBTj5kZAIDDw8WAh8BBSc8c3BhbiBzdHlsZT0nZm9udC1zaXplOiAxNHB4Jz4xPC9zcGFuPiBkZGThKja9I%2FSPNmSZZA9on4WKc4Raew%3D%3D&__VIEWSTATEGENERATOR=AE6CD562&hdnlstDeleted=-1&lstDeleted=-1&lstSortBy=0&txtSearch=".$user;
		$res = $this->Curl("GET", "https://ocean.isme99.com/_SubAg1/MemberSet.aspx?userName=" . $user . "&set=1", $header, false, false);
		$money = explode('<input name="txtTotalLimit" type="text" value="', $res);
		$money = explode('" id="txtTotalLimit"', $money[1]);
		$ck = explode('<input name="txtTotalLimit" type="text" value="', $res);
		$ck = explode('" id="txtTotalLimit"', $ck[1]);
		if ($ck[0] == null) {
			return 'error';
		} else {
			if (strlen($money[0]) >= 5) {
				$number = (float) str_replace(',', '', $money[0]);
				return $number;
			} else {
				return $money[0];
			}
		}
	}
	public function get_created_cookie($cookie)
	{
		if ($file = fopen($cookie, "r")) {
			while (!feof($file)) {
				$line = fgets($file);

				if (strpos($line, '__cfduid') !== false) {
					$cfduid = preg_replace("/\s+/", "", explode("__cfduid", $line)[1]);
				}
				if (strpos($line, 'ASP.NET_SessionId') !== false) {
					$aspid = preg_replace("/\s+/", "", explode("ASP.NET_SessionId", $line)[1]);
				}
			}
			fclose($file);
		}
		if (empty($cfduid) || empty($aspid)) {
			return false;
		} else {
			return array(
				"cfduid" => $cfduid,
				"aspid" => $aspid,
			);
		}
	}
	public function get_created_cookie_login($cookie)
	{
		if ($file = fopen($cookie, "r")) {
			while (!feof($file)) {
				$line = fgets($file);
				if (strpos($line, '.ASPXAUTH') !== false) {
					$aspx = preg_replace("/\s+/", "", explode(".ASPXAUTH", $line)[1]);
				}
			}
			fclose($file);
		}
		if (empty($aspx)) {
			return false;
		} else {
			return array(
				"aspx" => $aspx
			);
		}
	}
	public function get_created_cookie_wit($cookie)
	{
		if ($file = fopen($cookie, "r")) {
			while (!feof($file)) {
				$line = fgets($file);
				if (strpos($line, '_ws868admweb_v6_' . $GLOBALS['user_ag']) !== false) {
					$ws8 = preg_replace("/\s+/", "", explode("_ws868admweb_v6_" . $GLOBALS['user_ag'], $line)[1]);
				}
				if (strpos($line, '__cfduid') !== false) {
					$cfduid = preg_replace("/\s+/", "", explode("__cfduid", $line)[1]);
				}
				if (strpos($line, 'ASP.NET_SessionId') !== false) {
					$aspid = preg_replace("/\s+/", "", explode("ASP.NET_SessionId", $line)[1]);
				}
			}
			fclose($file);
		}
		if (empty($ws8)) {
			return false;
		} else {
			return array(
				"ws8" => $ws8,
				"cfduid" => $cfduid,
				"aspid" => $aspid
			);
		}
	}
	public function del_cookie($cookie)
	{
		return unlink($cookie);
	}
	public function genarate_GenerateUsername()
	{

		return rand(100000, 1000000);
	}
	public function code_addmember($ASPXAUTH)
	{
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: .ASPXAUTH=' . $ASPXAUTH,
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		$res = $this->Curl("GET", "https://ocean.isme99.com/_SubAg1/MemberSet.aspx", $header, false, false);
		$__VIEWSTATE = explode('id="__VIEWSTATE" value="', $res);
		$__VIEWSTATE = explode('" />', $__VIEWSTATE[1]);
		$__VIEWSTATE = trim(urlencode($__VIEWSTATE[0]));
		$__EVENTVALIDATION = explode('id="__EVENTVALIDATION" value="', $res);
		$__EVENTVALIDATION = explode('" />', $__EVENTVALIDATION[1]);
		$__EVENTVALIDATION = trim(urlencode($__EVENTVALIDATION[0]));
		$__VIEWSTATEGENERATOR = explode('id="__VIEWSTATEGENERATOR" value="', $res);
		$__VIEWSTATEGENERATOR = explode('" />', $__VIEWSTATEGENERATOR[1]);
		$__VIEWSTATEGENERATOR = trim(urlencode($__VIEWSTATEGENERATOR[0]));
		$arr = [
			'__VIEWSTATE' => $__VIEWSTATE,
			'__EVENTVALIDATION' => $__EVENTVALIDATION,
			'__VIEWSTATEGENERATOR' => $__VIEWSTATEGENERATOR
		];
		return $arr;
	}
	private function code($ASPXAUTH, $username)
	{
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"sec-fetch-dest: document",
			"sec-fetch-mode: navigate",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: .ASPXAUTH=' . $ASPXAUTH,
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		$res = $this->Curl("GET", "https://ocean.isme99.com/_SubAg1/MemberSet.aspx?userName=" . $username . "&set=1", $header, false, false);
		$__VIEWSTATE = explode('id="__VIEWSTATE" value="', $res);
		$__VIEWSTATE = explode('" />', $__VIEWSTATE[1]);
		$__VIEWSTATE = trim(urlencode($__VIEWSTATE[0]));
		$__EVENTVALIDATION = explode('id="__EVENTVALIDATION" value="', $res);
		$__EVENTVALIDATION = explode('" />', $__EVENTVALIDATION[1]);
		$__EVENTVALIDATION = trim(urlencode($__EVENTVALIDATION[0]));
		$__VIEWSTATEGENERATOR = explode('id="__VIEWSTATEGENERATOR" value="', $res);
		$__VIEWSTATEGENERATOR = explode('" />', $__VIEWSTATEGENERATOR[1]);
		$__VIEWSTATEGENERATOR = trim(urlencode($__VIEWSTATEGENERATOR[0]));
		$arr = [
			'__VIEWSTATE' => $__VIEWSTATE,
			'__EVENTVALIDATION' => $__EVENTVALIDATION,
			'__VIEWSTATEGENERATOR' => $__VIEWSTATEGENERATOR
		];
		return $arr;
	}
	public function Deposit($username, $amount)
	{	
		$iddp = $_POST["id"];
		$idcb = $_POST["id"];
		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {
			$money = $amount;
			$m = $this->Search($ASPXAUTH, $username);
			$code = $this->code($ASPXAUTH, $username);
			if ($m != 'error') {
				$m = $m + $amount;
				$header = array(
					"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
					"cache-control: no-cache",
					"sec-fetch-dest: document",
					"sec-fetch-mode: navigate",
					"sec-fetch-site: same-origin",
					"sec-fetch-user: ?1",
					"upgrade-insecure-requests: 1",
					'Cookie: .ASPXAUTH=' . $ASPXAUTH,
					"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
				);
				$data = "LoginType=btnLoginTypeYes&RAM=btnRAMEnable&RAR=btnRAREnable&RAS=btnRASEnable&RAU=btnRAUEnable&RBF=btnRBFEnable&RBH=btnRBHDisable&RBI=btnRBIEnable&RBL=btnRBLEnable&RBM=btnRBMEnable&RBO=btnRBOEnable&Suspend=btnSuspendNo&Usa=btnUsaYes&__EVENTARGUMENT=&__EVENTTARGET=btnUpdateC&__EVENTVALIDATION=" . $code['__EVENTVALIDATION'] . "&__LASTFOCUS=&__VIEWSTATE=" . $code['__VIEWSTATE'] . "&__VIEWSTATEGENERATOR=" . $code['__VIEWSTATEGENERATOR'] . "&hidRAMProfile=1&hidRARProfile=1&hidRBFProfile=4&hidRBGProfile=1&hidRBIProfile=1&hidRBMProfile=1&hidRBOProfile=1&lstCommission=0&lstCommissionOther=0&lstCommissionPar=0&lstCommissionRAM=0&lstCommissionRAR=0&lstCommissionRBF=0&lstCommissionRBG=0&lstCommissionRBM=0&lstCommissionRBO=0&lstCommissionType=A&lstCommissionX12=0&lstShares=0&lstSharesPar=0&lstSharesRAM=0&lstSharesRAR=0&lstSharesRAS=0&lstSharesRAU=0&lstSharesRBF=0&lstSharesRBG=0&lstSharesRBH=0&lstSharesRBI=0&lstSharesRBL=0&lstSharesRBM=0&lstSharesRBO=0&lstSharesRun=0&lstSharesRunX12=0&lstSharesX12=0&optRAMProfile=1&optRARProfile=1&optRBFProfile=4&optRBGProfile=1&optRBIProfile=1&optRBMProfile=1&optRBOProfile=1&txtBeforeRun=100%2C000&txtContact=&txtMatchLimitOS=100%2C000&txtMatchLimitOther=100%2C000&txtMatchLimitX12=100%2C000&txtMaxOS=150%2C000&txtMaxOther=150%2C000&txtMaxPar=150%2C000&txtMaxX12=150%2C000&txtPar=100%2C000&txtPassword=&txtTotalLimit=" . $m . "&txtTransLimit=100%2C000";
				//	   $data = "LoginType=btnLoginTypeYes&RAM=btnRAMEnable&RAR=btnRAREnable&RAS=btnRASEnable&RAU=btnRAUEnable&RBF=btnRBFEnable&RBH=btnRBHDisable&RBI=btnRBIEnable&RBL=btnRBLEnable&RBM=btnRBMEnable&RBO=btnRBOEnable&Suspend=btnSuspendNo&Usa=btnUsaYes&__EVENTARGUMENT=&__EVENTTARGET=btnUpdateC&__EVENTVALIDATION=".$code['__EVENTVALIDATION']."&__LASTFOCUS=&__VIEWSTATE=".$code['__VIEWSTATE']."&__VIEWSTATEGENERATOR=".$code['__VIEWSTATEGENERATOR']."&hidRAMProfile=1&hidRARProfile=1&hidRBFProfile=4&hidRBGProfile=1&hidRBIProfile=1&hidRBMProfile=1&hidRBOProfile=1&lstCommission=0&lstCommissionOther=0&lstCommissionPar=0&lstCommissionRAM=0&lstCommissionRAR=0&lstCommissionRBF=0&lstCommissionRBG=0&lstCommissionRBM=0&lstCommissionRBO=0&lstCommissionType=A&lstCommissionX12=0&lstShares=0&lstSharesPar=0&lstSharesRAM=0&lstSharesRAR=0&lstSharesRAS=0&lstSharesRAU=0&lstSharesRBF=0&lstSharesRBG=0&lstSharesRBH=0&lstSharesRBI=0&lstSharesRBL=0&lstSharesRBM=0&lstSharesRBO=0&lstSharesRun=0&lstSharesRunX12=0&lstSharesX12=0&optRAMProfile=1&optRARProfile=1&optRBFProfile=4&optRBGProfile=1&optRBIProfile=1&optRBMProfile=1&optRBOProfile=1&txtBeforeRun=100%2C000&txtContact=&txtMatchLimitOS=100%2C000&txtMatchLimitOther=100%2C000&txtMatchLimitX12=100%2C000&txtMaxOS=150%2C000&txtMaxOther=150%2C000&txtMaxPar=150%2C000&txtMaxX12=150%2C000&txtPar=100%2C000&txtPassword=&txtTotalLimit=".$m."&txtTransLimit=100%2C000";
				$res = $this->Curl("POST", "https://ocean.isme99.com/_SubAg1/MemberSet.aspx?userName=" . $username . "&set=1", $header, $data, false);
				$lblStatus = $this->DOMXPath($res, "//span[@class='ENG']");
				if ($lblStatus[0]->nodeValue == "Profile updated successfully.") {
					include('connectdb.php');

						$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
						$result = mysqli_query($con, $sql);
						$row = mysqli_fetch_assoc($result);
					
						$key = $row['linedeposit'];
					$sMessage = "เติมเครดิตโดยแอดมิน \nจำนวนเงิน ".$amount." บาท\nเข้ายูสเซอร์ ".$username;
				        $chOne = curl_init(); 
				        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
				        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
				        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
				        curl_setopt( $chOne, CURLOPT_POST, 1); 
				        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
				        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$key.'', );
				        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
				        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
				        $result = curl_exec( $chOne ); 
				        if(curl_error($chOne)) {echo 'error:' . curl_error($chOne); }else { 
				          $result_ = json_decode($result, true); } 
				          curl_close( $chOne );
				          echo '<script>  alert("เติมเครดิตสำเร็จ")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
				} else {
					echo '<script>  alert("เครดิตไม่เพียงพอ !!!!")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
				}
			} else {
				echo '<script>  alert("ไม่พบยูสเซอร์เนมนี้ !!!!")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
			}
		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->Deposit($username, $amount);
		}
	}
	public function GetBalance($username)
	{
		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {
			$url = "https://ocean.isme99.com/_SubAg/AccBal.aspx?role=sa&userName=" . $GLOBALS['user_ag'] . "&searchKey=" . $username . "&pageIndex=1";
			//$url = "https://ag1.ufabet.com/_SubAg_Sub/AccBal.aspx?role=sa&userName=".$GLOBALS['user_ag']."&searchKey=".$username."&pageIndex=1";
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"sec-fetch-dest: document",
				"Content-Type: application/x-www-form-urlencoded",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				'Cookie: .ASPXAUTH=' . $ASPXAUTH,
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);
			$res = $this->Curl("GET", $url, $header, false, false);
			$rows = $this->DOMXPath($res, '//table[@id="AccBal_cm1_g"]/tr');
			foreach ($rows as $row) {
				$cells = $row->getElementsByTagName('td');
				// alt $cells = $xpath->query('td', $row)

				$cellData = [];
				foreach ($cells as $cell) {
					$cellData[] = $cell->nodeValue;
				}
			}
			//print_r($cellData[9]);
			$json =  json_encode(['Balance' => $cellData[9]], JSON_UNESCAPED_UNICODE);
			return $json =  str_replace(array('\t', '\r', '\n', '            '), '', $json);
		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->GetBalance($username);
		}
	}
	public function cookie_Withdraw($ASPXAUTH, $cookie, $username)
	{
		$url = "https://ocean.isme99.com/_SubAg/AccBal.aspx?role=sa&userName=" . strtolower($GLOBALS['user_ag'])  . "&searchKey=" . $username . "&pageIndex=1";
		//$url = "https://ag1.ufabet.com/_SubAg_Sub/AccBal.aspx?role=sa&userName=".$GLOBALS['user_ag']."&searchKey=".$username."&pageIndex=1";
		$header = array(
			"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
			"cache-control: no-cache",
			"sec-fetch-dest: document",
			"Content-Type: application/x-www-form-urlencoded",
			"sec-fetch-site: same-origin",
			"sec-fetch-user: ?1",
			"upgrade-insecure-requests: 1",
			'Cookie: .ASPXAUTH=' . $ASPXAUTH,
			"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
		);
		return $res = $this->Curl("GET", $url, $header, false, $cookie);
	}

	public function turnover($username)
	{
		date_default_timezone_set('Europe/London');
		$date = date("m/d/Y");


		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"sec-fetch-dest: document",
				"Content-Type: application/x-www-form-urlencoded",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				'Cookie: .ASPXAUTH=' . $ASPXAUTH,
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);
			$cookie_turn = $this->genarate_cookie('cookie_turn');
			$url = "https://ocean.isme99.com/_SubAg/SubAccsWinLose2.aspx?role=sa&userName=" . $GLOBALS['user_ag'] . "&catId=&gId=-1";
			$res = $this->Curl("GET", $url, $header, false, $cookie_turn);
			$__VIEWSTATE = $this->DOMXPath($res, "//input[@name='__VIEWSTATE']/@value");
			$__EVENTVALIDATION = $this->DOMXPath($res, "//input[@name='__EVENTVALIDATION']/@value");
			$__VIEWSTATEGENERATOR = $this->DOMXPath($res, "//input[@name='__VIEWSTATEGENERATOR']/@value");
			//$data = 'SubAccsWinLose_cm1$chkAll=on&SubAccsWinLose_cm1$chkCatList$0=on&SubAccsWinLose_cm1$chkCatList$1=on&SubAccsWinLose_cm1$chkCatList$10=on&SubAccsWinLose_cm1$chkCatList$11=on&SubAccsWinLose_cm1$chkCatList$12=on&SubAccsWinLose_cm1$chkCatList$13=on&SubAccsWinLose_cm1$chkCatList$14=on&SubAccsWinLose_cm1$chkCatList$15=on&SubAccsWinLose_cm1$chkCatList$16=on&SubAccsWinLose_cm1$chkCatList$17=on&SubAccsWinLose_cm1$chkCatList$2=on&SubAccsWinLose_cm1$chkCatList$3=on&SubAccsWinLose_cm1$chkCatList$4=on&SubAccsWinLose_cm1$chkCatList$5=on&SubAccsWinLose_cm1$chkCatList$6=on&SubAccsWinLose_cm1$chkCatList$7=on&SubAccsWinLose_cm1$chkCatList$8=on&SubAccsWinLose_cm1$chkCatList$9=on&__EVENTARGUMENT=&__EVENTTARGET=SubAccsWinLose_cm1$btnSubmit&__EVENTVALIDATION='.$__EVENTVALIDATION[0]->nodeValue.'&__VIEWSTATE='.$__VIEWSTATE[0]->nodeValue.'&__VIEWSTATEGENERATOR='.$__VIEWSTATEGENERATOR[0]->nodeValue.'&datBegin=06/01/2020&datEnd=06/21/2020';
			$start_date = urlencode($date);
			$end_date = urlencode(date('m/d/Y'));
		$data = 'SubAccsWinLose_cm1%24chkAll=on&SubAccsWinLose_cm1%24chkCatList%240=on&SubAccsWinLose_cm1%24chkCatList%241=on&SubAccsWinLose_cm1%24chkCatList%2410=on&SubAccsWinLose_cm1%24chkCatList%2411=on&SubAccsWinLose_cm1%24chkCatList%2412=on&SubAccsWinLose_cm1%24chkCatList%2413=on&SubAccsWinLose_cm1%24chkCatList%2414=on&SubAccsWinLose_cm1%24chkCatList%2415=on&SubAccsWinLose_cm1%24chkCatList%2416=on&SubAccsWinLose_cm1%24chkCatList%2417=on&SubAccsWinLose_cm1%24chkCatList%242=on&SubAccsWinLose_cm1%24chkCatList%243=on&SubAccsWinLose_cm1%24chkCatList%244=on&SubAccsWinLose_cm1%24chkCatList%245=on&SubAccsWinLose_cm1%24chkCatList%246=on&SubAccsWinLose_cm1%24chkCatList%247=on&SubAccsWinLose_cm1%24chkCatList%248=on&SubAccsWinLose_cm1%24chkCatList%249=on&__EVENTARGUMENT=&__EVENTTARGET=SubAccsWinLose_cm1%24btnSubmit&__EVENTVALIDATION='.urlencode($__EVENTVALIDATION[0]->nodeValue).'&__VIEWSTATE='.urlencode($__VIEWSTATE[0]->nodeValue).'&__VIEWSTATEGENERATOR=9564A0B0&datBegin='.$start_date.'&datEnd='.$end_date;
			//$data = 'SubAccsWinLose_cm1%24chkAll=on&SubAccsWinLose_cm1%24chkCatList%240=on&SubAccsWinLose_cm1%24chkCatList%241=on&SubAccsWinLose_cm1%24chkCatList%2410=on&SubAccsWinLose_cm1%24chkCatList%2411=on&SubAccsWinLose_cm1%24chkCatList%2412=on&SubAccsWinLose_cm1%24chkCatList%2413=on&SubAccsWinLose_cm1%24chkCatList%2414=on&SubAccsWinLose_cm1%24chkCatList%2415=on&SubAccsWinLose_cm1%24chkCatList%2416=on&SubAccsWinLose_cm1%24chkCatList%2417=on&SubAccsWinLose_cm1%24chkCatList%242=on&SubAccsWinLose_cm1%24chkCatList%243=on&SubAccsWinLose_cm1%24chkCatList%244=on&SubAccsWinLose_cm1%24chkCatList%245=on&SubAccsWinLose_cm1%24chkCatList%246=on&SubAccsWinLose_cm1%24chkCatList%247=on&SubAccsWinLose_cm1%24chkCatList%248=on&SubAccsWinLose_cm1%24chkCatList%249=on&__EVENTARGUMENT=&__EVENTTARGET=SubAccsWinLose_cm1%24btnSubmit&__EVENTVALIDATION=' . urlencode($__EVENTVALIDATION[0]->nodeValue) . '&__VIEWSTATE=' . urlencode($__VIEWSTATE[0]->nodeValue) . '&__VIEWSTATEGENERATOR=9564A0B0&datBegin=' . $start_date . '&datEnd=' . $end_date;
			$res = $this->Curl("POST", $url, $header, ($data), false);
			$rows = $this->DOMXPath($res, '//table[@id="SubAccsWinLose_cm1_g"]/tr');
			$data_u = [];
			for ($i = 2; $i <= count($rows) - 2; $i++) {
				//$dd[] = $rows[$i]->nodeValue;
				$user_data = explode(PHP_EOL, $rows[$i]->nodeValue);
				$data_u[] = [
					"username" => trim($user_data[2]),
					"turnover" => trim(str_replace(",", "", $user_data[9])),
					"winlose" => trim(str_replace(",", "", $user_data[17])),
				];
			}
			//print_r($data_u);
			foreach ($data_u as $v) {
				if ($v['username'] == $username) {
					$dataa = $v;
					break;
				}
			}
			if (@$v['username'] != $username) {
				return json_encode(['status' => false, 'code' => 2, 'msg' => 'กรุณาเดิมพันก่อนถอนเงิน', "turnover" => 0]);
			}

			return json_encode(['status' => 200, 'username' => $v['username'], 'turnover' => $v['turnover'], 'winlose' => $v['winlose']]);
			//print_r(explode(PHP_EOL,$dd[1]));


		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->turnover($username, $date);
		}
	}


	public function Withdraw($username, $amount)
	{
		$idwd = $_POST["id"];
		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {

			$cookie = $this->genarate_cookie('cookie_wit');
			$this->cookie_Withdraw($ASPXAUTH, $cookie, $username);
			$cookie = $this->get_created_cookie_wit($cookie);
			$code = $this->code($ASPXAUTH, $username);
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"sec-fetch-dest: document",
				"Content-Type: application/x-www-form-urlencoded",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				'Cookie: __cfduid=' . $cookie['cfduid'] . ';_ws868admweb_v6_' . $GLOBALS['user_ag'] . '=' . $cookie['ws8'] . ';ASP.NET_SessionId=' . $cookie['aspid'] . ';.ASPXAUTH=' . $ASPXAUTH,
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);
			//print_r($header);
			$url = "https://ocean.isme99.com/_SubAg/AccBal.aspx?role=sa&userName=" . $GLOBALS['user_ag'] . "&searchKey=" . $username . "&pageIndex=1";
			//$url = "https://ag1.ufabet.com/_SubAg_Sub/AccBal.aspx?role=sa&userName=".$GLOBALS['user_ag']."&searchKey=".$username."&pageIndex=1";
			$res = $this->Curl("GET", $url, $header, false, false);
			$link2 = $this->DOMXPath($res, "//a[@class='Link2']/@href");
			$res_ = $this->Curl("GET", 'https://ocean.isme99.com' . $link2[0]->nodeValue, $header, false, false);
			$nowbalold = $this->DOMXPath($res, "//a[@class='Link2']");
			$__VIEWSTATE = $this->DOMXPath($res_, "//input[@name='__VIEWSTATE']/@value");
			$__EVENTVALIDATION = $this->DOMXPath($res_, "//input[@name='__EVENTVALIDATION']/@value");
			$_withdraw_data = array(
				'__LASTFOCUS' => '',
				'__EVENTTARGET' => '',
				'__EVENTARGUMENT' => '',
				'__VIEWSTATE' => $__VIEWSTATE[0]->nodeValue,
				'__VIEWSTATEGENERATOR' => '3AF6B3DA',
				'__EVENTVALIDATION' => $__EVENTVALIDATION[0]->nodeValue,
				'AccPay_cm1$txtAmount' => '-' . $amount,
				'AccPay_cm1$btnSubmit' => 'Submit'
			);  //print_r ($_withdraw_data);
			$withdraw_data = http_build_query($_withdraw_data);
			$check_w = $this->GetBalance($username);
			$Balance = json_decode($check_w, true);
			$money_ufa =  $Balance['Balance'];
			$m = (float) str_replace(',', '', $money_ufa);
			if ($m >= $amount) {
				$withdraw = $this->Curl("POST", 'https://ocean.isme99.com' . $link2[0]->nodeValue, $header, $withdraw_data, false);
				$lblStatus = $this->DOMXPath($withdraw, "//span[@id='AccPay_cm1_lblStatus']");
				//echo $lblStatus[0]->nodeValue;
				if ($lblStatus[0]->nodeValue == "Please try again after 30 seconds.") {
					$result = json_encode(['stats' => false, 'msg' => 'Please try again after 30 seconds.']);
					
					echo '<script>  alert("ตัดเครดิตสำเร็จ")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
				} elseif ($lblStatus[0]->nodeValue == "IG Balance >= Restricted Amount! Please Cash Out to make further payment.") {
					$result = json_encode(['stats' => false, 'msg' => 'IG Balance >= Restricted Amount! Please Cash Out to make further payment.']);
				} elseif (strrpos($lblStatus[0]->nodeValue, "outstanding")) {
					$result = json_encode(['stats' => false, 'msg' => 'outstanding']);
				} else if ($lblStatus[0]->nodeValue == '') {
					include('connectdb.php');

						$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
						$result = mysqli_query($con, $sql);
						$row = mysqli_fetch_assoc($result);
					
						$key = $row['linewithdraw'];
					$sMessage = "ตัดเครดิตโดยแอดมิน \nจำนวนเงิน ".$amount." บาท\nยูสเซอร์ ".$username;
				        $chOne = curl_init(); 
				        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
				        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
				        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
				        curl_setopt( $chOne, CURLOPT_POST, 1); 
				        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
				        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$key.'', );
				        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
				        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
				        $result = curl_exec( $chOne ); 
				        if(curl_error($chOne)) {echo 'error:' . curl_error($chOne); }else { 
				          $result_ = json_decode($result, true); } 
				          curl_close( $chOne );
					echo '<script>  alert("ตัดเครดิตสำเร็จ")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
				} else {
					$result = json_encode(['stats' => false, 'msg' => 'error']);
				}

				return $result;
			} else {
				
				echo '<script>  alert("เครดิตไม่เพียงพอ")</script>';
					echo "<script> window.location.href='javascript:history.back(1)'</script>";
			}
		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->Withdraw($username, $amount);
		}
	}


	public function tranfer($username, $amount)
	{
		@$aspx_auth = $this->get_created_cookie_login('cookie_login');
		$ASPXAUTH = @$aspx_auth['aspx'];
		$check = $this->check_login($ASPXAUTH);
		$check  = json_decode($check, true);
		if ($check['stats'] == true) {

			$cookie = $this->genarate_cookie('cookie_wit');
			$this->cookie_Withdraw($ASPXAUTH, $cookie, $username);
			$cookie = $this->get_created_cookie_wit($cookie);
			$code = $this->code($ASPXAUTH, $username);
			$header = array(
				"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
				"cache-control: no-cache",
				"sec-fetch-dest: document",
				"Content-Type: application/x-www-form-urlencoded",
				"sec-fetch-site: same-origin",
				"sec-fetch-user: ?1",
				"upgrade-insecure-requests: 1",
				'Cookie: __cfduid=' . $cookie['cfduid'] . ';_ws868admweb_v6_' . $GLOBALS['user_ag'] . '=' . $cookie['ws8'] . ';ASP.NET_SessionId=' . $cookie['aspid'] . ';.ASPXAUTH=' . $ASPXAUTH,
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
			);
			//print_r($header);
			$url = "https://ocean.isme99.com/_SubAg/AccBal.aspx?role=sa&userName=" . $GLOBALS['user_ag'] . "&searchKey=" . $username . "&pageIndex=1";
			//$url = "https://ag1.ufabet.com/_SubAg_Sub/AccBal.aspx?role=sa&userName=".$GLOBALS['user_ag']."&searchKey=".$username."&pageIndex=1";
			$res = $this->Curl("GET", $url, $header, false, false);
			$link2 = $this->DOMXPath($res, "//a[@class='Link2']/@href");
			$res_ = $this->Curl("GET", 'https://ocean.isme99.com' . $link2[0]->nodeValue, $header, false, false);
			$nowbalold = $this->DOMXPath($res, "//a[@class='Link2']");
			$__VIEWSTATE = $this->DOMXPath($res_, "//input[@name='__VIEWSTATE']/@value");
			$__EVENTVALIDATION = $this->DOMXPath($res_, "//input[@name='__EVENTVALIDATION']/@value");
			$_withdraw_data = array(
				'__LASTFOCUS' => '',
				'__EVENTTARGET' => '',
				'__EVENTARGUMENT' => '',
				'__VIEWSTATE' => $__VIEWSTATE[0]->nodeValue,
				'__VIEWSTATEGENERATOR' => '3AF6B3DA',
				'__EVENTVALIDATION' => $__EVENTVALIDATION[0]->nodeValue,
				'AccPay_cm1$txtAmount' => '' . $amount,
				'AccPay_cm1$btnSubmit' => 'Submit'
			);  //print_r ($_withdraw_data);
			$withdraw_data = http_build_query($_withdraw_data);
			$check_w = $this->GetBalance($username);
			$Balance = json_decode($check_w, true);
			$money_ufa =  $Balance['Balance'];
			$m = (float) str_replace(',', '', $money_ufa);
			if ($m >= $amount) {
				$withdraw = $this->Curl("POST", 'https://ocean.isme99.com' . $link2[0]->nodeValue, $header, $withdraw_data, false);
				$lblStatus = $this->DOMXPath($withdraw, "//span[@id='AccPay_cm1_lblStatus']");
				//echo $lblStatus[0]->nodeValue;
				if ($lblStatus[0]->nodeValue == "Please try again after 30 seconds.") {
					$result = json_encode(['stats' => false, 'msg' => '30']);
				} elseif ($lblStatus[0]->nodeValue == "IG Balance >= Restricted Amount! Please Cash Out to make further payment.") {
					$result = json_encode(['stats' => false, 'msg' => 'IG']);
				} elseif (strrpos($lblStatus[0]->nodeValue, "outstanding")) {
					$result = json_encode(['stats' => false, 'msg' => 'outstanding']);
				} else if ($lblStatus[0]->nodeValue == '') {
					$result = json_encode(['stats' => true, 'msg' => 'success']);
				} else {
					$result = json_encode(['stats' => false, 'msg' => 'error']);
				}

				return $result;
			} else {
				return json_encode(['status' => false, 'msg' => 'ยอดเงินไม่เพียงพอ']);
			}
		} else {
			$cookie = $this->genarate_cookie('cookie_capt');
			$cookie1 = $this->genarate_cookie('cookie_login');

			$ck = $this->get_created_cookie($cookie);
			$this->login_Ufa($ck, $code, $cookie1); //login agent
			return $this->Withdraw($username, $amount);
		}
	}
}
$api = new Ufa();

if(isset($_GET['deposit'])) {
			$admin=$_POST['admin'];
			if ($admin=='') {
				echo "<script>";
			    echo "alert('ท่านไม่สามารถเพิ่มเครดิตได้');";
			    echo "window.location.href='javascript:history.back(1)'; ";
			    echo "</script>";
			}else{
 			$username=$_POST['username'];
	 		$amount=$_POST['amount'];
	 	echo $api->Deposit($username,$amount);
}
	 	}

if(isset($_GET['cashback'])) {
 			$username=$_POST['username'];
	 		$amount=$_POST['amount'];
	 	echo $api->Deposit($username,$amount);

	 	}

if(isset($_GET['withdraw'])) {
 			$username=$_POST['username'];
	 		$amount=$_POST['amount'];
	 	echo $api->Withdraw($username,$amount);

	 	}


//echo $api->agent_info(); //ข้อมูลเอเย่น
//echo $api->turnover('ufrepi77said4'); // ดูยอดเทิร์นสมาชิก
//echo $api->Deposit('ufreph5503113',4); //เติมเงิน
//echo $api->GetBalance('ufreph5503113'); //เช็คยอดเงิน
//echo $api->Withdraw('ufrepi77said4',1); //เช็คยอดเงิน

$data1 = $api->agent_info();

$credit1=json_decode($data1);
      
$credit=$credit1->credit;


$data2 = $api->GetBalance($agent.$username_mb);

$Balance1=json_decode($data2);
      
$Balance=$Balance1->Balance;


$data3 = $api->turnover($agent.$username_mb);
$turnover8=json_decode($data3);
$turnover5=$turnover8->turnover;