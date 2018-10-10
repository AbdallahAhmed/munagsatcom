<?php

/*
 * Get option value by name
 * @param $name
 * @param null $default
 * @return mixed
 */
function option($name, $default = NULL)
{
    return \Dot\Options\Facades\Option::get($name, $default);
}
