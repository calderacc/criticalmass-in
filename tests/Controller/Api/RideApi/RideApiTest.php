<?php declare(strict_types=1);

namespace Tests\Controller\Api\RideApi;

use Tests\Controller\Api\AbstractApiControllerTest;

class RideApiTest extends AbstractApiControllerTest
{
    public function testCurrentRide(): void
    {
        $this->markTestSkipped('This must be improved as it is date related.');

        $client = static::createClient();

        $client->request('GET', '/api/hamburg/current');

        $expectedContent = '{"id":9,"cycle":null,"city":{"slug":"hamburg","id":7,"mainSlug":{"id":7,"slug":"hamburg"},"name":"Hamburg","title":"Critical Mass Hamburg","description":null,"url":null,"facebook":null,"twitter":null,"latitude":0,"longitude":0,"slugs":[{"id":7,"slug":"hamburg"}],"cityPopulation":0,"punchLine":null,"longDescription":null,"timezone":"Europe\/Berlin","threadNumber":0,"postNumber":0,"colorRed":0,"colorGreen":0,"colorBlue":0},"slug":"kidical-mass-hamburg-2035","title":"Critical Mass 24.06.2035","description":null,"dateTime":2066324400,"location":null,"latitude":null,"longitude":null,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null,"facebook":null,"twitter":null,"url":null,"participationsNumberYes":0,"participationsNumberMaybe":0,"participationsNumberNo":0}';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }

    public function testFirstRide(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/hamburg/2011-06-24');

        $expectedContent = '{"cycle":null,"city":{"slug":"hamburg","color":{"red":0,"green":0,"blue":0},"mainSlug":{"slug":"hamburg"},"name":"Hamburg","title":"Critical Mass Hamburg","description":null,"latitude":53.550556,"longitude":9.993333,"slugs":[{"slug":"hamburg"}],"socialNetworkProfiles":[],"cityPopulation":0,"punchLine":null,"longDescription":null,"timezone":"Europe\/Berlin","threadNumber":0,"postNumber":0},"slug":null,"title":"Critical Mass Hamburg 24.06.2011","description":null,"dateTime":1308942000,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null,"socialNetworkProfiles":[],"participationsNumberYes":0,"participationsNumberMaybe":0,"participationsNumberNo":0}';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }

    public function testCurrentRideWithoutSlugs(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/hamburg/current?slugsAllowed=true');

        $expectedContent = '{"id":9,"cycle":null,"city":{"slug":"hamburg","id":7,"mainSlug":{"id":7,"slug":"hamburg"},"name":"Hamburg","title":"Critical Mass Hamburg","description":null,"url":null,"facebook":null,"twitter":null,"latitude":0,"longitude":0,"slugs":[{"id":7,"slug":"hamburg"}],"cityPopulation":0,"punchLine":null,"longDescription":null,"timezone":"Europe\/Berlin","threadNumber":0,"postNumber":0,"colorRed":0,"colorGreen":0,"colorBlue":0},"slug":"kidical-mass-hamburg-2035","title":"Critical Mass 24.06.2035","description":null,"dateTime":2066324400,"location":null,"latitude":null,"longitude":null,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null,"facebook":null,"twitter":null,"url":null,"participationsNumberYes":0,"participationsNumberMaybe":0,"participationsNumberNo":0}';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }

    public function testCurrentRideWithSlugs(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/hamburg/current?slugsAllowed=true');

        $expectedContent = '{"id":9,"cycle":null,"city":{"slug":"hamburg","id":7,"mainSlug":{"id":7,"slug":"hamburg"},"name":"Hamburg","title":"Critical Mass Hamburg","description":null,"url":null,"facebook":null,"twitter":null,"latitude":0,"longitude":0,"slugs":[{"id":7,"slug":"hamburg"}],"cityPopulation":0,"punchLine":null,"longDescription":null,"timezone":"Europe\/Berlin","threadNumber":0,"postNumber":0,"colorRed":0,"colorGreen":0,"colorBlue":0},"slug":"kidical-mass-hamburg-2035","title":"Critical Mass 24.06.2035","description":null,"dateTime":2066324400,"location":null,"latitude":null,"longitude":null,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null,"facebook":null,"twitter":null,"url":null,"participationsNumberYes":0,"participationsNumberMaybe":0,"participationsNumberNo":0}';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }

    public function testCurrentRideBySlug(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/hamburg/kiddical-mass-hamburg-2035');

        $expectedContent = '{"id":9,"cycle":null,"city":{"slug":"hamburg","id":7,"mainSlug":{"id":7,"slug":"hamburg"},"name":"Hamburg","title":"Critical Mass Hamburg","description":null,"url":null,"facebook":null,"twitter":null,"latitude":0,"longitude":0,"slugs":[{"id":7,"slug":"hamburg"}],"cityPopulation":0,"punchLine":null,"longDescription":null,"timezone":"Europe\/Berlin","threadNumber":0,"postNumber":0,"colorRed":0,"colorGreen":0,"colorBlue":0},"slug":"kidical-mass-hamburg-2035","title":"Critical Mass 24.06.2035","description":null,"dateTime":2066324400,"location":null,"latitude":null,"longitude":null,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null,"facebook":null,"twitter":null,"url":null,"participationsNumberYes":0,"participationsNumberMaybe":0,"participationsNumberNo":0}';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }

    public function testRideListWithoutParameters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/ride');

        $expectedContent = '[{"slug":null,"title":"Critical Mass Hamburg 01.02.2015","description":null,"dateTime":1422817200,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.12.2015","description":null,"dateTime":1448996400,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.04.2016","description":null,"dateTime":1459537200,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.05.2016","description":null,"dateTime":1462129200,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.08.2016","description":null,"dateTime":1470078000,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.01.2017","description":null,"dateTime":1483297200,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.10.2017","description":null,"dateTime":1506884400,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.12.2017","description":null,"dateTime":1512154800,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.01.2018","description":null,"dateTime":1514833200,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null},{"slug":null,"title":"Critical Mass Hamburg 01.03.2018","description":null,"dateTime":1519930800,"location":null,"latitude":53.5,"longitude":10.5,"estimatedParticipants":null,"estimatedDistance":null,"estimatedDuration":null}]';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIdLessJsonEquals($expectedContent, $client->getResponse()->getContent());
    }
}