<?php

namespace Zilf\Cache;

abstract class TaggableStore
{
    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \Zilf\Cache\TaggedCache
     */
    public function tags($names)
    {
        return new TaggedCache($this, new TagSet($this, is_array($names) ? $names : func_get_args()));
    }
}
