<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DomainRedirect
{
    public function handle()
    {

        // $host = $_SERVER['HTTP_HOST'];
        // $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        // $domain_1 = 'homebethe.com';
        // $domain_2 = 'shopbethe.com';

        // /* ============================
        //    DOMAIN 2 RULES
        // ============================ */
        // if ($host === $domain_2 || $host ===  'www.shopbethe.com') {

        //     // Redirect homepage also
        //     if ($uri === '') {
        //         redirect("https://$domain_2/seller");
        //         exit;
        //     }

        //     // Allow seller URLs
        //     if (strpos($uri, 'seller') === 0 && strpos($uri, 'admin') === 0) {
        //         return;
        //     }

        //     $blockedForDomain2 = [
        //         'sellers',
        //         'home/contact-us',
        //         'home/about-us',
        //         'home/faq',
        //         'home/blogs',
        //         'products',
        //         'products/category',
        //         'products/details',
        //         'cart',
        //     ];

        //     foreach ($blockedForDomain2 as $route) {
        //         if ($uri === $route || strpos($uri, $route . '/') === 0) {

        //             redirect("https://$domain_1/$route");
        //             exit;
        //         }
        //     }
        // }

        // /* ============================
        //    DOMAIN 1 RULES
        // ============================ */
        // if ($host === $domain_1 || $host ===  'www.homebethe.com') {

        //     if ($uri === 'seller/auth/sign_up') {
        //         redirect("https://$domain_2/seller/auth/sign_up");
        //         exit;
        //     }

        //     $blockedForDomain1 = [
        //         'seller',
        //         'admin'
        //     ];

        //     foreach ($blockedForDomain1 as $route) {
        //         if ($uri === $route || strpos($uri, $route . '/') === 0) {
        //             redirect("https://$domain_2/$route");
        //             exit;
        //         }
        //     }
        // }
    }
}
