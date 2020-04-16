<?php
namespace Bromo\Transaction\Helpers;

class XenditBankNameUtil {

    //Unique Code Length
    const minLength = 4;
    const maxLength = 5;

    //Development
    const DEV = [
        '8808' => 'BNI',
        '10766' => 'BCA',
        '26215' => 'BRI',
        '88608' => 'MANDIRI',
    ];

    //Production
    const PROD = [
        '8808' => 'BNI',
        '11687' => 'BCA',
        '26215' => 'BRI',
        '88608' => 'MANDIRI',
    ];
    
    /**
     * Get Bank Name
     */
    public static function getBankName ( $bankAccountNumber ) {
        //CHECK ENVIRONMENT
        $bankNameCollection = [];
        switch(config('app.env')){
            case 'production':
                $bankNameCollection = self::PROD;
                break;
            case 'development':
                $bankNameCollection = self::DEV;
                break;
        }

        //FIND BANK NAME (LONGER CODE == MORE SPECIFIC)
        $bankName = null;
        if($bankNameCollection != []){
            for($codeLength = self::minLength; $codeLength <= self::maxLength; $codeLength++){
                $bankCode = substr($bankAccountNumber,0,$codeLength);
                if(array_key_exists($bankCode, $bankNameCollection)){
                    $bankName = $bankNameCollection[$bankCode];
                    break;
                }
            }
        }
        
        return $bankName;
    }

}