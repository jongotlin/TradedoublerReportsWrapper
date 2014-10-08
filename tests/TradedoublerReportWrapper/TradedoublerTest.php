<?php

use TradedoublerReportWrapper\Tradedoubler;

class TradedoublerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider transactionProvider
     */
    public function testReturnAListOfTransactions($xml)
    {
        $tradedoubler = new Tradedoubler('foo', 666, $this->getClientMock(200, $xml));

        $this->assertInternalType('array', $tradedoubler->getTransactions(new \DateTime(), new \DateTime()));
        $this->assertEquals(1291265, $tradedoubler->getTransactions(new \DateTime(), new \DateTime())[0]->getOrderId());
    }

    /**
     * @dataProvider programAndChannelProvider
     */
    public function testReturnAListOfPrograms($xml)
    {
        $tradedoubler = new Tradedoubler('foo', 666, $this->getClientMock(200, $xml));

        $this->assertInternalType('array', $tradedoubler->getPrograms());
        $this->assertEquals(42673, $tradedoubler->getPrograms()[0]->getId());
        $this->assertEquals('CoolStuff.se', $tradedoubler->getPrograms()[0]->getName());
    }

    /**
     * @dataProvider programAndChannelProvider
     */
    public function testReturnAListOfChannels($xml)
    {
        $tradedoubler = new Tradedoubler('foo', 666, $this->getClientMock(200, $xml));

        $this->assertInternalType('array', $tradedoubler->getChannels());
        $this->assertEquals(1140513, $tradedoubler->getChannels()[0]->getId());
        $this->assertEquals('Hitta Julklappar', $tradedoubler->getChannels()[0]->getName());
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

    /**
     * @return array
     */
    public function programAndChannelProvider()
    {
        return [[<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<report title="Mina program" name="aAffiliateMyProgramsReport" time="2014-10-08 07:31">
	<matrix rowcount="2">
		<rows>
			<row>
				<c>Du måste välja ett eller flera sale events innan du editerar</c>
			</row>
		</rows>
	</matrix>
	<matrix rowcount="1">
		<columns>
			<siteName type="string">Webbplatsnamn</siteName>
			<affiliateId type="string">Webbplats ID</affiliateId>
			<programName type="string">Program Namn</programName>
			<currentStatusExcel type="string">Program Prepayment Status</currentStatusExcel>
			<programId type="integer">Program ID</programId>
			<applicationDate type="date">Ansökningsdatum</applicationDate>
			<status type="string">Status</status>
		</columns>
		<rows>
			<row>
				<siteName>Hitta Julklappar</siteName>
				<affiliateId>1140513</affiliateId>
				<programName>CoolStuff.se</programName>
				<currentStatusExcel>Ok</currentStatusExcel>
				<programId>42673</programId>
				<applicationDate>2006-05-22</applicationDate>
				<status>Godkänd</status>
			</row>
		</rows>
	</matrix>
</report>
XML
]];
    }

    /**
     * @param int    $statusCode
     * @param string $xml
     *
     * @return Guzzle\Http\ClientInterface
     */
    protected function getClientMock($statusCode, $xml)
    {
        $clientMock = $this->getMock('Guzzle\\Http\\ClientInterface');
        $clientMock->expects($this->any())->method('get')
            ->will($this->returnValue($this->getRequestMock($statusCode, $xml)));

        return $clientMock;
    }

    /**
     * @param int    $statusCode
     * @param string $xml
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRequestMock($statusCode, $xml)
    {
        $requestMock = $this->getMock('Guzzle\\Http\\Message\\RequestInterface');
        $requestMock->expects($this->any())->method('send')->will(
            $this->returnValue($this->getResponseMock($statusCode, $xml))
        );

        return $requestMock;
    }

    /**
     * @param int    $statusCode
     * @param string $xml
     *
     * @return Guzzle\Http\Message\Response
     */
    protected function getResponseMock($statusCode, $xml)
    {
        $responseMock = $this->getMockBuilder('Guzzle\\Http\\Message\\Response')
            ->disableOriginalConstructor()->getMock();
        $responseMock->expects($this->any())->method('getStatusCode')->will($this->returnValue($statusCode));
        $responseMock->expects($this->any())->method('getBody')->will($this->returnValue($xml));

        return $responseMock;
    }
}
