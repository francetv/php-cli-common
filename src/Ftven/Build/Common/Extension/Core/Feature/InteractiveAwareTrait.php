<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Ftven\Build\Common\Feature\OutputAwareTrait;
use Ftven\Build\Common\Feature\InputAwareTrait;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait InteractiveAwareTrait
{
    use HelperSetAwareTrait;
    use OutputAwareTrait;
    use InputAwareTrait;
    /**
     * @param $message
     * @param null $default
     *
     * @return string
     */
    protected function prompt($message, $default = null)
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new Question($message . ($default ? (sprintf(' [%s]', $default)) : '') . ' : ', $default);

        $question->setValidator(function ($answer) {
            $len = function_exists('mb_strlen') ? mb_strlen($answer) : strlen($answer);

            if (0 === $len) {
                throw new \RuntimeException("You must enter a value", 23);
            }

            return $answer;
        });

        $question->setMaxAttempts(3);

        $response = $q->ask($this->getInput(), $this->getOutput(), $question);

        return $response;
    }
    /**
     * @param string $message
     * @param array  $expectedValues
     * @param mixed  $default
     *
     * @return string
     */
    protected function choice($message, $expectedValues, $default = null
    )
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new ChoiceQuestion(
            $message . ($default ? (sprintf(' [%s]', $default)) : '') . ' : ',
            $expectedValues,
            $default
        );

        $question->setMaxAttempts(5);

        $response = $q->ask($this->getInput(), $this->getOutput(), $question);

        return $response;
    }
    /**
     * @param $message
     * @param bool  $default
     *
     * @return string
     */
    protected function confirm($message, $default = null)
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new ConfirmationQuestion(
            $message . ($default ? (sprintf(' [%s]', $default ? 'yes' : 'no')) : '') . ' : ', true === $default
        );

        $question->setMaxAttempts(3);

        $response = $q->ask($this->getInput(), $this->getOutput(), $question);

        return $response;
    }
}