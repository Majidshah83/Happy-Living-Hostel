<?php

namespace App\Http\Middleware;

use Closure;

class XssClean
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->checkForHtmlTags($request);
        } catch (Exception $e) {
            abort(404);
        }
        return $next($request);
    }

    /**
     * @method checkForHtmlTags
     * @description This function checks for html tags and removes them
     * @param $request
     * @return mixed
     */
    private function checkForHtmlTags($request) {

        if (!in_array(strtolower($request->method()), ['put', 'post'])) {
            return $request;
        }
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            $replace = array('<script>','</script>');
            $input = str_replace($replace,'',$input);
//            $input = strip_tags($input, '<a><b></b><strong><em><hr><br><p><u><ul><ol><li><dl><dt><dd><table><thead><tr><th><tbody><td><tfoot>');
        });
        $request->merge($input);
        return $request;
    }
}
