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
final class InterfaceNameSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [
        'PHP',
        'JS',
    ];

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return [
            T_INTERFACE,
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
        // Get the class' name
        $classNameToken = $phpcsFile->getTokens()[$phpcsFile->findNext([T_STRING], $stackPtr)];

        // Does it ends with "Interface"?
        if (!$this->stringEndsWith($classNameToken['content'], 'Interface')) {
            $error = 'Interace names must end with "Interface"; found %s';
            $data  = [trim($classNameToken['content'])];
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }

    private function stringEndsWith(string $name, string $needle): bool
    {
        return (substr($name, -strlen($needle)) === $needle);
    }
}

