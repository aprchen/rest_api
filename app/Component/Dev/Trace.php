<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/4
 * Time: 上午10:23
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Dev;


class Trace
{
    var $startTime = [];
    var $endTime = [];

    var $single_mode = false;
    var $trace_mode = false;

    function getTimestamp()
    {
        return microtime(true);
    }

    function start($type, $time = 0)
    {
        if (empty($this->trace_mode)) return 0;

        if (!$time) {
            $time = $this->getTimestamp();
        }

        if ($this->single_mode) {
            $this->startTime[$type] = $time;
        } else {
            $this->startTime[$type][] = $time;
        }
    }

    function stop($type, $time = 0)
    {
        if (empty($this->trace_mode)) return 0;

        if (!$time) {
            $time = $this->getTimestamp();
        }

        if ($this->single_mode) {
            $this->endTime[$type] = $time;
        } else {
            $this->endTime[$type][] = $time;
        }
    }

    function time($type)
    {
        if (empty($this->trace_mode)) return 0;

        if (!isset($this->endTime[$type])) return 0;

        if (is_array($this->endTime[$type])) {
            return array_sum($this->endTime[$type]) - array_sum($this->startTime[$type]);
        } else {
            return $this->endTime[$type] - $this->startTime[$type];
        }
    }

    function log($type)
    {
        if (empty($this->trace_mode)) return 0;

        $log['type'] = $type;
        $log['time'] = $this->time($type);;
        // 每个框架不同的记日志方式，可切换
        Log::logger()->debug($log, 'trace_log');
    }


    function logAll($prefix = '', $ext = array())
    {
        if (empty($this->trace_mode)) return 0;

        if (!empty($ext)) {
            $log = $ext;
            $log['elapse_time'] = $this->output(false);
        } else {
            $log = $this->output(false);
        }

        if (!empty($log)) {
            $prefix = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $prefix));
            // 每个框架不同的记日志方式，可切换
            Log::logger()->debug($log, 'trace_' . $prefix . '_log');
        }
    }

    function output($with_endtime = true)
    {
        $output = array();
        if (!empty($this->startTime)) {
            foreach ($this->startTime as $_type => $_time) {
                $exec_time = $this->time($_type);
                if ($exec_time) {
                    $output[$_type] = $exec_time;
                    if ($with_endtime) {
                        if (is_array($this->endTime[$_type])) {
                            $output[$_type] .= '|' . max($this->endTime[$_type]);
                        } else {
                            $output[$_type] .= '|' . $this->endTime[$_type];
                        }
                    }
                }
            }
        }
        return $output;
    }

    function reset($type = null)
    {
        if (empty($type)) {
            $this->startTime = null;
            $this->endTime = null;
        } else {
            unset($this->startTime[$type]);
            unset($this->endTime[$type]);
        }

        return $this;
    }

    function enableTrace($exit = true)
    {
        $this->trace_mode = $exit;
    }
}