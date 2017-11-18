<?php

/**
 * Validator validates the following:
 *
 * URLs - http and https URLs only
 * Emails - all emails types
 * Phone Numbers - no toll free, 555 area code or 900 numbers
 * Zip Codes - 5 and 9 US zip codes
 * Names - full name validation
 * Date - dates with format MM/DD/YYYY and YYYY-MM-DD
 */

namespace App\Utilities;

class Validator {

    /**
     * Validate a URL with http or https
     *
     * @param $url string The URL to validate
     * @return bool
     */
    public function isValidURL($url) {
        if (!is_string($url)) {
            return false;
        }
        // regex came from https://stackoverflow.com/questions/2058578/best-way-to-check-if-a-url-is-valid
        $regex = '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i';
        return preg_match($regex, $url) ? true : false;
    }

    /**
     * Validate email addresses
     *
     * @param $email string The email address to validate
     * @return bool
     */
    public function isValidEmail($email) {
        if (!is_string($email)) {
            return false;
        }
        $regex = "/^[_a-z0-9-+]+(\.[_a-z0-9-]+)*@[a-z0-9]+([-]+[a-z0-9]+|[a-z0-9]+)(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
        return preg_match($regex, $email) ? true : false;
    }

    /**
     * Validate a 10 digit US phone number that it's not a toll free, 900 or 555 number
     *
     * @param $phone string The phone number to validate
     * @return bool
     */
    public function isValidPhone($phone) {
        if (!is_string($phone)) {
            return false;
        }
        // Normalize - Remove anything that it's not a digit.
        $phone = preg_replace("/\D/","", $phone);
        // Remove any leading 1s so the phone number is only 10 digits
        if (strlen($phone) == 11 && substr($phone, 0, 1) == "1"){
            $phone = substr($phone, -10);
        }

        // is the phone number 10 digits?
        if (strlen($phone) !== 10) {
            return false;
        }
        // no invalid area codes
        else if (preg_match("/^(800|888|866|877|900|555)/", $phone)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Validate a US zip code. It takes the 5 and 9 digit US zip codes
     *
     * @param $zip string The zip code to validate
     * @return bool
     */
    public function isValidZipCode($zip) {
        if (!is_string($zip)) {
            return false;
        }
        $regex = "/^\d{5}(\-\d{4})?$/";
        return preg_match($regex, $zip) ? true : false;
    }

    /**
     * Validate a first name or last name
     *
     * @param $name string The first name or last name to validate
     * @return bool
     */
    public function isValidName($name) {
        if (!is_string($name)) {
            return false;
        }
        $regex = "/^[a-zA-Z ]+[\-']?[a-zA-Z ]+[\-']?[a-zA-Z ]+[\-']?[a-zA-Z ]+$/";
        return preg_match($regex, $name) ? true : false;
    }

    /**
     * Validate a date with a given format
     *
     * @param $date string The date to validate
     * @param $format string The format of the date. ie m/d/Y or Y-m-d
     * @return bool
     */
    public function isValidDate($date, $format = 'm/d/Y') {
        if (!is_string($date)) {
            return false;
        }
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}