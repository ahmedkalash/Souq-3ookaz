<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class ProductPriceService
{
    /***@var Currency $currencyModelClass*/
    protected static string $currencyModelClass;

    protected static Currency $localeCurrency;

    protected static ?Collection $currencies = null;

//    public function __construct(string $currencyModel, array $eagerLoadCurrencies = [])
//    {
//       $this->setCurrencyModelClass($currencyModel);
//       $this->eagerLoadCurrencies($eagerLoadCurrencies);
//    }

    /**
     * Eager load the given currencies by its code.<br>
     * If an existing currency code is present in $currencies_code, then it will be refreshed.<br>
     * If the $currencies_code == ['*'], then all currencies will be loaded.<br>
     *
     * @param string[] $currencies_code
     * @return Collection Return only the loaded currencies
     */
    public static function eagerLoadCurrencies(array $currencies_code = ['*'])
    {
        if($currencies_code == ['*']){
            return static::$currencies = static::$currencyModelClass::query()->get();
        }else{
            $currencies =static::$currencyModelClass::query()
                ->whereIn('code', $currencies_code)
                ->get();

            if(static::$currencies != null){
                $codes = $currencies->pluck('code')->toArray();
                $currencies->reject(fn($item) => in_array($item->code, $codes));
                static::$currencies->merge($currencies);
            }

            return $currencies;
        }

    }

    public static function setCurrencyModelClass(string $currencyModelClass): void
    {
        static::$currencyModelClass = $currencyModelClass;
    }

    public static function setLocaleCurrency(Currency $localeCurrency): void
    {
        static::$localeCurrency = $localeCurrency;
    }

    public static function getCurrencyModelClass(): string
    {
        return static::$currencyModelClass;
    }

    public static function getLocaleCurrency(): Currency
    {
        return static::$localeCurrency;
    }

    /**
     * @param float|int $price Price in base currency
     * @param string $to Code of currency to change price to
     * @return float|int
     * @throws \Exception
     */
    public static function fromBase(float|int $price, string $to)
    {
        $currency = static::getCurrency($to);

        return $price * $currency->exchange_rate_from_base;
    }

    /**
     * @param string $code Code of currency
     * @return Currency
     * @throws \Exception
     */
    public static function getCurrency(string $code)
    {
        $currency = static::getCurrencies()?->firstWhere('code', '=', $code);
        if(!$currency){
            $currency = static::eagerLoadCurrencies([$code])->first();
            if($currency == null){
                throw new \Exception('Unsupported currency!');
            }
        }
        return $currency;
    }

    /**
     * @param string $code Currency Code
     * @param float $price Price in base currency
     * @return array
     * @throws \Exception
     */
    public static function getFullPriceInfoIn(string $code, float $price)
    {
        $currency = static::getCurrency($code)->toArray();
        $currency['price_in_base'] = $price;
        $currency['price'] = $price * $currency['exchange_rate_from_base'];

        return $currency;
    }

    /**
     * @return Currency
     * @throws \Exception
     */
    public static function loadSessionLocaleCurrency()
    {
        $localCurrency = static::getCurrency(static::localeCurrencyCode());

        static::setLocaleCurrency($localCurrency);

        return $localCurrency;
    }

    /**
     * @param float $price
     * @return array
     * @throws \Exception
     */
    public static function localizePrice(float $price)
    {
        // load the locale currency from Session if it is not set
        if(!static::getLocaleCurrency()){
            static::loadSessionLocaleCurrency();
        }
        $localCurrency = static::getLocaleCurrency()->toArray();
        $localCurrency['price'] = round($localCurrency['exchange_rate_from_base'] * $price, $localCurrency['decimal_digits']);
        return $localCurrency;
    }

    public static function localeCurrencyCode()
    {
        return session('currency_code', config('app.default_currency'));
    }

    private static function getCurrencies()
    {
        return static::$currencies;
    }
}
