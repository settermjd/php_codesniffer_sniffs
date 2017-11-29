<?php

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * This sniff prohibits the use of Perl style hash comments.
 *
 * @author    Your Name <you@domain.net>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 */

/**
 * This sniff prohibits the use of Perl style hash comments.
 *
 * An example of a hash comment is:
 *
 * <code>
 *  # This is a hash comment, which is prohibited.
 *  $hello = 'hello';
 * </code>
 *
 * @author    Your Name <you@domain.net>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 */
final class DisallowVardumpSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [
        'PHP',
    ];

    public function getIncludedSniffs()
    {
        return [
            'Generic/Sniffs/WhiteSpace/DisallowTabIndentSniff.php',
        ];
    }

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return [
            T_STRING,
        ];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param File      $phpcsFile The file where the token was found.
     * @param int       $stackPtr  The position in the stack where the
     *                             token was found.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $string_found = $tokens[$stackPtr];

        if ( $string_found['content'] === "var_dump") {
            $error = 'Use of var_dump is prohibited; found %s';
            $data  = [trim($tokens[$stackPtr]['content'])];
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
}

