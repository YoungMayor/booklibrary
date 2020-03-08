<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class BookTests extends TestCase
{

    public function testBrowse()
    {
        $client = new Client([
            "base_uri" => _env("BASE_URL")
        ]);

        $res = $client->request("GET", "/api/v1/browse.php");

        $this->assertEquals("200", $res->getStatusCode());
        $contentType = $res->getHeaders()['Content-Type']['0'];

        $this->assertRegexp("/application\/json/", $contentType);
    }

    public function testAdd()
    {
        $client = new Client([
            "base_uri" => _env("BASE_URL")
        ]);

        $res = $client->request("POST", "/api/v1/add.php", [
            "form_params" => [
                "isbn" => "1234123412334",
                "title" => "Book from Test",
                "author" => "Author Name",
                "description" => "The description"
            ]
        ]);

        $this->assertEquals("201", $res->getStatusCode());
        $contentType = $res->getHeaders()['Content-Type']['0'];

        $this->assertRegexp("/application\/json/", $contentType);
    }

    public function testView()
    {
        $client = new Client([
            "base_uri" => _env("BASE_URL")
        ]);

        $res = $client->request("POST", "/api/v1/view.php", [
            "query" => [
                "isbn" => "1234123412334"
            ]
        ]);

        $this->assertEquals("200", $res->getStatusCode());
        $contentType = $res->getHeaders()['Content-Type']['0'];

        $this->assertRegexp("/application\/json/", $contentType);
    }

    public function testLend()
    {
        $client = new Client([
            "base_uri" => _env("BASE_URL")
        ]);

        $res = $client->request("POST", "/api/v1/lend.php", [
            "form_params" => [
                "isbn" => "1234123412334",
                "user" => "1"
            ]
        ]);

        $this->assertEquals("200", $res->getStatusCode());
        $contentType = $res->getHeaders()['Content-Type']['0'];

        $this->assertRegexp("/application\/json/", $contentType);
    }

    public function testReturn()
    {
        $client = new Client([
            "base_uri" => _env("BASE_URL")
        ]);

        $res = $client->request("POST", "/api/v1/return.php", [
            "form_params" => [
                "isbn" => "1234123412334",
                "user" => "1"
            ]
        ]);

        $this->assertEquals("200", $res->getStatusCode());
        $contentType = $res->getHeaders()['Content-Type']['0'];

        $this->assertRegexp("/application\/json/", $contentType);
    }
}
