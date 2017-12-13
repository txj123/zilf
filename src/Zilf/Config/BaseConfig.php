<?php namespace Zilf\Config;

/**
 * Class BaseConfig
 *
 * Not intended to be used on its own, this class will attempt to
 * automatically populate the child class' properties with values
 * from the environment.
 *
 * These can be set within the .env file.
 */
class BaseConfig
{
    /**
     * Will attempt to get environment variables with names
     * that match the properties of the child class.
     */
    public function __construct()
    {
        $properties  = array_keys(get_object_vars($this));
        $prefix      = get_class($this);
        $shortPrefix = strtolower(substr($prefix, strrpos($prefix, '\\') + 1));

        foreach ($properties as $property)
        {
            if (is_array($this->$property)) {
                foreach ($this->$property as $key => $val)
                {
                    if ($value = $this->getEnvValue("{$property}.{$key}", $prefix, $shortPrefix)) {
                        if (is_null($value)) { continue;
                        }

                        if ($value === 'false') {    $value = false;
                        } elseif ($value === 'true') { $value = true;
                        }

                        $this->$property[$key] = $value;
                    }
                }
            }
            else
            {
                if (($value = $this->getEnvValue($property, $prefix, $shortPrefix)) !== false ) {
                    if (is_null($value)) { continue;
                    }

                    if ($value === 'false') {    $value = false;
                    } elseif ($value === 'true') { $value = true;
                    }

                    $this->$property = $value;
                }
            }
        }
    }

    //--------------------------------------------------------------------

    /**
     * Retrieve an environment-specific configuration setting
     *
     * @param  string $property
     * @param  string $prefix
     * @param  string $shortPrefix
     * @return type
     */
    protected function getEnvValue(string $property, string $prefix, string $shortPrefix)
    {
        if (($value = getenv("{$shortPrefix}.{$property}")) !== false) {
            return $value;
        }
        elseif (($value = getenv("{$prefix}.{$property}")) !== false) {
            return $value;
        }
        elseif (($value = getenv($property)) !== false && $property != 'path') {
            return $value;
        }

        return null;
    }

    //--------------------------------------------------------------------

}
