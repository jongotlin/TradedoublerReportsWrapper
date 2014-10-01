<?php

namespace TradedoublerReportWrapper;

use TradedoublerReportWrapper\Exception\AuthenticationException;
use TradedoublerReportWrapper\Exception\CommunicationException;
use Guzzle\Http\ClientInterface;

class Tradedoubler
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $organization;

    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $client;

    /**
     * @var \TradedoublerReportWrapper\Denormalizer
     */
    protected $denormalizer;

    /**
     * @param int             $key
     * @param string          $organization
     * @param ClientInterface $client
     */
    public function __construct($key, $organization, ClientInterface $client)
    {
        $this->key = $key;
        $this->organization = $organization;
        $this->client = $client;

        $this->denormalizer = new Denormalizer();
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return Transaction[]
     */
    public function getTransactions(\DateTime $from = null, \DateTime $to = null)
    {
        $result = $this->load(
            sprintf(
                'http://reports.tradedoubler.com/pan/aReport3Key.action?reportName=aAffiliateEventBreakdownReport' .
                '&columns=programId&columns=timeOfVisit&columns=timeOfEvent&columns=timeInSession' .
                '&columns=lastModified&columns=epi1&columns=epi2&columns=eventName&columns=pendingStatus&columns=siteName'.
                '&columns=siteId&columns=graphicalElementName&columns=productName&columns=productNrOf&columns=productValue' .
                '&columns=open_product_feeds_id&columns=open_product_feeds_name&columns=voucher_code&columns=deviceType'.
                '&columns=os&columns=browser&columns=vendor&columns=device&columns=affiliateCommission&columns=link' .
                '&columns=leadNR&columns=orderNR&columns=pendingReason&columns=orderValue'.
                '&startDate=%s&endDate=%s&metric1.lastOperator=/&currencyId=SEK&event_id=0&pending_status=1'.
                '&organizationId=%s&includeWarningColumn=true&metric1.summaryType=NONE&includeMobile=1'.
                '&latestDayToExecute=0&metric1.operator1=/&breakdownOption=2' .
                '&reportTitleTextKey=REPORT3_SERVICE_REPORTS_AAFFILIATEEVENTBREAKDOWNREPORT_TITLE&setColumns=true' .
                '&metric1.columnName1=orderValue&metric1.columnName2=orderValue&metric1.midOperator=/&dateSelectionType=1' .
                '&sortBy=timeOfEvent&filterOnTimeHrsInterval=false&customKeyMetricCount=0&key=%s&format=XML',
                $from->format('Y-m-d'),
                $to->format('Y-m-d'),
                $this->organization,
                $this->key
            )
        );

        return $this->denormalizer->denormalizeTransactions(new \SimpleXMLElement($result));
    }

    /**
     * @param string $url
     * @throws Exception\AuthenticationException
     * @throws Exception\CommunicationException
     *
     * @return string
     */
    protected function load($url)
    {
        $response = $this->client->get($url)->send();

        if (200 != $response->getStatusCode()) {
            throw new CommunicationException();
        }

        if (strpos($response->getContentType(), 'text/html') === 0) {
            throw new AuthenticationException('Probably authentication error...');
        }

        return $response->getBody();
    }
}
