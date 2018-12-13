<?php

namespace RelativeTime;

class RelativeTime
{
    const VERSION = '1.0';

    protected $config = array();

    protected $translation;

    public function __construct(array $config = array())
    {
        $this->config = array_merge(array(
            'language' => '\RelativeTime\Languages\English',
            'separator' => ', ',
            'suffix' => true,
            'truncate' => 0,
        ), $config);

        $this->translation = new \RelativeTime\Translation($this->config);
    }

    public function convert($fromTime, $toTime = null)
    {
        $interval = $this->getInterval($fromTime, $toTime);
        $units = $this->calculateUnits($interval);
        return $this->translation->translate($units, $interval->invert);
    }

    public function TimeAgo($date)
    {
        $interval = $this->getInterval(time(), $date);
        if ($interval->invert)
            return $this->convert(time(), $date);

        return $this->translation->translate();
    }

    public function TimeLeft($date)
    {
        $interval = $this->getInterval($date, time());
        if ($interval->invert)
            return $this->convert(time(), $date);

        return $this->translation->translate();
    }

    protected function getInterval($fromTime, $toTime = null)
    {
        $fromTime = new \DateTime($this->normalizeDate($fromTime));
        $toTime   = new \DateTime($this->normalizeDate($toTime));
        return $fromTime->diff($toTime);
    }

    protected function normalizeDate($date)
    {
        $date = str_replace(array('/', '|'), '-', $date);
        if (empty($date))
            return date('Y-m-d H:i:s');
        else if (ctype_digit($date))
            return date('Y-m-d H:i:s', $date);

        return $date;
    }

    protected function calculateUnits(\DateInterval $interval)
    {
        $units = array_filter(array(
            'years'   => (int) $interval->y,
            'months'  => (int) $interval->m,
            'days'    => (int) $interval->d,
            'hours'   => (int) $interval->h,
            'minutes' => (int) $interval->i,
            'seconds' => (int) $interval->s,
        ));

        if (empty($units))
            return array();
        else if ($this->config['truncate'] > 0)
            return array_slice($units, 0, $this->config['truncate']);
        else
            return $units;
    }
}
?>
