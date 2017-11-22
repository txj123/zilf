<?php
namespace Zilf\Facades;

use Zilf\System\Zilf;


/**
 *
 * @method static \Zilf\Validation\Validator make(array $data, array $rules, array $messages = [], array $customAttributes = [])
 * @method static null extend($rule, $extension, $message = null)
 * @method static null extendImplicit($rule, $extension, $message = null)
 * @method static null replacer($rule, $replacer)
 * @method static null resolver(Closure $resolver)
 * @method static \Zilf\Validation\TranslatorInterface getTranslator()
 * @method static \Zilf\Validation\PresenceVerifierInterface getPresenceVerifier()
 * @method static null setPresenceVerifier(PresenceVerifierInterface $presenceVerifier)
 *
 *
 * Class Validator
 * @package Zilf\Facades
 */

class Validator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'validator';
    }
}