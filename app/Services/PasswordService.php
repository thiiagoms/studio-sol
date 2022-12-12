<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Password validation
 *
 * @package App\Services
 * @author  Thiago Silva <thiagom.devsec@gmail.com>
 * @version 1.0
 */
final class PasswordService
{
    private function validateMinSize(string $password, int $minLength): bool
    {
        $strlen = strlen($password);
        return $strlen >= $minLength ? true : false;
    }

    /**
     * Validate min upper case characters in string
     *
     * @param string $password
     * @param integer $minUpperCaseLetters
     * @return void
     */
    private function validateMinUpperCase(string $password, int $minUpperCaseLetters)
    {
        $upperLettersCount = 0;

        array_map(function (string $letter) use (&$upperLettersCount): void {
            if (ctype_upper($letter)) {
                $upperLettersCount++;
            }
        }, str_split($password));

        return $upperLettersCount >= $minUpperCaseLetters ? true : false;
    }

    /**
     * Validate lower case
     *
     * @param string $password
     * @param integer $minLowerCaseLetters
     * @return void
     */
    private function validateMinLowerCase(string $password, int $minLowerCaseLetters)
    {
        $lowerLettersCount = 0;

        array_map(function (string $letter) use (&$lowerLettersCount): void {
            if (ctype_lower($letter)) {
                $lowerLettersCount++;
            }
        }, str_split($password));

        return $lowerLettersCount >= $minLowerCaseLetters ? true : false;
    }

    /**
     * Valite special chars in password
     *
     * @param string $password
     * @param integer $minSpecialChars
     * @return boolean
     */
    private function validatMinSpecialChars(string $password, int $minSpecialChars): bool
    {
        $specialChars = preg_match_all('![^A-z0-9]!i', $password);
        return $specialChars >= $minSpecialChars ? true : false;
    }

    /**
     * Check if password contains repeted characteres in sequence
     *
     * @param string $password
     * @return bool
     */
    private function notRepeted(string $password): bool
    {
        $count = 0;
        $errors = [];

        array_map(function (string $letter) use ($password, &$count, &$errors): void {

            ++$count;

            if (isset($password[$count])) {
                if ($letter === $password[$count]) {
                    array_push($errors, ['error' => "Repeted letter {$letter} in sequence"]);
                }
            }
        }, str_split($password));

        return empty($errors) ? true : false;
    }

    /**
     * Min numeric digits in password
     *
     * @param string $password
     * @param integer $minDigit
     * @return void
     */
    private function minDigit(string $password, int $minDigit)
    {
        $count = 0;

        array_map(function (string $letter) use (&$count): void {
            if (is_numeric($letter)) {
                $count++;
            }
        }, str_split($password));

        return $count >= $minDigit ? true : false;
    }

    /**
     * Make password validation
     *
     * @param string $password
     * @param array $passwordRules
     * @return array
     */
    public function validatePassword(string $password, array $passwordRules): array
    {
        $errors = [];

        foreach ($passwordRules as $rule) {
            if ($rule['rule'] === 'minSize') {
                $minSize = $this->validateMinSize($password, $rule['value']);
                $minSize === false ? array_push($errors, 'minSize') : null;
            }

            if ($rule['rule'] === 'minUppercase') {
                $minUpperCase = $this->validateMinUpperCase($password, $rule['value']);
                $minUpperCase === false ? array_push($errors, 'minUppercase') : null;
            }

            if ($rule['rule'] === 'minLowercase') {
                $minLowerCase = $this->validateMinLowerCase($password, $rule['value']);
                $minLowerCase === false ? array_push($errors, 'minLowerCase') : null;
            }

            if ($rule['rule'] === 'minSpecialChars') {
                $specialChars = $this->validatMinSpecialChars($password, $rule['value']);
                $specialChars === false ? array_push($errors, 'minSpecialChars') : null;
            }

            if ($rule['rule'] === 'noRepeted') {
                $repeted = $this->notRepeted($password);
                $repeted === false ? array_push($errors, 'notRepeted') : null;
            }

            if ($rule['rule'] === 'minDigit') {
                $minDigits = $this->minDigit($password, $rule['value']);
                $minDigits === false ? array_push($errors, 'minDigit') : null;
            }
        }

        return [
            'verify' => empty($errors) ? true : false,
            'noMatch' => $errors
        ];
    }
}
