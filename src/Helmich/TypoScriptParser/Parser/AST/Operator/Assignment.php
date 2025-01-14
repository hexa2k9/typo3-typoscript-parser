<?php
namespace Helmich\TypoScriptParser\Parser\AST\Operator;


use Helmich\TypoScriptParser\Parser\AST\ObjectPath;
use Helmich\TypoScriptParser\Parser\AST\Scalar;


/**
 * An assignment statement.
 *
 * Example:
 *
 *     foo = bar
 *
 * @package    Helmich\TypoScriptParser
 * @subpackage Parser\AST\Operator
 */
class Assignment extends BinaryOperator
{



    /**
     * The value to be assigned. Should be a scalar value, which MAY contain
     * a constant evaluation expression (like "${foo.bar}").
     *
     * @var \Helmich\TypoScriptParser\Parser\AST\Scalar
     */
    public $value;



    /**
     * Constructs an assignment.
     *
     * @param \Helmich\TypoScriptParser\Parser\AST\ObjectPath $object     The object to which to assign the value.
     * @param \Helmich\TypoScriptParser\Parser\AST\Scalar     $value      The value to be assigned.
     * @param int                                             $sourceLine The source line.
     */
    public function __construct(ObjectPath $object, Scalar $value, $sourceLine)
    {
        parent::__construct($sourceLine);

        $this->object = $object;
        $this->value  = $value;
    }

}