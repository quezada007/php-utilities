<?php

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Utilities\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase {

    public function setUp() {
        $this->Validator = new Validator();
    }

    public function tearDown() {
        unset($this->Validator);
    }

    public function listOfValidURLs() {
        return [
            ['https://www.goodcocktails.com', 'https://www.goodcocktails.com should be valid'],
            ['https://m.goodcocktails.com', 'https://m.goodcocktails.com should be valid'],
            ['http://example.com', 'http://example.com should be valid'],
            ['https://pt.wikipedia.org/wiki/Guimarães', 'https://pt.wikipedia.org/wiki/Guimarães should be valid'],
            ['https://www.example.com/', 'https://www.example.com/ should be valid'],
            ['http://www.example.com/some-page/', 'http://www.example.com/some-page/ should be valid'],
            ['http://example.com/somepage', 'http://example.com/somepage should be valid'],
            ['http://example.com/somepage/?param=hello&otherparam=2', 'http://example.com/somepage/?param=hello&otherparam=2 should be valid'],
            ['http://www.example.com/?&&&', 'http://www.example.com/?&&& should be valid'],
            ['http://www.exmpale.com/MYnewPage', 'http://www.exmpale.com/MYnewPage should be valid'],
            ['https://www.goodcocktails.com/recipes/mixed_drink.php?drinkID=1', 'https://www.goodcocktails.com/recipes/mixed_drink.php?drinkID=1 should be valid'],
            ['http://www.good-cocktails.com', 'http://www.good-cocktails.com should be valid']
        ];
    }

    public function listOfInValidURLs() {
        return [
            ['http://localhost', 'http://localhost should be invalid'],
            ['http://example', 'http://example should be invalid'],
            ['ftp://www.goodcocktails.com', 'ftp://www.goodcocktails.com should be invalid'],
            ['ssh://www.goodcocktails.com', 'ssh://www.goodcocktails.com should be invalid'],
            ['http://192.168.1.100', 'http://192.168.1.100 should be invalid'],
            ['http://www.example.com?test=1', 'http://www.example.com?test=1 should be invalid'],
            [3121, '3121 should be invalid'],
            ['Hello World', 'Hello World should be invalid'],
            ['www.example.com', 'www.example.com should be invalid'],
            ['//www.example.com', '//www.example.com should be invalid'],
            [[], '[] should be invalid'],
            ['', ' should be invalid']
        ];
    }

    /**
     * @dataProvider listOfValidURLs
     */
    public function testIsValidURLForValidURL($url, $msg) {
        $this->assertTrue($this->Validator->isValidURL($url), $msg);
    }

    /**
     * @dataProvider listOfInValidURLs
     */
    public function testIsValidURLForInValidURL($url, $msg) {
        $this->assertFalse($this->Validator->isValidURL($url), $msg);
    }

    public function listOfValidEmails() {
        return [
            ['admin@example.com', 'admin@example.com should be valid'],
            ['first.last@example.com', 'first.last@example.com should be valid'],
            ['first-last@example.com', 'first-last@example.com should be valid'],
            ['first+last@example.com', 'first+last@example.com should be valid'],
            ['no_reply@example.com', 'no_reply@example.com should be valid'],
            ['no_reply007@example.com', 'no_reply007@example.com should be valid'],
            ['number2@example.com', 'number2@example.com should be valid'],
            ['name@sub.example.com', 'name@sub.example.com should be valid'],
            ['name@one-example.com', 'name@one-example.com should be valid'],
            ['____@one-example.com', '____@one-example.com should be valid'],
            ['32131@example.com', '32131@example.com should be valid'],
            ['123something@example.com', '123something@example.com should be valid']
        ];
    }

    public function listOfInvalidEmails() {
        return [
            ['noatsign', 'noatsign should be invalid'],
            ['@example.com', '@example.com should be invalid'],
            ['@.com', '@.com should be invalid'],
            ['something@', 'something@ should be invalid'],
            ['something@.com', 'something@.com should be invalid'],
            ['.dot@example.com', '.dot@example.com should be invalid'],
            ['dot.@example.com', 'dot.@example.com should be invalid'],
            [3213, '3213 should be invalid'],
            ['something@.com', 'something@.com should be invalid'],
            [[], '[] should be invalid'],
            ['name@-example.com', 'name@-example.com should be invalid'],
            ['name@example-.com', 'name@example-.com should be invalid'],
            ['first..last@example.com', 'first..last@example.com should be invalid'],
            ['<first.last@example.com>', '<first.last@example.com> should be invalid'],
            ['first.last@example', 'first.last@example should be invalid'],
            ['first.@example.com', 'first.@example.com should be invalid'],
            ['first.last@example..com', 'first.last@example..com should be invalid'],
            ['first.example.com', 'first.example.com should be invalid'],
        ];
    }

    /**
     * @dataProvider listOfValidEmails
     */
    public function testIsValidEmail($email, $msg) {
        $this->assertTrue($this->Validator->isValidEmail($email), $msg);
    }

    /**
     * @dataProvider listOfInvalidEmails
     */
    public function testIsInvalidEmail($email, $msg) {
        $this->assertFalse($this->Validator->isValidEmail($email), $msg);
    }

    public function listOfValidPhoneNumbers() {
        return [
            ['(714) 652-4656', '(714) 652-4656 should be valid'],
            ['(714) 652-5556', '(714) 652-5556 should be valid'],
            ['(714) 652-5800', '(714) 652-5800 should be valid'],
            ['1 (714) 546-5468', '1 (714) 546-5468 should be valid'],
            ['1-949-654-4647', '1-949-654-4647 should be valid'],
            ['1945596512', '1945596512 should be valid'],
            ['7146985412', '7146985412 should be valid'],
            ['949-452-5468', '949-452-5468 should be valid'],
            ['(714)458-4547', '(714)458-4547 should be valid'],
            ['714.265.2565', '714.265.2565 should be valid'],
            ['1.265.256.1145', '1.265.256.1145 should be valid']
        ];
    }

    public function listOfInvalidPhoneNumbers() {
        return [
            ['(900) 548-5451', '(900) 548-5451 should be invalid'],
            ['(800) 451-5454', '(800) 451-5454 should be invalid'],
            ['(888) 451-5454', '(888) 451-5454 should be invalid'],
            ['(866) 451-5454', '(866) 451-5454 should be invalid'],
            ['(877) 451-5454', '(877) 451-5454 should be invalid'],
            ['(555) 123-4567', '(555) 123-4567 should be invalid'],
            ['1 (900) 548-5451', '1 (900) 548-5451 should be invalid'],
            ['1 (800) 451-5454', '1 (800) 451-5454 should be invalid'],
            ['1 (888) 451-5454', '1 (888) 451-5454 should be invalid'],
            ['1 (866) 451-5454', '1 (866) 451-5454 should be invalid'],
            ['1 (877) 451-5454', '1 (877) 451-5454 should be invalid'],
            ['1 (555) 123-4567', '1 (555) 123-4567 should be invalid'],
            ['1-900-548-5451', '1-900-548-5451 should be invalid'],
            ['1-800-451-5454', '1-800-451-5454 should be invalid'],
            ['1-888-451-5454', '1-888-451-5454 should be invalid'],
            ['1-866-451-5454', '1-866-451-5454 should be invalid'],
            ['1-877-451-5454', '1-877-451-5454 should be invalid'],
            ['1-555-123-4567', '1-555-123-4567 should be invalid'],
            ['1-714-CALL-MEE', '1-714-CALL-MEE should be invalid'],
            ['Call Now', 'Call Now should be invalid'],
            ['7485', '7485 should be invalid'],
            ['5556546546', '5556546546 should be invalid'],
            ['1234567898745', '1234567898745 should be invalid'],
            [[], '[] should be invalid'],
            [8884541254, '(int)8884541254 should be invalid']
        ];
    }

    /**
     * @dataProvider listOfValidPhoneNumbers
     */
    public function testIsValidPhone($phone, $msg) {
        $this->assertTrue($this->Validator->isValidPhone($phone), $msg);
    }

    /**
     * @dataProvider listOfInvalidPhoneNumbers
     */
    public function testIsInvalidPhone($phone, $msg) {
        $this->assertFalse($this->Validator->isValidPhone($phone), $msg);
    }

    public function listOfValidZipCodes() {
        return [
            ['92660', '92660 should be valid'],
            ['92660-2715', '92660-2715 should be valid'],
            ['01254', '01254 should be valid'],
            ['25698-5698', '25698-5698 should be valid']
        ];
    }

    public function listOfInvalidZipCodes() {
        return [
            ['zipcode', 'zipcode should be invalid'],
            ['6546546546', '6546546546 should be invalid'],
            ['92660-', '92660- should be invalid'],
            ['92660-456456', '92660-456456 should be invalid'],
            ['2660-1245', '2660-1245 should be invalid'],
            ['1-1', '1-1 should be invalid'],
            ['-21542', '-21542 should be invalid'],
            ['ad454', 'ad454 should be invalid'],
            ['45ds6', '45ds6 should be invalid'],
            ['56464-4d44', '56464-4d44 should be invalid'],
            ['452125621', '452125621 should be invalid'],
            [[], '[] should be invalid']
        ];
    }

    /**
     * @dataProvider listOfValidZipCodes
     */
    public function testIsValidZipCode($zip, $msg) {
        $this->assertTrue($this->Validator->isValidZipCode($zip), $msg);
    }

    /**
     * @dataProvider listOfInvalidZipCodes
     */
    public function testIsInvalidZipCode($zip, $msg) {
        $this->assertFalse($this->Validator->isValidZipCode($zip), $msg);
    }

    public function listOfValidNames() {
        return [
            ['Jose', 'Jose should be valid'],
            ['Jose M', 'Jose M should be valid'],
            ['John Doe', 'John Doe should be valid'],
            ['Jane Doe-Smith', 'Jane Doe-Smith should be valid'],
            ['Shaquille O\'Neal', 'Shaquille O\'Neal should be valid'],
            ['Shaq O\'Neal-Smith', 'Shaq O\'Neal-Smith should be valid'],
            ['D\'Nyce O\'Neal-Smith','D\'Nyce O\'Neal-Smith should be valid']
        ];
    }

    public function listOfInvalidNames() {
        return [
            ['Jose M.', 'Jose M. should be invalid'],
            ['32121', '32121 should be invalid'],
            ['##sfd4', '##sfd4 should be invalid'],
            ['adf&sd', 'adf&sd should be invalid'],
            ['\'apostrophe', '\'apostrophe should be invalid'],
            ['apostrophe\'', 'apostrophe\' should be invalid'],
            ['-hyphen', '-hyphen should be invalid'],
            ['hyphen-', 'hyphen- should be invalid'],
            ['using,commas', 'using,commas should be invalid'],
            ['somename?', 'somename? should be invalid'],
            ['hyphen-\'apostrophe', 'hyphen-\'apostrophe should be invalid'],
            ['apostrophe-\'hyphen', 'apostrophe-\'hyphen should be invalid'],
            ['apostrophe\'\'apostrophe', 'apostrophe\'\'apostrophe should be invalid'],
            ['hyphen--hyphen', 'hyphen--hyphen should be invalid'],
            ['', '(empty) should be invalid'],
            [12345, '(int)12345 should be invalid'],
            [[], '[] should be invalid']
        ];
    }

    /**
     * @dataProvider listOfValidNames
     */
    public function testIsValidName($name, $msg) {
        $this->assertTrue($this->Validator->isValidName($name), $msg);
    }

    /**
     * @dataProvider listOfInvalidNames
     */
    public function testIsInvalidName($name, $msg) {
        $this->assertFalse($this->Validator->isValidName($name), $msg);
    }

    public function listOfValidDates() {
        return [
            ['03/03/2017', 'm/d/Y', '03/03/2017 should be valid'],
            ['02/01/2018', 'm/d/Y', '02/01/2018 should be valid'],
            ['12/31/2016', 'm/d/Y', '12/31/2016 should be valid'],
            ['02/29/2020', 'm/d/Y', '02/29/2020 should be valid'],
            ['2017-07-01', 'Y-m-d', '2017-07-01 should be valid'],
            ['2020-02-29', 'Y-m-d', '2020-02-29 should be valid'],
            ['2016-02-29', 'Y-m-d', '2016-02-29 should be valid'],
            ['2018-01-01', 'Y-m-d', '2018-01-01 should be valid']
        ];
    }

    public function listOfInvalidDates() {
        return [
            ['3/3/2018', 'm/d/Y', '3/3/2018 should be invalid'],
            ['01/1/2018', 'm/d/Y', '01/1/2018 should be invalid'],
            ['9/6/2018', 'm/d/Y', '9/6/2018 should be invalid'],
            ['04/01/18', 'm/d/Y', '04/01/18 should be invalid'],
            ['5/30/18', 'm/d/Y', '5/30/18 should be invalid'],
            ['02/30/2020', 'm/d/Y', '02/30/2020 should be invalid'],
            ['13/01/2018', 'm/d/Y', '13/01/2018 should be invalid'],
            ['20/20/2020', 'm/d/Y', '20/20/2020 should be invalid'],
            ['00/01/2018', 'm/d/Y', '00/01/2018 should be invalid'],
            ['aa/bb/cccc', 'm/d/Y', 'aa/bb/cccc should be invalid'],
            ['2016-02*02', 'Y-m-d', '2016-02*02 should be invalid'],
            ['2018*03*15', 'Y-m-d', '2018*03*15 should be invalid'],
            ['2015-30-02', 'Y-m-d', '2015-30-02 should be invalid'],
            ['124523', 'Y-m-d', '124523 should be invalid'],
            ['20001212', 'Y-m-d', '20001212 should be invalid'],
            ['2020.02.02', 'Y-m-d', '2020.02.02 should be invalid'],
            ['string', 'Y-m-d', 'string should be invalid'],
            [20180205, 'Y-m-d', '(int)20180205 should be invalid'],
            ['03-03-2018', 'Y-m-d', '03-03-2018 should be invalid'],
            [[], 'Y-m-d', '[] should be invalid'],
            ['2018-02-02-02', 'Y-m-d', '2018-02-02-02 should be invalid'],
            ['20-18-0202', 'Y-m-d', '20-18-0202 should be invalid']
        ];
    }

    /**
     * @dataProvider listOfValidDates
     */
    public function testIsValidDate($date, $format, $msg) {
        $this->assertTrue($this->Validator->isValidDate($date, $format), $msg);
    }

    /**
     * @dataProvider listOfInvalidDates
     */
    public function testIsInvalidDate($date, $format, $msg) {
        $this->assertFalse($this->Validator->isValidDate($date, $format), $msg);
    }
}