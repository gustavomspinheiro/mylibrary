<?php

/**
 * **************************
 * *********VALIDATE**********
 * ***************************
 */

/**
 * Validate if certain string is an e-mail
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate if certain string is a valid password in the application
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool {
    if (password_get_info($password)['algo'] || mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN) {
        return true;
    }

    return false;
}

/**
 * *******************************
 * ********* END VALIDATE**********
 * ********************************
 */
/**
 * **************************
 * *********STRING************
 * ***************************
 */

/**
 * Return slug format string. Example: (This is a string -> this-is-a-string)
 * @param string $string
 * @return string
 */
function str_slug(string $string): string {
    $stringLower = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $format = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $slug = str_replace(["-----", "----", "---", "--"], "-", str_replace(" ", "-", trim(strtr(utf8_decode($stringLower), utf8_decode($format), $replace))));
    return $slug;
}

/**
 * Return a string in Studly Case mode.
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string {
    $stringRev = str_replace(" ", "", str_slug($string));
    $studlyString = str_replace("-", " ", mb_convert_case($stringRev, MB_CASE_TITLE));
    return $studlyString;
}

/**
 * Return a string in Camel Case mode.
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string {
    return lcfirst(str_studly_case($string));
}

/**
 * Return string in Title Mode.
 * @param string $string
 * @return string
 */
function str_title(string $string): string {
    $stringRev = filter_var($string, FILTER_SANITIZE_STRIPPED);
    return mb_convert_case($stringRev, MB_CASE_TITLE);
}

/**
 * Return a string formatted to display pricing points.
 * @param string|null $price
 * @return string
 */
function str_price(?string $price): string {
    return number_format((!empty($price) ? $price : 0), "2", ",", ".");
}

/**
 * Limit de quantity of words to be displayed in a certain text. Can be used in blog for example.
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = '...'): string {
    $stringRev = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    $textArray = explode(" ", $stringRev);

    if (count($textArray) <= $limit) {
        return $stringRev;
    }

    $stringLimit = implode(" ", array_slice($textArray, 0, $limit));
    return $stringLimit . $pointer;
}

/**
 * Limit the quantity of words in a slug
 * @param string $string
 * @param int $limit
 * @return string
 */
function str_limit_slug(string $string, int $limit): string {
    $stringRev = filter_var($string, FILTER_SANITIZE_STRIPPED);
    $stringLim = str_limit_words($stringRev, $limit);
    return str_slug($stringLim);
}

/**
 * Limit de quantity of chars to be displayed in a certain text. Can be used in blogPost for example.
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = '...'): string {
    $stringRev = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    if (mb_strlen($stringRev) <= $limit) {
        return $stringRev;
    }

    $stringChars = mb_substr($stringRev, 0, mb_strrpos(mb_substr($stringRev, 0, $limit), " "));
    return $stringChars . $pointer;
}

/**
 * Prepare the string to be displayed after a contact form.
 * @param string $string
 * @return string
 */
function str_text_area(string $string): string {
    $stringRev = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    $textArray = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
    return "<p>" . str_replace($textArray, '<p></p>', $stringRev) . "</p>";
}

function str_search(?string $search): string {
    if (!$search) {
        return "all";
    }

    return (!empty($search) ? preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search) : "all");
}

/**
 * *******************************
 * ********* END STRING************
 * ********************************
 */
/**
 * *******************************
 * *********URL************
 * ********************************
 */

/**
 * Return the path to related url.
 * @param string|null $path
 * @return string
 *
 */
function url(string $path = null): string {
    $urlBase = CONF_URL_BASE;

    if (strrpos($_SERVER["HTTP_HOST"], "localhost")) {
        $urlBase = CONF_URL_TEST;
    }

    if ($path) {
        return $url = $urlBase . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return $urlBase;
}

/**
 * Return the url assessed before
 * @return string
 */
function url_back(): string {
    return ($_SERVER["HTTP_REFERER"] ?? url());
}

/**
 * Return the path to specific theme, in order to access theme assets
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(?string $path, string $theme = CONF_THEME_WEB): string {
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * Redirect the application to certain url
 * @param string $url
 */
function redirect(string $url): void {
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_var(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * @param string|null $image
 * @param int|null $width
 * @return string|null
 */
function image(?string $image, ?int $width, int $height = null): ?string {
    if ($image) {
        return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
    }

    return null;
}

/**
 * *******************************
 * ********* END URL************
 * ********************************
 */
/**
 * *******************************
 * *********PASSWORD***************
 * ********************************
 */

/**
 * Returns the hash of the informed password
 * @param string $password
 * @return string
 */
function passwd(string $password): string {
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * Verifies if a password is equal to the hash.
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool {
    return password_verify($password, $hash);
}

/**
 * Check if existing hash matches the "hash options"
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool {
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ***********************************
 * *********END PASSWORD***************
 * ************************************
 */
/**
 * *******************************
 * *********DATE*******************
 * ********************************
 */

/**
 * Return a string formatted in standard time.
 * @param string|null $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date, string $format = "d/m/Y H\hi"): string {
    $dateRev = (!empty($date) ? $date : "now");
    return (new DateTime($dateRev))->format($format);
}

/**
 * Return a string formatted in Brazilian time.
 * @param string|null $date
 * @return string
 * @throws Exception
 */
function date_fmt_br(?string $date): string {
    $dateRev = (!empty($date) ? $date : "now");
    return (new DateTime($dateRev))->format(CONF_DATE_BR);
}

/**
 * Return a string formatted to be applied in application.
 * @param string|null $date
 * @return string
 * @throws Exception
 */
function date_fmt_app(?string $date): string {
    $dateRev = (!empty($date) ? $date : "now");
    return (new DateTime($dateRev))->format(CONF_DATE_APP);
}

/**
 * Return a database formatted date.
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string {
    if (!$date)
        return null;

    if (strrpos($date, " ")) {
        $dateArr = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $dateArr[0]))) . " " . $dateArr[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * ***********************************
 * *********END DATE*******************
 * ************************************
 */
/**
 * ***********************************
 * *********SESSION*******************
 * ************************************
 */

/**
 * Responsible for returning flash message in form of div.
 * @return string|null
 */
function flashMessage() {
    $session = (new Source\Core\Session());

    if (!$session->flash) {
        return null;
    }

    $flash = $session->flash;
    unset($session->flash);

    return "<div class='button {$flash->getType()}'>{$flash->getText()}</div>";
}
