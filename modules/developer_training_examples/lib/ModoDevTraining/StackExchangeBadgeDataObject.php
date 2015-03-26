<?php

/*
 * Copyright © 2010 - 2014 Modo Labs Inc. All rights reserved.
 *
 * The license governing the constents of this file is located in the LICENSE
 * file located at the root directory of this distribution. If the LICENSE file
 * is missing, please constact sales@modolabs.com.
 *
 */

class StackExchangeBadgeDataObject extends KGODataObject implements KGOUIArrayItemInterface {

    const BADGE_TYPE_ATTRIBUTE = 'stackexchange:badgetype';
    const BADGE_RANK_ATTRIBUTE = 'stackexchange:badgerank';
    const BADGE_AWARD_COUNT_ATTRIBUTE = 'stackexchange:badgeawardcount';
    const BADGE_LINK_ATTRIBUTE = 'stackexchange:badgelink';
    

    /**
     * Init method.
     *
     * @param array $args The initialization arguments.
     *
     */
    protected function init($args) {
        parent::init($args);
    }

    public function setType($badgeType) {
        $this->setAttribute(self::BADGE_TYPE_ATTRIBUTE, $badgeType);
    }

    public function setRank($badgeRank) {
        $this->setAttribute(self::BADGE_RANK_ATTRIBUTE, $badgeRank);
    }

    public function setAwardCount($badgeAwardCount) {
        $this->setAttribute(self::BADGE_AWARD_COUNT_ATTRIBUTE, $badgeAwardCount);
    }

    public function setLink($badgeLink) {
        $this->setAttribute(self::BADGE_LINK_ATTRIBUTE, $badgeLink);
    }
}