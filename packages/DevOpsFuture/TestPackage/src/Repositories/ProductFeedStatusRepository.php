<?php

namespace DevOpsFuture\TestPackage\Repositories;

use DevOpsFuture\Core\Eloquent\Repository;
use SellingPartnerApi as SPA;

class ProductFeedStatusRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'DevOpsFuture\TestPackage\Contracts\ProductFeedStatus';
    }

    public function addProductFeedRecord($feedId, $documentId, $productType, $sku, $extItemType, $extItemId, $feedType ) {
        $newRecord = [
            'feed_id' => $feedId,
            'document_id' => $documentId,
            'product_type' => $productType,
            'product_identifier' => $sku,
            'external_indicator' => $extItemType,
            'external_product_identifier' => $extItemId,
            'feed_type' => $feedType,
            'feed_status' => 'IN_QUEUE',
            'is_completed' => false,
        ];
        return $this->create($newRecord);
    }

    public function getCompletedFeedList() {
        return $this->findByField('is_completed', true);
    }

    public function getUncompletedFeedList() {
        return $this->findByField('is_completed', false);
    }

    /**
     * Find data by field and value
     *
     * @param  SPA\Model\Feeds\Feed  $feedInfo
     * @return void
     */
    public function updateRecordByFeed($feedInfo) {
        $update_data = [
            'feed_status'   => $feedInfo->getProcessingStatus(),
        ];
        if($feedInfo->getProcessingStatus() === 'DONE') {
            $update_data['result_document_id'] = $feedInfo->getResultFeedDocumentId();
            $update_data['is_completed'] = true;
        }
        $this->getModel()->where(['feed_id'=>$feedInfo->getFeedId()])->update($update_data);
    }
}
