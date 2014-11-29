<?php

namespace TradedoublerReportWrapper;

class Denormalizer
{
    /**
     * @param \SimpleXMLElement $xml
     *
     * @return Program[]
     */
    public function denormalizePrograms(\SimpleXMLElement $xml)
    {
        $programs = [];
        foreach ($xml->matrix[1]->rows->row as $row) {
            $program = $this->denormalizeProgram($row);
            $programs[$program->getId()] = $program;
        }

        return array_values($programs);
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return Program
     */
    public function denormalizeProgram(\SimpleXMLElement $xml)
    {
        $program = new Program();
        $program->setId(intval($xml->programId));
        $program->setName(strval($xml->programName));

        return $program;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return Channel[]
     */
    public function denormalizeChannels(\SimpleXMLElement $xml)
    {
        $channels = [];
        foreach ($xml->matrix[1]->rows->row as $row) {
            $channel = $this->denormalizeChannel($row);
            $channels[$channel->getId()] = $channel;
        }

        return array_values($channels);
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return Channel
     */
    public function denormalizeChannel(\SimpleXMLElement $xml)
    {
        $channel = new Channel();
        $channel->setId(intval($xml->affiliateId));
        $channel->setName(strval($xml->siteName));

        return $channel;
    }

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
        // @todo fix dates!
        $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s T', str_replace('UTC+1', 'UTC', $row->timeOfEvent));
        $clickedAt = \DateTime::createFromFormat('Y-m-d H:i:s T', str_replace('UTC+1', 'UTC', $row->timeOfVisit));

        $transaction = new Transaction();
        $transaction->setId($createdAt->getTimestamp() . '_' . $row->orderNR);
        $transaction->setCreatedAt($createdAt);
        $transaction->setClickedAt($clickedAt);
        $transaction->setEpi(strval($row->epi1));
        $transaction->setOrderId(strval($row->orderNR));
        $program = new Program();
        $program->setId(intval($row->programId));
        $program->setName(strval($row->programName));
        $transaction->setProgram($program);
        $channel = new Channel();
        $channel->setId(intval($row->siteId));
        $channel->setName(strval($row->siteName));
        $transaction->setChannel($channel);
        $transaction->setOrderValue(round((float)$row->orderValue * (float)100));
        $transaction->setCommission(round((float)$row->affiliateCommission * (float)100));

        return $transaction;
    }
}
