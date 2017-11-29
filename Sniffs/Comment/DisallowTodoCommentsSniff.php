<?php

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

final class DisallowTodoCommentsSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [
        'PHP',
    ];

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return [
            T_COMMENT,
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
        $content = $tokens[$stackPtr]['content'];
        if (substr($content, 0, 8) === '// TODO:') {
            $error = 'TODO comments are prohibited;';
            $data  = [trim($tokens[$stackPtr]['content'])];
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
}

