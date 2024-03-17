<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use App\Models\Currency;
use CurrencyApi\CurrencyApi\CurrencyApiClient;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ManageCurrencies extends ManageRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {

        $RefreshRates = Actions\Action::make('Load from currencyapi')
            ->label('Refresh from currencyapi.com')
            ->action(function ($action){
                $currencyApi = new CurrencyApiClient(env('CURRENCY_API_KEY'));
//                Cache::add('currencies',$currencyApi->currencies() );
                $latestRates =  $currencyApi->latest();
//                $latestRates =  Cache::get('latestRates',[]);
                /* $latestRates schema
                    [
                    'meta' => [ "last_updated_at" => "2024-03-11T23:59:59Z" ]
                    'data' => [
                            '<currency_code>' => [ "code" => <currency_code> , "value" => <exchange_rate_from_base>],
                            'ADA' => [ "code" => "ADA" , "value" => 1.2921598739],
                            ]
                    ]
               */

//                $currencies = Cache::get('currencies',[]);
                $currencies = $currencyApi->currencies();
                $currencies = array_values($currencies)[0];

                $neededAttributes = [
                    'type', 'name_plural',
                    'code', 'decimal_digits',
                    'name', 'symbol',
                    'symbol_native', 'exchange_rate_from_base',
                    'exchange_rate_from_base_last_updated_at'
                ];
                foreach ($currencies as $currency_code => &$currencyData){
                    $currencyData['exchange_rate_from_base'] = $latestRates['data'][$currency_code]['value'];
                    $dt = $latestRates['meta']['last_updated_at'];
                    $currencyData['exchange_rate_from_base_last_updated_at'] = Carbon::parse($dt)
                        ->setTimezone('UTC')
                        ->toDateTimeString();

                    foreach ($currencyData as $attribute => $value){
                        if(!in_array($attribute, $neededAttributes)) {
                            unset($currencyData[$attribute]);
                        }
                    }
                }
                Currency::truncate();
                Currency::insert($currencies);
                $action->success();
            })
            ->successNotification(
                Notification::make()
                    ->title('Refreshed successfully')
                    ->success()
            )
        ->failureNotification(
            Notification::make()
                ->title('Some thing went wrong')
                ->danger()
            );

        return [
            Actions\CreateAction::make(),
            $RefreshRates
        ];
    }
}
