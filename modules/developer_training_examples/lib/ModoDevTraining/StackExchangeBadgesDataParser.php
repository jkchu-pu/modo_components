<?php

/*
 * Copyright © 2010 - 2014 Modo Labs Inc. All rights reserved.
 *
 * The license governing the contents of this file is located in the LICENSE
 * file located at the root directory of this distribution. If the LICENSE file
 * is missing, please contact sales@modolabs.com.
 *
 */

class StackExchangeBadgesDataParser extends KGOJSONDataParser
{
    public function parseData($data) {

        // Perform preprocessing on the raw API response
        
        // Deflate the compressed API response
        $data = gzinflate($data);
        return parent::parseData($data);
    }

    public function parseResponse(DataResponse $response) {

        // If we are using a parsemap
        if($this->getOption('useParseMap')) {
            // Return the result of the parsemap
            return parent::parseResponse($response);
        }

        // If we are not using a parsemap, we need to parse the response manually
        $badges = array();

        // Run the response data through out parseData method to deflate it
        $data = $this->parseData($response->getResponse());
        
        // For every data item returned by the API
        foreach($data['items'] as $badgeData) {

            // Create an instance of StackExchangeBadgeDataObject using KGODataObject's factory method
            $badge = KGODataObject::factory('StackExchangeBadgeDataObject');

            // Manually set attributes on the object from the API
            // Using setter methods is optional
            // $badge->setAttribute('foo', 'bar') is also an option
            $badge->setId($badgeData['badge_id']);
            $badge->setTitle($badgeData['name']);
            $badge->setType($badgeData['badge_type']);
            $badge->setRank($badgeData['rank']);
            $badge->setAwardCount($badgeData['award_count']);
            $badge->setLink($badgeData['link']);

            // Add the new badge to our array
            $badges[] = $badge;
        }
        
        // Return a parsed list of badges
        return $badges;
    }
}