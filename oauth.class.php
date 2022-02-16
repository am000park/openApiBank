<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/openApi/openApiBank.class.php');

class OpenApiBank_Oauth extends OpenApiBank {

/*
  public function runAuth($redirect_uri = "")
  {
    $data = new stdClass();

    $data->response_type = 'code';
    $data->client_id = $this->clientId;
    $data->scope = 'inquiry';
    $data->state = parent::getMakeHash(); // CSRF 보안 대응휘해 난수값 생성
    $data->auth_type = 0;
    $data->redirect_uri = $redirect_uri;

    $url = ($this->pro == 0) ? $this->testUrl : $this->proUrl;

    $url .= '/oauth/2.0/authorize';

    $url = sprintf("%s?%s", $url, http_build_query($data));

    return $url;
  }
*/

  /**
  * 토큰 생성
  */
  public function createToken()
  {
    $headers = array("Content-Type:application/x-www-form-urlencoded");
    $params = new stdClass();

    $params->client_id = parent::getClientId();
    $params->client_secret = parent::getClientSecret();
    $params->scope = 'oob';
    $params->grant_type = 'client_credentials';

    $params = http_build_query($params);

    return parent::request('POST', '/oauth/2.0/token', $params, $headers);
  }

}
?>
