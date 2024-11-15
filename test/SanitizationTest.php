<?php

namespace PhpSanitization\PhpSanitization\Test;

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;
use PHPUnit\Framework\TestCase;

class SanitizationTest extends TestCase
{
    public function testCheckIfTheLibrarySanitizeString()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize("<script>alert('xss');</script>");
        $expected = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibrarySanitizeArray()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize(["<script>alert('xss');</script>"]);
        $expected[0] = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected[0], $sanitized[0]);
    }

    public function testCheckIfTheLibrarySanitizeAssociativeArrayValues()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize(["xss" => "<script>alert('xss');</script>"]);
        $expected["xss"] = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected["xss"], $sanitized["xss"]);
    }

    public function testCheckIfTheLibrarySanitizeAssociativeArrayKeys()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize(["sql'" => "xss"]);
        $expected["sql&#039;"] = "xss";

        $this->assertEquals(
            $expected["sql&#039;"],
            $sanitized["sql&#039;"]
        );
    }

    public function testCheckIfTheLibraryIdentiftyEmptyString()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize("");
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryIdentiftyEmptyArray()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useSanitize([]);
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryIdentiftyEmptyQuery()
    {
        $sanitizer = new Sanitization(new Utils);
        $sanitized = $sanitizer->useEscape("");
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryEscapeSqlQueries()
    {
        $sanitizer = new Sanitization(new Utils);
        $escaped = $sanitizer->useEscape(
            "SELECT * FROM 'users' WHERE username = 'admin';"
        );
        $expected = "SELECT * FROM \'users\' WHERE username = \'admin\';";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseStripSlashesWorks()
    {
        $sanitizer = new Sanitization(new Utils);
        $escaped = $sanitizer->useStripSlashes("C:\Users\Faris\Music");
        $expected = "C:UsersFarisMusic";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseHtmlSpecialCharsWorks()
    {
        $sanitizer = new Sanitization(new Utils);
        $escaped = $sanitizer->useHtmlSpecialChars("<script>alert('This is js code');</script>");
        $expected = "&lt;script&gt;alert(&#039;This is js code&#039;);&lt;/script&gt;";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testSetterAndGetter()
    {
        $sanitizer = new Sanitization(new Utils);

        $this->testCheckIfTheSetterCanSetData($sanitizer);

        $this->testCheckIfTheGetterCanGetData($sanitizer);
    }

    private function testCheckIfTheSetterCanSetData($s)
    {
        $bool = $s->setData("data");

        $this->assertNull($bool);
    }

    private function testCheckIfTheGetterCanGetData($s)
    {
        $data = $s->getData();

        $this->assertEquals("data", $data);
    }

    public function testCheckIfUsePregReplaceWorks()
    {
        $sanitizer = new Sanitization(new Utils);

        $sanitized = $sanitizer->usePregReplace(
            "/([A-Z])\w+/",
            "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, sint?"
        );
        $expected = " ipsum dolor sit amet consectetur, adipisicing elit. , sint?";

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfUsePregReplaceFindNull()
    {
        $sanitizer = new Sanitization(new Utils);

        $sanitized = $sanitizer->usePregReplace("/([A-Z])\w+/", "");
        $expected = null;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfUsePregReplaceWorksOnArray()
    {
        $sanitizer = new Sanitization(new Utils);

        $sanitized = $sanitizer->usePregReplace(["/([A-Z])\w+/"], [
            "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, sint?"
        ]);
        $expected[0] = " ipsum dolor sit amet consectetur, adipisicing elit. , sint?";

        $this->assertEquals($expected[0], $sanitized[0]);
    }




    public function testCheckIfIsValidWork()
    {
        $sanitizer = new Sanitization(new Utils);

        $validate = $sanitizer->isValid("demo@gmail.com", FILTER_VALIDATE_EMAIL);

        $expected = "demo@gmail.com";

        $this->assertEquals($expected, $validate);
    }

    public function testCheckIfIsAssociativeWorks()
    {
        $utils = new Utils();

        $bool = $utils->isAssociative([
            "key" => "value"
        ]);

        $expected = true;

        $this->assertEquals($expected, $bool);
    }

    public function testCheckIfIsEmptyWorks()
    {
        $utils = new Utils();

        $bool = $utils->isEmpty("");

        $expected = true;

        $this->assertEquals($bool, $expected);
    }

    public function testCallbackWithArgs()
    {
        $sanitizer = new Sanitization(new Utils);

        $bool = $sanitizer->callback(function ($bool) {
            return $bool;
        }, true);

        $expected = true;

        $this->assertEquals($bool, $expected);
    }

    public function testCallbackWitouthArgs()
    {
        $sanitizer = new Sanitization(new Utils);

        $bool = $sanitizer->callback(function () {
            return true;
        });

        $expected = true;

        $this->assertEquals($bool, $expected);
    }
}
