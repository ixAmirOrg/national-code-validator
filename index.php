<?php

class IranianNationalCodeValidator
{
    public static function isValid(string $code): bool
    {
        if (!preg_match('/^\d{10}$/', $code)) {
            throw new Exception("کد ملی باید 10 رقمی باشد");
        }

        if (preg_match('/^(\d)\1{9}$/', $code)) {
            throw new Exception("کد ملی نمیتواند یکسان باشد");
        }

        $check = (int) $code[9];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $code[$i] * (10 - $i);
        }

        $remainder = $sum % 11;

        if (($remainder < 2 && $check != $remainder) || ($remainder >= 2 && $check != (11 - $remainder))) {
            throw new Exception("کدملی معتبر نیست");
        }

        return true;
    }

    public static function validateCode(string $code): array
    {
        try {
            self::isValid($code);
            return ['message' => "✅ کد ملی $code صحیح است", 'status' => 'success'];
        } catch (Exception $e) {
            return ['message' => "❌ " . $e->getMessage(), 'status' => 'error'];
        }
    }
}





$nationalCode   = '000000000'; 
$result         = IranianNationalCodeValidator::validateCode($nationalCode);

echo $result['message']."<br>";  // show message
echo $result['message'];        // show status
?>