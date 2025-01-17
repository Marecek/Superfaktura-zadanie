<?php

namespace CoById\Utilities;

trait Utilities
{
    /**
     * @return string
     */
    public function getRootDir(): string
    {
        $root = str_replace(
            '\\',
            '/',
            dirname(str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']))
        );

        if ('.' == $root) {
            return '/';
        }

        if (str_ends_with($root, '/')) {
            $root = substr($root, 0, -1);
        }

        return ! str_starts_with($root, '/') ? '/' . $root : $root;
    }

    /**
     * @param string $str
     *
     * @return bool
     */
    public function IsNullOrEmptyString(string $str): bool
    {
        return (trim($str) === '');
    }


    /**
     * @param $message
     *
     * @return array
     */
    public function extractDocrefUrl($message): array
    {
        $docref = [
            'message' => $message,
            'url'     => null,
        ];

        if (! ini_get('html_errors') || ! ini_get('docref_root')) {
            return $docref;
        }

        $pattern = "/\[<a href='([^']+)'>(?:[^<]+)<\/a>\]/";
        if (preg_match($pattern, $message, $matches)) {
            $docref['message'] = preg_replace($pattern, '', $message, 1);
            $docref['url']     = $matches[1];
        }

        return $docref;
    }


    /**
     * @param $level
     *
     * @return bool
     */
    public static function isExcLevelFatal($level): bool
    {
        $errors = E_ERROR;
        $errors |= E_PARSE;
        $errors |= E_CORE_ERROR;
        $errors |= E_CORE_WARNING;
        $errors |= E_COMPILE_ERROR;
        $errors |= E_COMPILE_WARNING;

        return ($level & $errors) > 0;
    }

    /**
     * @return bool
     */
    public function canSendHeaders(): bool
    {
        return isset($_SERVER["REQUEST_URI"]) && ! headers_sent();
    }

    /**
     * @return bool
     */
    public function isAjaxRequest(): bool
    {
        return (
            ! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function validateCzCoId(string $id): bool
    {
        $id = preg_replace('#\s+#', '', $id);

        if (! preg_match('#^\d{8}$#', $id)) {
            return false;
        }
        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $id[$i] * (8 - $i);
        }
        $a = $a % 11;
        if ($a === 0) {
            $c = 1;
        } elseif ($a === 1) {
            $c = 0;
        } else {
            $c = 11 - $a;
        }

        return (int)$id[7] === $c;
    }


}
