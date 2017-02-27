<?php

/*
 * LASTSEEN PRODUCTS ANYWHERE for OXID 4.10.0 and higher
 * Module to include last_seen_products.tpl anywhere 
 * Filename: modules/mylastseen.php 
 * Add one line to System/Modules for each view where 
 * you want to show last seen articles, excluding "details" view, e.g.: 
  alist => mylastseen
  start => mylastseen
 */

class mylastseen extends mylastseen_parent {

    public function getLastProducts($iCnt = 0) {
        if (!$iCnt) {
            $iCnt = $this->getConfig()->getConfigParam('iMlsNumberOfHistoryArticles');
        }
        if ($oProduct = $this->getProduct()) {
            $sArtId = $oProduct->oxarticles__oxparentid->value ? $oProduct->oxarticles__oxparentid->value : $oProduct->getId();

            $oHistoryArtList = oxNew('oxarticlelist');
            $oHistoryArtList->loadHistoryArticles($sArtId, $iCnt);
            $this->_aLastProducts = $oHistoryArtList;
        }
        if ($this->_aLastProducts === null) {
            $oHistoryArtList = new lastseenoxarticlelist;
            $aHistoryArticles = $oHistoryArtList->getHistoryArticles();
            if (is_array($aHistoryArticles)) {
                $aHistoryArticles = array_unique($aHistoryArticles);
                if (count($aHistoryArticles) > ( $iCnt )) {
                    array_shift($aHistoryArticles);
                }
                $aHistoryArticles = array_values($aHistoryArticles);
                $oHistoryArtList->loadIds($aHistoryArticles);
                $oHistoryArtList->sortByIds($aHistoryArticles);
                $this->_aLastProducts = $oHistoryArtList;
            }
        }
        return $this->_aLastProducts;
    }

}

class lastseenoxarticlelist extends oxarticlelist {

    public function sortByIds($aArtIds) {
        parent::sortByIds($aArtIds);
    }

}
