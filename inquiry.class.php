<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/openApi/oauth.class.php');

class OpenApiBank_Inquiry extends OpenApiBank_Oauth {

  /**
  * 계좌 실명 인증
  */
  public function realName($birth, $bankCode, $bankNumber)
  {
     $tokens = parent::createToken();

     $headers = array(
       'Content-Type:application/json',
       'Authorization:'.$tokens->token_type.$tokens->access_token);

     $params = new stdClass();
     // $params->bank_tran_id = $tokens->client_use_code.'U'.$bankCode.date('His', time());
     $params->bank_tran_id = $tokens->client_use_code.'U'.$bankCode.parent::randStrGenerator(0, 6);
     $params->bank_code_std = $bankCode; // 은행 번호
     $params->account_num = $bankNumber; // 게좌번호
     $params->account_holder_info_type = ''; // 예금주 실명번호 구분코드 1-국내, 2-외국인
     $params->account_holder_info = $birth; // 예금주 실명번호
     $params->tran_dtime = date('YmdHis', time()); // 요청일시

     $params = json_encode($params, true);

     return parent::request('POST', '/v2.0/inquiry/real_name', $params, $headers);
  }

}
