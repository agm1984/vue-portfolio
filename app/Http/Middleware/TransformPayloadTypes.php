<?php

namespace App\Http\Middleware;

use Closure;

class TransformPayloadTypes
{
    /**
     * Converts a form input request field's type to its proper type after values are received stringified.
     *
     * Function flow:
     *      1. Check if it is an array, if yes, return array
     *      2. Remove unused spaces
     *      3. Check if it is '0', if yes, return 0
     *      4. Check if it is empty, if yes, return blank string
     *      5. Check if it is 'null', if yes, return null
     *      6. Check if it is 'undefined', if yes, return null
     *      7. Check if it is '1', if yes, return 1
     *      8. Check if it is numeric
     *      9. If numeric, this may be a integer or double, must compare this values
     *      10. If string, try parse to bool
     *      11. If not, this is string
     *
     * (c) José Moreira - Microdual (www.microdual.com)
     * With the help of Svisstack (http://stackoverflow.com/users/283564/svisstack)
     *
     * Found at: https://stackoverflow.com/questions/2690654/how-to-get-the-real-type-of-a-value-inside-string
     *
     * @param  string $string
     * @return mixed
     */
    private function typeCorrected($string) {
        if (gettype($string) === 'array') {
            return (array)$string;
        }

        $string = trim($string);

        if ($string === '0') { // we must check this before empty because zero is empty
            return 0;
        }

        if (empty($string)) {
            return '';
        }

        if ($string === 'null') {
            return null;
        }

        if ($string === 'undefined') {
            return null;
        }

        if ($string === '1') {
            return 1;
        }

        if (!preg_match('/[^0-9.]+/', $string)) {
            if(preg_match('/[.]+/', $string)) {
                return (double)$string;
            }else{
                return (int)$string;
            }
        }

        if ($string == 'true') {
            return true;
        }

        if ($string == 'false') {
            return false;
        }

        return (string)$string;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        foreach($input as $key => $value) {
            $input[$key] = $this->typeCorrected($value);
        }

        $request->replace($input);

        return $next($request);
    }
}
