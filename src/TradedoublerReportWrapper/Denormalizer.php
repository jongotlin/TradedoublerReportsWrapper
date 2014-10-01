<?php

namespace TradedoublerReportWrapper;

class Denormalizer
{
    /**
     * @param \SimpleXMLElement $xml
     *
     * @return Transaction[]
     */
    public function denormalizeTransactions(\SimpleXMLElement $xml)
    {
        $transactions = [];
        foreach ($xml->matrix->rows->row as $row) {
            $transactions[] = $this->denormalizeTransaction($row);
        }

        return $transactions;
    }

    /**
     * @param \SimpleXMLElement $row
     *
     * @return Transaction
     */
    public function denormalizeTransaction(\SimpleXMLElement $row)
    {
        $transaction = new Transaction();
        $transaction->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s T', $row->timeOfEvent));
        $transaction->setClickedAt(\DateTime::createFromFormat('Y-m-d H:i:s T', $row->timeOfVisit));
        $transaction->setEpi($row->epi1);
        $transaction->setOrderId($row->orderNR);
        $program = new Program();
        $program->setId($row->programId);
        $program->setName($row->programName);
        $transaction->setProgram($program);
        $channel = new Channel();
        $channel->setId($row->siteId);
        $channel->setName($row->siteName);
        $transaction->setChannel($channel);
        $transaction->setOrderValue(intval($row->orderValue * 100));
        $transaction->setCommission(intval($row->affiliateCommission * 100));

        return $transaction;
    }
}
