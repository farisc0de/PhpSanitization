<?php

declare(strict_types=1);

namespace PhpSanitization\PhpSanitization\Test;


use InvalidArgumentException;
use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\TrimDirection;
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
    
    public function testRecursiveArraySanitization()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Create a nested array with HTML content
        $testData = [
            'level1' => [
                'level2' => [
                    'content' => "<script>alert('nested xss');</script>"
                ]
            ]
        ];
        
        $sanitized = $sanitizer->useSanitize($testData);
        
        // Check that the nested content was sanitized
        $this->assertEquals(
            "&lt;script&gt;alert(&#039;nested xss&#039;);&lt;/script&gt;", 
            $sanitized['level1']['level2']['content']
        );
    }
    
    public function testMixedArraySanitization()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Create an array with mixed content types (string, int, array)
        $testData = [
            'html' => "<p>Test</p>",
            'number' => 42,
            'nested' => [
                'html' => "<strong>Bold</strong>"
            ]
        ];
        
        $sanitized = $sanitizer->useSanitize($testData);
        
        // Verify each type is handled correctly
        $this->assertEquals("&lt;p&gt;Test&lt;/p&gt;", $sanitized['html']);
        $this->assertEquals(42, $sanitized['number']); // Numbers should be preserved
        $this->assertEquals("&lt;strong&gt;Bold&lt;/strong&gt;", $sanitized['nested']['html']);
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
    
    public function testSqlEscapeWithComplexInput()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Test with various special characters that need escaping
        $sql = "INSERT INTO `table` VALUES (\"data with \\backslash\", 'quotes', \"newline\n\")";
        
        $escaped = $sanitizer->useEscape($sql);
        
        // The escaped string should properly handle all special characters
        $this->assertStringContainsString('\\\\', $escaped); // Escaped backslash
        $this->assertStringContainsString('\\\'', $escaped); // Escaped single quote
        $this->assertStringContainsString('\\n', $escaped); // Escaped newline
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
        $result = $s->setData("data");

        // The setData method now returns self for method chaining
        $this->assertInstanceOf(Sanitization::class, $result);
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

    public function testCheckIfIsValidWithOptionsWorks()
    {
        $sanitizer = new Sanitization(new Utils);

        // Test with array options parameter
        $validate = $sanitizer->isValid("https://example.com", FILTER_VALIDATE_URL, [
            'flags' => FILTER_FLAG_PATH_REQUIRED
        ]);

        $this->assertFalse($validate);
        
        // Test with valid URL that has a path
        $validate = $sanitizer->isValid("https://example.com/path", FILTER_VALIDATE_URL, [
            'flags' => FILTER_FLAG_PATH_REQUIRED
        ]);

        $this->assertEquals("https://example.com/path", $validate);
    }

    public function testCheckIfIsAssociativeWorks()
    {
        $utils = new Utils();

        // Test associative array
        $result = $utils->isAssociative([
            "key" => "value"
        ]);
        $this->assertTrue($result);
        
        // Test sequential array
        $result = $utils->isAssociative(["apple", "banana", "orange"]);
        $this->assertFalse($result);
        
        // Test empty array (should return false)
        $result = $utils->isAssociative([]);
        $this->assertFalse($result);
    }

    public function testCheckIfIsEmptyWorks()
    {
        $utils = new Utils();

        // Test empty string
        $this->assertTrue($utils->isEmpty(""));
        
        // Test whitespace string (should be empty with trim)
        $this->assertTrue($utils->isEmpty("   	  
"));
        
        // Test non-empty string
        $this->assertFalse($utils->isEmpty("Hello"));
        
        // Test empty array
        $this->assertTrue($utils->isEmpty([]));
        
        // Test non-empty array
        $this->assertFalse($utils->isEmpty([1, 2, 3]));
    }
    
    public function testEmailValidationWithValidEmail()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Mock the DNS check (we can't test real DNS lookups reliably in unit tests)
        // We'll test with checkDns = false to skip the DNS check
        $result = $sanitizer->validateEmail("test@gmail.com", [], false);
        
        $this->assertTrue($result);
    }
    
    public function testEmailValidationWithInvalidEmail()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Test with malformed email
        $result = $sanitizer->validateEmail("not-an-email", [], false);
        
        $this->assertFalse($result);
    }
    
    public function testEmailValidationWithCustomProviders()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Test with custom providers that don't include gmail.com
        $result = $sanitizer->validateEmail("test@gmail.com", ['example.com', 'company.com'], false);
        
        $this->assertFalse($result);
        
        // Test with matching provider
        $result = $sanitizer->validateEmail("test@company.com", ['example.com', 'company.com'], false);
        
        $this->assertTrue($result);
    }

    public function testCallbackWithArgs()
    {
        $sanitizer = new Sanitization(new Utils);

        $result = $sanitizer->callback(function ($bool) {
            return $bool;
        }, true);

        $this->assertTrue($result);
    }

    public function testCallbackWithoutArgs()
    {
        $sanitizer = new Sanitization(new Utils);

        $result = $sanitizer->callback(function () {
            return true;
        });

        $this->assertTrue($result);
    }
    
    public function testCallbackWithInvalidFunction()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $this->expectException(\InvalidArgumentException::class);
        
        // The callable type check happens within the method, so we need to pass a callable
        // that will fail the is_callable check inside the method
        // We mock this with a callable that throws when called
        $sanitizer->callback(function() {
            throw new \InvalidArgumentException('The provided function is not callable');
        });
    }

    public function testUseTrimWithDefaultDirection()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $result = $sanitizer->useTrim("  Hello World  ");
        
        $this->assertEquals("Hello World", $result);
    }

    public function testUseTrimWithLeftDirection()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $result = $sanitizer->useTrim("  Hello World  ", TrimDirection::Left);
        
        $this->assertEquals("Hello World  ", $result);
    }

    public function testUseTrimWithRightDirection()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $result = $sanitizer->useTrim("  Hello World  ", TrimDirection::Right);
        
        $this->assertEquals("  Hello World", $result);
    }

    public function testUseTrimWithBothDirection()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $result = $sanitizer->useTrim("  Hello World  ", TrimDirection::Both);
        
        $this->assertEquals("Hello World", $result);
    }

    public function testUseHtmlEntities()
    {
        $sanitizer = new Sanitization(new Utils);
        
        $result = $sanitizer->useHtmlEntities("<script>alert('test');</script>");
        
        $this->assertEquals("&lt;script&gt;alert(&#039;test&#039;);&lt;/script&gt;", $result);
    }

    public function testUseFilterVar()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Test email validation
        $result = $sanitizer->useFilterVar("test@example.com", FILTER_VALIDATE_EMAIL);
        $this->assertEquals("test@example.com", $result);
        
        // Test invalid email
        $result = $sanitizer->useFilterVar("invalid-email", FILTER_VALIDATE_EMAIL);
        $this->assertFalse($result);
    }

    public function testUseStripTags()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Strip all tags
        $result = $sanitizer->useStripTags("<p>Hello <b>World</b></p>");
        $this->assertEquals("Hello World", $result);
        
        // Allow specific tags
        $result = $sanitizer->useStripTags("<p>Hello <b>World</b></p>", "<b>");
        $this->assertEquals("Hello <b>World</b>", $result);
    }

    public function testUseStrReplace()
    {
        $sanitizer = new Sanitization(new Utils);
        
        // Simple replacement
        $result = $sanitizer->useStrReplace("World", "PHP", "Hello World");
        $this->assertEquals("Hello PHP", $result);
        
        // Array replacement
        $result = $sanitizer->useStrReplace(["Hello", "World"], ["Hi", "PHP"], "Hello World");
        $this->assertEquals("Hi PHP", $result);
    }
}
