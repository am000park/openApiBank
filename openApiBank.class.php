<?php
//ini_set('display_errors','1');
class OpenApiBank
{
  private $clientId = '';
  private $clientSecret = '';
  public $proUrl = "https://openapi.openbanking.or.kr";
  public $testUrl = "https://testapi.openbanking.or.kr";
  public $pro = 0; // 0-테스트서버, 1-운영서버

  public function get_header()
  {
    date_default_timezone_set('Asia/Seoul');
    $date = date('Y-m-d\TH:i:s.Z\Z', time());
    return "date={$date}";
  }

  public function request($method, $resource, $data = array(), $headers = null)
  {
    try {
      $url = ($this->pro == 0) ? $this->testUrl : $this->proUrl;

      $url .= $resource;

      $httpHeader = array();

      if(is_array($headers)) $httpHeader = array_merge($httpHeader, $headers);

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

      switch($method) {
        case "POST":
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
        default: // GET
          $url = sprintf("%s?%s", $url, http_build_query($data));
      }

      curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 문자열로 반환

      if(curl_error($curl)) {
        print_r(curl_error($curl));
      }

      $response = curl_exec($curl);
      curl_close($curl);

      return json_decode($response);
    } catch(Exception $e) {
      return $e;
    }

  }

  public function getClientId()
  {
    return $this->clientId;
  }

  public function getClientSecret()
  {
    return $this->clientSecret;
  }

  /**
  * 숫자 + 문자를 조합한 난수생성
  */
  public function randStrGenerator($min = 0, $max = 10)
  {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLNMOPQRSTUVWXYZ'), $min, $max);
  }

}
?>
