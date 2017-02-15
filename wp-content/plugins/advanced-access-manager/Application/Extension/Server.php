<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * AAM server
 * 
 * Connection to the external AAM server.
 * 
 * @package AAM
 * @author Vasyl Martyniuk <vasyl@vasyltech.com>
 */
final class AAM_Extension_Server {

    /**
     * Server endpoint
     */
    const SERVER_URL = 'https://aamplugin.com/api/v1';

    /**
     * Fetch the extension list
     * 
     * Fetch the extension list with versions from the server
     * 
     * @return array
     * 
     * @access public
     */
    public static function check() {
        $domain = parse_url(site_url(), PHP_URL_HOST);
        
        //prepare check params
        $params = array(
            'domain'     => $domain, 
            'version'    => AAM_Core_API::version(),
            'extensions' => array()
        );
        
        //add list of all premium installed extensions
        foreach(AAM_Extension_Repository::getInstance()->getList() as $item) {
            if ($item['status'] !== AAM_Extension_Repository::STATUS_DOWNLOAD) {
                $params['extensions'][$item['title']] = $item['license'];
            }
        }
        
        $response = self::send(self::SERVER_URL . '/check', $params);
        $result   = array();
        
        if (!is_wp_error($response)) {
            //WP Error Fix bug report
            if ($response->error !== true && !empty($response->extensions)) {
                $result = $response->extensions;
            }
        }

        return $result;
    }

    /**
     * Download the extension
     * 
     * @param string $license
     * 
     * @return base64|WP_Error
     * 
     * @access public
     */
    public static function download($license) {
        $domain = parse_url(site_url(), PHP_URL_HOST);

        $response = self::send(
                self::SERVER_URL . '/download', 
                array('license' => $license, 'domain' => $domain)
        );
        
        if (!is_wp_error($response)) {
            if ($response->error === true) {
                $result = new WP_Error($response->code, $response->message);
            } else {
                $result = $response;
            }
        } else {
            $result = $response;
        }

        return $result;
    }

    /**
     * Send request
     * 
     * @param string $request
     * 
     * @return stdClass|WP_Error
     * 
     * @access protected
     */
    protected static function send($request, $params) {
        //add AAM UID
        $params['uid'] = AAM_Core_API::getOption('aam-uid', null, 'site');
        
        $response = AAM_Core_API::cURL($request, false, $params);
        if (!is_wp_error($response)) {
            $response = json_decode($response['body']);
            if (empty($params['uid']) && isset($response->uid)) {
                AAM_Core_API::updateOption('aam-uid', $response->uid, 'site');
            }
        }

        return $response;
    }

}