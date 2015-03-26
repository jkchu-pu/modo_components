<?php

/*
 * Copyright © 2010 - 2014 Modo Labs Inc. All rights reserved.
 *
 * The license governing the contents of this file is located in the LICENSE
 * file located at the root directory of this distribution. If the LICENSE file
 * is missing, please contact sales@modolabs.com.
 *
 */

class StackExchangeBadgesDataRetriever extends KGOURLDataRetriever
{
    // The page size to pass to the Stack Exchange API
    const PAGE_SIZE = 20;

    protected static $defaultParserClass = 'StackExchangeBadgesDataParser';
    protected $stackExchangeSite;
    protected $stackExchangeAPIKey;

    protected function init($args) {

        // Save the 'site' from the feed options
        if(isset($args['site'])) {
            $this->stackExchangeSite = $args['site'];
        }

        // Save the 'apiKey' from the feed options
        if(isset($args['apiKey'])) {
            $this->stackExchangeAPIKey = $args['apiKey'];
        }

        return parent::init($args);
    }

    protected function initRequestIfNeeded(){
        parent::initRequestIfNeeded();

        // Add a header to specify to the API what compression format we want to use
        $this->addHeader('Accept-Encoding', 'deflate');

        // Add these parameters to every request
        $this->addParameter('pagesize', self::PAGE_SIZE);
        $this->addParameter('order', 'asc');
        $this->addParameter('sort', 'rank');
        $this->addParameter('site', $this->stackExchangeSite);
        $this->addParameter('key', $this->stackExchangeAPIKey);
    }

    public function getBadges($useParseMap=true) {

        // If we are using a parsemap
        if($useParseMap) {
            // Set an option so our Data Parser knows
            $this->setOption('useParseMap', true);
            // Set our parsemap to the badge parsemap
            $this->setParsemap(self::badgeParsemap());
        }

        // If there is a start parameter in the request, then this is a request for a specific page
        if($this->getCurrentArg('start')) {
            // Calculate the page number and add it as a parameter to the API
            $this->addParameter('page', ($this->getCurrentArg('start') / self::PAGE_SIZE) + 1);
        }

        // Get the parsed list of badges
        $data = $this->getData($response);

        // Set a context variable 'limit' on the response object
        // This lets out Data Model know there are additional results
        $response->setContext('limit', count($data));

        // Return the list of badges
        return $data;
    }

    public static function badgeParsemap() {
        return array(
            'key'                       => 'items',
            'includeUnmappedAttributes' => false,
            'class'                     => 'StackExchangeBadgeDataObject',
            'attributes' => array(
                'kgo:id' => 'badge_id',
                'kgo:title' => 'name',
                StackExchangeBadgeDataObject::BADGE_AWARD_COUNT_ATTRIBUTE => 'award_count',
                StackExchangeBadgeDataObject::BADGE_RANK_ATTRIBUTE => 'rank',
                StackExchangeBadgeDataObject::BADGE_LINK_ATTRIBUTE => 'link',
                StackExchangeBadgeDataObject::BADGE_TYPE_ATTRIBUTE => 'badge_type',
            )
        );
    }

    /* Below is an example API response containing two badges
     * Included here as an example of what this ParseMap is designed to parse
        {
            "items": [{
                "badge_type": "named",
                "award_count": 0,
                "rank": "gold",
                "badge_id": 3108,
                "link": "http://stackoverflow.com/badges/3108/constable",
                "name": "Constable"
            }, {
                "badge_type": "named",
                "award_count": 1239,
                "rank": "gold",
                "badge_id": 223,
                "link": "http://stackoverflow.com/badges/223/copy-editor",
                "name": "Copy Editor"
            }],
            "has_more": true,
            "quota_max": 10000,
            "quota_remaining": 9955
        }
    */
}