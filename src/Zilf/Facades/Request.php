<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-4-28
 * Time: 上午9:43
 */

namespace Zilf\Facades;

/**
 *
 * @method static \Zilf\HttpFoundation\Request getInstance()
 * @method static \Zilf\HttpFoundation\ParameterBag query()
 * @method static \Zilf\HttpFoundation\ParameterBag request()
 * @method static \Zilf\HttpFoundation\ParameterBag attributes()
 * @method static \Zilf\HttpFoundation\ParameterBag cookies()
 * @method static \Zilf\HttpFoundation\FileBag files()
 * @method static \Zilf\HttpFoundation\ServerBag server()
 * @method static \Zilf\HttpFoundation\HeaderBag headers()
 * @method static string method()
 * @method static string url()
 * @method static string fullUrl()
 *
 * @method static \Zilf\HttpFoundation\Request createFromGlobals()
 * @method static \Zilf\HttpFoundation\Request create($uri, $method = 'GET', $parameters = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
 * @method static callable|null setFactory($callable)
 * @method static \Zilf\HttpFoundation\Request duplicate(array $query = null, array $request = null, array $attributes = null, array $cookies = null, array $files = null, array $server = null)
 * @method static null setTrustedProxies(array $proxies)
 * @method static array getTrustedProxies()
 * @method static null setTrustedHosts(array $hostPatterns)
 * @method static array getTrustedHosts()
 * @method static null setTrustedHeaderName($key, $value)
 * @method static string getTrustedHeaderName($key)
 * @method static string normalizeQueryString($qs)
 * @method static null enableHttpMethodParameterOverride()
 * @method static bool getHttpMethodParameterOverride()
 * @method static mixed get($key, $default = null)
 * @method static SessionInterface|null getSession()
 * @method static bool hasPreviousSession()
 * @method static bool hasSession()
 * @method static bool setSession(SessionInterface $session)
 * @method static string getClientIps()
 * @method static string getClientIp()
 * @method static string getScriptName()
 * @method static string getPathInfo()
 * @method static string getBasePath()
 * @method static string getBaseUrl()
 * @method static string getScheme()
 * @method static string getPort()
 * @method static string|null getUser()
 * @method static string|null getPassword()
 * @method static string getUserInfo()
 * @method static string getHttpHost()
 * @method static string getRequestUri()
 * @method static string getSchemeAndHttpHost()
 * @method static string getUri()
 * @method static string getUriForPath($path)
 * @method static string getRelativeUriForPath($path)
 * @method static string getQueryString()
 * @method static bool isSecure()
 * @method static string getHost()
 * @method static null setMethod($method)
 * @method static string getMethod()
 * @method static string getRealMethod()
 * @method static string getMimeType($format)
 * @method static string getMimeTypes($format)
 * @method static string|null getFormat($mimeType)
 * @method static string setFormat($format, $mimeTypes)
 * @method static string getRequestFormat($default = 'html')
 * @method static string setRequestFormat($format)
 * @method static string getContentType()
 * @method static null setDefaultLocale($locale)
 * @method static string getDefaultLocale()
 * @method static null setLocale($locale)
 * @method static string getLocale()
 * @method static bool isMethod($method)
 * @method static string isMethodSafe()
 * @method static string|resource getContent($asResource = false)
 * @method static array getETags()
 * @method static bool isNoCache()
 * @method static string getPreferredLanguage(array $locales = null)
 * @method static array getLanguages()
 * @method static string getCharsets()
 * @method static string getEncodings()
 * @method static array getAcceptableContentTypes()
 * @method static bool isXmlHttpRequest()
 * @method static string isFromTrustedProxy()
 *
 * Class Request
 * @package Zilf\Facades
 */

class Request extends Facade
{
    protected static function getFacadeAccessor(){
        return 'request';
    }
}