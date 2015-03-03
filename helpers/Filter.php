<?php

/**
 * Filter helper class file
 */
class Filter {

    /**
     * Sanitizes specified data
     * @param string $type method sanitize ex: string|email|url|alpha|alphanumeric|int|float
     * @param mixed $data
     */
    public static function sanitize($type, $data)
    {
        switch ($type)
        {
            case 'int':
                // Strip tags, optionally strip or encode special characters
                return filter_var($data, FILTER_VALIDATE_INT);
                break;
            case 'string':
                // Strip tags, optionally strip or encode special characters
                return filter_var($data, FILTER_SANITIZE_STRING);
                break;
            case 'email':
                // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
                return filter_var($data, FILTER_SANITIZE_EMAIL);
                break;
            case 'url':
                // Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
                return filter_var($data, FILTER_SANITIZE_URL);
                break;
            case 'alpha':
                // Leave only letters 
                return preg_replace('/[^A-Za-z]/', '', $data);
                break;
            case 'alphanumeric':
                // Leave only letters and digits
                return preg_replace('/[^A-Za-z0-9]/', '', $data);
                break;
            case 'int_number':
                // Remove all characters except digits, plus and minus sign
                return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 'float':
                // Remove all characters except digits, +- and optionally .,eE
                return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
                break;

            default:
                if (!is_array($data))
                {
                    return htmlentities($data, ENT_QUOTES, 'UTF-8');
                }
                break;
        }

        return $data;
    }

}
