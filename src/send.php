<?PHP

namespace richbarrett\itagg;

include_once(__DIR__.'/itagg.php');

class send extends \richbarrett\itagg\itagg {
  
  var $endpoint = 'https://secure.itagg.com/smsg/sms.mes';
  var $route = 'd';
  
  function addTo($number) {
    $this->parameters['to'][]=$number;
    $this->parameters['to'] = array_unique($this->parameters['to']);
  }
  
  function setFrom($from) {
    if(strlen($from) > 11) throw new \Exception('From must be max of 11 characters');
    $this->parameters['from'] = $from;
  }
  
  function setReadReceiptUrl($url) {
    $this->parameters['dreceipt_url'] = $url;
  }
  
  function scheduleSend($datetime) {
    $this->parameters['send'] = date('YmdHis', strtotime($datetime));
  }
  
  function setBody($text) {
    if(strlen($text) > 1377) throw new \Exception('Message can be a maximum of 1377 characters');
    $this->parameters['txt'] = $text;
  }
  
  function setRoute($route) {
    $this->route = $route;
  }
  
  function getRequestParameters() {
    
    $params = parent::getRequestParameters();
    
    $params['route'] = $this->route;
    $params['type'] = 'text';
    $params['to'] = implode(',', $this->parameters['to']);
    
    return $params;
    
  }
  
  function parseResponse($response) {
    
    if($response->code != '200') {
      throw new \Exception('Response code: '.$response->code);
    }
    
    // Handle response
    $find = ['error','fail'];
    
    foreach($find as $word) {
      if(substr($response->body, 0, strlen($word)) == $word) {
        
        // Failed
        if($word == 'fail') {
          throw new \Exception($response->body);
        }
        
        if($word == 'error') {
          
          $body = explode("\n", $response->body);
          unset($body[0]);
          $body = explode("|", array_values($body)[0]);
          
          if($body[0] != 0) {
            throw new \Exception($body[1]);
          }
          
        }
        
      }
    }
    
    return true;
    
  }
  
}

?>