<?PHP

namespace richbarrett\itagg;

include_once(__DIR__.'/../vendor/autoload.php');

class itagg {
  
  var $endpoint = '';
  var $user = '';
  var $password = '';
  var $parameters = array();
  var $requestTimeout = 5;
  
  function __construct($user, $password) {
    $this->user = $user;
    $this->password = $password;
  }
  
  function getRequestParameters() {
    return $this->parameters;
  }
  
  function sendRequest() {
    
    $parameters = $this->getRequestParameters();
    
    // Add authentication params
    $parameters['usr'] = $this->user;
    $parameters['pwd'] = $this->password;
    
    // Do the request
    $request = \Httpful\Request::POST($this->endpoint);
    $request->body($parameters);
    $request->timeoutIn($this->requestTimeout);
    $request->sendsType(\Httpful\Mime::FORM);

    // Parse the response
    $response = $request->send();
    return $this->parseResponse($response);
    
  }
  
  function parseResponse($response) {
    return $response;
  }
  
}


?>