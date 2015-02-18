<?php
/**
 * Filter helper class file
 *
 * @project ApPHP Framework
 * @author ApPHP <info@apphp.com>
 * @link http://www.apphpframework.com/
 * @copyright Copyright (c) 2012 ApPHP Framework
 * @license http://www.apphpframework.com/license/
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * 
 * 
 * STATIC:
 * ---------------------------------------------------------------
 * sanitize
 * 
 */	  

class Filter
{
    /**
     * Sanitizes specified data
     * @param string $type
     * @param mixed $data
     */
    public static function sanitize($type, $data)
    {
        if($type == 'string'){
            // Strip tags, optionally strip or encode special characters
            return filter_var($data, FILTER_SANITIZE_STRING);        
        }else if($type == 'email'){
            // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
            return filter_var($data, FILTER_SANITIZE_EMAIL);       
        }else if($type == 'url'){
            // Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
            return filter_var($data, FILTER_SANITIZE_URL);
        }else if($type == 'alpha'){
            // Leave only letters 
            return preg_replace('/[^A-Za-z]/', '', $data);       
        }else if($type == 'alphanumeric'){
            // Leave only letters and digits
            return preg_replace('/[^A-Za-z0-9]/', '', $data);       
        }else if($type == 'number_int'){
            // Remove all characters except digits, plus and minus sign
            return filter_var($data, FILTER_SANITIZE_NUMBER_INT);       
        }else if($type == 'number_float'){
            // Remove all characters except digits, +- and optionally .,eE
            return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);       
        }        
        
        return $data;        
    }
        
}