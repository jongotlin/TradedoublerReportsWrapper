<?php

use TradedoublerReportWrapper\Denormalizer;

class DenormalizerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider transactionProvider
     */
    public function testCalculateTransactionId($xml)
    {
        $transactions = (new Denormalizer())->denormalizeTransactions(new \SimpleXMLElement($xml));

        //Guard
        $this->assertInstanceOf('\TradedoublerReportWrapper\Transaction', $transactions[0]);

        $this->assertEquals('1410116127_1291265', $transactions[0]->getId());
    }

    /**
     * @return array
     */
    public function transactionProvider()
    {
        return [[<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<report title="Avslut- och leadrapport" name="aAffiliateEventBreakdownReport" time="2014-10-08 07:01">
	<matrix rowcount="1">
		<columns>
			<programName type="string">Program Namn</programName>
			<currentStatusExcel type="string">Program Prepayment Status</currentStatusExcel>
			<programId type="integer">Program ID</programId>
			<timeOfVisit type="datetime">Tidpunkt för besöket</timeOfVisit>
			<timeOfEvent type="datetime">Tidpunkt för event</timeOfEvent>
			<timeInSession type="string">Tidpunkt i session</timeInSession>
			<lastModified type="datetime">Tidpunkt Senast uppdaterad</lastModified>
			<leadNR type="string">Leadnummer</leadNR>
			<orderNR type="string">Ordernummer</orderNR>
			<epi1 type="string">EPI EPI 1</epi1>
			<epi2 type="string">EPI EPI 2</epi2>
			<eventName type="string">Event Namn</eventName>
			<pendingStatus type="string">Event Status</pendingStatus>
			<pendingReason type="string">Anledning</pendingReason>
			<siteId type="integer">Webbplats ID</siteId>
			<graphicalElementName type="string">Annons Namn</graphicalElementName>
			<productName type="string">Produktinfo Namn</productName>
			<productNrOf type="string">Produktinfo #</productNrOf>
			<productValue type="decimal">Produktinfo Produktvärde</productValue>
			<open_product_feeds_id type="string">Products Open API information Produkt-ID</open_product_feeds_id>
			<open_product_feeds_name type="string">Products Open API information Produktnamn</open_product_feeds_name>
			<voucher_code type="string">Vouchers Voucher code</voucher_code>
			<affiliateCommission type="decimal">Ersättning Publisher</affiliateCommission>
		</columns>
		<rows>
			<row>
				<programName>CoolStuff.se</programName>
				<currentStatusExcel>Ok</currentStatusExcel>
				<programId>42673</programId>
				<timeOfVisit>2014-09-07 20:48:34 CEST</timeOfVisit>
				<timeOfEvent>2014-09-07 20:55:27 CEST</timeOfEvent>
				<timeInSession>Y</timeInSession>
				<lastModified></lastModified>
				<leadNR></leadNR>
				<orderNR>1291265</orderNR>
				<epi1></epi1>
				<epi2></epi2>
				<eventName>Avslut</eventName>
				<pendingStatus>A</pendingStatus>
				<pendingReason></pendingReason>
				<siteId>2122225</siteId>
				<graphicalElementName>Eget grafiskt element</graphicalElementName>
				<productName></productName>
				<productNrOf></productNrOf>
				<productValue>0.0</productValue>
				<open_product_feeds_id></open_product_feeds_id>
				<open_product_feeds_name></open_product_feeds_name>
				<voucher_code></voucher_code>
				<affiliateCommission>22.192</affiliateCommission>
			</row>
		</rows>
	</matrix>
</report>
XML
        ]];
    }
}
