<?php
namespace PublicFun\Cdn77\Api;
use GuzzleHttp;

/**
 * @property-read string $userName
 * @property-read string $password
 */
class Api 
{
  
  const URL = 'https://api.cdn77.com/v2.0';
  
  /* @var string */
  private $userName;
  
  /** @var var string */
  private $password;
  
  /**
   * @param string $userName
   * @param string $password
   */
  public function __construct($userName, $password) 
  {
    $this->userName = $userName;
    $this->password = $password;
  }
  
  /**
   * @return string
   */
  public function getUserName()
  {
    return $this->userName;
  }
  
  /**
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }
  
  
  /* Account */
  
  /**
   * @return array
   */
  public function getAccountDetails()
  {
    $client = $this->getClient();
    return $client->get($this->getUrl('account/details'), $this->getGetParameters());
  }
  
  
  /* Data management */
  
  /**
   * @param integer $cdnId
   * @param array $urls
   * @param bool $purge
   */
  public function makeDataPrefetch($cdnId, $urls, $purge = FALSE)
  {
    $client = $this->getClient();
    return $client->post($this->getUrl('data/prefetch'), $this->getPostParameters(array('cdn_id' => $cdnId, 'url' => $urls, 'purge_first' => $purge === TRUE ? 1 : 0)));
  }
  
  /**
   * @param integer $cdnId
   * @param array $urls
   */
  public function makeDataPurge($cdnId, $urls)
  {
    $client = $this->getClient();
    return $client->post($this->getUrl('data/purge'), $this->getPostParameters(array('cdn_id' => $cdnId, 'url' => $urls)));
  }
  
  /**
   * @param integer $cdnId
   */
  public function makeDataPurgeAll($cdnId)
  {
    $client = $this->getClient();
    return $client->post($this->getUrl('data/purge-all'), $this->getPostParameters(array('cdn_id' => $cdnId)));
  }
  
  
  
  
  /* Calls */
  
  /**
   * @reutrn GuzzleHttp\Client
   */
  protected function getClient()
  {
    return new GuzzleHttp\Client();
  }
  
  /**
   * @param string $url
   * @return string
   */
  protected function getUrl($url)
  {
    return self::URL . '/' . $url;
  }
  
  /**
   * @param array $params
   * @return array
   */
  protected function getGetParameters($params = array())
  {
    return array('query' => $this->getLoginParameters() + $params);
  }
  
  /**
   * @param array $params
   * @return array
   */
  protected function getPostParameters($params = array())
  {
    return array('form_params' => $this->getLoginParameters() + $params);
  }
  
  /**
   * @return array
   */
  protected function getLoginParameters()
  {
    return array('login' => $this->userName, 'passwd' => $this->password);
  }
  
}