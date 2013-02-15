<?php 
/* 
* LASTSEEN PRODUCTS ANYWHERE for OXID 4.5.0 and higher
* Module to include last_seen_products.tpl anywhere 
* Filename: modules/mylastseen.php 
* Add one line to System/Modules for each view where 
* you want to show last seen articles, excluding "details" view, e.g.: 
    alist => mylastseen 
    start => mylastseen
*/ 

class mylastseen extends mylastseen_parent{ 
    public function getLastProducts( $iCnt = 4 )
    {
        $oHistoryArtList = new lastseenoxarticlelist;
        $aHistoryArticles = $oHistoryArtList->getHistoryArticles();
        if (is_array($aHistoryArticles)){
            $aHistoryArticles = array_unique( $aHistoryArticles );
            if ( count( $aHistoryArticles ) > ( $iCnt ) ) {
                array_shift( $aHistoryArticles );
            }
            $aHistoryArticles = array_values( $aHistoryArticles );
            $oHistoryArtList->loadIds( $aHistoryArticles );
            $oHistoryArtList->sortByIds( $aHistoryArticles );
        }
        return $oHistoryArtList;
    }
}
class lastseenoxarticlelist extends oxarticlelist{
    public function sortByIds($aArtIds){
        parent::sortByIds($aArtIds);
    }
}