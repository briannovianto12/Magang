<?php
namespace Bromo\Transaction\Helpers;

class XenditBankNameUtil {
    
    /**
     * Get Bank Name
     */
    public static function getBankName ( $bankAccountNumber ) {
        //Unique Code Length
        $minLength = 4;
        $maxLength = 5;

        //Bank Name Collection
        $bankNameCollection = [];
        if(config('shop.prefix_va_bni')) $bankNameCollection[config('shop.prefix_va_bni')] = 'BNI';
        if(config('shop.prefix_va_bca')) $bankNameCollection[config('shop.prefix_va_bca')] = 'BCA';
        if(config('shop.prefix_va_bri')) $bankNameCollection[config('shop.prefix_va_bri')] = 'BRI';
        if(config('shop.prefix_va_mandiri')) $bankNameCollection[config('shop.prefix_va_mandiri')] = 'MANDIRI';

        //FIND BANK NAME (LONGER CODE == MORE SPECIFIC)
        $bankName = null;
        if($bankNameCollection != []){
            for($codeLength = $minLength; $codeLength <= $maxLength; $codeLength++){
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