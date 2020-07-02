<?php

namespace App\Services;

use App\LoanApplication;
use App\Status;
use App\User;
use Illuminate\Support\Str;

class AuditLogService
{
    public static function generateLogs(LoanApplication $loanApplication)
    {
        $changes      = [];
        $statuses     = Status::pluck('name', 'id');
        $users        = User::pluck('name', 'id');

        foreach ($loanApplication->logs as $log) {
            $current = json_decode($log->properties, true);
            unset($current['status'], $current['id']);

            if (isset($previous)) {
                $differences   = array_diff_assoc($current, $previous);
                $value         = [
                    'user'    => $log->user->name,
                    'time'    => $log->created_at,
                    'comment' => null,
                    'changes' => []
                ];

                foreach ($differences as $key => $difference) {
                    $previousValue = $previous[$key] ?? null;
                    $currentValue  = $current[$key] ?? null;

                    if (Str::endsWith($key, '_at') || $previousValue == $currentValue) {
                        continue;
                    }

                    if ($key == 'status_id') {
                        $previousValue = $previousValue ? $statuses[$previousValue] : null;
                        $currentValue  = $statuses[$currentValue];
                        $key           = Str::replaceFirst('_id', '', $key);
                        if (in_array($difference, [3, 4, 6, 7])) {
                            $column = in_array($difference, [3, 4]) ? 'analyst_id' : 'cfo_id';
                            $value['comment'] = $loanApplication->comments->where('user_id', $current[$column])->first()->comment_text;
                        }
                    } elseif (in_array($key, ['analyst_id', 'cfo_id'])) {
                        $previousValue = $previousValue ? $users[$previousValue] : null;
                        $currentValue  = $users[$currentValue];
                        $key           = Str::replaceFirst('_id', '', $key);
                    }

                    $changesString = '<b>' . Str::of($key)->replace('_', ' ')->title() . '</b>: ';
                    $changesString .= $previousValue ? 'from ' . $previousValue . ' to ' . $currentValue : 'set to ' . $currentValue;
                    $value['changes'][] = $changesString;
                }

                $changes[] = $value;
            }

            $previous = $current;
        }

        return $changes;
    }
}
