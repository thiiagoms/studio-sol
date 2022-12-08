<?php

declare(strict_types=1);

namespace App\Services;

final class PasswordService
{
    private function validateMinSize(string $password, int $minLength): bool
    {
        $strlen = strlen($password);
        return $strlen >= $minLength ? true : false;
    }

    private function minUpperCase(string $password, int $minUpperCaseLetters)
    {
        // TODO
    }

    private function minLowerCase(string $password, int $minLowerCaseLetters)
    {
        // TODO
    }

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

    final public function validatePassword(string $password, array $passwordRules): array
    {
        $errors = [];

        $passwordValidate = false;

        foreach ($passwordRules as $key => $rules) {
            if ($rules['rule'] === 'minSize') {
                $minSize = $this->validateMinSize($password, $rules['value']);
                $minSize === false ? array_push($errors, 'minSize') : null;
            }

            if ($rules['rule'] === 'minSpecialChars') {
                $specialChars = $this->validatMinSpecialChars($password, $rules['value']);
                $specialChars === false ? array_push($errors, 'minSpecialChars') : null;
            }

            if ($rules['rule'] === 'noRepeted') {
                $repeted = $this->notRepeted($password);
                $repeted === false ? array_push($errors, 'notRepeted') : null;
            }

            if ($rules['rule'] === 'minDigit') {
                $minDigits = $this->minDigit($password, $rules['value']);
                $minDigits === false ? array_push($errors, 'minDigit') : null;
            }
        }

        return [
            'verify' => $passwordValidate != false ? true : false,
            'noMatch' => $errors
        ];
    }
}
