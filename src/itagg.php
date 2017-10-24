<?PHP

namespace richbarrett\itagg;

class itagg {
  
  var $endpoint = '';
  var $user = '';
  var $password = '';
  var $parameters = array();
  var $requestTimeout = 5;
  var $debug = false;
  
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
    if($this->debug) {
      print_r($request);
      exit;
    }
    
    $response = $request->send();
    return $this->parseResponse($response);
    
  }
  
  function parseResponse($response) {
    return $response;
  }
  
}


?>