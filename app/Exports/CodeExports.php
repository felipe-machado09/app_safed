<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\BarCodes;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class CodeExports implements FromQuery, WithHeadings, WithColumnFormatting, WithMapping
{

    use Exportable;

    public function headings(): array
    {
        return [
            'Usúario',
            'Chassi',
            'ConnectCar',
            'Criado em'
        ];
    }

    public function map($barCodes): array
    {
        return [
            $barCodes->user->name,
            $barCodes->chassi,
            $barCodes->connectCar,
            Date::dateTimeToExcel($barCodes->created_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function forYesterday($type)
    {
        $yesterday = Carbon::yesterday();
        $this->yesterday = $yesterday;
        $this->type = $type;
        return $this;
    }
    public function forToday($type)
    {
        $today = Carbon::today();
        $this->today = $today;
        $this->type = $type;
        return $this;
    }
    public function forWeek($type)
    {
        $data = \Carbon\CarbonImmutable::now()->locale('pt_BR');
        $start = $data->startOfWeek(Carbon::SUNDAY);
        $end = $data->endOfWeek(Carbon::SATURDAY);

        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
        return $this;
    }
    public function forMonth($type)
    {
        $data = \Carbon\CarbonImmutable::now()->locale('pt_BR');
        $start = $data->firstOfMonth();
        $end = $data->endOfMonth();

        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
        return $this;
    }
    public function forInterval($start, $end, $type)
    {
        $this->start = Carbon::parse($start)->startOfDay()->toDateTimeString();
        $this->end = Carbon::parse($end)->endOfDay()->toDateTimeString();;
        $this->type = $type;
        return $this;
    }

    public function query()
    {

        switch ($this->type) {
            case 'yesterday':

                return BarCodes::query()->whereDate('created_at', $this->yesterday);

                break;
            case 'today':

                return BarCodes::query()->whereDate('created_at', $this->today);

                break;
            case 'week':

                return BarCodes::query()->whereBetween('created_at', [$this->start,$this->end]);

                break;
            case 'month':

                return BarCodes::whereBetween('created_at', [$this->start,$this->end]);

                break;
            case 'interval':

                return BarCodes::whereBetween('created_at', [$this->start,$this->end]);

                break;
        }

    }
}
