<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Factory to build code coverage checkers.
 */
class PHPUnit_Framework_CodeCoverage_FactoryChecker
{
    /**
     * Creates an instance of a code coverage checker for a given test suit
     * and adding the results into a given test result.
     *
     * @param string $name
     * @param PHPUnit_Framework_Test $suite
     * @param PHPUnit_Framework_TestResult $result
     *
     * @return PHPUnit_Framework_CodeCoverage_Type
     *
     * @throws \InvalidArgumentException
     */
    public function getCodeCoverageCheckerFor(
        $name,
        PHPUnit_Framework_Test $suite,
        PHPUnit_Framework_TestResult $result
    )
    {
        $candidateClassName = $this->getClassNameCandidate($name);
        return $this->createHandler($candidateClassName, $suite, $result);
    }

    /**
     * @param string $candidateClassName
     * @param PHPUnit_Framework_Test $suite
     * @param PHPUnit_Framework_TestResult $result
     *
     * @return PHPUnit_Framework_CodeCoverage_Type
     *
     * @throws \InvalidArgumentException
     */
    private function createHandler(
        $candidateClassName,
        PHPUnit_Framework_Test $suite,
        PHPUnit_Framework_TestResult $result)
    {
        $candidateForCodeCoverageChecker = new $candidateClassName($suite, $result);
        if ($candidateForCodeCoverageChecker instanceof PHPUnit_Framework_CodeCoverage_Type)
        {
            return $candidateForCodeCoverageChecker;
        }
        throw new \InvalidArgumentException('A code coverge checker must implement PHPUnit_Framework_CodeCoverage_Type');
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    private function getClassNameCandidate($name)
    {
        $candidateClassName = "PHPUnit_Framework_CodeCoverage_{$name}Type";
        if (class_exists($candidateClassName)) {
            return $candidateClassName;
        }
        throw new \InvalidArgumentException("Not exist an implementation for a code coverage checker $name");
    }
}