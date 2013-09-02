<?php
namespace Framework;
class Filter {
	public static function get(array $data, array $type) {
		if(is_array($data)) {
			foreach($data as $key=>$value) {
				if(array_key_exists($key, $type)) {
					$return[$key] = self::sanatizeItem($value, $type[$key]);
				}else $return[$key] = $value;
			}
		return $return;
		}else return $data;
		
	}
	public static function sanatizeItem($var, $type)
    {
        $flags = NULL;
        switch($type)
        {
            case 'url':
                $filter = FILTER_SANITIZE_URL;
            break;
            case 'int':
                $filter = FILTER_SANITIZE_NUMBER_INT;
            break;
            case 'float':
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
            break;
            case 'email':
                $var = substr($var, 0, 254);
                $filter = FILTER_SANITIZE_EMAIL;
            break;
            case 'string':
            default:
                $filter = FILTER_SANITIZE_STRING;
                $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
            break;

        }
        $output = filter_var($var, $filter, $flags);        
        return($output);
    }

}
