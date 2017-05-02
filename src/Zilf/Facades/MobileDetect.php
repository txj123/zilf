<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-5-2
 * Time: 上午10:09
 */

namespace Zilf\Facades;

/**
 * @method static string getScriptVersion()
 * @method static null setHttpHeaders($httpHeaders = null)
 * @method static array getHttpHeaders()
 * @method static string|null getHttpHeader($header)
 * @method static array getMobileHeaders()
 * @method static array getUaHttpHeaders()
 * @method static null setCfHeaders($cfHeaders = null)
 * @method static array getCfHeaders()
 * @method static null setUserAgent($userAgent = null)
 * @method static string getUserAgent()
 * @method static null setDetectionType($type = null)
 * @method static string getMatchingRegex()
 * @method static array getMatchesArray()
 * @method static array getPhoneDevices()
 * @method static array getTabletDevices()
 * @method static array getUserAgents()
 * @method static array getBrowsers()
 * @method static array getUtilities()
 * @method static array getMobileDetectionRules()
 * @method static array getMobileDetectionRulesExtended()
 * @method static array getRules()
 * @method static array getOperatingSystems()
 * @method static bool checkHttpHeadersForMobile()
 * @method static bool isMobile($userAgent = null, $httpHeaders = null)
 * @method static bool isTablet($userAgent = null, $httpHeaders = null)
 * @method static bool is($key, $userAgent = null, $httpHeaders = null)
 * @method static bool match($regex, $userAgent = null)
 * @method static array getProperties()
 * @method static float prepareVersionNo($ver)
 * @method static string|float version($propertyName, $type = self::VERSION_TYPE_STRING)
 * @method static string mobileGrade()
 *
 * Class MobileDetect
 * @package Zilf\Facades
 */

class MobileDetect extends Facade
{
    protected static function getFacadeAccessor(){
        return new \Zilf\Detection\MobileDetect;
    }
}