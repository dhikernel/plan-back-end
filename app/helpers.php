<?php
/**
 * Modelo para retorno.
 *
 * @param int $statusCode
 * @param null $message
 * @param null $data
 *
 * @return Application|ResponseFactory|Response
 */

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (! function_exists('responseHTTP')) {
    function responseHTTP(int $statusCode, $message = null, $data = null): Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}

if (! function_exists('checkDiffDays')) {
    function checkDiffDays($dataOld, $dataNew)
    {
        $start_date = Carbon::parse($dataOld);

        return $start_date->diffInDays(Carbon::parse($dataNew));
    }
}

if (! function_exists('formatToBrazilianMoney')) {
    function formatToBrazilianMoney(?float $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY))->formatCurrency($value, 'BRL');
    }
}

if (! function_exists('formatToBrazilianDate')) {
    function formatToBrazilianDate($date, $format = 'Y-m-d')
    {
        if ($date instanceof Carbon) {
            return $date->format('d/m/Y H:i:s');
        }

        if (is_string($date) && isValidDate($date, $format)) {
            return Carbon::createFromFormat($format, $date)->format('d/m/Y H:i:s');
        }

        return null;
    }
}

if (! function_exists('getOnlyDateInBrazilianFulldate')) {
    function getOnlyDateInBrazilianFulldate(?string $date)
    {
        if (is_null($date)) {
            return null;
        }

        if (strlen($date) === 19) {
            return Str::substr($date, 0, 10);
        }

        return $date;
    }
}

if (! function_exists('formatToBrazilianMonthYear')) {
    function formatToBrazilianMonthYear($date)
    {
        if ($date instanceof Carbon) {
            return $date->format('F /d/e Y');
        }

        if (is_string($date) && isValidDate($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('F /d/e Y');
        }

        return null;
    }
}

if (! function_exists('toBRDate')) {
    function toBRDate($date)
    {
        try {
            if (is_string($date) && strlen($date) === 10) {
                return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}

if (! function_exists('isValidDate')) {
    function isValidDate(string $date, $format = 'Y-m-d'): bool
    {
        if (empty($date)) {
            return false;
        }

        $d = \DateTime::createFromFormat($format, $date);

        return (bool) $d;
    }
}

if (! function_exists('normalizeChars')) {
    /**
     * Replace language-specific characters by ASCII-equivalents.
     *
     * @param string $s
     *
     * @return string
     */
    function normalizeChars($s)
    {
        $replace = [
            'ъ' => '-', 'Ь' => '-', 'Ъ' => '-', 'ь' => '-',
            'Ă' => 'A', 'Ą' => 'A', 'À' => 'A', 'Ã' => 'A', 'Á' => 'A', 'Æ' => 'A', 'Â' => 'A', 'Å' => 'A', 'Ä' => 'Ae',
            'Þ' => 'B',
            'Ć' => 'C', 'ץ' => 'C', 'Ç' => 'C',
            'È' => 'E', 'Ę' => 'E', 'É' => 'E', 'Ë' => 'E', 'Ê' => 'E',
            'Ğ' => 'G',
            'İ' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Í' => 'I', 'Ì' => 'I',
            'Ł' => 'L',
            'Ñ' => 'N', 'Ń' => 'N',
            'Ø' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe',
            'Ş' => 'S', 'Ś' => 'S', 'Ș' => 'S', 'Š' => 'S',
            'Ț' => 'T',
            'Ù' => 'U', 'Û' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
            'Ý' => 'Y',
            'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z',
            'â' => 'a', 'ǎ' => 'a', 'ą' => 'a', 'á' => 'a', 'ă' => 'a', 'ã' => 'a', 'Ǎ' => 'a', 'а' => 'a', 'А' => 'a', 'å' => 'a', 'à' => 'a', 'א' => 'a', 'Ǻ' => 'a', 'Ā' => 'a', 'ǻ' => 'a', 'ā' => 'a', 'ä' => 'ae', 'æ' => 'ae', 'Ǽ' => 'ae', 'ǽ' => 'ae',
            'б' => 'b', 'ב' => 'b', 'Б' => 'b', 'þ' => 'b',
            'ĉ' => 'c', 'Ĉ' => 'c', 'Ċ' => 'c', 'ć' => 'c', 'ç' => 'c', 'ц' => 'c', 'צ' => 'c', 'ċ' => 'c', 'Ц' => 'c', 'Č' => 'c', 'č' => 'c', 'Ч' => 'ch', 'ч' => 'ch',
            'ד' => 'd', 'ď' => 'd', 'Đ' => 'd', 'Ď' => 'd', 'đ' => 'd', 'д' => 'd', 'Д' => 'D', 'ð' => 'd',
            'є' => 'e', 'ע' => 'e', 'е' => 'e', 'Е' => 'e', 'Ə' => 'e', 'ę' => 'e', 'ĕ' => 'e', 'ē' => 'e', 'Ē' => 'e', 'Ė' => 'e', 'ė' => 'e', 'ě' => 'e', 'Ě' => 'e', 'Є' => 'e', 'Ĕ' => 'e', 'ê' => 'e', 'ə' => 'e', 'è' => 'e', 'ë' => 'e', 'é' => 'e',
            'ф' => 'f', 'ƒ' => 'f', 'Ф' => 'f',
            'ġ' => 'g', 'Ģ' => 'g', 'Ġ' => 'g', 'Ĝ' => 'g', 'Г' => 'g', 'г' => 'g', 'ĝ' => 'g', 'ğ' => 'g', 'ג' => 'g', 'Ґ' => 'g', 'ґ' => 'g', 'ģ' => 'g',
            'ח' => 'h', 'ħ' => 'h', 'Х' => 'h', 'Ħ' => 'h', 'Ĥ' => 'h', 'ĥ' => 'h', 'х' => 'h', 'ה' => 'h',
            'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ì' => 'i', 'į' => 'i', 'ĭ' => 'i', 'ı' => 'i', 'Ĭ' => 'i', 'И' => 'i', 'ĩ' => 'i', 'ǐ' => 'i', 'Ĩ' => 'i', 'Ǐ' => 'i', 'и' => 'i', 'Į' => 'i', 'י' => 'i', 'Ї' => 'i', 'Ī' => 'i', 'І' => 'i', 'ї' => 'i', 'і' => 'i', 'ī' => 'i', 'ĳ' => 'ij', 'Ĳ' => 'ij',
            'й' => 'j', 'Й' => 'j', 'Ĵ' => 'j', 'ĵ' => 'j', 'я' => 'ja', 'Я' => 'ja', 'Э' => 'je', 'э' => 'je', 'ё' => 'jo', 'Ё' => 'jo', 'ю' => 'ju', 'Ю' => 'ju',
            'ĸ' => 'k', 'כ' => 'k', 'Ķ' => 'k', 'К' => 'k', 'к' => 'k', 'ķ' => 'k', 'ך' => 'k',
            'Ŀ' => 'l', 'ŀ' => 'l', 'Л' => 'l', 'ł' => 'l', 'ļ' => 'l', 'ĺ' => 'l', 'Ĺ' => 'l', 'Ļ' => 'l', 'л' => 'l', 'Ľ' => 'l', 'ľ' => 'l', 'ל' => 'l',
            'מ' => 'm', 'М' => 'm', 'ם' => 'm', 'м' => 'm',
            'ñ' => 'n', 'н' => 'n', 'Ņ' => 'n', 'ן' => 'n', 'ŋ' => 'n', 'נ' => 'n', 'Н' => 'n', 'ń' => 'n', 'Ŋ' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'Ň' => 'n', 'ň' => 'n',
            'о' => 'o', 'О' => 'o', 'ő' => 'o', 'õ' => 'o', 'ô' => 'o', 'Ő' => 'o', 'ŏ' => 'o', 'Ŏ' => 'o', 'Ō' => 'o', 'ō' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'ǒ' => 'o', 'ò' => 'o', 'Ǿ' => 'o', 'Ǒ' => 'o', 'ơ' => 'o', 'ó' => 'o', 'Ơ' => 'o', 'œ' => 'oe', 'Œ' => 'oe', 'ö' => 'oe',
            'פ' => 'p', 'ף' => 'p', 'п' => 'p', 'П' => 'p',
            'ק' => 'q',
            'ŕ' => 'r', 'ř' => 'r', 'Ř' => 'r', 'ŗ' => 'r', 'Ŗ' => 'r', 'ר' => 'r', 'Ŕ' => 'r', 'Р' => 'r', 'р' => 'r',
            'ș' => 's', 'с' => 's', 'Ŝ' => 's', 'š' => 's', 'ś' => 's', 'ס' => 's', 'ş' => 's', 'С' => 's', 'ŝ' => 's', 'Щ' => 'sch', 'щ' => 'sch', 'ш' => 'sh', 'Ш' => 'sh', 'ß' => 'ss',
            'т' => 't', 'ט' => 't', 'ŧ' => 't', 'ת' => 't', 'ť' => 't', 'ţ' => 't', 'Ţ' => 't', 'Т' => 't', 'ț' => 't', 'Ŧ' => 't', 'Ť' => 't', '™' => 'tm',
            'ū' => 'u', 'у' => 'u', 'Ũ' => 'u', 'ũ' => 'u', 'Ư' => 'u', 'ư' => 'u', 'Ū' => 'u', 'Ǔ' => 'u', 'ų' => 'u', 'Ų' => 'u', 'ŭ' => 'u', 'Ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'ű' => 'u', 'Ű' => 'u', 'Ǖ' => 'u', 'ǔ' => 'u', 'Ǜ' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'У' => 'u', 'ǚ' => 'u', 'ǜ' => 'u', 'Ǚ' => 'u', 'Ǘ' => 'u', 'ǖ' => 'u', 'ǘ' => 'u', 'ü' => 'ue',
            'в' => 'v', 'ו' => 'v', 'В' => 'v',
            'ש' => 'w', 'ŵ' => 'w', 'Ŵ' => 'w',
            'ы' => 'y', 'ŷ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ÿ' => 'y', 'Ŷ' => 'y',
            'Ы' => 'y', 'ž' => 'z', 'З' => 'z', 'з' => 'z', 'ź' => 'z', 'ז' => 'z', 'ż' => 'z', 'ſ' => 'z', 'Ж' => 'zh', 'ж' => 'zh',
        ];

        return strtr($s, $replace);
    }

    if (! function_exists('getValue')) {
        function getValue($var)
        {
            if (isset($var) && ! empty($var)) {
                return $var;
            }

            return null;
        }
    }
}

if (! function_exists('transformParamsInArray')) {
    function transformParamsInArray(string $idsQuerystring, string $delimiter = ','): array
    {
        if (empty($idsQuerystring)) {
            return [];
        }

        return collect(Str::of($idsQuerystring)
            ->explode($delimiter))
            ->map(fn ($item) => is_numeric($item) ? (int) $item : $item)
            ->toArray();
    }
}
