<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SiteInitializer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = URL::current();
        $urlArr = explode("/", URL::current());
        $currentUrlEnd = end($urlArr);
        $all_settings = SiteSetting::all();
        $site_settings = array();
        foreach ($all_settings as $setting) {
            $site_settings[$setting['key']] = $setting['value'];
        }
        if($currentUrl.str_contains($currentUrl, "postDetails")) {
            $pageMeta = DB::table('page_metas')->where('url', "/postDetails/".$currentUrlEnd)->first();
            if($pageMeta) {
                $site_settings['page_title'] = $pageMeta->title;
                $site_settings['page_description'] = $pageMeta->description;
            } else {
                $site_settings['page_title'] = $site_settings['site_name'];
                $site_settings['page_description'] = $site_settings['site_description'];
            }
        } else {
            $site_settings['page_title'] = $site_settings['site_name'];
            $site_settings['page_description'] = $site_settings['site_description'];
        }
        $request->attributes->set('site_settings', $site_settings);
        return $next($request);
    }
}
