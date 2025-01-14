<?php
namespace Helmich\TypoScriptParser\Parser\Traverser;


use Helmich\TypoScriptParser\Parser\AST\ConditionalStatement;
use Helmich\TypoScriptParser\Parser\AST\NestedAssignment;

class Traverser
{



    /**
     * @var \Helmich\TypoScriptParser\Parser\AST\Statement[]
     */
    private $statements;


    /** @var \Helmich\TypoScriptParser\Parser\Traverser\AggregatingVisitor */
    private $visitors;



    /**
     * @param \Helmich\TypoScriptParser\Parser\AST\Statement[] $statements
     */
    public function __construct(array $statements)
    {
        $this->statements = $statements;
        $this->visitors   = new AggregatingVisitor();
    }



    /**
     * @param \Helmich\TypoScriptParser\Parser\Traverser\Visitor $visitor
     */
    public function addVisitor(Visitor $visitor)
    {
        $this->visitors->addVisitor($visitor);
    }



    public function walk()
    {
        $this->visitors->enterTree($this->statements);
        $this->walkRecursive($this->statements);
        $this->visitors->exitTree($this->statements);
    }



    /**
     * @param \Helmich\TypoScriptParser\Parser\AST\Statement[] $statements
     * @return \Helmich\TypoScriptParser\Parser\AST\Statement[]
     */
    private function walkRecursive(array $statements)
    {
        foreach ($statements as $key => $statement)
        {
            $this->visitors->enterNode($statement);

            if ($statement instanceof NestedAssignment)
            {
                $statement->statements = $this->walkRecursive($statement->statements);
            }
            else if ($statement instanceof ConditionalStatement)
            {
                $statement->ifStatements   = $this->walkRecursive($statement->ifStatements);
                $statement->elseStatements = $this->walkRecursive($statement->elseStatements);
            }

            $this->visitors->exitNode($statement);
        }
        return $statements;
    }

}